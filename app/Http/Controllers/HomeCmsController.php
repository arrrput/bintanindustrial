<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\TenantLogo;
use Illuminate\Http\Request;

class HomeCmsController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        $tenants = TenantLogo::latest()->get();
        return view('cms.home.index', compact('testimonials', 'tenants'));
    }
}
