<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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

    /**
     * Settings for the bie / work / bintan sections keyed by section_key.
     * Cached for an hour; SectionSettingController busts 'bie_page_settings' on update.
     */
    public static function cachedForBiePage(): Collection
    {
        return Cache::remember('bie_page_settings', 3600, fn () =>
            static::whereIn('section_key', ['bie', 'work', 'bintan'])->get()->keyBy('section_key')
        );
    }
}
