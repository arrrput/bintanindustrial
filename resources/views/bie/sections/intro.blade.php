{{-- Section: BIE Intro (Our Industrial Estate) --}}
@include('bie.partials.header-overlay', [
    'slideshowId' => 'bieBgSlideshow',
    'setting' => $bieSetting,
    'fallbackImage' => 'assets/img/Bintan/bie.jpg',
    'fallbackTitle' => 'Our Industrial Estate',
])

<section class="page-content section position-relative overflow-hidden">
    <div class="container position-relative" style="z-index: 1;">
        @foreach ($bies as $index => $section)
            @php $isReversed = $index % 2 != 0; @endphp

            <div class="row align-items-center mb-5 pb-5" data-aos="{{ $isReversed ? 'fade-left' : 'fade-right' }}"
                data-aos-duration="1000">
                <div class="col-lg-6 {{ $isReversed ? 'order-lg-2' : '' }}">
                    <div class="position-relative">
                        <img src="{{ $section->image ? asset('storage/' . $section->image) : asset('assets/img/Bintan/image5.jpeg') }}"
                            class="img-fluid rounded shadow-lg" alt="{{ $section->title }}" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6 {{ $isReversed ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
                    @if ($section->badge)
                        <span class="badge bg-success-subtle text-success mb-2 px-3 py-2 rounded-pill fw-bold"
                            style="background: rgba(51,86,66,0.1);">{{ $section->badge }}</span>
                    @endif
                    <h2 class="text-primary fw-bold mb-2 text-uppercase">{{ $section->title }}</h2>
                    @if ($section->subtitle)
                        <h4 class="mb-3 text-secondary fw-semibold">{{ $section->subtitle }}</h4>
                    @endif
                    <div class="text-muted" style="line-height: 1.8;">
                        {!! nl2br(e($section->description)) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
