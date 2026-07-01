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
        Schema::create('section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // e.g., 'bie', 'bintan', 'work', 'life', 'career', 'blog'
            $table->string('title')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_image_2')->nullable();
            $table->integer('fade_duration')->default(5); // seconds
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_settings');
    }
};
