<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bie extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_group',
        'badge',
        'title',
        'subtitle',
        'description',
        'image',
        'icon',
        'layout_style',
        'extra_content',
        'category',
        'order',
    ];

    protected $casts = [
        'extra_content' => 'array',
    ];
}
