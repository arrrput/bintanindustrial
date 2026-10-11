<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bie;
use App\Models\SectionSetting;

class OssCmsController extends Controller
{
    // Manage OSS: everything shown on the public OSS page (One Stop Service Suite, Facilities).
    public function index()
    {
        $works = Bie::where('page_group', 'work')->whereIn('category', ['service_suite', 'facility'])->orderBy('order')->get();
        $suiteWorks = $works->where('category', 'service_suite')->values();
        $facilities = $works->where('category', 'facility')->values();

        $serviceSuiteSetting = SectionSetting::where('section_key', 'service_suite')->first();
        $facilitiesSetting = SectionSetting::where('section_key', 'facilities')->first();

        return view('cms.oss.index', compact('suiteWorks', 'facilities', 'serviceSuiteSetting', 'facilitiesSetting'));
    }
}
