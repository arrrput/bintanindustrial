<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bie;
use App\Models\SectionSetting;

class BieUnifiedCmsController extends Controller
{
    // Manage Profiles: everything shown on the public Profile page (Bintan Island, Business Opportunity).
    // "Our Industrial Estate" (page_group "bie") is managed in HomeCmsController, OSS in OssCmsController.
    public function index()
    {
        $bintans = Bie::where('page_group', 'bintan')->orderBy('order')->get();
        $mainWorks = Bie::where('page_group', 'work')->where('category', 'main_section')->orderBy('order')->get();

        $bintanSetting = SectionSetting::where('section_key', 'bintan')->first();
        $workSetting   = SectionSetting::where('section_key', 'work')->first();

        return view('cms.bie-page.index', compact('bintans', 'mainWorks', 'bintanSetting', 'workSetting'));
    }
}
