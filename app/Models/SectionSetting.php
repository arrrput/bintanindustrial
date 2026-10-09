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
        'subtitle',
        'background_type',
        'background_color',
        'background_images',
    ];

    protected $casts = [
        'background_images' => 'array',
    ];

    /**
     * The solid background color when the banner uses one, otherwise null (image slideshow).
     */
    public function solidColor(): ?string
    {
        return $this->background_type === 'color' && $this->background_color
            ? $this->background_color
            : null;
    }

    /**
     * Whether the solid color is light enough to need a dark title (perceived luminance).
     */
    public function isLightColor(): bool
    {
        if (! $color = $this->solidColor()) {
            return false;
        }
        [$r, $g, $b] = sscanf($color, '#%02x%02x%02x');
        return (0.299 * $r + 0.587 * $g + 0.114 * $b) > 160;
    }

    /**
     * Settings for the bie / work / bintan / service_suite sections keyed by section_key.
     * Cached for an hour; SectionSettingController busts 'bie_page_settings' on update.
     */
    public static function cachedForBiePage(): Collection
    {
        return Cache::remember('bie_page_settings', 3600, fn () =>
            static::whereIn('section_key', ['bie', 'work', 'bintan', 'service_suite'])->get()->keyBy('section_key')
        );
    }
}
