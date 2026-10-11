{{--
    Section sub-heading in the template's ".section-title" style (small pill label, large title, description),
    managed per section in the CMS (section_settings.heading_*). Renders nothing when the section has no heading.

    Params:
    - $setting : SectionSetting model or null
    - $class   : (optional) extra classes, e.g. 'pb-4'
--}}
@if ($setting?->hasHeading())
    <div class="section-title {{ $class ?? '' }}" data-aos="fade-up">
        @if (filled($setting->heading_badge))
            <h2>{{ $setting->heading_badge }}</h2>
        @endif
        @if (filled($setting->heading_title))
            <p>{{ $setting->heading_title }}</p>
        @endif
        @if (filled($setting->heading_description))
            <small class="text-muted d-block mt-2 mx-auto" style="max-width: 760px;">{{ $setting->heading_description }}</small>
        @endif
    </div>
@endif
