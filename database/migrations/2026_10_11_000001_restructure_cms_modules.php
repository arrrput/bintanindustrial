<?php

use App\Models\Bie;
use App\Models\SectionSetting;
use App\Support\CmsPermissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * CMS restructure:
 * - "Profile & OSS" is split into "Profiles" and "OSS"; "News" becomes "Blog" (permissions renamed, access kept).
 * - The old "Facilities" rows (Prepared Land Parcels, Ready Built Factories) are now "Business Opportunity".
 * - The hard-coded OSS "Integrated Services" become manageable "Facilities" (bies: page_group work, category facility).
 */
return new class extends Migration
{
    private const RENAMES = [
        'profile-oss.manage' => 'profiles.manage',
        'news.manage'        => 'blog.manage',
    ];

    private const FACILITIES = [
        ['title' => 'Water Treatment Plant', 'icon' => 'fa-solid fa-droplet', 'file' => 'WTP.jpg'],
        ['title' => 'Power House', 'icon' => 'fa-solid fa-bolt', 'file' => 'PH.jpg'],
        ['title' => 'Waste Water Treatment Plant', 'icon' => 'fa-solid fa-water', 'file' => 'WWTP.jpg'],
        ['title' => 'Sewage Treatment Plant', 'icon' => 'fa-solid fa-recycle', 'file' => 'STP.jpg'],
        ['title' => 'Bandar Seri Udana Port', 'icon' => 'fa-solid fa-anchor', 'file' => 'BSU.jpg'],
        ['title' => 'Pujasera Foodcourt', 'icon' => 'fa-solid fa-utensils', 'file' => 'PF.jpg'],
    ];

    public function up(): void
    {
        $registrar = app(\Spatie\Permission\PermissionRegistrar::class);
        $registrar->forgetCachedPermissions();

        // 1. Rename permissions (role assignments follow automatically, they reference the id)
        foreach (self::RENAMES as $old => $new) {
            if (!Permission::where('name', $new)->exists()) {
                Permission::where('name', $old)->update(['name' => $new]);
            }
        }
        CmsPermissions::sync();
        $registrar->forgetCachedPermissions();

        // 2. Roles that managed "Profile & OSS" keep managing OSS
        foreach (Role::permission('profiles.manage')->get() as $role) {
            $role->givePermissionTo('oss.manage');
        }

        // 3. Banner of the old "Facilities" section is now "Business Opportunity"
        SectionSetting::where('section_key', 'work')->where('title', 'Facilities')->update(['title' => 'Business Opportunity']);

        // 4. Facilities: move the hard-coded list into the database (only once)
        if (!Bie::where('page_group', 'work')->where('category', 'facility')->exists()) {
            foreach (self::FACILITIES as $i => $facility) {
                $source = public_path('assets/img/Services/' . $facility['file']);
                $image = null;
                if (File::exists($source)) {
                    $image = 'facilities/' . strtolower($facility['file']);
                    Storage::disk('public')->put($image, File::get($source));
                }

                Bie::create([
                    'page_group'  => 'work',
                    'category'    => 'facility',
                    'title'       => $facility['title'],
                    'icon'        => $facility['icon'],
                    'image'       => $image,
                    'description' => null,
                    'order'       => $i + 1,
                ]);
            }
        }

        Cache::forget('bie_page_settings');
        $registrar->forgetCachedPermissions();
    }

    public function down(): void
    {
        foreach (self::RENAMES as $old => $new) {
            Permission::where('name', $new)->update(['name' => $old]);
        }
        Permission::where('name', 'oss.manage')->delete();

        SectionSetting::where('section_key', 'work')->where('title', 'Business Opportunity')->update(['title' => 'Facilities']);

        foreach (Bie::where('page_group', 'work')->where('category', 'facility')->get() as $facility) {
            if ($facility->image) {
                Storage::disk('public')->delete($facility->image);
            }
            $facility->delete();
        }

        Cache::forget('bie_page_settings');
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
