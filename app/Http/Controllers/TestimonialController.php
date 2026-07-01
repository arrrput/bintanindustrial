<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

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
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $testimonial = Testimonial::create($data);

        LogHelper::log('CREATE', 'Testimonials', "Added new testimonial from: {$testimonial->name}");

        return redirect()->route('cms.home.index')->with('success', 'Testimonial created successfully!');
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
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        LogHelper::log('UPDATE', 'Testimonials', "Updated testimonial from: {$testimonial->name}");

        return redirect()->route('cms.home.index')->with('success', 'Testimonial updated successfully!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }
        $testimonial->delete();

        LogHelper::log('DELETE', 'Testimonials', "Deleted testimonial from: $name");

        return back()->with('success', 'Testimonial deleted successfully!');
    }
}
