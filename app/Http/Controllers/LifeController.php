<?php

namespace App\Http\Controllers;

use App\Models\Life;
use App\Models\SectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class LifeController extends Controller
{
    /**
     * Menampilkan daftar item "Life" di CMS
     */
    public function index()
    {
        $lives = Life::orderBy('category')->orderBy('order')->get();
        $setting = SectionSetting::where('section_key', 'life')->first();
        return view('cms.lives.index', compact('lives', 'setting'));
    }

    /**
     * Menampilkan form untuk membuat item baru
     */
    public function create()
    {
        return view('cms.lives.create');
    }

    /**
     * Menyimpan item baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category'    => 'required|in:work,relaxation',
            'order'       => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('life', 'public');
        }

        // Auto-increment order logic
        $order = $request->order;
        if (is_null($order)) {
            $maxOrder = Life::where('category', $request->category)->max('order');
            $order = $maxOrder ? $maxOrder + 1 : 1;
        }

        $life = Life::create([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'image'       => $imagePath,
            'category'    => $request->category,
            'order'       => $order,
        ]);

        LogHelper::log('CREATE', 'Life at BIE', "Added new Life content: {$life->title}");

        return redirect()->route('cms.lives.index')
                         ->with('success', 'Life content successfully added!');
    }

    /**
     * Menampilkan form edit item
     */
    public function edit($id)
    {
        $life = Life::findOrFail($id);
        return view('cms.lives.edit', compact('life'));
    }

    /**
     * Memperbarui item di database
     */
    public function update(Request $request, $id)
    {
        $life = Life::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category'    => 'required|in:work,relaxation',
        ]);

        $imagePath = $life->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($life->image && Storage::disk('public')->exists($life->image)) {
                Storage::disk('public')->delete($life->image);
            }
            $imagePath = $request->file('image')->store('life', 'public');
        }

        $life->update([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'image'       => $imagePath,
            'category'    => $request->category,
        ]);

        LogHelper::log('UPDATE', 'Life at BIE', "Updated Life content: {$life->title}");

        return redirect()->route('cms.lives.index')
                         ->with('success', 'Life content successfully updated!');
    }

    /**
     * Menghapus item
     */
    public function destroy($id)
    {
        $life = Life::findOrFail($id);
        $title = $life->title;

        if ($life->image && Storage::disk('public')->exists($life->image)) {
            Storage::disk('public')->delete($life->image);
        }

        $life->delete();

        LogHelper::log('DELETE', 'Life at BIE', "Deleted Life content: $title");

        return redirect()->route('cms.lives.index')
                         ->with('success', 'Life content successfully deleted!');
    }

    /**
     * Menampilkan halaman Life untuk publik
     */
    public function publicIndex()
    {
        $workLife = Life::where('category', 'work')->orderBy('order')->get();
        $relaxationLife = Life::where('category', 'relaxation')->orderBy('order')->get();
        $setting = SectionSetting::where('section_key', 'life')->first();

        return view('life', compact('workLife', 'relaxationLife', 'setting'));
    }
}
