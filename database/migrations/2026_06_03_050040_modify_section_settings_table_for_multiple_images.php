<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_settings', function (Blueprint $table) {
            $table->json('background_images')->after('title')->nullable();
            $table->dropColumn(['background_image', 'background_image_2', 'fade_duration']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_settings', function (Blueprint $table) {
            $table->string('background_image')->nullable();
            $table->string('background_image_2')->nullable();
            $table->integer('fade_duration')->default(5);
            $table->dropColumn('background_images');
        });
    }
};
