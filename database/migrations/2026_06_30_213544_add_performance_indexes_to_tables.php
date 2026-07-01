<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bies', function (Blueprint $table) {
            $table->index('page_group');
            $table->index(['page_group', 'category']);
            $table->index(['page_group', 'order']);
        });

        Schema::table('careers', function (Blueprint $table) {
            $table->index('status');
            $table->index('closing_date');
            $table->index(['status', 'closing_date']);
            $table->index('posted_date');
        });

        Schema::table('applicants', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('lives', function (Blueprint $table) {
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::table('bies', function (Blueprint $table) {
            $table->dropIndex(['page_group']);
            $table->dropIndex(['page_group', 'category']);
            $table->dropIndex(['page_group', 'order']);
        });

        Schema::table('careers', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['closing_date']);
            $table->dropIndex(['status', 'closing_date']);
            $table->dropIndex(['posted_date']);
        });

        Schema::table('applicants', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('lives', function (Blueprint $table) {
            $table->dropIndex(['category']);
        });
    }
};
