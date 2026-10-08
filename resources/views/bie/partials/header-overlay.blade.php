{{--
    Full-width section header with a background slideshow (handled by bie-unified.js).

    Params:
    - $slideshowId   : id of the slideshow container
    - $setting       : SectionSetting model (title, background_images) or null
    - $fallbackImage : image used when the setting has no background images
    - $fallbackTitle : title used when the setting has no title
    - $aos           : (optional) data-aos attributes for the title container
    - $titleClass    : (optional) extra classes for the title
--}}
@php
    $backgroundImages = collect($setting?->background_images ?? [])
        ->map(fn ($img) => asset('storage/' . $img))
        ->whenEmpty(fn () => collect([asset($fallbackImage)]));
@endphp

<section class="section-header-overlay">
    <div class="bg-container" id="{{ $slideshowId }}">
        @foreach ($backgroundImages as $index => $image)
            <div class="bg-parallax-layer {{ $index === 0 ? 'active' : '' }}"
                style="background-image: url('{{ $image }}');"></div>
        @endforeach
    </div>
    <div class="dark-overlay"></div>
    <div class="container position-relative" style="z-index: 3;"
        {!! $aos ?? 'data-aos="zoom-in" data-aos-duration="1000"' !!}>
        <h2 class="section-title-custom mx-auto {{ $titleClass ?? '' }}">{{ $setting->title ?? $fallbackTitle }}</h2>
    </div>
</section>
