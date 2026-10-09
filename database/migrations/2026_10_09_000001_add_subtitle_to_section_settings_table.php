<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('section_settings', function (Blueprint $table) {
            // Optional text under the banner title (e.g. the "Beyond The Workplace" quote)
            $table->text('subtitle')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('section_settings', function (Blueprint $table) {
            $table->dropColumn('subtitle');
        });
    }
};
