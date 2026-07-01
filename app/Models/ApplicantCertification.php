<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantCertification extends Model
{
    protected $fillable = [
        'applicant_id', 'name', 'issued_by', 'issued_date', 'expiration_date'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
