@extends('layouts.main')

@section('title', 'News - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/blogs.css') }}">
@endpush

@section('content')
    @include('partials.page-title', ['current' => 'News'])

    @include('partials.page-header', [
        'prefix' => 'blog',
        'slideshowId' => 'blogBgSlideshow',
        'setting' => $setting,
        'fallbackImage' => 'assets/img/Bintan/DSC00465.jpg',
        'fallbackTitle' => 'News & Media',
        'script' => 'assets/js/pages/blogs.js',
        'containerClass' => 'text-center',
    ])

    <section id="blog" class="blog section py-5">
        <div class="container">
            <div class="mb-5" data-aos="fade-up">
                <h3 class="fw-bold text-dark mb-2">All News & Articles</h3>
                <p class="text-muted">Stay updated with our latest news, press releases, and stories.</p>
            </div>

            <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">
                @forelse ($blogs as $blog)
                    @include('news.partials.blog-card', ['blog' => $blog])
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
@endsection
