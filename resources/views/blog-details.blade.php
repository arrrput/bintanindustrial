@extends('layouts.main')

@section('title', $blog->title . ' - Bintan Industrial Estate')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/blog-details.css') }}">
@endpush

@section('content')
<main id="main">

    <div class="page-title" data-aos="fade">
        <div class="container d-flex align-items-center">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/blogs') }}">Blog</a></li>
                    <li class="current">Read Article</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section pt-5 pb-5">
        <div class="container" data-aos="fade-up">
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    
                    <div class="mb-4">
                        <h1 class="fw-bold text-dark mb-3" style="font-size: 2.5rem; line-height: 1.2;">{{ $blog->title }}</h1>
                        <div class="d-flex align-items-center text-muted small fw-bold">
                            <i class="bi bi-calendar-event text-success me-2 fs-5"></i>
                            <span>{{ $blog->created_at->format('d F Y') }}</span>
                            <span class="mx-3">|</span>
                            <i class="bi bi-person-circle text-success me-2 fs-5"></i>
                            <span>Admin BIIE</span>
                        </div>
                    </div>

                    @if($blog->image)
                        @php
                            // Cek apakah data image berupa array/JSON (banyak gambar) atau string (1 gambar artikel lama)
                            $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
                            
                            // Jika json_decode gagal (berarti format string artikel lama), jadikan array tunggal
                            if (!$images) {
                                $images = [$blog->image];
                            }
                        @endphp

                        @if(count($images) > 1)
                            <div id="blogImageCarousel" class="carousel slide mb-5 shadow-sm rounded-4 overflow-hidden bg-light" data-bs-ride="carousel">
                                
                                <div class="carousel-indicators">
                                    @foreach($images as $index => $img)
                                        <button type="button" data-bs-target="#blogImageCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                                
                                <div class="carousel-inner text-center">
                                    @foreach($images as $index => $img)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $img) }}" class="img-fluid" alt="{{ $blog->title }} - Slide {{ $index + 1 }}" style="max-height: 400px; width: auto; max-width: 100%; margin: 0 auto; display: inline-block;">
                                        </div>
                                    @endforeach
                                </div>
                                
                                <button class="carousel-control-prev" type="button" data-bs-target="#blogImageCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-success rounded-circle p-3 shadow" aria-hidden="true" style="background-size: 50%;"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#blogImageCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-success rounded-circle p-3 shadow" aria-hidden="true" style="background-size: 50%;"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @else
                            <div class="mb-5 text-center">
                                <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $blog->title }}" class="img-fluid rounded-4 shadow" style="max-height: 500px; width: auto; max-width: 100%; margin: 0 auto; display: block;">
                            </div>
                        @endif
                    @endif

                    <div class="article-content mb-5">
                        {!! $blog->content !!}
                    </div>

                    <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ url('/#blog') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i> Back to Homepage
                        </a>
                        
                        <div class="d-flex gap-2">
                            <span class="text-muted me-2 align-self-center small fw-bold">Share:</span>
                            <a href="#" class="btn btn-sm btn-light rounded-circle text-success" style="width:35px; height:35px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-whatsapp"></i></a>
                            <a href="#" class="btn btn-sm btn-light rounded-circle text-success" style="width:35px; height:35px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

</main>
@endsection