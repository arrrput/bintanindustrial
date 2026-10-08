{{-- Section: Beyond The Workplace (banner + Events, Entertainment, CSR from CMS > Programs) --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/beyond-the-workplace.css') }}">
@endpush

<div class="beyond-the-workplace">
    <section class="program-parallax-divider"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/img/Bintan/condo.jpg') }}');">
        <div class="container program-parallax-content" data-aos="zoom-in" data-aos-duration="1200">
            <h3>Beyond The Workplace</h3>
            <p>"Where meaningful celebrations, leisure and community care come together. A complete, self-sustained ecosystem designed to enrich the lives of everyone within Bintan Industrial Estate."</p>
        </div>
    </section>

    @include('news.sections.events')
    @include('news.sections.entertainment')
    @include('news.sections.csr')
</div>
