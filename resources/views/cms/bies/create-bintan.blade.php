@extends('layouts.main')

@section('title', 'Add Bintan Island Content - BIIE CMS')

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.bie-page.index') }}">BIE Page</a></li>
        <li class="current">Add Bintan Slide</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-plus-circle me-2"></i> Add New Bintan Island Slide</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.bies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_group" value="bintan">

                        <div class="row g-4">
                            <!-- Layout Style Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Description Style</label>
                                <select name="layout_style" id="layout_style" class="form-select @error('layout_style') is-invalid @enderror" required>
                                    <option value="default" {{ old('layout_style') == 'default' ? 'selected' : '' }}>Default (Just Description)</option>
                                    <option value="info_grid" {{ old('layout_style') == 'info_grid' ? 'selected' : '' }}>Info Grid (Bullet Icon style)</option>
                                    <option value="advantage_grid" {{ old('layout_style') == 'advantage_grid' ? 'selected' : '' }}>Advantage Grid (Cards style)</option>
                                </select>
                                @error('layout_style') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Title -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. CONNECTED THINKING" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Subtitle -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Subtitle / Quote (Optional)</label>
                                <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}" placeholder="e.g. Bintan sits at the crossroads...">
                                @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Icon -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">Icon</label>
                                @include('cms.layouts.icon-picker-input', [
                                    'name' => 'icon',
                                    'inputId' => 'mainIconInput',
                                    'previewId' => 'mainIconPreview',
                                    'value' => old('icon', 'fa-solid fa-star')
                                ])
                                @error('icon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <!-- Order -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">Display Order</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order') }}" placeholder="e.g. 1">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Slider Image</label>
                                <div class="p-3 border border-2 border-dashed rounded-3 text-center bg-light">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                </div>
                                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Main Description</label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Write the introductory text here...">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Extra Content Section -->
                            <div id="extra-content-container" class="col-12 mt-4" style="display: none;">
                                <hr>
                                <h5 class="fw-bold mb-3 text-primary" id="extra-content-title">Dynamic Content</h5>

                                {{-- Advantage Grid Editor --}}
                                <div id="advantage-grid-editor" style="display: none;">
                                    <div id="cards-list"></div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addAdvantageCard()">
                                        <i class="fa-solid fa-plus me-1"></i> Add Advantage Card
                                    </button>
                                </div>

                                {{-- Info Grid Editor --}}
                                <div id="info-grid-editor" style="display: none;">
                                    <p class="text-muted small mb-3">Manage up to three information columns with custom titles and item lists.</p>
                                    <div class="row g-3">
                                        @foreach(['glance' => 'Bintan at a Glance', 'distance' => 'Connectivity', 'connectivity' => 'Distance'] as $key => $default)
                                        <div class="col-md-4">
                                            <div class="card p-3 h-100">
                                                <input type="text" name="extra_content[{{ $key }}][title]" class="form-control form-control-sm fw-bold mb-2" placeholder="Title" value="{{ $default }}">
                                                <div id="{{ $key }}-list" class="small-inputs"></div>
                                                <button type="button" class="btn btn-link btn-sm p-0 text-start mt-2" onclick="addInfoItem('{{ $key }}')">+ Add Item</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('cms.bie-page.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-success rounded-pill px-5 shadow fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Save Slide
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('cms.layouts.icon-picker-modal')

<template id="advantage-card-template">
    <div class="card p-3 mb-3 advantage-card-item border-start border-4 border-success">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="fw-bold text-dark mb-0">Card #<span class="card-num">1</span></h6>
            <button type="button" class="btn-close btn-sm" onclick="this.closest('.advantage-card-item').remove()"></button>
        </div>
        <div class="row g-2">
            <div class="col-md-8">
                <input type="text" name="extra_content[cards][INDEX][title]" class="form-control form-control-sm" placeholder="Card Title" required>
            </div>
            <div class="col-md-4">
                @include('cms.layouts.icon-picker-input', [
                    'name' => 'extra_content[cards][INDEX][icon]',
                    'inputId' => 'advIconInput_INDEX',
                    'previewId' => 'advIconPreview_INDEX',
                    'value' => 'fa-solid fa-check'
                ])
            </div>
            <div class="col-12">
                <textarea name="extra_content[cards][INDEX][description]" class="form-control form-control-sm" rows="2" placeholder="Description content..."></textarea>
            </div>
        </div>
    </div>
</template>

<template id="info-item-template">
    <div class="input-group input-group-sm mb-2 info-item">
        <div class="input-group-text p-0" style="width: 40px;">
            <div id="infoIconPreview_TYPE_INDEX" class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>
        <input type="hidden" name="extra_content[TYPE][items][INDEX][icon]" id="infoIconInput_TYPE_INDEX" value="fa-solid fa-check">
        <button type="button" class="btn btn-outline-secondary px-2" onclick="openIconPicker('infoIconInput_TYPE_INDEX', 'infoIconPreview_TYPE_INDEX')">
            <i class="fa-solid fa-icons"></i>
        </button>
        <input type="text" name="extra_content[TYPE][items][INDEX][label]" class="form-control" placeholder="Label">
        <input type="text" name="extra_content[TYPE][items][INDEX][value]" class="form-control" placeholder="Value">
        <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-times"></i></button>
    </div>
</template>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-bies-create-bintan.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-bies-create-bintan.css') }}">
@endpush
