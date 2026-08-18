<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', \App\Models\Page::class);

        $menu = Menu::with(['items.children'])
            ->where('location', $request->string('location', 'header'))
            ->firstOrFail();

        return view('admin.cms.menus.index', [
            'menu'  => $menu,
            'menus' => Menu::all(),
        ]);
    }

    public function storeItem(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'parent_id'  => ['nullable', 'exists:menu_items,id'],
            'label'      => ['required', 'string', 'max:120'],
            'type'       => ['required', 'in:custom,page,category,destination,blog'],
            'url'        => ['nullable', 'string', 'max:255'],
            'target_id'  => ['nullable', 'integer'],
            'icon'       => ['nullable', 'string', 'max:60'],
            'open_in_new'=> ['boolean'],
        ]);

        $data['sort_order'] = (int) $menu->allItems()->max('sort_order') + 1;

        $menu->allItems()->create($data);
        $this->flush();

        return back()->with('success', 'Menu item added.');
    }

    public function updateItem(Request $request, MenuItem $item)
    {
        $item->update($request->validate([
            'label'       => ['required', 'string', 'max:120'],
            'url'         => ['nullable', 'string', 'max:255'],
            'icon'        => ['nullable', 'string', 'max:60'],
            'open_in_new' => ['boolean'],
        ]));

        $this->flush();

        return back()->with('success', 'Menu item updated.');
    }

    /** Drag-and-drop reorder: one flat array of {id, parent_id, sort_order}. */
    public function reorder(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'items'             => ['required', 'array'],
            'items.*.id'        => ['required', 'exists:menu_items,id'],
            'items.*.parent_id' => ['nullable', 'exists:menu_items,id'],
            'items.*.sort_order'=> ['required', 'integer'],
        ]);

        DB::transaction(function () use ($data, $menu): void {
            foreach ($data['items'] as $item) {
                $menu->allItems()->whereKey($item['id'])->update([
                    'parent_id'  => $item['parent_id'],
                    'sort_order' => $item['sort_order'],
                ]);
            }
        });

        $this->flush();

        return $this->ok(message: 'Menu order saved.');
    }

    public function destroyItem(MenuItem $item)
    {
        // Children would otherwise dangle; promote them to the item's parent.
        $item->children()->update(['parent_id' => $item->parent_id]);
        $item->delete();
        $this->flush();

        return back()->with('success', 'Menu item removed.');
    }

    private function flush(): void
    {
        Cache::forget('cms:menus');
    }
}
