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
            $table->dropColumn(['cert_name', 'cert_issued_by', 'cert_issued_date', 'cert_expiration_date', 'cert_comments']);
        });
    }

    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('cert_name')->nullable();
            $table->string('cert_issued_by')->nullable();
            $table->date('cert_issued_date')->nullable();
            $table->date('cert_expiration_date')->nullable();
            $table->text('cert_comments')->nullable();
        });
    }
};
