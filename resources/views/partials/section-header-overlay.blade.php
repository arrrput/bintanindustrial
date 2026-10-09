{{--
    Full-width section header with a background slideshow (Home, Profile)
    or a solid background color when the setting's background_type is "color".
    Its CSS and slideshow script are pushed once per page.

    Params:
    - $slideshowId   : id of the slideshow container
    - $setting       : SectionSetting model (title, subtitle, background_type, background_color, background_images) or null
    - $fallbackImage : image used when the setting has no background images
    - $fallbackTitle : title used when the setting has no title
    - $aos           : (optional) data-aos attributes for the title container
    - $titleClass    : (optional) extra classes for the title
    - $fallbackSubtitle : (optional) text under the title when the setting has none (only used without a setting)
--}}
@php
    $solidColor = $setting?->solidColor();
    $isLightColor = $setting?->isLightColor() ?? false;
    $subtitle = $setting ? $setting->subtitle : ($fallbackSubtitle ?? null);

    $backgroundImages = collect($setting?->background_images ?? [])
        ->map(fn ($img) => asset('storage/' . $img))
        ->whenEmpty(fn () => collect([asset($fallbackImage)]));
@endphp

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/components/section-header-overlay.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/js/components/bg-slideshow.js') }}"></script>
    @endpush
@endonce

<section class="section-header-overlay {{ $solidColor ? 'is-solid' : '' }} {{ $isLightColor ? 'is-light' : '' }}"
    @if ($solidColor) style="background-color: {{ $solidColor }};" @endif>
    @unless ($solidColor)
        <div class="bg-container" id="{{ $slideshowId }}">
            @foreach ($backgroundImages as $index => $image)
                <div class="bg-parallax-layer {{ $index === 0 ? 'active' : '' }}"
                    style="background-image: url('{{ $image }}');"></div>
            @endforeach
        </div>
        <div class="dark-overlay"></div>
    @endunless
    <div class="container position-relative" style="z-index: 3;"
        {!! $aos ?? 'data-aos="zoom-in" data-aos-duration="1000"' !!}>
        <h2 class="section-title-custom mx-auto {{ $titleClass ?? '' }}">{{ $setting->title ?? $fallbackTitle }}</h2>
        @if ($subtitle)
            <p class="section-subtitle-custom mx-auto">{{ $subtitle }}</p>
        @endif
    </div>
</section>
