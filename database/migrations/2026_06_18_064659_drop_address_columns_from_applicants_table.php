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
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['country', 'postal_code', 'address_line', 'city', 'regency', 'province']);
        });
    }

    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address_line')->nullable();
            $table->string('city')->nullable();
            $table->string('regency')->nullable();
            $table->string('province')->nullable();
        });
    }
};
