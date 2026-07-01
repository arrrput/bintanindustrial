<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\SectionSetting;
use Illuminate\Http\Request;
use App\Services\InstagramService;
use App\Helpers\LogHelper;

class BlogController extends Controller
{
    /**
     * Menampilkan daftar artikel blog di CMS
     */
    public function index()
    {
        // Mengambil semua blog dari database, urutkan dari yang terbaru
        $blogs = Blog::latest()->get();
        $setting = SectionSetting::where('section_key', 'blog')->first();
        return view('cms.blogs.index', compact('blogs', 'setting'));
    }

    /**
     * Menampilkan form untuk membuat artikel baru
     */
    public function create()
    {
        return view('cms.blogs.create');
    }

    /**
     * Menyimpan artikel baru ke database
     */
    /**
     * Menyimpan artikel baru ke database
     */
    /**
     * Menyimpan artikel baru ke database dan posting ke Instagram jika aktif
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'slug'      => 'required|string|unique:blogs,slug|max:255',
            'content'   => 'required',
            'image'     => 'required|array',
            'image.*'   => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt'   => 'nullable|string|max:1000',
        ]);

        $imagePaths = [];

        // Looping Upload Semua Gambar
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePaths[] = $file->store('blogs', 'public');
            }
        }

        // Simpan ke Database
        $blog = Blog::create([
            'title'      => $request->title,
            'slug'       => $request->slug,
            'content'    => $request->content,
            'excerpt'    => $request->excerpt,
            'image'      => json_encode($imagePaths), 
            'post_to_ig' => $request->has('post_to_ig') ? true : false, 
        ]);

        LogHelper::log('CREATE', 'Blogs', "Published new blog post: {$blog->title}");

        // PROSES OTOMATIS POST KE INSTAGRAM
        if ($blog->post_to_ig) {
            $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
            $firstImage = $images[0] ?? null;

            if ($firstImage) {
                
                $imageUrl = asset('storage/' . $firstImage); 
                
                $caption = $request->excerpt ?? $blog->title;

                $igService = new InstagramService();
                $igPostId = $igService->publishPost($imageUrl, $caption);

                // Update data blog jika berhasil diposting
                if ($igPostId) {
                    $blog->update(['ig_post_id' => $igPostId]);
                }
            }
        }

        return redirect()->route('cms.blogs.index')
                         ->with('success', 'Article successfully published!');
    }

    /**
     * Menampilkan form edit artikel
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('cms.blogs.edit', compact('blog'));
    }

    /**
     * Memperbarui artikel di database
     */
    /**
     * Memperbarui artikel di database
     */
    /**
     * Memperbarui artikel di database
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'     => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'content'   => 'required',
            'image.*'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt'   => 'nullable|string|max:1000',
        ]);

        // 1. Ambil data gambar lama ke dalam array
        $imagePaths = [];
        if ($blog->image) {
            $imagePaths = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
            if (!$imagePaths) $imagePaths = [$blog->image];
        }

        // 2. Cek apakah pengguna menghapus gambar lama secara spesifik
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $deletedImage) {
                // Hapus file fisiknya dari storage
                if (\Storage::disk('public')->exists($deletedImage)) {
                    \Storage::disk('public')->delete($deletedImage);
                }
                // Buang nama file tersebut dari array $imagePaths
                $imagePaths = array_diff($imagePaths, [$deletedImage]);
            }
            // Susun ulang urutan (index) array agar format JSON tetap rapi
            $imagePaths = array_values($imagePaths); 
        }

        // 3. Jika ada upload gambar BARU (Tambahkan, jangan timpa!)
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePaths[] = $file->store('blogs', 'public'); // Tambahkan ke array yang sudah ada
            }
        }

        // 4. Update Database
        $blog->update([
            'title'      => $request->title,
            'slug'       => $request->slug,
            'content'    => $request->content,
            'excerpt'    => $request->excerpt,
            'image'      => json_encode($imagePaths),
            'post_to_ig' => $request->has('post_to_ig') ? true : false,
        ]);

        LogHelper::log('UPDATE', 'Blogs', "Updated blog post: {$blog->title}");

        return redirect()->route('cms.blogs.index')
                         ->with('success', 'Article successfully updated!');
    }

    /**
     * Menghapus artikel
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $title = $blog->title;

        // Hapus gambar fisik dari storage (decode JSON array)
        if ($blog->image) {
            $imagePaths = json_decode($blog->image, true);
            if (is_array($imagePaths)) {
                foreach ($imagePaths as $path) {
                    if (\Storage::disk('public')->exists($path)) {
                        \Storage::disk('public')->delete($path);
                    }
                }
            } else {
                if (\Storage::disk('public')->exists($blog->image)) {
                    \Storage::disk('public')->delete($blog->image);
                }
            }
        }

        // Hapus data dari database
        $blog->delete();

        LogHelper::log('DELETE', 'Blogs', "Deleted blog post: {$title}");

        return redirect()->route('cms.blogs.index')
                         ->with('success', 'Article successfully deleted!');
    }

    public function publicIndex()
    {
        $blogs = Blog::latest()->paginate(9);
        $setting = SectionSetting::where('section_key', 'blog')->first();
        return view('blogs', compact('blogs', 'setting'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('blog-details', compact('blog'));
    }
}