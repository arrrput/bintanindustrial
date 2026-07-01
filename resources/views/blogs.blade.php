@extends('layouts.main')

@section('title', 'Semua Artikel - Bintan Industrial Estate')

@section('content')
<main id="main">

    <div class="page-title" data-aos="fade">
        <div class="container d-flex align-items-center">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="current">Blogs</li>
                </ol>
            </nav>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('assets/css/pages/blogs.css') }}">

    <section class="blog-header">
        <div class="blog-bg-container" id="blogBgSlideshow">
            @if($setting && $setting->background_images && count($setting->background_images) > 0)
                @foreach($setting->background_images as $index => $img)
                    <div class="blog-bg-layer {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $img) }}');"></div>
                @endforeach
            @else
                <div class="blog-bg-layer active" style="background-image: url('{{ asset('assets/img/Bintan/DSC00465.jpg') }}');"></div>
            @endif
        </div>
        <div class="blog-bg-overlay"></div>
        <div class="container position-relative text-center" style="z-index: 3;" data-aos="zoom-in" data-aos-duration="1000">
            <h2 class="section-title-custom text-white fw-bold mx-auto">{{ $setting->title ?? 'News & Media' }}</h2>
        </div>
    </section>

    @if($setting && $setting->background_images && count($setting->background_images) > 1)
    <script src="{{ asset('assets/js/pages/blogs.js') }}"></script>
    @endif

    <section id="blog" class="blog section py-5">
        <div class="container">
            
            <div class="mb-5" data-aos="fade-up">
                <h3 class="fw-bold text-dark mb-2">All News & Articles</h3>
                <p class="text-muted">Stay updated with our latest news, press releases, and stories.</p>
            </div>
            
            <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">
                @forelse($blogs as $blog)
                <div class="col-lg-4 col-md-6 blog-item">
                    @php
                        $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
                        if (!$images) {
                            $images = [$blog->image];
                        }
                    @endphp

                    @if(count($images) > 1)
                        <div id="carouselGrid{{ $blog->id }}" class="carousel slide carousel-fade shadow-sm" data-bs-ride="carousel" data-bs-interval="3000" style="border-radius: 8px; overflow: hidden;">
                            <div class="carousel-inner">
                                @foreach($images as $index => $img)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <a href="{{ url('/blog/' . $blog->slug) }}" class="d-block">
                                            <img src="{{ asset('storage/' . $img) }}" class="img-fluid w-100" alt="{{ $blog->title }}" style="aspect-ratio: 1 / 1; object-fit: cover;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ url('/blog/' . $blog->slug) }}" class="d-block">
                            <img src="{{ asset('storage/' . $images[0]) }}" class="img-fluid w-100 shadow-sm" alt="{{ $blog->title }}" style="aspect-ratio: 1 / 1; object-fit: cover; border-radius: 8px;">
                        </a>
                    @endif
                    <div class="blog-info d-flex justify-content-between align-items-center shadow-sm" style="border-radius: 0 0 8px 8px;">
                        
                        <div class="blog-text flex-grow-1 pe-2" style="min-width: 0;">
                            <h4 class="fw-bold mb-1 text-truncate" title="{{ $blog->title }}">{{ $blog->title }}</h4>
                            <p class="mb-0 blog-desc">{{ $blog->excerpt ?? strip_tags($blog->content) }}</p>
                        </div>
                        
                        <div class="blog-icons d-flex gap-2 flex-shrink-0">
                            <a href="{{ asset('storage/' . $images[0]) }}" data-gallery="blog-gallery-{{ $blog->id }}" class="glightbox icon-btn"><i class="bi bi-zoom-in"></i></a>
                            <a href="{{ url('/blog/' . $blog->slug) }}" title="Read More" class="icon-btn"><i class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fa-solid fa-newspaper fs-1 mb-3 text-light"></i>
                    <h5 class="fw-bold text-secondary">Belum ada artikel</h5>
                    <p>Artikel yang dipublikasikan akan muncul di sini.</p>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5 pt-4">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>

</main>
@endsection