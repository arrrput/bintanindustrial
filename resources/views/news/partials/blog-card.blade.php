{{--
    Article card on the News page.

    Params:
    - $blog : Blog model (image can be a single path or a JSON array of paths)
--}}
@php
    $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
    $images = $images ?: [$blog->image];
    $blogUrl = url('/blog/' . $blog->slug);
@endphp

<div class="col-lg-4 col-md-6 blog-item">
    @if (count($images) > 1)
        <div id="carouselGrid{{ $blog->id }}" class="carousel slide carousel-fade shadow-sm" data-bs-ride="carousel"
            data-bs-interval="3000" style="border-radius: 8px; overflow: hidden;">
            <div class="carousel-inner">
                @foreach ($images as $index => $img)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <a href="{{ $blogUrl }}" class="d-block">
                            <img src="{{ asset('storage/' . $img) }}" class="img-fluid w-100" alt="{{ $blog->title }}"
                                style="aspect-ratio: 1 / 1; object-fit: cover;">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ $blogUrl }}" class="d-block">
            <img src="{{ asset('storage/' . $images[0]) }}" class="img-fluid w-100 shadow-sm" alt="{{ $blog->title }}"
                style="aspect-ratio: 1 / 1; object-fit: cover; border-radius: 8px;">
        </a>
    @endif

    <div class="blog-info d-flex justify-content-between align-items-center shadow-sm" style="border-radius: 0 0 8px 8px;">
        <div class="blog-text flex-grow-1 pe-2" style="min-width: 0;">
            <h4 class="fw-bold mb-1 text-truncate" title="{{ $blog->title }}">{{ $blog->title }}</h4>
            <p class="mb-0 blog-desc">{{ $blog->excerpt ?? strip_tags($blog->content) }}</p>
        </div>

        <div class="blog-icons d-flex gap-2 flex-shrink-0">
            <a href="{{ asset('storage/' . $images[0]) }}" data-gallery="blog-gallery-{{ $blog->id }}"
                class="glightbox icon-btn"><i class="bi bi-zoom-in"></i></a>
            <a href="{{ $blogUrl }}" title="Read More" class="icon-btn"><i class="bi bi-link-45deg"></i></a>
        </div>
    </div>
</div>
