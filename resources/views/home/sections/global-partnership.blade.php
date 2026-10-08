{{-- Section: Global Partnership (testimonials + tenant logos) --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/index-clients.css') }}">
@endpush

<section id="clients" class="clients section overflow-hidden"
    style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('assets/img/bgtenant.jpg') }}');">
    <div class="container d-flex flex-column align-items-center justify-content-center" data-aos="fade-up"
        data-aos-offset="100" style="min-height: 200px;">
        <div class="section-title mb-0 pb-0">
            <h2>Global Partnership</h2>
            <p>What Our <span>Clients Say</span></p>
        </div>
    </div>

    {{-- Testimonials (horizontal scroll, driven by index.js) --}}
    <div class="horizontal-scroll-wrapper">
        <div class="horizontal-scroll-content d-flex">
            @foreach ($testimonials as $t)
                <div class="testimonial-horizontal-item">
                    <div class="testimonial-item shadow-lg rounded-4 overflow-hidden">
                        <div class="row g-0 h-100">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                @if ($t->photo)
                                    <img loading="lazy" src="{{ asset('storage/' . $t->photo) }}"
                                        class="img-fluid h-100 w-100" alt="{{ $t->name }}" style="object-fit: cover;">
                                @else
                                    <div class="text-white-50 fs-1"><i class="bi bi-person-circle"></i></div>
                                @endif
                            </div>
                            <div class="col-8 p-4 d-flex flex-column justify-content-center text-start">
                                <div class="stars mb-2 small">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="bi bi-star-fill {{ $i < $t->stars ? 'text-warning' : 'text-white-50' }}"></i>
                                    @endfor
                                </div>
                                <p class="fst-italic mb-3 text-white-50 small" style="line-height: 1.4;">
                                    "{{ $t->description }}"
                                </p>
                                <div>
                                    <h3 class="fs-6 fw-bold mb-0 text-white">{{ $t->name }}</h3>
                                    <h4 class="small text-white-50 mb-0">{{ $t->position }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Call-to-action card --}}
            <div class="testimonial-horizontal-item">
                <div class="testimonial-item shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0 h-100">
                        <div class="col-4 d-flex align-items-center justify-content-center">
                            <div class="text-white fs-1"><i class="bi bi-building"></i></div>
                        </div>
                        <div class="col-8 p-4 d-flex flex-column justify-content-center text-start">
                            <h3 class="fs-5 fw-bold mb-2 text-white">Join Our Community</h3>
                            <p class="text-white-50 small">
                                Experience world-class industrial facilities and growth opportunities at BIE.
                            </p>
                            <a href="#contact" class="btn btn-sm btn-success rounded-pill mt-2 w-50">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tenant logos --}}
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="tenants-badge badge px-3 py-2 rounded-pill border fw-bold">OUR ESTEEMED TENANTS</span>
        </div>
        <div class="tenants-swiper swiper init-swiper shadow-sm py-3 px-2">
            <script type="application/json" class="swiper-config">
                {
                    "loop": true,
                    "speed": 3000,
                    "autoplay": { "delay": 1, "disableOnInteraction": false },
                    "slidesPerView": "auto",
                    "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true },
                    "breakpoints": {
                        "320": { "slidesPerView": 3, "spaceBetween": 30 },
                        "480": { "slidesPerView": 4, "spaceBetween": 50 },
                        "640": { "slidesPerView": 5, "spaceBetween": 70 },
                        "992": { "slidesPerView": 6, "spaceBetween": 100 }
                    }
                }
            </script>
            <div class="swiper-wrapper align-items-center">
                @foreach ($tenants as $t)
                    <div class="swiper-slide text-center">
                        <img loading="lazy" src="{{ asset('storage/' . $t->logo) }}" class="img-fluid"
                            alt="{{ $t->name }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
