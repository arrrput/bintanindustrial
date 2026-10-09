{{-- Section: Beyond The Workplace (banner + Events, Entertainment, CSR from CMS > Programs) --}}
@php
    $solidColor = $programSetting?->solidColor();
    $isLightColor = $programSetting?->isLightColor() ?? false;

    $backgroundImages = $solidColor
        ? collect()
        : collect($programSetting?->background_images ?? [])
            ->map(fn ($img) => asset('storage/' . $img))
            ->whenEmpty(fn () => collect([asset('assets/img/Bintan/condo.jpg')]));

    $bannerSubtitle = $programSetting
        ? $programSetting->subtitle
        : '"Where meaningful celebrations, leisure and community care come together. A complete, self-sustained ecosystem designed to enrich the lives of everyone within Bintan Industrial Estate."';
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/beyond-the-workplace.css') }}">
@endpush

@if ($backgroundImages->count() > 1)
    @push('scripts')
        <script src="{{ asset('assets/js/components/bg-slideshow.js') }}"></script>
    @endpush
@endif

<div class="beyond-the-workplace">
    <section class="program-parallax-divider {{ $solidColor ? 'is-solid' : '' }} {{ $isLightColor ? 'is-light' : '' }}"
        @if ($solidColor) style="background-color: {{ $solidColor }};" @endif>
        @unless ($solidColor)
            <div class="bg-container" id="programBgSlideshow">
                @foreach ($backgroundImages as $index => $image)
                    <div class="program-parallax-layer bg-parallax-layer {{ $index === 0 ? 'active' : '' }}"
                        style="background-image: url('{{ $image }}');"></div>
                @endforeach
            </div>
            <div class="program-parallax-overlay"></div>
        @endunless
        <div class="container program-parallax-content" data-aos="zoom-in" data-aos-duration="1200">
            <h3>{{ $programSetting->title ?? 'Beyond The Workplace' }}</h3>
            @if ($bannerSubtitle)
                <p>{{ $bannerSubtitle }}</p>
            @endif
        </div>
    </section>

    @include('news.sections.events')
    @include('news.sections.entertainment')
    @include('news.sections.csr')
</div>
