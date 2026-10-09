<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('section_settings', function (Blueprint $table) {
            // "image" = background_images slideshow, "color" = solid background_color
            $table->string('background_type', 10)->default('image')->after('title');
            $table->string('background_color', 7)->nullable()->after('background_type');
        });
    }

    public function down()
    {
        Schema::table('section_settings', function (Blueprint $table) {
            $table->dropColumn(['background_type', 'background_color']);
        });
    }
};
