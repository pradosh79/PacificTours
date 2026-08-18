<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Key/value site configuration with a single cached read per request cycle.
 * Secrets (Stripe keys, SMTP password) are stored with type = encrypted.
 */
class SettingService
{
    private const CACHE_KEY = 'settings:all';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return Setting::all()->mapWithKeys(fn (Setting $s) => [
                "{$s->group}.{$s->key}" => $s->typed_value,
            ])->toArray();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        /*
         * The store is a flat map keyed by "group.key" (e.g. "home.hero_title_lead"),
         * so we need an exact-key lookup. data_get() would treat the dot as a path
         * separator and walk into a non-existent "home" sub-array, which is the bug
         * that made every setting() call silently return its default value.
         */
        $all = $this->all();

        return array_key_exists($key, $all) ? ($all[$key] ?? $default) : $default;
    }

    public function group(string $group): array
    {
        $prefix = $group.'.';

        return collect($this->all())
            ->filter(fn ($v, $k) => str_starts_with($k, $prefix))
            ->mapWithKeys(fn ($v, $k) => [substr($k, strlen($prefix)) => $v])
            ->toArray();
    }

    public function set(string $group, string $key, mixed $value, string $type = 'string'): void
    {
        Setting::updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => $type === 'encrypted' ? encrypt($value) : (is_array($value) ? json_encode($value) : $value), 'type' => $type]
        );

        $this->flush();
    }

    public function setMany(string $group, array $values, array $types = []): void
    {
        foreach ($values as $key => $value) {
            $this->set($group, $key, $value, $types[$key] ?? 'string');
        }
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
