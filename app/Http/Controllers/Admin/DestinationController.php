<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use App\Services\MediaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class DestinationController extends CrudController
{
    protected string $model = Destination::class;

    protected string $viewPath = 'admin.cms.destinations';

    protected string $routeName = 'admin.destinations';

    protected string $permission = 'destination';

    protected array $searchable = ['name', 'slug'];

    protected array $relations = ['country:id,name'];

    public function __construct(private readonly MediaService $media) {}

    protected function rules(?Model $record = null): array
    {
        return [
            'country_id'         => ['required', 'exists:countries,id'],
            'city_id'            => ['nullable', 'exists:cities,id'],
            'name'               => ['required', 'string', 'max:160'],
            'slug'               => ['nullable', 'string', Rule::unique('destinations', 'slug')->ignore($record?->id)],
            'short_description'  => ['nullable', 'string', 'max:255'],
            'description'        => ['nullable', 'string'],
            'thumbnail'          => ['nullable', 'image', 'max:4096'],
            'banner'             => ['nullable', 'image', 'max:6144'],
            'best_time_to_visit' => ['nullable', 'string', 'max:160'],
            'is_featured'        => ['boolean'],
            'is_active'          => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        foreach (['thumbnail', 'banner'] as $field) {
            if (($data[$field] ?? null) instanceof UploadedFile) {
                $data[$field] = $this->media->store($data[$field], 'destinations');
            }
        }

        return $data;
    }
}
