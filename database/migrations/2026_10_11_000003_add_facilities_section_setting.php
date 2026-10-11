<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * OSS > Facilities gets a managed sub-heading (it has no banner).
 * Defaults to the heading that used to be hard-coded on the OSS page.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!DB::table('section_settings')->where('section_key', 'facilities')->exists()) {
            DB::table('section_settings')->insert([
                'section_key'         => 'facilities',
                'show_banner'         => false,
                'title'               => 'Facilities',
                'heading_badge'       => 'World-Class Infrastructure',
                'heading_title'       => 'Facilities',
                'heading_description' => 'Reliable utilities and supporting infrastructure that keep your operations running around the clock.',
                'background_type'     => 'color',
                'background_images'   => json_encode([]),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        Cache::forget('bie_page_settings');
    }

    public function down(): void
    {
        DB::table('section_settings')->where('section_key', 'facilities')->delete();
        Cache::forget('bie_page_settings');
    }
};
