<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'title',
        'background_images',
    ];

    protected $casts = [
        'background_images' => 'array',
    ];
}
