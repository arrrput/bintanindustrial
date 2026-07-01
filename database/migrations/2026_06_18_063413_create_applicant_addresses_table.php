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
        Schema::create('applicant_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            $table->string('country');
            $table->string('postal_code');
            $table->text('address_line');
            $table->string('city_regency');
            $table->string('province');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_addresses');
    }
};
