{{--
    One logo row: image drop zone (click / drag & drop / Ctrl+V) + alternative text.
    Used by the create form (dynamic rows, also as <template> with index "__INDEX__") and the edit form.

    Params:
    - $index    : row index used in the field names, or null for the edit form (fields "logo" / "name")
    - $name     : alternative text value
    - $current  : (optional) URL of the current logo (edit form)
    - $required : whether an image is required
--}}
@php
    $fileField = $index === null ? 'logo' : "logos[{$index}]";
    $nameField = $index === null ? 'name' : "names[{$index}]";
    $errorKey  = $index === null ? 'name' : "names.{$index}";
    $fileErrorKey = $index === null ? 'logo' : "logos.{$index}";
@endphp

<div class="logo-row card border rounded-4 shadow-sm mb-3" data-logo-row>
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <label class="logo-dropzone" data-dropzone tabindex="0" aria-label="Choose, drop or paste a logo image">
                    <input type="file" name="{{ $fileField }}" accept="image/*" class="visually-hidden" data-logo-input {{ $required ? 'required' : '' }}>
                    <img src="{{ $current ?? '' }}" alt="" class="logo-dropzone-preview {{ empty($current) ? 'd-none' : '' }}" data-logo-preview>
                    <span class="logo-dropzone-hint {{ empty($current) ? '' : 'd-none' }}" data-logo-hint>
                        <i class="fa-solid fa-cloud-arrow-up fs-3 d-block mb-1"></i>
                        <span class="fw-bold d-block">Click, drop or paste a logo</span>
                        <span class="small">JPG, PNG or WEBP{{ !empty($maxFileHuman) ? " · max {$maxFileHuman}" : "" }}</span>
                    </span>
                </label>
                @if (!empty($current))
                    <div class="form-text text-center">Choose a new image only if you want to replace the current logo.</div>
                @endif
                @error($fileErrorKey) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col">
                <label class="form-label fw-bold text-dark small mb-1">Alternative Text <span class="text-danger">*</span></label>
                <input type="text" name="{{ $nameField }}" value="{{ $name }}" maxlength="255" required data-logo-name
                       class="form-control rounded-pill @error($errorKey) is-invalid @enderror" placeholder="e.g. PT Bionesia Organic Foods">
                <div class="form-text">The tenant name. Shown when visitors hover over the logo and read by screen readers.</div>
                @error($errorKey) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            @if ($index !== null)
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" data-remove-row title="Remove this logo" aria-label="Remove this logo">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
