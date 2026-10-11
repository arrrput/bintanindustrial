<?php

namespace App\Support;

/**
 * Single source of truth for CMS permissions.
 *
 * Permissions are checked in code (routes, views), so they are defined here
 * rather than created from the UI. The admin panel only assigns them to roles.
 */
class CmsPermissions
{
    /** Role that always has every permission (see AuthServiceProvider Gate::before). */
    public const SUPER_ADMIN_ROLE = 'IT';

    /**
     * Grouped permission definitions: group => [name => [label, description]].
     */
    public const GROUPS = [
        'Website Content' => [
            'home.manage'     => ['Manage Home', 'Our Industrial Estate sections, client testimonials and tenant logos.'],
            'profiles.manage' => ['Manage Profiles', 'Bintan Island slides and Business Opportunity on the Profile page.'],
            'oss.manage'      => ['Manage OSS', 'One Stop Service Suite and Facilities on the OSS page.'],
            'blog.manage'     => ['Manage Blog', 'Blog articles and press releases.'],
            'programs.manage' => ['Manage Programs', 'Event, Entertainment & CSR programs on the Blog page.'],
        ],
        'Recruitment' => [
            'careers.manage'    => ['Manage Careers', 'Job vacancies and their requirements.'],
            'applicants.manage' => ['Manage Applicants', 'View applicants and update their recruitment status.'],
        ],
        'System' => [
            'users.manage'       => ['Manage Users', 'Create, edit and delete CMS users and assign their role.'],
            'roles.manage'       => ['Manage Roles & Permissions', 'Create roles and decide which permissions each role has.'],
            'activity-logs.view' => ['View Activity Log', 'See the audit trail of changes made in the CMS.'],
        ],
    ];

    /**
     * Default permissions for the roles that already existed before permissions were introduced
     * (mirrors the old hard-coded role:... route middleware).
     */
    public const DEFAULT_ROLE_PERMISSIONS = [
        'HRGA' => ['careers.manage', 'applicants.manage'],
        'BDD'  => ['home.manage', 'profiles.manage', 'oss.manage', 'blog.manage', 'programs.manage'],
        'CRS'  => ['home.manage', 'profiles.manage', 'oss.manage', 'blog.manage', 'programs.manage'],
    ];

    /** @return string[] */
    public static function all(): array
    {
        return array_merge(...array_map('array_keys', array_values(self::GROUPS)));
    }

    public static function label(string $permission): string
    {
        foreach (self::GROUPS as $permissions) {
            if (isset($permissions[$permission])) {
                return $permissions[$permission][0];
            }
        }

        return $permission;
    }

    /** Create any missing permissions (safe to run repeatedly). */
    public static function sync(): void
    {
        $registrar = app(\Spatie\Permission\PermissionRegistrar::class);
        $registrar->forgetCachedPermissions();

        foreach (self::all() as $name) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $registrar->forgetCachedPermissions();
    }
}
