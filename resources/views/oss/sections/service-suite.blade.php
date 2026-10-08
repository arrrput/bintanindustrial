{{-- Section: One Stop Service Suite --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/service-suite.css') }}">
@endpush

@if ($serviceSuite && $serviceSuite->count() > 0)
    @php
        // Balance service cards across rows (max 3 per row) instead of a
        // fixed 3-column grid, so e.g. 4 items render as 2+2, not 3+1.
        $totalServiceItems = $serviceSuite->count();
        $serviceRowCount = max(1, (int) ceil($totalServiceItems / 3));
        $serviceRowBase = intdiv($totalServiceItems, $serviceRowCount);
        $serviceRowExtra = $totalServiceItems % $serviceRowCount;
        $serviceChunks = [];
        $serviceOffset = 0;
        for ($r = 0; $r < $serviceRowCount; $r++) {
            $rowSize = $serviceRowBase + ($r < $serviceRowExtra ? 1 : 0);
            $serviceChunks[] = $serviceSuite->slice($serviceOffset, $rowSize);
            $serviceOffset += $rowSize;
        }
        $serviceGlobalIndex = 0;
    @endphp

    <section class="section pt-5 pb-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h3 class="text-primary fw-bold text-uppercase">ONE STOP SERVICE SUITE</h3>
                <p class="lead">Comprehensive support services designed for operational efficiency.</p>
            </div>

            <div class="service-suite-flex">
                @foreach ($serviceChunks as $serviceChunk)
                    <div class="service-suite-row" style="--row-cols: {{ $serviceChunk->count() }};">
                        @foreach ($serviceChunk as $service)
                            @php $serviceGlobalIndex++; @endphp
                            <div class="service-item" data-aos="zoom-in" data-aos-delay="{{ $serviceGlobalIndex * 100 }}">
                                <div class="card service-card border-0 shadow-sm p-4 text-center d-flex flex-column h-100 w-100">
                                    <div class="mb-4">
                                        <i class="{{ $service->icon ?? 'fa-solid fa-gear' }} text-primary"
                                            style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h4 class="fw-bold mb-3">{{ $service->title }}</h4>
                                    <div class="small text-muted text-start flex-grow-1" style="line-height: 1.6;">
                                        {!! nl2br(e($service->description)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
