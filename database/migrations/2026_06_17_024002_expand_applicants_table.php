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
            // Contact Information
            $table->string('title')->nullable()->after('nik'); // Mr, Mrs, etc
            $table->string('first_name')->after('title');
            $table->string('last_name')->after('first_name');
            $table->string('middle_name')->nullable()->after('last_name');
            $table->string('linkedin_profile')->nullable()->after('email');

            // Address
            $table->string('country')->nullable()->after('phone');
            $table->string('postal_code')->nullable()->after('country');
            $table->text('address_line')->nullable()->after('postal_code');
            $table->string('city')->nullable()->after('address_line');
            $table->string('regency')->nullable()->after('city');
            $table->string('province')->nullable()->after('regency');

            // Education
            $table->string('edu_degree')->nullable();
            $table->string('edu_major')->nullable();
            $table->string('edu_school')->nullable();
            $table->date('edu_start_date')->nullable();
            $table->date('edu_end_date')->nullable();
            $table->string('edu_country')->nullable();

            // Experience
            $table->string('exp_job_title')->nullable();
            $table->date('exp_start_date')->nullable();
            $table->date('exp_end_date')->nullable();
            $table->string('exp_company')->nullable();
            $table->string('exp_city')->nullable();
            $table->string('exp_type_business')->nullable();
            $table->text('exp_job_desc')->nullable();
            $table->text('exp_leaving_reason')->nullable();

            // License & Certification
            $table->string('cert_name')->nullable();
            $table->string('cert_issued_by')->nullable();
            $table->date('cert_issued_date')->nullable();
            $table->date('cert_expiration_date')->nullable();
            $table->text('cert_comments')->nullable();
        });
    }

    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'first_name', 'last_name', 'middle_name', 'linkedin_profile',
                'country', 'postal_code', 'address_line', 'city', 'regency', 'province',
                'edu_degree', 'edu_major', 'edu_school', 'edu_start_date', 'edu_end_date', 'edu_country',
                'exp_job_title', 'exp_start_date', 'exp_end_date', 'exp_company', 'exp_city', 'exp_type_business', 'exp_job_desc', 'exp_leaving_reason',
                'cert_name', 'cert_issued_by', 'cert_issued_date', 'cert_expiration_date', 'cert_comments'
            ]);
        });
    }
};
