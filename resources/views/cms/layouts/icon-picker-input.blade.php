<div class="d-flex gap-2 align-items-center">
    <div class="icon-preview-box shadow-sm d-flex align-items-center justify-content-center bg-light border rounded" 
         id="{{ $previewId }}" 
         style="width: 45px; height: 45px; font-size: 1.2rem; color: var(--accent-color);">
        <i class="{{ $value ?? 'fa-solid fa-star' }}"></i>
    </div>
    <input type="hidden" name="{{ $name }}" id="{{ $inputId }}" value="{{ $value ?? 'fa-solid fa-star' }}">
    <button type="button" class="btn btn-outline-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" 
            onclick="openIconPicker('{{ $inputId }}', '{{ $previewId }}')"
            style="width: 32px; height: 32px;"
            title="Change Icon">
        <i class="fa-solid fa-icons"></i>
    </button>
</div>
