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
    Schema::create('careers', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('location')->default('Bintan, Kepulauan Riau');
        $table->string('level');
        $table->string('min_education');
        $table->string('min_experience');
        $table->text('description');
        $table->text('requirements');
        $table->enum('status', ['open', 'closed'])->default('open');
        $table->date('posted_date');
        $table->date('closing_date');
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
        Schema::dropIfExists('careers');
    }
};
