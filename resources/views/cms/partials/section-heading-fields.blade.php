{{--
    Banner on/off switch + section sub-heading fields for CMS section-settings forms.
    Place it as the first child of the form's ".row g-3".
    The sub-heading uses the public ".section-title" style: small pill label, large title, description.

    Params:
    - $key     : section_key, also used to make element ids unique
    - $setting    : SectionSetting model or null
    - $withBanner : (optional, default true) false for sections without a banner — only the sub-heading fields are shown
--}}
@php
    $isThisForm = old('section_key') === $key;
    $withBanner = $withBanner ?? true;
    $showBanner = $isThisForm ? (bool) old('show_banner') : \App\Models\SectionSetting::bannerVisible($setting);
    $value = fn ($field) => $isThisForm ? old($field) : ($setting->{$field} ?? '');
@endphp

@if ($withBanner)
<div class="col-12">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 rounded-4 border bg-light">
        <div>
            <div class="fw-bold text-dark">Show banner</div>
            <div class="text-muted small">When off, the banner is hidden and the section starts with its sub-heading below.</div>
        </div>
        <div class="form-check form-switch m-0">
            <input type="hidden" name="show_banner" value="0">
            <input class="form-check-input" type="checkbox" role="switch" name="show_banner" value="1" id="{{ $key }}_show_banner"
                   style="width: 3em; height: 1.5em; cursor: pointer;" {{ $showBanner ? 'checked' : '' }}>
            <label class="visually-hidden" for="{{ $key }}_show_banner">Show banner</label>
        </div>
    </div>
</div>
@endif

<div class="col-12">
    <div class="p-3 rounded-4 border">
        <div class="fw-bold text-dark mb-1">Section sub-heading</div>
        <div class="text-muted small mb-3">Shown at the top of the section, e.g. a small "INDUSTRIAL SOLUTIONS" label above "Explore Our Factory Types". Leave all fields empty to hide it.</div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold" for="{{ $key }}_heading_badge">Label</label>
                <input type="text" name="heading_badge" id="{{ $key }}_heading_badge" maxlength="100" class="form-control rounded-pill"
                       value="{{ $value('heading_badge') }}" placeholder="e.g. Industrial Solutions">
            </div>
            <div class="col-md-8">
                <label class="form-label small fw-bold" for="{{ $key }}_heading_title">Title</label>
                <input type="text" name="heading_title" id="{{ $key }}_heading_title" maxlength="255" class="form-control rounded-pill"
                       value="{{ $value('heading_title') }}" placeholder="e.g. Explore Our Factory Types">
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold" for="{{ $key }}_heading_description">Description <span class="text-muted fw-normal">(optional)</span></label>
                <textarea name="heading_description" id="{{ $key }}_heading_description" rows="2" maxlength="1000" class="form-control rounded-4"
                          placeholder="Short text shown under the title">{{ $value('heading_description') }}</textarea>
            </div>
        </div>
    </div>
</div>

@if ($withBanner)
<div class="col-12">
    <div class="fw-bold text-dark mt-2">Banner</div>
    <div class="text-muted small">Used only when "Show banner" is on.</div>
</div>
@endif
