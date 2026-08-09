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
            'logos'   => 'required|array|max:20',
            'logos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $count = 0;
        foreach ($request->file('logos') as $file) {
            $path = $file->store('tenants', 'public');
            TenantLogo::create([
                'logo' => $path,
                'name' => $file->getClientOriginalName(),
            ]);
            $count++;
        }

        LogHelper::log('CREATE', 'Tenant Logos', "Uploaded {$count} new tenant logos.");

        $message = "{$count} tenant logo(s) uploaded successfully!";

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Request $request, TenantLogo $tenant)
    {
        $logoName = $tenant->name;
        Storage::disk('public')->delete($tenant->logo);
        $tenant->delete();

        LogHelper::log('DELETE', 'Tenant Logos', "Deleted tenant logo: $logoName");

        $message = 'Tenant logo deleted successfully!';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
