<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
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
        Schema::rename('lives', 'programs');

        DB::statement("ALTER TABLE programs MODIFY category ENUM('event', 'entertainment', 'csr') NOT NULL DEFAULT 'event'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE programs MODIFY category ENUM('work', 'relaxation') NOT NULL DEFAULT 'work'");

        Schema::rename('programs', 'lives');
    }
};
