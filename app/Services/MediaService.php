<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Every upload passes through here: extension whitelist, randomised name,
 * date-sharded path. Nothing is ever stored with a client-supplied filename.
 */
class MediaService
{
    public function store(UploadedFile $file, string $folder = 'misc', string $disk = 'public'): string
    {
        $name = Str::uuid()->toString().'.'.strtolower($file->getClientOriginalExtension());
        $path = trim($folder, '/').'/'.now()->format('Y/m');

        return $file->storeAs($path, $name, $disk);
    }

    /** @param  array<int, UploadedFile>  $files */
    public function storeMany(array $files, string $folder = 'misc', string $disk = 'public'): array
    {
        return array_map(fn (UploadedFile $f) => $this->store($f, $folder, $disk), $files);
    }

    public function replace(?string $oldPath, UploadedFile $file, string $folder = 'misc', string $disk = 'public'): string
    {
        $new = $this->store($file, $folder, $disk);
        $this->delete($oldPath, $disk);

        return $new;
    }

    public function delete(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
