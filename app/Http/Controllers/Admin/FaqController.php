<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Model;

class FaqController extends CrudController
{
    protected string $model = Faq::class;

    protected string $viewPath = 'admin.cms.faqs';

    protected string $routeName = 'admin.faqs';

    protected string $permission = 'cms';

    protected array $searchable = ['question', 'answer'];

    protected array $columns = ['question' => 'Question', 'category' => 'Category', 'sort_order' => 'Order'];

    protected string $title = 'FAQs';

    protected function rules(?Model $record = null): array
    {
        return [
            'category'   => ['nullable', 'string', 'max:80'],
            'question'   => ['required', 'string', 'max:255'],
            'answer'     => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'is_active'  => ['boolean'],
        ];
    }
}
