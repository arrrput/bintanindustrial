@extends('layouts.main')

@section('title', 'Home - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/index.css') }}">
@endpush

@section('content')

    <section id="home" class="hero section light-background">
        <div class="hero-watermark">
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="500">
                Be Professional
            </div>
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="700">
                Initiative
            </div>
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="900">
                Inovative
            </div>
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="1100">
                Engage For Collaboration
            </div>
        </div>
        <div class="container" style="z-index: 2; position: relative;">
            <div class="row gy-4 align-items-stretch">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                    <div class="liquid-glass-card">
                        <div class="card-content-wrapper">
                            <h1>Welcome to </h1>
                            <h1><span>Bintan Industrial Estate</span></h1>
                            <h3>THE BEST INVESTMENT IN SOUTH EAST ASIA</h3>
                            <p>One Location For Global Markets</p>
                            <div class="d-flex mt-4">
                                <a href="#factype" class="btn-get-started">Explore us</a>
                                <a href="{{ asset('vr360/index.html') }}" target="_blank" class="btn-get-started ms-3"
                                    style="background: rgba(255,255,255,0.2) !important; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3) !important;">360
                                    View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                    <div class="video-card-wrapper">
                        <div class="video-card">
                            <div class="custom-video-container" id="videoContainer"
                                style="position: relative; width: 100%; height: 100%; border-radius: 20px; overflow: hidden; background: black;">
                                <video id="heroVideo" src="{{ asset('assets/vid/biieprovid.mp4') }}"
                                    poster="{{ asset('assets/img/hero-bg.jpg') }}" preload="metadata" playsinline muted loop
                                    controlsList="nodownload" oncontextmenu="return false;"
                                    onclick="window.toggleHeroVid(event)"
                                    style="width: 100%; height: 100%; border-radius: 20px; object-fit: cover; cursor: pointer;">
                                </video>

                                <!-- Center Play/Pause Overlay -->
                                <div class="video-overlay-play" id="overlayPlayBtn" onclick="window.toggleHeroVid(event)"
                                    style="z-index: 9999 !important; pointer-events: auto !important;">
                                    <i class="bi bi-play-fill"></i>
                                </div>

                                <!-- Bottom Controls Bar -->
                                <div class="video-custom-controls"
                                    style="z-index: 10000 !important; pointer-events: auto !important;">
                                    <div class="control-row-top">
                                        <input type="range" class="v-progress" id="vProgress" min="0"
                                            max="100" step="0.01" value="0"
                                            oninput="window.previewSeek(this.value)"
                                            onchange="window.commitSeek(this.value)"
                                            onmousedown="window.isSeeking=true; event.stopPropagation();"
                                            onclick="event.stopPropagation()" style="cursor: pointer;">
                                    </div>
                                    <div class="control-row-bottom">
                                        <div class="left-controls">
                                            <button class="v-btn" onclick="window.toggleHeroVid(event)"><i
                                                    class="bi bi-pause-fill" id="vPlayIcon"></i></button>
                                            <button class="v-btn" onclick="window.skipHeroVid(-10, event)"><i
                                                    class="bi bi-arrow-counterclockwise"></i></button>
                                            <button class="v-btn" onclick="window.skipHeroVid(10, event)"><i
                                                    class="bi bi-arrow-clockwise"></i></button>
                                            <span class="v-time" id="vTime">0:00 / 0:00</span>
                                        </div>
                                        <div class="right-controls">
                                            <div class="volume-group">
                                                <button class="v-btn" onclick="window.muteHeroVid(event)"><i
                                                        class="bi bi-volume-mute-fill" id="vMuteIcon"></i></button>
                                                <input type="range" class="v-volume" id="vVolume" min="0"
                                                    max="1" step="0.1" value="0.5"
                                                    oninput="window.volHeroVid(this.value)"
                                                    onmousedown="event.stopPropagation()" onclick="event.stopPropagation()">
                                            </div>

                                            <button class="v-btn" onclick="window.fullHeroVid(event)"><i
                                                    class="bi bi-fullscreen"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script src="{{ asset('assets/js/pages/index-hero-video.js') }}"></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="factype" class="featured-services section">
        <div class="ornament-wrapper">
            <i class="fa-solid fa-city floating-ornament" style="top: 20%; left: 3%; animation-duration: 25s;"></i>
            <i class="fa-solid fa-gears floating-ornament"
                style="top: 5%; left: 80%; animation-duration: 20s; animation-delay: -2s;"></i>
        </div>
        <div class="container section-title" data-aos="fade-up">
            <h2>Industrial Solutions</h2>
            <p>Explore Our <span>Factory Types</span></p>
            <small class="text-muted d-block mt-2">Click anywhere on a card to view its 3D model. Click the Read more to
                see details.</small>
        </div>

        <div class="container">
            <div class="canvas-container shadow-sm" id="main-canvas" data-aos="zoom-in">
                <div id="loading-overlay">
                    <h4 class="mb-0">Loading 3D Models...</h4>
                    <div class="progress-bar-bg">
                        <div id="progress-fill"></div>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-6 col-xl-3 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item image-bg-card position-relative w-100 shadow" id="card-A"
                        onclick="switchModel('A', event)"
                        style="background-image: url('{{ asset('assets/img/Factory/Type A-Single Storey Terrace.webp') }}'); background-size: cover; background-position: center;">
                        <div class="content w-100 text-center" style="line-height: 1.2;">
                            <h4 class="m-0 text-white">TYPE A</h4>
                            <p class="small m-0 opacity-75 text-white">Single Storey Terrace</p>
                            <a href="{{ url('/factory/type-a') }}"
                                class="read-more text-white small fw-bold mt-1 d-inline-block text-decoration-none"
                                onclick="event.stopPropagation();">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-xl-3 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item image-bg-card position-relative w-100 shadow" id="card-B"
                        onclick="switchModel('B', event)"
                        style="background-image: url('{{ asset('assets/img/Factory/Tipe B-Detached-Single-Storey-with-Mezzanine-Floor-copy.webp') }}'); background-size: cover; background-position: center;">
                        <div class="content w-100 text-center" style="line-height: 1.2;">
                            <h4 class="m-0 text-white">TYPE B</h4>
                            <p class="small m-0 opacity-75 text-white">Detached Single Storey</p>
                            <a href="{{ url('/factory/type-b') }}"
                                class="read-more text-white small fw-bold mt-1 d-inline-block text-decoration-none"
                                onclick="event.stopPropagation();">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-xl-3 d-flex" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item image-bg-card position-relative w-100 shadow" id="card-C"
                        onclick="switchModel('C', event)"
                        style="background-image: url('{{ asset('assets/img/Factory/Tipe C-Single-Storey-Semi-Detached-copy.webp') }}'); background-size: cover; background-position: center;">
                        <div class="content w-100 text-center" style="line-height: 1.2;">
                            <h4 class="m-0 text-white">TYPE C</h4>
                            <p class="small m-0 opacity-75 text-white">Semi-Detached Factory</p>
                            <a href="{{ url('/factory/type-c') }}"
                                class="read-more text-white small fw-bold mt-1 d-inline-block text-decoration-none"
                                onclick="event.stopPropagation();">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-xl-3 d-flex" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item image-bg-card position-relative w-100 shadow"
                        style="background-image: url('{{ asset('assets/img/Factory/Custom Build.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="content w-100 text-center" style="line-height: 1.2;">
                            <h4 class="m-0 text-white">Custom Build</h4>
                            <p class="small m-0 opacity-75 text-white">Tailored to Your Needs</p>
                            <a href="{{ url('/factory/custom') }}"
                                class="read-more text-white small fw-bold mt-1 d-inline-block text-decoration-none"
                                onclick="event.stopPropagation();">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="clients" class="clients section overflow-hidden"
        style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('assets/img/bgtenant.jpg') }}') center center no-repeat; background-size: cover; background-attachment: fixed; position: relative; padding: 100px 0; margin-top: 40px;">
        <div class="container d-flex flex-column align-items-center justify-content-center" data-aos="fade-up"
            data-aos-offset="100" style="min-height: 200px;">
            <div class="section-title mb-0 pb-0">
                <h2 style="color: #ffffff !important;">Global Partnership</h2>
                <p style="color: #ffffff !important; margin-bottom: 0;">What Our <span
                        style="color: var(--accent-color);">Clients Say</span></p>
            </div>
        </div>

        <link rel="stylesheet" href="{{ asset('assets/css/pages/index-clients.css') }}">

        <div class="horizontal-scroll-wrapper" style="position: relative; overflow: hidden;">
            <div class="horizontal-scroll-content d-flex"
                style="width: max-content; padding-top: 0; padding-bottom: 100px; padding-left: 20px;">
                @foreach ($testimonials as $t)
                    <div class="testimonial-horizontal-item" style="width: 420px; margin-right: 30px; flex-shrink: 0;">
                        <div class="testimonial-item shadow-lg rounded-4 overflow-hidden"
                            style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.2); height: 210px;">
                            <div class="row g-0 h-100">
                                <div class="col-4 d-flex align-items-center justify-content-center"
                                    style="background: rgba(255,255,255,0.05);">
                                    @if ($t->photo)
                                        <img loading="lazy" src="{{ asset('storage/' . $t->photo) }}"
                                            class="img-fluid h-100 w-100" alt="{{ $t->name }}"
                                            style="object-fit: cover;">
                                    @else
                                        <div class="text-white-50 fs-1"><i class="bi bi-person-circle"></i></div>
                                    @endif
                                </div>
                                <div class="col-8 p-4 d-flex flex-column justify-content-center text-start">
                                    <div class="stars mb-2 small">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i
                                                class="bi bi-star-fill {{ $i < $t->stars ? 'text-warning' : 'text-white-50' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="fst-italic mb-3 text-white-50 small" style="line-height: 1.4;">
                                        "{{ $t->description }}"</p>
                                    <div>
                                        <h3 class="fs-6 fw-bold mb-0 text-white">{{ $t->name }}</h3>
                                        <h4 class="small text-white-50 mb-0">{{ $t->position }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="testimonial-horizontal-item" style="width: 420px; margin-right: 30px; flex-shrink: 0;">
                    <div class="testimonial-item shadow-lg rounded-4 overflow-hidden"
                        style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.2); height: 210px;">
                        <div class="row g-0 h-100">
                            <div class="col-4 d-flex align-items-center justify-content-center"
                                style="background: rgba(255,255,255,0.05);">
                                <div class="text-white fs-1"><i class="bi bi-building"></i></div>
                            </div>
                            <div class="col-8 p-4 d-flex flex-column justify-content-center text-start">
                                <h3 class="fs-5 fw-bold mb-2 text-white">Join Our Community</h3>
                                <p class="text-white-50 small">Experience world-class industrial facilities and growth
                                    opportunities at BIE.</p>
                                <a href="#contact" class="btn btn-sm btn-success rounded-pill mt-2 w-50">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="text-center mb-4" data-aos="fade-up">
                <span class="badge px-3 py-2 rounded-pill border fw-bold"
                    style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); color: #ffffff; border-color: rgba(255,255,255,0.2);">OUR
                    ESTEEMED TENANTS</span>
            </div>
            <div class="swiper init-swiper shadow-sm py-3 px-2"
                style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.2);">
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
                                alt="{{ $t->name }}"
                                style="max-height: 60px; transition: 0.3s; filter: none !important;">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="services section">
        <div class="container section-title" data-aos="fade-up">
            <h2>World-Class Infrastructure</h2>
            <p>Integrated <span>Services</span></p>
        </div>

        <div class="container">
            <div class="row gy-4">
                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url({{ asset('assets/img/Services/WTP.jpg') }}); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="bi bi-droplet-half"></i>
                            </div>
                            <a href="{{ asset('assets/img/Services/WTP1.jpg') }}" class="stretched-link glightbox"
                                data-gallery="services-gallery">
                                <h3>Water Treatment Plant</h3>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url('{{ asset('assets/img/Services/PH.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                            <a href="{{ asset('assets/img/Services/PH1.jpg') }}" class="stretched-link glightbox"
                                data-gallery="services-gallery">
                                <h3>Power House</h3>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url('{{ asset('assets/img/Services/WWTP.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="bi bi-water"></i>
                            </div>
                            <a href="{{ asset('assets/img/Services/WWTP1.jpg') }}" class="stretched-link glightbox"
                                data-gallery="services-gallery">
                                <h3>Waste Water Treatment Plant</h3>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url('{{ asset('assets/img/Services/STP.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="bi bi-life-preserver"></i>
                            </div>
                            <a href="{{ asset('assets/img/Services/STP1.jpg') }}" class="stretched-link glightbox"
                                data-gallery="services-gallery">
                                <h3>Sewage Treatment Plant</h3>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url('{{ asset('assets/img/Services/BSU.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="bi bi-calendar4-week"></i>
                            </div>
                            <a href="{{ asset('assets/img/Services/BSU1.jpg') }}" class="stretched-link glightbox"
                                data-gallery="services-gallery">
                                <h3>Bandar Seri Udana Port</h3>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url('{{ asset('assets/img/Services/PF.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="bi bi-egg-fried"></i>
                            </div>
                            <a href="{{ asset('assets/img/Services/PF1.jpg') }}" class="stretched-link glightbox"
                                data-gallery="services-gallery">
                                <h3>Pujasera Foodcourt</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="blog" class="blog section">
        <div class="container section-title" data-aos="fade-up">
            <h2>News & Media</h2>
            <p>Latest <span>Activity</span></p>
        </div>

        <div class="container">
            <div class="isotope-layout" data-layout="masonry" data-sort="original-order">
                <div class="row gy-5 isotope-container" data-aos="fade-up" data-aos-delay="200">

                    @forelse($blogs as $blog)
                        <div class="col-lg-4 col-md-6 blog-item isotope-item">
                            <div class="blog-card-wrapper h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                                @php
                                    $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
                                    if (!$images) {
                                        $images = [$blog->image];
                                    }
                                @endphp

                                @if (count($images) > 1)
                                    <div id="carouselGrid{{ $blog->id }}" class="carousel slide carousel-fade"
                                        data-bs-ride="carousel" data-bs-interval="4000">
                                        <div class="carousel-inner">
                                            @foreach ($images as $index => $img)
                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                    <a href="{{ url('/blog/' . $blog->slug) }}"
                                                        class="d-block position-relative">
                                                        <img loading="lazy" src="{{ asset('storage/' . $img) }}"
                                                            class="img-fluid w-100" alt="{{ $blog->title }}"
                                                            style="aspect-ratio: 16 / 10; object-fit: cover;">
                                                        <div class="image-overlay"></div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ url('/blog/' . $blog->slug) }}" class="d-block position-relative">
                                        <img loading="lazy" src="{{ asset('storage/' . $images[0]) }}"
                                            class="img-fluid w-100" alt="{{ $blog->title }}"
                                            style="aspect-ratio: 16 / 10; object-fit: cover;">
                                        <div class="image-overlay"></div>
                                    </a>
                                @endif

                                <div class="blog-info">
                                    <div class="blog-info-content">
                                        <div class="d-flex align-items-center mb-2">
                                            <span
                                                class="badge bg-success-subtle text-success small border border-success-subtle px-2 py-1">{{ $blog->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <h5 class="fw-bold mb-3"><a href="{{ url('/blog/' . $blog->slug) }}"
                                                class="text-dark hover-accent">{{ $blog->title }}</a></h5>
                                    </div>

                                    <p class="blog-desc mb-4 text-muted small">
                                        {{ $blog->excerpt ?? strip_tags($blog->content) }}</p>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <a href="{{ url('/blog/' . $blog->slug) }}"
                                            class="btn btn-link p-0 fw-bold text-success text-decoration-none small">Read
                                            More <i class="bi bi-arrow-right ms-1"></i></a>
                                        <div class="d-flex gap-2">
                                            <a href="{{ asset('storage/' . $images[0]) }}"
                                                data-gallery="blog-gallery-{{ $blog->id }}"
                                                class="glightbox btn btn-sm btn-light rounded-circle"><i
                                                    class="bi bi-zoom-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="col-12 text-center text-muted py-5">
                            <i class="fa-solid fa-newspaper fs-1 mb-3 text-light"></i>
                            <p>Stay tuned for our upcoming stories.</p>
                        </div>
                    @endforelse

                </div>

                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ url('/blogs') }}" class="btn btn-outline-success rounded-pill px-5 py-2 fw-bold">View All
                        Articles</a>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Connect With Us</h2>
            <p>Get In <span>Touch</span></p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="info-wrap shadow-lg border-0 rounded-4 overflow-hidden"
                        style="background: white; padding: 40px;">
                        <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt me-3"></i>
                            <div>
                                <h3 class="fs-5 fw-bold mb-1">Our Location</h3>
                                <p class="small text-muted mb-0">Wisma Bintan Industrial Estate, Tlk. Lobam, Bintan, Riau
                                    29154</p>
                            </div>
                        </div>

                        <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone me-3"></i>
                            <div>
                                <h3 class="fs-5 fw-bold mb-1">Call Support</h3>
                                <p class="small text-muted mb-0">(0770) 696833</p>
                            </div>
                        </div>

                        <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope me-3"></i>
                            <div>
                                <h3 class="fs-5 fw-bold mb-1">Email Us</h3>
                                <p class="small text-muted mb-0">Yudha@biie.co.id</p>
                            </div>
                        </div>

                        <div class="rounded-4 overflow-hidden shadow-sm mt-4">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7978.4129713333605!2d104.24653172492981!3d1.003422104564382!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d99d16ba73f09d%3A0x1255a0678c427a50!2sBINTAN%20INDUSTRIAL%20ESTATE!5e0!3m2!1sid!2sid!4v1779332838937!5m2!1sid!2sid"
                                frameborder="0" style="border:0; width: 100%; height: 250px;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="form-wrap shadow-lg border-0 rounded-4 p-5" style="background: white;">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 rounded-3"
                                role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="php-email-form">
                            @csrf

                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" id="name-field"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" required="" style="border-radius: 10px;">
                                        <label for="name-field">Your Name</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email-field" value="{{ old('email') }}" required=""
                                            style="border-radius: 10px;">
                                        <label for="email-field">Your Email</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                            name="subject" id="subject-field" value="{{ old('subject') }}"
                                            required="" style="border-radius: 10px;">
                                        <label for="subject-field">Subject</label>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="10"
                                            id="message-field" required="" style="height: 150px; border-radius: 10px;">{{ old('message') }}</textarea>
                                        <label for="message-field">Message</label>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    @error('captcha')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div
                                        class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
                                        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
                                        <button type="submit"
                                            class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm"
                                            style="transition: 0.3s;">
                                            Send Message <i class="bi bi-send ms-2"></i>
                                        </button>
                                    </div>
                                    <div class="loading mt-3">Processing...</div>
                                    <div class="error-message mt-3"></div>
                                    <div class="sent-message mt-3">Your message has been sent. Thank you!</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.14/dist/dotlottie-wc.js" type="module"></script>
    @push('scripts')
        <script src="https://unpkg.com/three@0.128.0/build/three.min.js"></script>
        <script src="https://unpkg.com/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
        <script src="https://unpkg.com/three@0.128.0/examples/js/loaders/RGBELoader.js"></script>
        <script src="https://unpkg.com/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>
        <script>
            window.__factoryAssetBase = "{{ asset('assets/img/3d_Factory') }}";
        </script>
        <script src="{{ asset('assets/js/pages/index-3d-simulation.js') }}"></script>
    @endpush
@endsection
