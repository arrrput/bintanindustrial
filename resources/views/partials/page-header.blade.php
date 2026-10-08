{{--
    Page header with a background slideshow (Program, Careers, News).
    CSS classes are derived from $prefix: {prefix}-header, {prefix}-bg-container,
    {prefix}-bg-layer and {prefix}-bg-overlay.

    Params:
    - $prefix         : class prefix, e.g. 'program', 'career', 'blog'
    - $slideshowId    : id of the slideshow container
    - $setting        : SectionSetting model (title, background_images) or null
    - $fallbackImage  : image used when the setting has no background images
    - $fallbackTitle  : title used when the setting has no title
    - $script         : slideshow script, only loaded when there is more than one image
    - $containerClass : (optional) extra classes for the title container
    - $aos            : (optional) data-aos attributes for the title container
--}}
@php
    $backgroundImages = collect($setting?->background_images ?? [])
        ->map(fn ($img) => asset('storage/' . $img))
        ->whenEmpty(fn () => collect([asset($fallbackImage)]));
@endphp

<section class="{{ $prefix }}-header">
    <div class="{{ $prefix }}-bg-container" id="{{ $slideshowId }}">
        @foreach ($backgroundImages as $index => $image)
            <div class="{{ $prefix }}-bg-layer {{ $index === 0 ? 'active' : '' }}"
                style="background-image: url('{{ $image }}');"></div>
        @endforeach
    </div>
    <div class="{{ $prefix }}-bg-overlay"></div>
    <div class="container position-relative {{ $containerClass ?? '' }}" style="z-index: 3;"
        {!! $aos ?? 'data-aos="zoom-in" data-aos-duration="1000"' !!}>
        <h2 class="section-title-custom text-white fw-bold mx-auto">{{ $setting->title ?? $fallbackTitle }}</h2>
    </div>
</section>

@if ($backgroundImages->count() > 1)
    @push('scripts')
        <script src="{{ asset($script) }}"></script>
    @endpush
@endif
