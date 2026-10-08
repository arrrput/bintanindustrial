{{--
    One image + text row of the Program page.

    Params:
    - $reversed         : true puts the image on the right (desktop)
    - $rowClass         : spacing classes for the row
    - $image, $alt      : image url and alt text
    - $headingTag       : 'h2' or 'h3'
    - $headingClass     : classes for the heading
    - $title            : heading text (may be an HtmlString)
    - $subtitle         : (optional) quote shown under the heading
    - $description      : HtmlString body
    - $descriptionClass : (optional) wrapper classes; without it the body is rendered as-is
    - $cta              : (optional) show the "Explore Bintan Resorts" button
--}}
<div class="row align-items-center {{ $rowClass }}" data-aos="{{ $reversed ? 'fade-left' : 'fade-right' }}"
    data-aos-duration="1000">
    <div class="col-lg-6 {{ $reversed ? 'order-lg-2' : '' }}">
        <div class="position-relative">
            <img src="{{ $image }}" class="img-fluid rounded shadow-lg" alt="{{ $alt }}">
        </div>
    </div>
    <div class="col-lg-6 {{ $reversed ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
        <{{ $headingTag }} class="{{ $headingClass }}">{{ $title }}</{{ $headingTag }}>

        @if (!empty($subtitle))
            <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">{{ $subtitle }}</p>
        @endif

        @if (!empty($descriptionClass))
            <div class="{{ $descriptionClass }}">
                {{ $description }}
            </div>
        @else
            {{ $description }}
        @endif

        @if (!empty($cta))
            <div class="mt-4">
                <a href="https://www.bintan-resorts.com" target="_blank"
                    class="btn btn-outline-success fw-bold rounded-pill px-4 py-2 shadow-sm"
                    style="transition: 0.3s; border-color: var(--accent-color); color: var(--accent-color);">
                    Explore Bintan Resorts <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                </a>
            </div>
        @endif
    </div>
</div>
