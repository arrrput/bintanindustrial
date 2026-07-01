<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAddress extends Model
{
    protected $fillable = [
        'applicant_id', 'country', 'postal_code', 'address_line', 'city_regency', 'province'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
