{{-- Section: Hero --}}
@php
    $heroWatermarks = ['Be Professional', 'Initiative', 'Inovative', 'Engage For Collaboration'];
@endphp

<section id="home" class="hero section light-background">
    <div class="hero-watermark">
        @foreach ($heroWatermarks as $i => $word)
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="{{ 500 + $i * 200 }}">
                {{ $word }}
            </div>
        @endforeach
    </div>

    <div class="container" style="z-index: 2; position: relative;">
        <div class="row gy-4 align-items-stretch">
            {{-- Welcome card --}}
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                <div class="liquid-glass-card">
                    <div class="card-content-wrapper">
                        <h1>Welcome to </h1>
                        <h1><span>Bintan Industrial Estate</span></h1>
                        <h3>THE BEST INVESTMENT IN SOUTH EAST ASIA</h3>
                        <p>One Location For Global Markets</p>
                        <div class="d-flex mt-4">
                            <a href="{{ route('profile') }}#factype" class="btn-get-started">Explore us</a>
                            <a href="{{ URL::to('/vr360/index.html') }}" target="_blank"
                                class="btn-get-started ms-3"
                                style="background: rgba(255,255,255,0.2) !important; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3) !important;">
                                360 View
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile video --}}
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

                            {{-- Center play/pause overlay --}}
                            <div class="video-overlay-play" id="overlayPlayBtn" onclick="window.toggleHeroVid(event)"
                                style="z-index: 9999 !important; pointer-events: auto !important;">
                                <i class="bi bi-play-fill"></i>
                            </div>

                            {{-- Bottom controls bar --}}
                            <div class="video-custom-controls"
                                style="z-index: 10000 !important; pointer-events: auto !important;">
                                <div class="control-row-top">
                                    <input type="range" class="v-progress" id="vProgress"
                                        min="0" max="100" step="0.01" value="0"
                                        oninput="window.previewSeek(this.value)"
                                        onchange="window.commitSeek(this.value)"
                                        onmousedown="window.isSeeking=true; event.stopPropagation();"
                                        onclick="event.stopPropagation()" style="cursor: pointer;">
                                </div>
                                <div class="control-row-bottom">
                                    <div class="left-controls">
                                        <button class="v-btn" onclick="window.toggleHeroVid(event)">
                                            <i class="bi bi-pause-fill" id="vPlayIcon"></i>
                                        </button>
                                        <button class="v-btn" onclick="window.skipHeroVid(-10, event)">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                        <button class="v-btn" onclick="window.skipHeroVid(10, event)">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                        <span class="v-time" id="vTime">0:00 / 0:00</span>
                                    </div>
                                    <div class="right-controls">
                                        <div class="volume-group">
                                            <button class="v-btn" onclick="window.muteHeroVid(event)">
                                                <i class="bi bi-volume-mute-fill" id="vMuteIcon"></i>
                                            </button>
                                            <input type="range" class="v-volume" id="vVolume"
                                                min="0" max="1" step="0.1" value="0.5"
                                                oninput="window.volHeroVid(this.value)"
                                                onmousedown="event.stopPropagation()" onclick="event.stopPropagation()">
                                        </div>
                                        <button class="v-btn" onclick="window.fullHeroVid(event)">
                                            <i class="bi bi-fullscreen"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script src="{{ asset('assets/js/pages/index-hero-video.js') }}"></script>
@endpush
