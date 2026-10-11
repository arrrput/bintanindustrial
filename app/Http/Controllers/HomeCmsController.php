<?php

namespace App\Http\Controllers;

use App\Models\Bie;
use App\Models\SectionSetting;
use App\Models\Testimonial;
use App\Models\TenantLogo;
use Illuminate\Http\Request;

class HomeCmsController extends Controller
{
    public function index()
    {
        // "Our Industrial Estate" section (page_group "bie")
        $bies = Bie::where('page_group', 'bie')->orderBy('order')->get();
        $bieSetting = SectionSetting::where('section_key', 'bie')->first();

        $testimonials = Testimonial::latest()->get();

        // Tenant logos: preview only, managed on their own page (cms.tenants.index)
        $tenantCount = TenantLogo::count();
        $tenants = TenantLogo::latest()->take(12)->get();

        return view('cms.home.index', compact('bies', 'bieSetting', 'testimonials', 'tenants', 'tenantCount'));
    }
}
