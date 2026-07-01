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
        Schema::create('applicant_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            $table->string('job_title');
            $table->string('company');
            $table->string('city')->nullable();
            $table->string('type_business')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('job_desc')->nullable();
            $table->text('leaving_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_experiences');
    }
};
