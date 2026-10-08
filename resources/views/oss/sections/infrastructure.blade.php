{{-- Section: World-Class Infrastructure --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/components/image-bg-card.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/infrastructure.css') }}">
@endpush

@php
    $services = [
        ['title' => 'Water Treatment Plant', 'icon' => 'bi-droplet-half', 'image' => 'WTP'],
        ['title' => 'Power House', 'icon' => 'bi-lightning-charge', 'image' => 'PH'],
        ['title' => 'Waste Water Treatment Plant', 'icon' => 'bi-water', 'image' => 'WWTP'],
        ['title' => 'Sewage Treatment Plant', 'icon' => 'bi-life-preserver', 'image' => 'STP'],
        ['title' => 'Bandar Seri Udana Port', 'icon' => 'bi-calendar4-week', 'image' => 'BSU'],
        ['title' => 'Pujasera Foodcourt', 'icon' => 'bi-egg-fried', 'image' => 'PF'],
    ];
@endphp

<section id="services" class="services section">
    <div class="container section-title" data-aos="fade-up">
        <h2>World-Class Infrastructure</h2>
        <p>Integrated <span>Services</span></p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach ($services as $i => $service)
                {{-- Card uses {image}.jpg as thumbnail and {image}1.jpg as the lightbox image --}}
                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($i + 1) * 100 }}">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url('{{ asset('assets/img/Services/' . $service['image'] . '.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="bi {{ $service['icon'] }}"></i>
                            </div>
                            <a href="{{ asset('assets/img/Services/' . $service['image'] . '1.jpg') }}"
                                class="stretched-link glightbox" data-gallery="services-gallery">
                                <h3>{{ $service['title'] }}</h3>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
