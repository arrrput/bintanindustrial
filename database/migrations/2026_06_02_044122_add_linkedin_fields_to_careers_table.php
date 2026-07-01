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
            $table->boolean('post_to_linkedin')->default(false)->after('closing_date');
            $table->string('linkedin_post_id')->nullable()->after('post_to_linkedin');
        });
    }

    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn(['post_to_linkedin', 'linkedin_post_id']);
        });
    }
};
