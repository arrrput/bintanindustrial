<?php

namespace App\Http\Controllers;

use App\Models\TenantLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class TenantLogoController extends Controller
{
    public function index()
    {
        return redirect()->route('cms.home.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'logos'   => 'required|array',
            'logos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logos')) {
            foreach ($request->file('logos') as $file) {
                $path = $file->store('tenants', 'public');
                TenantLogo::create([
                    'logo' => $path,
                    'name' => $file->getClientOriginalName(),
                ]);
            }
        }

        LogHelper::log('CREATE', 'Tenant Logos', "Uploaded " . count($request->file('logos')) . " new tenant logos.");

        return back()->with('success', 'Tenant logos uploaded successfully!');
    }

    public function destroy(TenantLogo $tenant)
    {
        $logoName = $tenant->name;
        Storage::disk('public')->delete($tenant->logo);
        $tenant->delete();

        LogHelper::log('DELETE', 'Tenant Logos', "Deleted tenant logo: $logoName");

        return back()->with('success', 'Tenant logo deleted successfully!');
    }
}
