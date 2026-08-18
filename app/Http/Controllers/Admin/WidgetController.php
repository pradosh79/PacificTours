<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WidgetController extends Controller
{
    public function index()
    {
        return view('admin.cms.widgets.index', [
            'widgets' => Widget::orderBy('area')->get()->groupBy('area'),
        ]);
    }

    public function update(Request $request, Widget $widget)
    {
        $widget->update($request->validate([
            'title'     => ['nullable', 'string', 'max:160'],
            'content'   => ['nullable', 'array'],
            'is_active' => ['boolean'],
        ]));

        Cache::forget('cms:widgets');

        return back()->with('success', 'Widget saved.');
    }
}
