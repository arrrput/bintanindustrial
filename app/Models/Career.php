<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'location', 'level', 'min_education', 
        'min_experience', 'description', 'requirements', 
        'status', 'posted_date', 'closing_date',
        'post_to_linkedin', 'linkedin_caption', 'linkedin_post_id', 'media'
    ];

    protected static function booted()
    {
        static::deleting(function ($career) {
            $career->applicants()->chunkById(50, function ($chunk) {
                $chunk->each->delete();
            });
        });
    }

    public function getIsClosedAttribute()
    {
        return $this->status === 'closed' || \Carbon\Carbon::parse($this->closing_date)->endOfDay()->isPast();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}
