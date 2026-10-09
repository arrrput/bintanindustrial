{{--
    Banner background fields for CMS section-settings forms: Image (slideshow) or Solid Color.
    Place it inside the form's ".row g-3", right after the title column, and give the
    <form> the class "js-banner-bg-form" (wired by assets/js/components/banner-background-picker.js).

    Params:
    - $key     : section_key, also used to make element ids unique
    - $setting : SectionSetting model or null
    - $compact : (optional) true for narrow forms — stacks every field full width
--}}
@php
    $compact = $compact ?? false;
    $col = $compact ? 'col-12' : 'col-md-6';
    $isThisForm = old('section_key') === $key;
    $bgType = $isThisForm ? old('background_type', 'image') : ($setting->background_type ?? 'image');
    $bgColor = $isThisForm ? old('background_color', '#335642') : ($setting->background_color ?? '#335642');
    $presets = [
        '#335642' => 'Brand Green',
        '#1f3329' => 'Dark Green',
        '#1e3a5f' => 'Navy',
        '#222222' => 'Charcoal',
        '#8a6d3b' => 'Bronze',
        '#f4f6f4' => 'Light Grey',
    ];
@endphp

<div class="{{ $col }}">
    <label class="form-label small fw-bold d-block">Background Type</label>
    <div class="btn-group" role="group" aria-label="Background type">
        <input type="radio" class="btn-check" name="background_type" id="{{ $key }}_bg_image" value="image" {{ $bgType === 'image' ? 'checked' : '' }}>
        <label class="btn btn-outline-success rounded-start-pill px-4" for="{{ $key }}_bg_image"><i class="fa-solid fa-image me-2"></i>Image</label>
        <input type="radio" class="btn-check" name="background_type" id="{{ $key }}_bg_color" value="color" {{ $bgType === 'color' ? 'checked' : '' }}>
        <label class="btn btn-outline-success rounded-end-pill px-4" for="{{ $key }}_bg_color"><i class="fa-solid fa-palette me-2"></i>Solid Color</label>
    </div>
</div>

{{-- Image background --}}
<div class="col-12" data-bg-panel="image">
    <div class="row g-3">
        <div class="{{ $col }}">
            <label class="form-label small fw-bold">Add Background Images</label>
            <input type="file" name="background_images[]" class="form-control rounded-pill" multiple accept="image/*">
            <p class="text-muted small mt-2 mb-0">
                <i class="fa-regular fa-clipboard me-1"></i> Tip: drag &amp; drop an image here, or press <kbd>Ctrl</kbd> + <kbd>V</kbd> to paste one.
            </p>
        </div>
        @if ($setting && $setting->background_images && count($setting->background_images) > 0)
            <div class="col-12">
                <label class="form-label small fw-bold">Current Images <span class="text-muted fw-normal">(click × to remove)</span></label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach ($setting->background_images as $img)
                        <div class="position-relative border rounded p-1 shadow-sm" style="width: 120px;">
                            <img src="{{ asset('storage/' . $img) }}" class="rounded w-100" style="height: 80px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 p-1">
                                <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_{{ $key }}_{{ $loop->index }}" class="d-none">
                                <label for="del_{{ $key }}_{{ $loop->index }}" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 25px; height: 25px; cursor: pointer;" onclick="this.parentElement.parentElement.style.opacity='0.3';">
                                    <i class="fa-solid fa-xmark" style="font-size: 0.7rem;"></i>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Solid color background --}}
<div class="col-12" data-bg-panel="color">
    <div class="row g-3 align-items-start">
        <div class="{{ $col }}">
            <label class="form-label small fw-bold">Background Color</label>
            <div class="d-flex align-items-center gap-2">
                <input type="color" class="form-control form-control-color rounded-3 js-bg-color-picker" value="{{ $bgColor }}" title="Choose color">
                <input type="text" name="background_color" class="form-control rounded-pill js-bg-color-hex {{ $isThisForm && $errors->has('background_color') ? 'is-invalid' : '' }}" value="{{ $bgColor }}" maxlength="7" placeholder="#335642" style="max-width: 140px;">
            </div>
            @if ($isThisForm && $errors->has('background_color'))
                <div class="text-danger small mt-1">Please enter a valid hex color, e.g. #335642.</div>
            @endif
            <div class="d-flex flex-wrap gap-2 mt-3">
                @foreach ($presets as $hex => $name)
                    <button type="button" class="btn p-0 rounded-circle border shadow-sm js-bg-color-swatch" data-color="{{ $hex }}" title="{{ $name }} ({{ $hex }})" style="width: 32px; height: 32px; background: {{ $hex }};"></button>
                @endforeach
            </div>
        </div>
        <div class="{{ $col }}">
            <label class="form-label small fw-bold">Preview</label>
            <div class="rounded-4 d-flex align-items-center justify-content-center text-center fw-bold fs-4 px-3 js-bg-color-preview" style="height: 110px; background: {{ $bgColor }}; color: #fff;">
                {{ $setting->title ?? '' }}
            </div>
            <p class="text-muted small mt-2 mb-0">
                <i class="fa-solid fa-circle-info me-1"></i> Uploaded images are kept, so you can switch back to Image anytime.
            </p>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script src="{{ asset('assets/js/components/banner-background-picker.js') }}"></script>
    @endpush
@endonce
