<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Every section can hide its banner and shows a managed sub-heading
 * (small pill label + large title + description, the "Industrial Solutions" style).
 * Banners start hidden; each section gets a sensible default heading.
 */
return new class extends Migration
{
    private const HEADINGS = [
        'bie' => ['Our Industrial Estate', 'Bintan Industrial Estate', 'A self-contained, sea-front industrial township just 60 minutes by ferry from Singapore.'],
        'bintan' => ['Company Profile', 'PT Bintan Inti Industrial Estate', 'Developer and manager of Bintan Industrial Estate in Lobam, Bintan: a self-contained, sea-front industrial township just 60 minutes by ferry from Singapore, and a member of Gallant Venture Ltd within the Salim Group.'],
        'work' => ['Business Opportunity', 'Land & Factories Ready for You', 'Prepared land parcels and ready-built factories designed for a fast, cost-efficient start-up.'],
        'service_suite' => ['One Stop Service Suite', 'Everything Your Operation Needs', 'Comprehensive support services designed for operational efficiency.'],
        'blog' => ['Blog', 'Latest News & Articles', 'Stay updated with our latest news, press releases and stories.'],
        'program' => ['Beyond The Workplace', 'Life at Bintan Industrial Estate', 'Where meaningful celebrations, leisure and community care come together.'],
        'career' => ['Grow With Us', 'Careers at Bintan Industrial Estate', 'Build your career at the forefront of industrial development in Bintan. Explore our current openings below.'],
    ];

    public function up(): void
    {
        Schema::table('section_settings', function (Blueprint $table) {
            $table->boolean('show_banner')->default(true)->after('section_key');
            $table->string('heading_badge')->nullable()->after('subtitle');
            $table->string('heading_title')->nullable()->after('heading_badge');
            $table->text('heading_description')->nullable()->after('heading_title');
        });

        $now = now();
        foreach (self::HEADINGS as $key => [$badge, $title, $description]) {
            $exists = DB::table('section_settings')->where('section_key', $key)->exists();
            $values = [
                'show_banner'         => false,
                'heading_badge'       => $badge,
                'heading_title'       => $title,
                'heading_description' => $description,
                'updated_at'          => $now,
            ];

            if ($exists) {
                DB::table('section_settings')->where('section_key', $key)->update($values);
            } else {
                DB::table('section_settings')->insert($values + ['section_key' => $key, 'created_at' => $now]);
            }
        }

        Cache::forget('bie_page_settings');
        Cache::forget('section_setting_career');
    }

    public function down(): void
    {
        Schema::table('section_settings', function (Blueprint $table) {
            $table->dropColumn(['show_banner', 'heading_badge', 'heading_title', 'heading_description']);
        });

        Cache::forget('bie_page_settings');
        Cache::forget('section_setting_career');
    }
};
