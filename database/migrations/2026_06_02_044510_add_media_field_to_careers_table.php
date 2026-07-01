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
            $table->string('media')->nullable()->after('linkedin_post_id');
        });
    }

    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn('media');
        });
    }
};
