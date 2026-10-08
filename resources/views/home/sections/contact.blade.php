{{-- Section: Connect With Us --}}
@php
    $contactInfo = [
        [
            'icon' => 'bi-geo-alt',
            'title' => 'Our Location',
            'text' => 'Wisma Bintan Industrial Estate, Tlk. Lobam, Bintan, Riau 29154',
        ],
        ['icon' => 'bi-telephone', 'title' => 'Call Support', 'text' => '(0770) 696833'],
        // Email Us disembunyikan sementara karena email belum tersedia
        // ['icon' => 'bi-envelope', 'title' => 'Email Us', 'text' => 'Yudha@biie.co.id'],
    ];

    $inputFields = [
        ['name' => 'name', 'type' => 'text', 'label' => 'Your Name', 'col' => 'col-md-6'],
        ['name' => 'email', 'type' => 'email', 'label' => 'Your Email', 'col' => 'col-md-6'],
        ['name' => 'subject', 'type' => 'text', 'label' => 'Subject', 'col' => 'col-md-12'],
    ];

    $mapsEmbedUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7978.4129713333605!2d104.24653172492981!3d1.003422104564382!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d99d16ba73f09d%3A0x1255a0678c427a50!2sBINTAN%20INDUSTRIAL%20ESTATE!5e0!3m2!1sid!2sid!4v1779332838937!5m2!1sid!2sid';
@endphp

<section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Connect With Us</h2>
        <p>Get In <span>Touch</span></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            {{-- Contact info + map --}}
            <div class="col-lg-5">
                <div class="info-wrap shadow-lg border-0 rounded-4 overflow-hidden" style="background: white; padding: 40px;">
                    @foreach ($contactInfo as $i => $info)
                        <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="{{ 200 + $i * 100 }}">
                            <i class="bi {{ $info['icon'] }} me-3"></i>
                            <div>
                                <h3 class="fs-5 fw-bold mb-1">{{ $info['title'] }}</h3>
                                <p class="small text-muted mb-0">{{ $info['text'] }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="rounded-4 overflow-hidden shadow-sm mt-4">
                        <iframe src="{{ $mapsEmbedUrl }}" frameborder="0"
                            style="border: 0; width: 100%; height: 250px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            {{-- Contact form --}}
            <div class="col-lg-7">
                <div class="form-wrap shadow-lg border-0 rounded-4 p-5" style="background: white;">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 rounded-3"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="php-email-form">
                        @csrf

                        <div class="row gy-4">
                            @foreach ($inputFields as $field)
                                <div class="{{ $field['col'] }}">
                                    <div class="form-floating">
                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                            id="{{ $field['name'] }}-field"
                                            class="form-control @error($field['name']) is-invalid @enderror"
                                            value="{{ old($field['name']) }}" required style="border-radius: 10px;">
                                        <label for="{{ $field['name'] }}-field">{{ $field['label'] }}</label>
                                        @error($field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea name="message" id="message-field" rows="10"
                                        class="form-control @error('message') is-invalid @enderror"
                                        required style="height: 150px; border-radius: 10px;">{{ old('message') }}</textarea>
                                    <label for="message-field">Message</label>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                @error('captcha')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
                                    <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
                                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm"
                                        style="transition: 0.3s;">
                                        Send Message <i class="bi bi-send ms-2"></i>
                                    </button>
                                </div>
                                <div class="loading mt-3">Processing...</div>
                                <div class="error-message mt-3"></div>
                                <div class="sent-message mt-3">Your message has been sent. Thank you!</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
