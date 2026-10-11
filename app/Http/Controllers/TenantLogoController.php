<?php

namespace App\Http\Controllers;

use App\Models\TenantLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;
use App\Helpers\ImageCompressor;
use App\Support\UploadLimits;

class TenantLogoController extends Controller
{
    public function index()
    {
        $tenants = TenantLogo::latest()->get();
        return view('cms.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('cms.tenants.create', ['limits' => $this->limits()]);
    }

    public function store(Request $request)
    {
        // Limits come from the server's php.ini (see App\Support\UploadLimits)
        $limits = $this->limits();

        $request->validate([
            'logos'   => 'required|array|min:1|max:' . $limits['maxFiles'],
            'logos.*' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:' . UploadLimits::perFileKilobytes(),
            'names'   => 'required|array',
            'names.*' => 'required|string|max:255',
        ], [
            'logos.required'   => 'Please add at least one logo.',
            'logos.max'        => "You can add up to {$limits['maxFiles']} logos at a time (server limit).",
            'logos.*.required' => 'Every row needs a logo image.',
            'logos.*.uploaded' => "A logo could not be uploaded. Each file may be at most {$limits['perFileHuman']} on this server.",
            'logos.*.image'    => 'Each logo must be an image (JPG, PNG or WEBP).',
            'logos.*.max'      => "Each logo may not be larger than {$limits['perFileHuman']} (server limit).",
            'names.*.required' => 'Every logo needs an alternative text (the tenant name).',
        ]);

        $names = $request->input('names', []);
        $count = 0;
        foreach ($request->file('logos') as $index => $file) {
            TenantLogo::create([
                'logo' => ImageCompressor::store($file, 'tenants'),
                'name' => trim($names[$index] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)),
            ]);
            $count++;
        }

        LogHelper::log('CREATE', 'Tenant Logos', "Added {$count} new tenant logo(s).");

        return redirect()->route('cms.tenants.index')->with('success', "{$count} tenant logo(s) added successfully!");
    }

    public function edit(TenantLogo $tenant)
    {
        return view('cms.tenants.edit', ['tenant' => $tenant, 'limits' => $this->limits()]);
    }

    public function update(Request $request, TenantLogo $tenant)
    {
        $limits = $this->limits();

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:' . UploadLimits::perFileKilobytes(),
        ], [
            'name.required' => 'Please enter the alternative text (the tenant name).',
            'logo.uploaded' => "The logo could not be uploaded. Files may be at most {$limits['perFileHuman']} on this server.",
            'logo.max'      => "The logo may not be larger than {$limits['perFileHuman']} (server limit).",
        ]);

        $data = ['name' => trim($request->name)];

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($tenant->logo);
            $data['logo'] = ImageCompressor::store($request->file('logo'), 'tenants');
        }

        $tenant->update($data);

        LogHelper::log('UPDATE', 'Tenant Logos', "Updated tenant logo: {$tenant->name}");

        return redirect()->route('cms.tenants.index')->with('success', 'Tenant logo updated successfully!');
    }

    /** Server upload limits for the forms (data attributes for client-side checks + help text). */
    private function limits(): array
    {
        $perFile = UploadLimits::perFileKilobytes() * 1024;
        $total = UploadLimits::totalBytes();

        return [
            'perFileBytes' => $perFile,
            'totalBytes'   => $total,
            'maxFiles'     => UploadLimits::maxFiles(),
            'perFileHuman' => UploadLimits::human($perFile),
            'totalHuman'   => UploadLimits::human($total),
        ];
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:tenant_logos,id',
        ]);

        $logos = TenantLogo::whereIn('id', $validated['ids'])->get();
        $ids   = $logos->pluck('id')->all();

        foreach ($logos as $logo) {
            Storage::disk('public')->delete($logo->logo);
            $logo->delete();
        }

        $count = count($ids);
        LogHelper::log('DELETE', 'Tenant Logos', "Bulk deleted {$count} tenant logos.");

        $message = "{$count} tenant logo(s) deleted successfully!";

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'ids' => $ids]);
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
