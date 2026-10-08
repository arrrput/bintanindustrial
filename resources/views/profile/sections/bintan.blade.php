{{-- Section: Bintan Island (advantages slider + descriptions) --}}
@include('partials.section-header-overlay', [
    'slideshowId' => 'bintanBgSlideshow',
    'setting' => $bintanSetting,
    'fallbackImage' => 'assets/img/Bintan/bintan.jpg',
    'fallbackTitle' => 'Bintan Island',
])

<section class="why-bintan section light-background position-relative">
    <div class="container position-relative" style="z-index: 1;">
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill fw-bold"
                style="font-size: 1rem; border: 1px solid rgba(51,86,66,0.2); letter-spacing: 1px;">
                ADVANTAGES
            </span>
        </div>

        {{-- Image slider (synced with descriptions below by bie-unified.js) --}}
        <div class="bintan-slider-outer" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-arrow-left-circle-fill bintan-prev"></i>
            <div class="swiper bintan-img-slider">
                <div class="swiper-wrapper">
                    @foreach ($bintans as $slider)
                        <div class="swiper-slide">
                            <img src="{{ $slider->image ? asset('storage/' . $slider->image) : asset('assets/img/Bintan/image2.jpeg') }}"
                                alt="{{ $slider->title }}" loading="lazy">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination bintan-pagination"></div>
            </div>
            <i class="bi bi-arrow-right-circle-fill bintan-next"></i>
        </div>

        {{-- Description per slide --}}
        <div class="bintan-desc-container mt-5">
            @foreach ($bintans as $index => $slider)
                <div class="bintan-desc-item" data-index="{{ $index }}">
                    <h3><i class="{{ $slider->icon ?? 'fa-solid fa-circle' }} me-2"></i> {{ $slider->title }}</h3>

                    @if ($slider->subtitle)
                        <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">
                            {{ $slider->subtitle }}
                        </p>
                    @endif

                    @if ($slider->description)
                        <div class="description-content mb-4 text-muted" style="line-height: 1.8;">
                            {!! nl2br(e($slider->description)) !!}
                        </div>
                    @endif

                    {{-- Extra content depends on the slide's layout style --}}
                    @if ($slider->layout_style == 'info_grid' && isset($slider->extra_content))
                        @php
                            $glance = $slider->extra_content['glance'] ?? null;
                            $distance = $slider->extra_content['distance'] ?? null;
                        @endphp

                        <div class="row mt-4">
                            @if ($glance && isset($glance['items']))
                                <div class="col-md-6">
                                    <h5 class="fw-bold text-dark mb-3">
                                        <i class="fa-solid fa-map-location-dot text-primary me-2"></i>
                                        {{ $glance['title'] ?? 'Column 1' }}
                                    </h5>
                                    <ul class="info-list list-unstyled">
                                        @foreach ($glance['items'] as $item)
                                            <li>
                                                <i class="{{ $item['icon'] ?? 'fa-solid fa-check' }}"></i>
                                                @isset($item['label'])
                                                    <strong>{{ $item['label'] }}:</strong>
                                                @endisset
                                                {{ $item['value'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if ($distance && isset($distance['items']))
                                <div class="col-md-6 mt-4 mt-md-0">
                                    <h5 class="fw-bold text-dark mb-3">
                                        <i class="fa-solid fa-route text-primary me-2"></i>
                                        {{ $distance['title'] ?? 'Column 2' }}
                                    </h5>
                                    <ul class="info-list list-unstyled">
                                        @foreach ($distance['items'] as $item)
                                            <li><i class="{{ $item['icon'] ?? 'fa-solid fa-ship' }}"></i> {{ $item['value'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @elseif ($slider->layout_style == 'advantage_grid' && isset($slider->extra_content['cards']))
                        <div class="row mt-4 g-3">
                            @foreach ($slider->extra_content['cards'] as $card)
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded border-start border-3 border-success h-100 shadow-sm">
                                        <h6 class="fw-bold text-primary">
                                            <i class="{{ $card['icon'] ?? 'fa-solid fa-check' }} me-2"></i> {{ $card['title'] }}
                                        </h6>
                                        <div class="info-list ps-0 small list-unstyled mt-2 text-muted">
                                            {!! nl2br(e($card['description'] ?? '')) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
