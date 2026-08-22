<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;
use App\Helpers\ImageCompressor;

class TestimonialController extends Controller
{
    public function index()
    {
        return redirect()->route('cms.home.index');
    }

    public function create()
    {
        return view('cms.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'description' => 'required|string',
            'stars'       => 'required|integer|min:1|max:5',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = ImageCompressor::store($request->file('photo'), 'testimonials');
        }

        $testimonial = Testimonial::create($data);

        LogHelper::log('CREATE', 'Testimonials', "Added new testimonial from: {$testimonial->name}");

        $message = 'Testimonial created successfully!';

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => $message,
                'redirect' => route('cms.home.index'),
            ]);
        }

        return redirect()->route('cms.home.index')->with('success', $message);
    }

    public function edit(Testimonial $testimonial)
    {
        return view('cms.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'description' => 'required|string',
            'stars'       => 'required|integer|min:1|max:5',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $data['photo'] = ImageCompressor::store($request->file('photo'), 'testimonials');
        }

        $testimonial->update($data);

        LogHelper::log('UPDATE', 'Testimonials', "Updated testimonial from: {$testimonial->name}");

        $message = 'Testimonial updated successfully!';

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => $message,
                'redirect' => route('cms.home.index'),
            ]);
        }

        return redirect()->route('cms.home.index')->with('success', $message);
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:testimonials,id',
        ]);

        $items = Testimonial::whereIn('id', $validated['ids'])->get();
        $ids   = $items->pluck('id')->all();

        foreach ($items as $item) {
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $item->delete();
        }

        $count = count($ids);
        LogHelper::log('DELETE', 'Testimonials', "Bulk deleted {$count} testimonials.");

        $message = "{$count} testimonial(s) deleted successfully!";

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'ids' => $ids]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }
        $testimonial->delete();

        LogHelper::log('DELETE', 'Testimonials', "Deleted testimonial from: $name");

        $message = 'Testimonial deleted successfully!';

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
