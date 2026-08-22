<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\SectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;
use App\Helpers\ImageCompressor;

class ProgramController extends Controller
{
    /**
     * Menampilkan daftar item "Program" di CMS
     */
    public function index()
    {
        $programs = Program::orderBy('category')->orderBy('order')->get();
        $setting = SectionSetting::where('section_key', 'program')->first();
        return view('cms.programs.index', compact('programs', 'setting'));
    }

    /**
     * Menampilkan form untuk membuat item baru
     */
    public function create()
    {
        return view('cms.programs.create');
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
            'category'    => 'required|in:event,entertainment,csr',
            'order'       => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = ImageCompressor::store($request->file('image'), 'program');
        }

        // Auto-increment order logic
        $order = $request->order;
        if (is_null($order)) {
            $maxOrder = Program::where('category', $request->category)->max('order');
            $order = $maxOrder ? $maxOrder + 1 : 1;
        }

        $program = Program::create([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'image'       => $imagePath,
            'category'    => $request->category,
            'order'       => $order,
        ]);

        LogHelper::log('CREATE', 'Program at BIE', "Added new Program content: {$program->title}");

        return redirect()->route('cms.programs.index')
                         ->with('success', 'Program content successfully added!');
    }

    /**
     * Menampilkan form edit item
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('cms.programs.edit', compact('program'));
    }

    /**
     * Memperbarui item di database
     */
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category'    => 'required|in:event,entertainment,csr',
        ]);

        $imagePath = $program->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
            }
            $imagePath = ImageCompressor::store($request->file('image'), 'program');
        }

        $program->update([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'image'       => $imagePath,
            'category'    => $request->category,
        ]);

        LogHelper::log('UPDATE', 'Program at BIE', "Updated Program content: {$program->title}");

        return redirect()->route('cms.programs.index')
                         ->with('success', 'Program content successfully updated!');
    }

    /**
     * Menghapus item
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $title = $program->title;

        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();

        LogHelper::log('DELETE', 'Program at BIE', "Deleted Program content: $title");

        return redirect()->route('cms.programs.index')
                         ->with('success', 'Program content successfully deleted!');
    }

    /**
     * Menampilkan halaman Program untuk publik
     */
    public function publicIndex()
    {
        $eventProgram = Program::where('category', 'event')->orderBy('order')->get();
        $entertainmentProgram = Program::where('category', 'entertainment')->orderBy('order')->get();
        $csrProgram = Program::where('category', 'csr')->orderBy('order')->get();
        $setting = SectionSetting::where('section_key', 'program')->first();

        return view('program', compact('eventProgram', 'entertainmentProgram', 'csrProgram', 'setting'));
    }
}
