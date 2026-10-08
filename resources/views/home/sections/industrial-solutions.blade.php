{{-- Section: Industrial Solutions (factory types + 3D viewer) --}}
@php
    $factoryTypes = [
        [
            'model' => 'A',
            'title' => 'TYPE A',
            'subtitle' => 'Single Storey Terrace',
            'image' => 'assets/img/Factory/Type A-Single Storey Terrace.webp',
            'url' => '/factory/type-a',
        ],
        [
            'model' => 'B',
            'title' => 'TYPE B',
            'subtitle' => 'Detached Single Storey',
            'image' => 'assets/img/Factory/Tipe B-Detached-Single-Storey-with-Mezzanine-Floor-copy.webp',
            'url' => '/factory/type-b',
        ],
        [
            'model' => 'C',
            'title' => 'TYPE C',
            'subtitle' => 'Semi-Detached Factory',
            'image' => 'assets/img/Factory/Tipe C-Single-Storey-Semi-Detached-copy.webp',
            'url' => '/factory/type-c',
        ],
        [
            'model' => null, // No 3D model for custom build
            'title' => 'Custom Build',
            'subtitle' => 'Tailored to Your Needs',
            'image' => 'assets/img/Factory/Custom Build.jpg',
            'url' => '/factory/custom',
        ],
    ];
@endphp

<section id="factype" class="featured-services section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Industrial Solutions</h2>
        <p>Explore Our <span>Factory Types</span></p>
        <small class="text-muted d-block mt-2">
            Click anywhere on a card to view its 3D model. Click the Read more to see details.
        </small>
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
            @foreach ($factoryTypes as $i => $factory)
                <div class="col-6 col-xl-3 d-flex" data-aos="fade-up" data-aos-delay="{{ 200 + $i * 100 }}">
                    <div class="service-item image-bg-card position-relative w-100 shadow"
                        @if ($factory['model'])
                            id="card-{{ $factory['model'] }}"
                            onclick="switchModel('{{ $factory['model'] }}', event)"
                        @endif
                        style="background-image: url('{{ asset($factory['image']) }}'); background-size: cover; background-position: center;">
                        <div class="content w-100 text-center" style="line-height: 1.2;">
                            <h4 class="m-0 text-white">{{ $factory['title'] }}</h4>
                            <p class="small m-0 opacity-75 text-white">{{ $factory['subtitle'] }}</p>
                            <a href="{{ url($factory['url']) }}"
                                class="read-more text-white small fw-bold mt-1 d-inline-block text-decoration-none"
                                onclick="event.stopPropagation();">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

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
