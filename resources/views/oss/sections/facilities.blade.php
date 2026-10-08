{{-- Section: Facilities --}}
@include('partials.section-header-overlay', [
    'slideshowId' => 'workBgSlideshow',
    'setting' => $workSetting,
    'fallbackImage' => 'assets/img/Bintan/work.jpg',
    'fallbackTitle' => 'Facilities',
    'aos' => 'data-aos="fade-up"',
    'titleClass' => 'mb-2',
])

<section class="page-content section position-relative overflow-hidden">
    <div class="container mt-5">
        @foreach ($works as $index => $item)
            @php $isReversed = $index % 2 != 0; @endphp

            <div class="row align-items-center mb-4 pb-2" data-aos="{{ $isReversed ? 'fade-left' : 'fade-right' }}"
                data-aos-duration="1000">
                <div class="col-lg-6 {{ $isReversed ? 'order-lg-2' : '' }}">
                    <div class="position-relative p-2 p-md-4">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/img/Bintan/image6.jpeg') }}"
                            class="img-fluid rounded-4 shadow-lg position-relative" alt="{{ $item->title }}" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6 {{ $isReversed ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
                    <div class="position-relative">
                        <h3 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px;">{{ $item->title }}</h3>
                        @if ($item->subtitle)
                            <p class="lead text-primary fw-semibold mb-4"
                                style="font-size: 1.1rem; border-left: 4px solid var(--accent-color); padding-left: 15px;">
                                {{ $item->subtitle }}
                            </p>
                        @endif
                        <div class="description-text text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                            {!! nl2br(e($item->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
