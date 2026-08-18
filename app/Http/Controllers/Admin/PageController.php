<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Page::class, 'page');
    }

    public function index()
    {
        return view('admin.cms.pages.index', ['pages' => Page::latest('id')->paginate(20)]);
    }

    public function create()
    {
        return view('admin.cms.pages.form', ['page' => new Page]);
    }

    public function edit(Page $page)
    {
        $page->load('seo');

        return view('admin.cms.pages.form', compact('page'));
    }

    public function store(Request $request)
    {
        $page = Page::create($this->validateData($request));
        $page->syncSeo($request->input('seo', []));

        return redirect()->route('admin.pages.edit', $page->uuid)->with('success', 'Page created.');
    }

    public function update(Request $request, Page $page)
    {
        $page->update($this->validateData($request, $page));
        $page->syncSeo($request->input('seo', []));

        return back()->with('success', 'Page updated.');
    }

    public function destroy(Page $page)
    {
        abort_if($page->is_system, 403, 'System pages cannot be deleted.');

        $page->delete();

        return back()->with('success', 'Page deleted.');
    }

    private function validateData(Request $request, ?Page $page = null): array
    {
        return $request->validate([
            'title'          => ['required', 'string', 'max:200'],
            'slug'           => ['nullable', 'string', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'template'       => ['required', 'string', 'max:60'],
            'content'        => ['nullable', 'string'],
            'sections'       => ['nullable', 'array'],
            'show_in_footer' => ['boolean'],
            'status'         => ['required', 'in:draft,published'],
        ]) + ['updated_by' => auth()->id()];
    }
}
