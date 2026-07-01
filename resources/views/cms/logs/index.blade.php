@extends('layouts.main') 

@section('title', 'Activity Logs - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-logs-index.css') }}">
@endpush

@section('content')

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li class="current">Activity Logs</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-clock-rotate-left text-success me-2"></i> Activity Logs
            </h2>
            <p class="text-muted small mb-0 mt-1">Audit trail of all administrative actions performed in the CMS.</p>
        </div>
        <div id="live-indicator" class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 d-none">
            <span class="spinner-grow spinner-grow-sm me-1" role="status"></span> Updating...
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form id="filter-form">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Search Name/Desc</label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text ps-3 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="filter-search" class="form-control px-3" placeholder="Type to search..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Module</label>
                        <div class="filter-select-wrapper">
                            <select name="module" id="filter-module" class="form-select rounded-pill px-3 form-select-custom">
                                <option value="">All Modules</option>
                                @foreach($modules as $mod)
                                    <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>{{ $mod }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Action</label>
                        <div class="filter-select-wrapper">
                            <select name="action" id="filter-action" class="form-select rounded-pill px-3 form-select-custom">
                                <option value="">All Actions</option>
                                @foreach($actions as $act)
                                    <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end justify-content-end">
                        <a href="{{ route('cms.logs.index') }}" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Reset Filters">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;"> 
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted sticky-top" style="font-size: 0.85rem; letter-spacing: 1px; z-index: 10;">
                        <tr>
                            <th class="ps-4 py-3">USER</th>
                            <th class="py-3">ACTION</th>
                            <th class="py-3">MODULE</th>
                            <th class="py-3">DESCRIPTION</th>
                            <th class="py-3">IP ADDRESS</th>
                            <th class="py-3">TIME</th>
                        </tr>
                    </thead>
                    <tbody id="logs-table-body">
                        @include('cms.logs._table_rows')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-logs-index.js') }}"></script>
@endpush
