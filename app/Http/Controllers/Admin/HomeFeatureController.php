<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\HomeFeature;
use App\Services\MediaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

class HomeFeatureController extends CrudController
{
    protected string $model = HomeFeature::class;

    protected string $viewPath = 'admin.cms.home-features';

    protected string $routeName = 'admin.home-features';

    protected string $permission = 'cms';

    protected array $searchable = ['title', 'description'];

    protected array $columns = [
        'title'       => 'Title',
        'image'       => 'Image',
        'icon'        => 'Icon',
        'description' => 'Description',
        'sort_order'  => 'Order',
    ];

    protected string $title = 'Home page features';

    /** File and textarea hints for the generic modal. */
    protected array $fileFields = ['image'];

    protected array $textareaFields = ['description'];

    /**
     * Named icons available to non-technical staff. Add a matching path in
     * resources/views/components/icon.blade.php to extend this list.
     */
    protected array $selectOptions = [
        'icon' => [
            'check' => 'Check', 'users' => 'Users', 'shield' => 'Shield', 'award' => 'Award',
            'anchor' => 'Anchor', 'clock' => 'Clock', 'car' => 'Car', 'star' => 'Star',
            'heart' => 'Heart', 'phone' => 'Phone', 'mail' => 'Mail', 'map-pin' => 'Map pin',
            'gear' => 'Gear', 'calendar' => 'Calendar', 'ticket' => 'Ticket', 'tag' => 'Tag',
            'percent' => 'Percent', 'chart' => 'Chart', 'compass' => 'Compass', 'file' => 'File',
        ],
    ];

    public function __construct(private readonly MediaService $media) {}

    protected function rules(?Model $record = null): array
    {
        return [
            'icon'        => ['nullable', 'string', 'max:40'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'title'       => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        if (($data['image'] ?? null) instanceof UploadedFile) {
            $data['image'] = $this->media->store($data['image'], 'home-features');
        }

        // If the user uploaded no image AND left icon empty, fall back to a sensible default
        if (empty($data['icon']) && empty($data['image'])) {
            $data['icon'] = 'check';
        }

        return $data;
    }

    protected function afterSave(Model $record): void
    {
        Cache::forget('home:payload:'.app()->getLocale());
    }

    protected function afterDelete(Model $record): void
    {
        Cache::forget('home:payload:'.app()->getLocale());
    }
}
