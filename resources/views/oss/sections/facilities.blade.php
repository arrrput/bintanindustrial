{{-- Section: Facilities (World-Class Infrastructure) — managed in CMS > Manage OSS --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/components/image-bg-card.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/infrastructure.css') }}">
@endpush

@if ($facilities->isNotEmpty())
<section id="services" class="services section">
    {{-- Heading managed in CMS > Manage OSS > Facilities --}}
    <div class="container">
        @include('partials.section-heading', ['setting' => $facilitiesSetting])
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach ($facilities as $i => $facility)
                @php $photo = $facility->image ? asset('storage/' . $facility->image) : asset('assets/img/Bintan/work.jpg'); @endphp
                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min(($i + 1) * 100, 600) }}">
                    <div class="image-bg-card service-item position-relative w-100 shadow"
                        style="background-image: url('{{ $photo }}'); background-size: cover; background-position: center;">
                        <div class="content">
                            <div class="icon">
                                <i class="{{ $facility->icon ?: 'fa-solid fa-industry' }}"></i>
                            </div>
                            <a href="{{ $photo }}" class="stretched-link glightbox" data-gallery="facilities-gallery"
                                @if ($facility->description) data-description="{{ $facility->description }}" @endif
                                data-title="{{ $facility->title }}">
                                <h3>{{ $facility->title }}</h3>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
