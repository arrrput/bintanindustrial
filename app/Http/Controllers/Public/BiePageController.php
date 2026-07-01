<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bie;
use App\Models\SectionSetting;
use Illuminate\Support\Facades\Cache;

class BiePageController extends Controller
{
    public function index()
    {
        $settings = Cache::remember('bie_page_settings', 3600, function () {
            return SectionSetting::whereIn('section_key', ['bie', 'work', 'bintan'])
                ->get()->keyBy('section_key');
        });

        $bieSetting    = $settings->get('bie');
        $workSetting   = $settings->get('work');
        $bintanSetting = $settings->get('bintan');

        $bies = Bie::where('page_group', 'bie')->orderBy('order')->get();

        $allWorks     = Bie::where('page_group', 'work')->orderBy('order')->get();
        $works        = $allWorks->where('category', 'main_section')->values();
        $serviceSuite = $allWorks->where('category', 'service_suite')->values();

        $bintans = Bie::where('page_group', 'bintan')->orderBy('order')->get();

        return view('bie-unified', compact(
            'bieSetting', 'workSetting', 'bintanSetting',
            'bies', 'works', 'bintans', 'serviceSuite'
        ));
    }
}
