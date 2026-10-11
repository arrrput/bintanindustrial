<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bie;
use App\Models\SectionSetting;

class BiePageController extends Controller
{
    public function index()
    {
        // Profile page: Bintan Island + Business Opportunity ("work" main sections).
        // "bie" (Our Industrial Estate) is shown on Home; Service Suite & Facilities on OSS.
        $settings = SectionSetting::cachedForBiePage();
        $bintanSetting = $settings->get('bintan');
        $workSetting = $settings->get('work');
        $bintans = Bie::where('page_group', 'bintan')->orderBy('order')->get();
        $works = Bie::where('page_group', 'work')->where('category', 'main_section')->orderBy('order')->get();

        return view('profile.index', compact('bintanSetting', 'bintans', 'workSetting', 'works'));
    }
}
