{{-- Session flash messages, rendered by public/assets/js/app-alerts.js via SweetAlert2 --}}
@php
    $swalFlash = array_filter([
        'success' => session('success'),
        'error'   => session('error'),
        'warning' => session('warning'),
        'info'    => session('info'),
        'errors'  => isset($errors) && $errors->any() ? $errors->all() : null,
    ]);
@endphp
@if (!empty($swalFlash))
<script type="application/json" id="swal-flash-data">@json($swalFlash)</script>
@endif
