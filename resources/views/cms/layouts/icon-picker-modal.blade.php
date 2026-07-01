{{-- Icon Picker Modal --}}
<div class="modal fade" id="iconPickerModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-icons text-primary me-2"></i> Select Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="input-group mb-4 shadow-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" id="iconSearch" class="form-control border-start-0 ps-0" placeholder="Search icons (e.g. ship, heart, gear)...">
                </div>
                <div class="icon-picker-grid" id="iconGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(50px, 1fr)); gap: 10px; max-height: 400px; overflow-y: auto;">
                    @php
                        $icons = [
                            'fa-solid fa-earth-asia', 'fa-solid fa-network-wired', 'fa-solid fa-chart-line',
                            'fa-solid fa-scale-balanced', 'fa-solid fa-handshake-angle', 'fa-solid fa-building-shield',
                            'fa-solid fa-map-location-dot', 'fa-solid fa-route', 'fa-solid fa-tower-cell',
                            'fa-solid fa-anchor', 'fa-solid fa-ship', 'fa-solid fa-plane-departure',
                            'fa-solid fa-maximize', 'fa-solid fa-users', 'fa-solid fa-language',
                            'fa-solid fa-temperature-high', 'fa-solid fa-clock', 'fa-solid fa-ferry',
                            'fa-solid fa-umbrella-beach', 'fa-solid fa-star', 'fa-solid fa-circle-check',
                            'fa-solid fa-bolt', 'fa-solid fa-industry', 'fa-solid fa-briefcase',
                            'fa-solid fa-newspaper', 'fa-solid fa-heart', 'fa-solid fa-globe',
                            'fa-solid fa-link', 'fa-solid fa-location-dot', 'fa-solid fa-suitcase',
                            'fa-solid fa-gears', 'fa-solid fa-compass', 'fa-solid fa-warehouse',
                            'fa-solid fa-truck', 'fa-solid fa-microchip', 'fa-solid fa-helmet-safety',
                            'fa-solid fa-magnifying-glass-chart', 'fa-solid fa-boxes-stacked', 'fa-solid fa-wheat-awn',
                            'fa-solid fa-eye', 'fa-solid fa-lightbulb', 'fa-solid fa-rocket', 'fa-solid fa-trophy','fa fa-address-book'
                        ];
                    @endphp
                    @foreach($icons as $icon)
                        <div class="icon-option d-flex align-items-center justify-content-center border rounded cursor-pointer" 
                             data-icon="{{ $icon }}" 
                             onclick="selectPickedIcon('{{ $icon }}')" 
                             title="{{ $icon }}"
                             style="width: 45px; height: 45px; font-size: 1.2rem; cursor: pointer; transition: all 0.2s;">
                            <i class="{{ $icon }}"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-layouts-icon-picker-modal.css') }}">

<script src="{{ asset('assets/js/pages/cms-layouts-icon-picker-modal.js') }}"></script>
