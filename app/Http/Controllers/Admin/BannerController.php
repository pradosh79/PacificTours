<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\BannerType;
use App\Models\Banner;
use App\Services\MediaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class BannerController extends CrudController
{
    protected string $model = Banner::class;

    protected string $viewPath = 'admin.cms.banners';

    protected string $routeName = 'admin.banners';

    protected string $permission = 'cms';

    protected array $searchable = ['title', 'subtitle'];

    public function __construct(private readonly MediaService $media) {}

    protected array $columns = ['image' => 'Image', 'title' => 'Title', 'type' => 'Placement', 'starts_at' => 'Starts', 'ends_at' => 'Ends'];

    protected string $title = 'Banners';

    protected function rules(?Model $record = null): array
    {
        return [
            'type'        => ['required', Rule::enum(BannerType::class)],
            'title'       => ['nullable', 'string', 'max:200'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'image'       => [$record ? 'nullable' : 'required', 'image', 'max:6144'],
            'mobile_image'=> ['nullable', 'image', 'max:4096'],
            'button_text' => ['nullable', 'string', 'max:60'],
            'button_url'  => ['nullable', 'string', 'max:255'],
            'starts_at'   => ['nullable', 'date'],
            'ends_at'     => ['nullable', 'date', 'after:starts_at'],
            'sort_order'  => ['nullable', 'integer'],
            'is_active'   => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        foreach (['image', 'mobile_image'] as $field) {
            if (($data[$field] ?? null) instanceof UploadedFile) {
                $data[$field] = $this->media->store($data[$field], 'banners');
            }
        }

        return $data;
    }
}
