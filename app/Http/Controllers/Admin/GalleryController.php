<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\MediaService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(private readonly MediaService $media) {}

    public function index()
    {
        return view('admin.cms.galleries.index', [
            'galleries' => Gallery::withCount('images')->latest('id')->paginate(20),
        ]);
    }

    public function show(Gallery $gallery)
    {
        return view('admin.cms.galleries.show', ['gallery' => $gallery->load('images')]);
    }

    public function store(Request $request)
    {
        $gallery = Gallery::create($request->validate([
            'title'       => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
        ]));

        return redirect()->route('admin.galleries.show', $gallery->uuid)->with('success', 'Gallery created.');
    }

    public function upload(Request $request, Gallery $gallery)
    {
        $request->validate([
            'images'   => ['required', 'array', 'max:20'],
            'images.*' => ['image', 'max:6144'],
        ]);

        $order = (int) $gallery->images()->max('sort_order');

        foreach ($request->file('images') as $image) {
            $gallery->images()->create([
                'path'       => $this->media->store($image, 'galleries'),
                'sort_order' => ++$order,
            ]);
        }

        return back()->with('success', 'Images uploaded.');
    }

    public function destroyImage(Gallery $gallery, int $imageId)
    {
        $image = $gallery->images()->findOrFail($imageId);
        $this->media->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->images as $image) {
            $this->media->delete($image->path);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery deleted.');
    }
}
