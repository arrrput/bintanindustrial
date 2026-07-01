@extends('layouts.main')

@section('title', 'BIE - Bintan Industrial Estate')

@push('styles')
    <link href="{{ asset('assets/css/puu.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/pages/bie-unified.css') }}">
@endpush

@section('content')
  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li class="current">BIE</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- 1. BIE INTRO SECTION                                                      -->
  <!-- ========================================================================= -->
  <section class="section-header-overlay">
    <div class="bg-container" id="bieBgSlideshow">
      @if($bieSetting && $bieSetting->background_images && count($bieSetting->background_images) > 0)
        @foreach($bieSetting->background_images as $index => $img)
          <div class="bg-parallax-layer {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $img) }}');"></div>
        @endforeach
      @else
        <div class="bg-parallax-layer active" style="background-image: url('{{ asset('assets/img/Bintan/bie.jpg') }}');"></div>
      @endif
    </div>
    <div class="dark-overlay"></div>
    <div class="container position-relative" style="z-index: 3;" data-aos="zoom-in" data-aos-duration="1000">   
      <h2 class="section-title-custom mx-auto">{{ $bieSetting->title ?? 'Our Industrial Estate' }}</h2>
    </div>
  </section>

  <section class="page-content section position-relative overflow-hidden">
    <!-- Ornaments -->
    <i class="fa-solid fa-industry bie-bg-ornament" style="font-size: 6rem; top: 5%; right: 2%;"></i>
    <i class="fa-solid fa-boxes-stacked bie-bg-ornament" style="font-size:10rem; top: 70%; left: -2%; animation-delay: 2.5s;"></i>
    <i class="fa-solid fa-anchor bie-bg-ornament" style="font-size: 12rem; bottom: 10%; right: -2%; animation-delay: 4.5s;"></i>

    <div class="container position-relative" style="z-index: 1;">
      @foreach($bies as $index => $section)
        <div class="row align-items-center mb-5 pb-5" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}" data-aos-duration="1000">
          <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-2' : '' }}">
            <div class="position-relative">
              <img src="{{ $section->image ? asset('storage/' . $section->image) : asset('assets/img/Bintan/image5.jpeg') }}" class="img-fluid rounded shadow-lg" alt="{{ $section->title }}" loading="lazy">
              @if($index % 2 == 0)
                <div class="position-absolute bottom-0 start-0 translate-middle-y z-n1 d-none d-lg-block" style="margin-left: -100px;">
                   <i class="fa-solid fa-gears bie-bg-ornament" style="font-size: 15rem; opacity: 0.1;"></i>    
                </div>
              @else
                <div class="position-absolute top-0 end-0 translate-middle-y z-n1 d-none d-lg-block" style="margin-right: -30px;">
                   <i class="fa-solid fa-compass bie-bg-ornament" style="font-size: 9rem; opacity: 0.1;"></i>   
                </div>
              @endif
            </div>
          </div>
          <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
            @if($section->badge)
              <span class="badge bg-success-subtle text-success mb-2 px-3 py-2 rounded-pill fw-bold" style="background: rgba(51,86,66,0.1);">{{ $section->badge }}</span>
            @endif
            <h2 class="text-primary fw-bold mb-2 text-uppercase">{{ $section->title }}</h2>
            @if($section->subtitle)
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

  <!-- ========================================================================= -->
  <!-- 3. BINTAN SECTION                                                         -->
  <!-- ========================================================================= -->
  <section class="section-header-overlay">
    <div class="bg-container" id="bintanBgSlideshow">
      @if($bintanSetting && $bintanSetting->background_images && count($bintanSetting->background_images) > 0)
        @foreach($bintanSetting->background_images as $index => $img)
          <div class="bg-parallax-layer {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $img) }}');"></div>
        @endforeach
      @else
        <div class="bg-parallax-layer active" style="background-image: url('{{ asset('assets/img/Bintan/bintan.jpg') }}');"></div>
      @endif
    </div>
    <div class="dark-overlay"></div>
    <div class="container position-relative" style="z-index: 3;" data-aos="zoom-in" data-aos-duration="1000">   
      <h2 class="section-title-custom mx-auto">{{ $bintanSetting->title ?? 'Bintan Island' }}</h2>
    </div>
  </section>

  <section class="why-bintan section light-background position-relative">
    <i class="fa-solid fa-map bintan-bg-ornament" style="font-size: 11rem; top: 10%; left: -2%;"></i>
    <i class="fa-solid fa-compass bintan-bg-ornament" style="font-size: 12rem; bottom: 15%; right: -2%; animation-delay: 2s;"></i>
    <i class="fa-solid fa-ship bintan-bg-ornament" style="font-size: 8rem; top: 40%; right: 5%; animation-delay: 4s;"></i>

    <div class="container position-relative" style="z-index: 1;">
      
      <!-- Added Advantages Badge -->
      <div class="text-center mb-4" data-aos="fade-up">
        <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill fw-bold" style="font-size: 1rem; border: 1px solid rgba(51,86,66,0.2); letter-spacing: 1px;">
            ADVANTAGES
        </span>
      </div>

      <div class="bintan-slider-outer" data-aos="fade-up" data-aos-delay="200">
        <i class="bi bi-arrow-left-circle-fill bintan-prev"></i>
        <div class="swiper bintan-img-slider">
          <div class="swiper-wrapper">
            @foreach($bintans as $slider)
            <div class="swiper-slide">
                <img src="{{ $slider->image ? asset('storage/' . $slider->image) : asset('assets/img/Bintan/image2.jpeg') }}" alt="{{ $slider->title }}" loading="lazy">
            </div>
            @endforeach
          </div>
          <div class="swiper-pagination bintan-pagination"></div>
        </div>
        <i class="bi bi-arrow-right-circle-fill bintan-next"></i>
      </div>

      <div class="bintan-desc-container mt-5">
        @foreach($bintans as $index => $slider)
        <div class="bintan-desc-item" data-index="{{ $index }}">
          <h3><i class="{{ $slider->icon ?? 'fa-solid fa-circle' }} me-2"></i> {{ $slider->title }}</h3>        

          @if($slider->subtitle)
            <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">{{ $slider->subtitle }}</p>
          @endif

          @if($slider->description)
            <div class="description-content mb-4 text-muted" style="line-height: 1.8;">
              {!! nl2br(e($slider->description)) !!}
            </div>
          @endif

          {{-- Render Extra Content based on Layout Style (Preserving Bintan Logic) --}}
          @if($slider->layout_style == 'info_grid' && isset($slider->extra_content))
            <div class="row mt-4">
              @php $glance = $slider->extra_content['glance'] ?? null; @endphp
              @if($glance && isset($glance['items']))
              <div class="col-md-6">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-map-location-dot text-primary me-2"></i> {{ $glance['title'] ?? 'Column 1' }}</h5>
                <ul class="info-list list-unstyled">
                  @foreach($glance['items'] as $item)
                  <li><i class="{{ $item['icon'] ?? 'fa-solid fa-check' }}"></i> @if(isset($item['label'])) <strong>{{ $item['label'] }}:</strong> @endif {{ $item['value'] }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              @php $distance = $slider->extra_content['distance'] ?? null; @endphp
              @if($distance && isset($distance['items']))
              <div class="col-md-6 mt-4 mt-md-0">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-route text-primary me-2"></i> {{ $distance['title'] ?? 'Column 2' }}</h5>
                <ul class="info-list list-unstyled">
                  @foreach($distance['items'] as $item)
                  <li><i class="{{ $item['icon'] ?? 'fa-solid fa-ship' }}"></i> {{ $item['value'] }}</li>       
                  @endforeach
                </ul>
              </div>
              @endif
            </div>
          @elseif($slider->layout_style == 'advantage_grid' && isset($slider->extra_content['cards']))
            <div class="row mt-4 g-3">
               @foreach($slider->extra_content['cards'] as $card)
               <div class="col-md-4">
                  <div class="p-3 bg-light rounded border-start border-3 border-success h-100 shadow-sm">       
                     <h6 class="fw-bold text-primary"><i class="{{ $card['icon'] ?? 'fa-solid fa-check' }} me-2"></i> {{ $card['title'] }}</h6>
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

  <!-- ========================================================================= -->
  <!-- 4. ONE STOP SERVICE SUITE                                                 -->
  <!-- ========================================================================= -->
  @if($serviceSuite && $serviceSuite->count() > 0)
  <section class="section pt-5 pb-5 bg-white">
      <div class="container">
          <div class="text-center mb-5" data-aos="fade-up">
              <h3 class="text-primary fw-bold text-uppercase">ONE STOP SERVICE SUITE</h3>
              <p class="lead">Comprehensive support services designed for operational efficiency.</p>
          </div>

          <div class="service-suite-flex">
              @foreach($serviceSuite as $index => $service)
              <div class="service-item" data-aos="zoom-in" data-aos-delay="{{ ($index + 1) * 100 }}">
                  <div class="card service-card border-0 shadow-sm p-4 text-center d-flex flex-column h-100 w-100">
                      <div class="mb-4">
                          <i class="{{ $service->icon ?? 'fa-solid fa-gear' }} text-primary" style="font-size: 2.5rem;"></i>
                      </div>
                      <h4 class="fw-bold mb-3">{{ $service->title }}</h4>
                      <div class="small text-muted text-start flex-grow-1" style="line-height: 1.6;">
                          {!! nl2br(e($service->description)) !!}
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
      </div>
  </section>
  @endif

  <!-- ========================================================================= -->
  <!-- 5. FACILITIES SECTION                                                    -->
  <!-- ========================================================================= -->
  <section class="section-header-overlay">
    <div class="bg-container" id="workBgSlideshow">
      @if($workSetting && $workSetting->background_images && count($workSetting->background_images) > 0)
        @foreach($workSetting->background_images as $index => $img)
          <div class="bg-parallax-layer {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $img) }}');"></div>
        @endforeach
      @else
        <div class="bg-parallax-layer active" style="background-image: url('{{ asset('assets/img/Bintan/work.jpg') }}');"></div>
      @endif
    </div>
    <div class="dark-overlay"></div>
    <div class="container position-relative" style="z-index: 3;" data-aos="fade-up">
      <h2 class="section-title-custom mx-auto mb-2">{{ $workSetting->title ?? 'Facilities' }}</h2>
    </div>
  </section>

  <section class="page-content section position-relative overflow-hidden">
    <div class="container mt-5">
      @forelse($works as $index => $item)
      <div class="row align-items-center mb-4 pb-2" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}" data-aos-duration="1000">
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-2' : '' }}">
          <div class="position-relative p-2 p-md-4">
            <div class="position-absolute {{ $index % 2 == 0 ? 'top-0 start-0' : 'bottom-0 end-0' }} translate-middle z-n1 d-none d-lg-block">
               <i class="bi bi-grid-3x3-gap-fill text-primary" style="font-size: 5rem; opacity: 0.15;"></i>     
            </div>
            <div class="work-ornament {{ $index % 2 == 0 ? 'bottom-0 end-0' : 'top-0 start-0' }}" style="margin: -20px;">
                <i class="fa-solid fa-cog floating-gear text-primary gear-icon"></i>
            </div>
            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/img/Bintan/image6.jpeg') }}" class="img-fluid rounded-4 shadow-lg position-relative" alt="{{ $item->title }}" loading="lazy">
          </div>
        </div>
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
          <div class="position-relative">
            <div class="bg-shape-light d-none d-lg-block"></div>
            <h3 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px;">{{ $item->title }}</h3>
            @if($item->subtitle)
                <p class="lead text-primary fw-semibold mb-4" style="font-size: 1.1rem; border-left: 4px solid var(--accent-color); padding-left: 15px;">{{ $item->subtitle }}</p>
            @endif
            <div class="description-text text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                {!! nl2br(e($item->description)) !!}
            </div>
          </div>
        </div>
      </div>
      @empty
      @endforelse
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- 6. BIE CLOSING (RETURN ON FORESIGHT)                                      -->
  <!-- ========================================================================= -->
  <section class="section py-5 light-background">
      <div class="container text-center">
        <div class="row mt-3 text-center">
            <div class="col-12" data-aos="zoom-in" data-aos-duration="900">
            <div class="cta-box-custom">
                <h2 class="text-primary fw-bold mb-2">RETURN ON FORESIGHT</h2>
                <p class="lead text-secondary max-width-700 mx-auto mb-4">Investing in Bintan Industrial Estate is investing in the future today. To find out how the sea-fronting Bintan Industrial Estate can open a world of business opportunities for you, contact us at:</p>

                <div class="row justify-content-center mt-4 g-3">
                    <div class="col-md-5">
                        <div class="d-flex align-items-center justify-content-center p-3 bg-white rounded shadow-sm border border-light h-100">
                        <i class="fa-solid fa-envelope text-primary me-3" style="font-size: 1.4rem;"></i>
                        <h6 class="mb-0 fw-bold text-dark" style="min-width: 0; word-break: break-all; font-size: clamp(12px, 3.5vw, 16px);">industrialparks@gallantventure.com</h6>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex align-items-center justify-content-center p-3 bg-white rounded shadow-sm border border-light h-100">
                        <i class="fa-solid fa-phone text-primary me-3" style="font-size: 1.4rem;"></i>
                        <h6 class="mb-0 fw-bold text-dark">+65 6389 3535</h6>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>
  </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/bie-unified.js') }}"></script>
@endpush