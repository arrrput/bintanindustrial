<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEducation extends Model
{
    protected $table = 'applicant_education';
    
    protected $fillable = [
        'applicant_id', 'degree', 'major', 'school', 'start_date', 'end_date', 'country'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}