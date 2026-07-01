<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantExperience extends Model
{
    protected $fillable = [
        'applicant_id', 'job_title', 'company', 'city', 'type_business', 'start_date', 'end_date', 'job_desc', 'leaving_reason'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
