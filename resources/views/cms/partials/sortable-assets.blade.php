{{-- Assets for drag & drop table reordering. Include once per page that has a <tbody data-sortable-url>. --}}
@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/components/sortable-rows.css') }}">
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
        <script src="{{ asset('assets/js/components/sortable-rows.js') }}"></script>
    @endpush
@endonce
