<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bie;
use App\Models\SectionSetting;

class BieUnifiedCmsController extends Controller
{
    // Profile (Bintan Island) & OSS (Service Suite, Facilities) content and banners.
    // "Our Industrial Estate" (page_group "bie") is managed in HomeCmsController.
    public function index()
    {
        $mainWorks  = Bie::where('page_group', 'work')->where('category', 'main_section')->orderBy('order')->get();
        $suiteWorks = Bie::where('page_group', 'work')->where('category', 'service_suite')->orderBy('order')->get();
        $bintans = Bie::where('page_group', 'bintan')->orderBy('order')->get();

        $serviceSuiteSetting = SectionSetting::where('section_key', 'service_suite')->first();
        $workSetting   = SectionSetting::where('section_key', 'work')->first();
        $bintanSetting = SectionSetting::where('section_key', 'bintan')->first();

        return view('cms.bie-page.index', compact(
            'mainWorks', 'suiteWorks', 'bintans',
            'serviceSuiteSetting', 'workSetting', 'bintanSetting'
        ));
    }
}
