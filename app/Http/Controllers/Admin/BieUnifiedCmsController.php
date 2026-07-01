<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bie;
use App\Models\SectionSetting;

class BieUnifiedCmsController extends Controller
{
    public function index()
    {
        $bies       = Bie::where('page_group', 'bie')->orderBy('order')->get();
        $mainWorks  = Bie::where('page_group', 'work')->where('category', 'main_section')->orderBy('order')->get();
        $suiteWorks = Bie::where('page_group', 'work')->where('category', 'service_suite')->orderBy('order')->get();
        $bintans = Bie::where('page_group', 'bintan')->orderBy('order')->get();

        $bieSetting    = SectionSetting::where('section_key', 'bie')->first();
        $workSetting   = SectionSetting::where('section_key', 'work')->first();
        $bintanSetting = SectionSetting::where('section_key', 'bintan')->first();

        return view('cms.bie-page.index', compact(
            'bies', 'mainWorks', 'suiteWorks', 'bintans',
            'bieSetting', 'workSetting', 'bintanSetting'
        ));
    }
}
