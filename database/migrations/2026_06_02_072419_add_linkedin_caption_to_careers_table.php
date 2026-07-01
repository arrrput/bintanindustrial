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
        Schema::table('careers', function (Blueprint $table) {
            $table->text('linkedin_caption')->nullable()->after('post_to_linkedin');
        });
    }

    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn('linkedin_caption');
        });
    }
};
