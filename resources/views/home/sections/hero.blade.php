{{-- Section: Hero --}}
<section id="home" class="hero hero-full section">
    <div class="hero-full-bg" style="background-image: url('{{ asset('assets/img/hero-bg.jpg') }}');"></div>
    <div class="hero-full-overlay"></div>

    <div class="container hero-full-content">
        <div class="hero-full-text" data-aos="fade-up" data-aos-duration="900">
            <h3>THE BEST INVESTMENT IN SOUTH EAST ASIA</h3>
            <h1>Bintan Industrial Estate</h1>
            <p>One Location For Global Markets</p>
        </div>

        <div class="hero-full-bottom" data-aos="fade-up" data-aos-duration="900" data-aos-delay="200">
            <div class="hero-full-actions">
                <a href="{{ route('profile') }}" class="hero-btn hero-btn-primary">
                    Explore us <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ URL::to('/vr360/index.html') }}" target="_blank" class="hero-btn hero-btn-light">
                    <i class="bi bi-globe"></i> 360 View
                </a>
            </div>

            <button type="button" class="hero-video-link" id="heroVideoOpen">
                <span class="hero-video-circle"><i class="bi bi-play-fill"></i></span>
                <span class="hero-video-label">Watch video profile</span>
            </button>
        </div>
    </div>
</section>

{{-- Video profile modal (rendered at the end of <body>, outside AOS transforms) --}}
@push('scripts')
    <div class="hv-modal" id="heroVideoModal" aria-hidden="true" data-lenis-prevent>
        <div class="hv-backdrop" data-hv-close></div>
        <div class="hv-dialog" role="dialog" aria-modal="true" aria-label="Video profile">
            <button type="button" class="hv-close" data-hv-close aria-label="Close"><i class="bi bi-x-lg"></i></button>

            <div class="hv-player" id="hvPlayer">
                <video id="hvVideo" src="{{ route('video.profile') }}"
                    poster="{{ asset('assets/img/hero-bg.jpg') }}" preload="none" playsinline
                    controlsList="nodownload" oncontextmenu="return false;"></video>

                <button type="button" class="hv-center" id="hvCenter" aria-label="Play"><i class="bi bi-play-fill"></i></button>

                <div class="hv-controls">
                    <input type="range" class="hv-progress" id="hvProgress" min="0" max="100" step="0.01" value="0" aria-label="Seek">
                    <div class="hv-row">
                        <div class="hv-group">
                            <button type="button" class="hv-btn" id="hvBack" title="Mundur 10 detik"><i class="bi bi-arrow-counterclockwise"></i><small>10</small></button>
                            <button type="button" class="hv-btn hv-btn-main" id="hvPlay" title="Play / Pause"><i class="bi bi-play-fill"></i></button>
                            <button type="button" class="hv-btn" id="hvFwd" title="Maju 10 detik"><i class="bi bi-arrow-clockwise"></i><small>10</small></button>
                            <span class="hv-time" id="hvTime">0:00 / 0:00</span>
                        </div>
                        <div class="hv-group">
                            <button type="button" class="hv-btn" id="hvMute" title="Mute"><i class="bi bi-volume-up-fill"></i></button>
                            <input type="range" class="hv-volume" id="hvVolume" min="0" max="1" step="0.05" value="1" aria-label="Volume">
                            <button type="button" class="hv-btn" id="hvFull" title="Fullscreen"><i class="bi bi-fullscreen"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/pages/index-hero-video.js') }}?v={{ filemtime(public_path('assets/js/pages/index-hero-video.js')) }}"></script>
@endpush
