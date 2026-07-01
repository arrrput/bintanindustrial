<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\TenantLogo;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $blogs = Blog::latest()->take(6)->get();
        $testimonials = Testimonial::latest()->get();
        $tenants = TenantLogo::latest()->get();

        return view('index', compact('blogs', 'testimonials', 'tenants'));
    }
}
