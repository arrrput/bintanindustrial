{{--
    Breadcrumb bar shown under the navbar.

    Params:
    - $current : label of the current page
--}}
<div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="current">{{ $current }}</li>
            </ol>
        </nav>
    </div>
</div>
