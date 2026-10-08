<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bie;
use App\Models\SectionSetting;

class BiePageController extends Controller
{
    public function index()
    {
        // "bie" (Our Industrial Estate) is shown on Home; "work" (Service Suite, Facilities) on OSS.
        $bintanSetting = SectionSetting::cachedForBiePage()->get('bintan');
        $bintans = Bie::where('page_group', 'bintan')->orderBy('order')->get();

        return view('profile.index', compact('bintanSetting', 'bintans'));
    }
}
