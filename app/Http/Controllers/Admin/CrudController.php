<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Shared AJAX CRUD for the simple catalogue screens (categories, destinations,
 * countries, cities, testimonials, FAQs, banners, tags, post categories).
 * Each child sets four properties instead of repeating 120 lines of controller.
 */
abstract class CrudController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;

    protected string $viewPath;

    protected string $routeName;

    protected string $permission;

    protected array $searchable = ['name'];

    protected array $relations = [];

    /**
     * Column map for the generic table: 'accessor' => 'Heading'.
     * Dot notation walks relations ('country.name'). Children that need a
     * bespoke layout simply ship their own Blade file at $viewPath instead.
     */
    protected array $columns = ['name' => 'Name'];

    protected string $title = 'Records';

    /**
     * Field-type hints for the generic add/edit modal — override in children
     * so file/textarea/select inputs render correctly.
     *
     *   $fileFields    — columns that should be rendered as file inputs
     *   $textareaFields— columns that should be rendered as textareas
     *   $selectOptions — ['column' => ['value' => 'Label', ...]]
     *
     * Any column not listed here defaults to a single-line text input.
     */
    protected array $fileFields = ['image', 'avatar', 'thumbnail', 'banner', 'logo', 'favicon', 'photo', 'cover'];

    protected array $textareaFields = ['description', 'content', 'answer', 'address', 'bio', 'excerpt'];

    protected array $selectOptions = [];

    abstract protected function rules(?Model $record = null): array;

    public function index(Request $request)
    {
        $this->guard('view');

        $records = $this->model::query()
            ->with($this->relations)
            ->when($request->filled('keyword'), function ($q) use ($request): void {
                $q->where(function ($sub) use ($request): void {
                    foreach ($this->searchable as $column) {
                        $sub->orWhere($column, 'like', "%{$request->keyword}%");
                    }
                });
            })
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 20))
            ->withQueryString();

        // Prefer a bespoke view; fall back to the shared generic CRUD screen.
        $table = view()->exists("{$this->viewPath}.partials.table")
            ? "{$this->viewPath}.partials.table"
            : 'admin.crud.partials.table';

        $index = view()->exists("{$this->viewPath}.index")
            ? "{$this->viewPath}.index"
            : 'admin.crud.index';

        $payload = [
            'records'        => $records,
            'columns'        => $this->columns,
            'title'          => $this->title,
            'routeName'      => $this->routeName,
            'fileFields'     => $this->fileFields,
            'textareaFields' => $this->textareaFields,
            'selectOptions'  => $this->selectOptions,
        ];

        return $request->ajax()
            ? view($table, $payload)->render()
            : view($index, $payload);
    }

    public function store(Request $request)
    {
        $this->guard('create');

        $record = $this->model::create($this->prepare($request->validate($this->rules())));
        $this->afterSave($record);

        return $request->ajax()
            ? $this->ok($record, 'Created.')
            : back()->with('success', 'Created.');
    }

    public function update(Request $request, int $id)
    {
        $this->guard('update');

        $record = $this->model::findOrFail($id);
        $record->update($this->prepare($request->validate($this->rules($record))));
        $this->afterSave($record);

        return $request->ajax()
            ? $this->ok($record, 'Saved.')
            : back()->with('success', 'Saved.');
    }

    public function destroy(Request $request, int $id)
    {
        $this->guard('delete');

        $record = $this->model::findOrFail($id);
        $record->delete();
        $this->afterDelete($record);

        return $request->ajax()
            ? $this->ok(message: 'Deleted.')
            : back()->with('success', 'Deleted.');
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'action' => ['required', 'in:delete,activate,deactivate'],
            'ids'    => ['required', 'array', 'min:1'],
        ]);

        $this->guard($data['action'] === 'delete' ? 'delete' : 'update');

        $query = $this->model::whereIn('id', $data['ids']);

        $affected = match ($data['action']) {
            'delete'     => $query->delete(),
            'activate'   => $query->update(['is_active' => true]),
            'deactivate' => $query->update(['is_active' => false]),
        };

        return $this->ok(['affected' => $affected], "{$affected} record(s) updated.");
    }

    /** Hook for child controllers that need to transform input (file uploads, slugs). */
    protected function prepare(array $data): array
    {
        return $data;
    }

    /** Hooks for children that need to flush caches or fire events after writes. */
    protected function afterSave(Model $record): void {}

    protected function afterDelete(Model $record): void {}

    private function guard(string $ability): void
    {
        abort_unless(auth()->user()->can("{$this->permission}.{$ability}") || auth()->user()->isSuperAdmin(), 403);
    }
}
