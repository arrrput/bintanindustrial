{{--
    Job vacancy card on the Careers page.

    Params:
    - $job : Career model
--}}
@php
    $isClosed = $job->is_closed;
    $iconColor = $isClosed ? 'text-danger' : 'text-primary';
@endphp

<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="800">
    <div class="value-card h-100 d-flex flex-column {{ $isClosed ? 'is-closed' : '' }}">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="value-icon-wrapper mb-0">
                <i class="fa-solid {{ $isClosed ? 'fa-shield-halved' : 'fa-briefcase' }}" style="font-size: 1.5rem;"></i>
            </div>
            <div class="text-end">
                @if ($isClosed)
                    <span class="badge bg-danger text-white px-3 py-1 rounded-pill mb-1 shadow-sm">CLOSED</span><br>
                @else
                    <span class="badge bg-success text-white px-3 py-1 rounded-pill mb-1 shadow-sm">OPEN</span><br>
                @endif
                <span class="badge bg-secondary-subtle text-secondary px-3 py-1 rounded-pill">{{ $job->level }}</span>
            </div>
        </div>

        <h5 class="fw-bold text-dark mb-2">{{ $job->title }}</h5>
        <p class="small text-muted mb-3">
            <i class="fa-solid fa-location-dot me-2 {{ $iconColor }}"></i>{{ $job->location }}
        </p>

        <div class="bg-light p-3 rounded mb-4 flex-grow-1 border">
            <ul class="list-unstyled small text-muted mb-0">
                <li class="mb-2">
                    <i class="fa-solid fa-graduation-cap me-2 {{ $iconColor }}"></i>
                    <strong>Education:</strong> {{ $job->min_education }}
                </li>
                <li class="mb-2">
                    <i class="fa-solid fa-briefcase me-2 {{ $iconColor }}"></i>
                    <strong>Experience:</strong> {{ $job->min_experience }}
                </li>
                <li class="mb-2">
                    <i class="fa-solid fa-calendar-plus me-2 {{ $iconColor }}"></i>
                    <strong>Posted:</strong> {{ \Carbon\Carbon::parse($job->posted_date)->format('d M Y') }}
                </li>
                <li>
                    <i class="fa-solid fa-calendar-xmark me-2 text-danger"></i>
                    <strong>Deadline:</strong>
                    <span class="text-danger fw-bold">{{ \Carbon\Carbon::parse($job->closing_date)->format('d M Y') }}</span>
                </li>
            </ul>
        </div>

        <a href="{{ route('career.show', $job->slug) }}"
            class="btn btn-sm w-100 fw-bold rounded-pill py-2 {{ $isClosed ? 'btn-outline-danger' : 'btn-outline-success btn-job-apply' }}"
            style="transition: 0.3s;">
            View Details {{ $isClosed ? '(Closed)' : '& Apply' }}
        </a>
    </div>
</div>
