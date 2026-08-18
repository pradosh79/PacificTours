<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Services\MediaService;
use App\Services\SettingService;
use Illuminate\Http\UploadedFile;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingService $settings,
        private readonly MediaService $media,
    ) {
        $this->middleware('can:manage-settings');
    }

    private const GROUPS = ['general', 'smtp', 'payment', 'theme', 'seo', 'social', 'home'];

    public function edit(string $group = 'general')
    {
        abort_unless(in_array($group, self::GROUPS, true), 404);

        return view('admin.settings.index', [
            'group'  => $group,
            'values' => $this->settings->group($group),
        ]);
    }

    public function update(SettingRequest $request, string $group)
    {
        abort_unless(in_array($group, self::GROUPS, true), 404);

        $values = $request->validated();
        $types  = [];

        foreach ($values as $key => $value) {
            if ($value instanceof UploadedFile) {
                $values[$key] = $this->media->store($value, 'branding');
                $types[$key]  = 'file';
            } elseif (in_array($key, $request->encryptedKeys(), true)) {
                if (blank($value)) {
                    unset($values[$key]);   // keep the stored secret when the field is left empty
                    continue;
                }
                $types[$key] = 'encrypted';
            } elseif (is_array($value)) {
                // fleet_features and similar list fields are stored as JSON.
                $values[$key] = array_values(array_filter($value, fn ($v) => filled($v)));
                $types[$key]  = 'json';
            } elseif (is_bool($value)) {
                $types[$key] = 'bool';
            }
        }

        $this->settings->setMany($group, $values, $types);

        // Home-page cache is warmed by the settings block, so bust it on any change.
        if ($group === 'home' || $group === 'general' || $group === 'social') {
            \Illuminate\Support\Facades\Cache::forget('home:payload:'.app()->getLocale());
        }

        return back()->with('success', ucfirst($group).' settings saved.');
    }
}
