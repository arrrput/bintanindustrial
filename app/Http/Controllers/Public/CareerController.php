<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\SectionSetting;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::where('status', '!=', 'closed')
            ->where(function ($q) {
                $q->whereNull('closing_date')
                  ->orWhere('closing_date', '>=', now()->toDateString());
            })
            ->orderBy('posted_date', 'desc')
            ->get();

        $setting = \Illuminate\Support\Facades\Cache::remember('section_setting_career', 3600, fn() =>
            SectionSetting::where('section_key', 'career')->first()
        );

        return view('careers', compact('careers', 'setting'));
    }

    public function show($slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();
        return view('careers.detail', compact('career'));
    }
}
