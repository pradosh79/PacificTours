<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use App\Services\MediaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class TestimonialController extends CrudController
{
    protected string $model = Testimonial::class;

    protected string $viewPath = 'admin.cms.testimonials';

    protected string $routeName = 'admin.testimonials';

    protected string $permission = 'cms';

    protected array $searchable = ['name', 'content'];

    public function __construct(private readonly MediaService $media) {}

    /*
     * Column list controls both what's shown in the table AND what fields
     * appear in the add/edit modal. `content` MUST be here — validation requires
     * it, and there's no other way for admins to fill it in. The generic modal
     * renders it as a textarea because it's in $textareaFields below.
     */
    protected array $columns = [
        'avatar'      => 'Photo',
        'name'        => 'Name',
        'designation' => 'Role',
        'content'     => 'What they said',
        'rating'      => 'Rating',
        'sort_order'  => 'Order',
    ];

    /** File and textarea hints for the generic add/edit modal. */
    protected array $fileFields = ['avatar'];

    protected array $textareaFields = ['content'];

    protected string $title = 'Testimonials';

    protected function rules(?Model $record = null): array
    {
        return [
            'name'        => ['required', 'string', 'max:160'],
            'designation' => ['nullable', 'string', 'max:160'],
            'company'     => ['nullable', 'string', 'max:160'],
            'rating'      => ['required', 'integer', 'between:1,5'],
            'content'     => ['required', 'string', 'max:2000'],
            'avatar'      => ['nullable', 'image', 'max:2048'],
            'sort_order'  => ['nullable', 'integer'],
            'is_active'   => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        if (($data['avatar'] ?? null) instanceof UploadedFile) {
            $data['avatar'] = $this->media->store($data['avatar'], 'testimonials');
        }

        return $data;
    }
}
