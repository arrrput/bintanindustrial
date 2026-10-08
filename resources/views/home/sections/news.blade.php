{{-- Section: News & Media --}}
<section id="blog" class="blog section">
    <div class="container section-title" data-aos="fade-up">
        <h2>News & Media</h2>
        <p>Latest <span>Activity</span></p>
    </div>

    <div class="container">
        <div class="isotope-layout" data-layout="masonry" data-sort="original-order">
            <div class="row gy-5 isotope-container" data-aos="fade-up" data-aos-delay="200">
                @forelse ($blogs as $blog)
                    @php
                        $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
                        $images = $images ?: [$blog->image];
                        $blogUrl = route('news.show', $blog->slug);
                    @endphp

                    <div class="col-lg-4 col-md-6 blog-item isotope-item">
                        <div class="blog-card-wrapper h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                            @if (count($images) > 1)
                                <div id="carouselGrid{{ $blog->id }}" class="carousel slide carousel-fade"
                                    data-bs-ride="carousel" data-bs-interval="4000">
                                    <div class="carousel-inner">
                                        @foreach ($images as $index => $img)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <a href="{{ $blogUrl }}" class="d-block position-relative">
                                                    <img loading="lazy" src="{{ asset('storage/' . $img) }}"
                                                        class="img-fluid w-100" alt="{{ $blog->title }}"
                                                        style="aspect-ratio: 16 / 10; object-fit: cover;">
                                                    <div class="image-overlay"></div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $blogUrl }}" class="d-block position-relative">
                                    <img loading="lazy" src="{{ asset('storage/' . $images[0]) }}"
                                        class="img-fluid w-100" alt="{{ $blog->title }}"
                                        style="aspect-ratio: 16 / 10; object-fit: cover;">
                                    <div class="image-overlay"></div>
                                </a>
                            @endif

                            <div class="blog-info">
                                <div class="blog-info-content">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-success-subtle text-success small border border-success-subtle px-2 py-1">
                                            {{ $blog->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <h5 class="fw-bold mb-3">
                                        <a href="{{ $blogUrl }}" class="text-dark hover-accent">{{ $blog->title }}</a>
                                    </h5>
                                </div>

                                <p class="blog-desc mb-4 text-muted small">
                                    {{ $blog->excerpt ?? strip_tags($blog->content) }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <a href="{{ $blogUrl }}"
                                        class="btn btn-link p-0 fw-bold text-success text-decoration-none small">
                                        Read More <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                    <div class="d-flex gap-2">
                                        <a href="{{ asset('storage/' . $images[0]) }}"
                                            data-gallery="blog-gallery-{{ $blog->id }}"
                                            class="glightbox btn btn-sm btn-light rounded-circle">
                                            <i class="bi bi-zoom-in"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fa-solid fa-newspaper fs-1 mb-3 text-light"></i>
                        <p>Stay tuned for our upcoming stories.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('news.index') }}" class="btn btn-outline-success rounded-pill px-5 py-2 fw-bold">
                    View All Articles
                </a>
            </div>
        </div>
    </div>
</section>
