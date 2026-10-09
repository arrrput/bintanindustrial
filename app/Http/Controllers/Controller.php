<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Bie;
use App\Models\Blog;
use App\Models\SectionSetting;
use App\Models\Testimonial;
use App\Models\TenantLogo;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        // "Our Industrial Estate" section (managed in CMS > Manage Home).
        // Shares the cache key with the Profile page so CMS updates bust both.
        $bieSetting = SectionSetting::cachedForBiePage()->get('bie');
        $bies = Bie::where('page_group', 'bie')->orderBy('order')->get();

        $blogs = Blog::latest()->take(6)->get();
        $testimonials = Testimonial::latest()->get();
        $tenants = TenantLogo::latest()->get();

        return view('home.index', compact('bieSetting', 'bies', 'blogs', 'testimonials', 'tenants'));
    }
}
