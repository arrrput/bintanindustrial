<?php

namespace App\Http\Controllers;

use App\Models\SectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class SectionSettingController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'section_key'        => 'required|string',
            'title'              => 'nullable|string|max:255',
            'background_images'  => 'nullable|array',
            'background_images.*'=> 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_images'      => 'nullable|array',
        ]);

        $setting = SectionSetting::firstOrNew(['section_key' => $request->section_key]);

        $setting->title = $request->title;
        
        $currentImages = $setting->background_images ?? [];

        // Remove images
        if ($request->remove_images) {
            foreach ($request->remove_images as $imgToRemove) {
                if (($key = array_search($imgToRemove, $currentImages)) !== false) {
                    Storage::disk('public')->delete($imgToRemove);
                    unset($currentImages[$key]);
                }
            }
        }

        // Add new images
        if ($request->hasFile('background_images')) {
            foreach ($request->file('background_images') as $file) {
                $path = $file->store('sections', 'public');
                $currentImages[] = $path;
            }
        }

        $setting->background_images = array_values($currentImages);
        $setting->save();

        LogHelper::log('UPDATE', 'Section Settings', "Updated settings for section: {$request->section_key}");

        return back()->with('success', 'Section settings updated successfully!');
    }
}
