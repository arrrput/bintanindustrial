@extends('layouts.main')

@section('title', '3D Single Model Test - Bintan Industrial Estate')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/experiments-3d-scroll.css') }}">

    <div id="debug-panel">
        <div>Status: <span id="status">Initializing...</span></div>
        <div id="logs" style="margin-top:10px; height: 100px; overflow-y: auto; border-top: 1px solid #333; padding-top: 5px;"></div>
    </div>

    <div id="tweak-panel">
        <h4 style="margin:0 0 10px 0; color:#007bff;">Transformasi Model</h4>
        <div class="control-group">
            <label>Model Pos (X, Y, Z)</label>
            <div class="rot-inputs">
                <input type="number" step="0.5" id="m-pos-x" value="0" oninput="updateModel()">
                <input type="number" step="0.5" id="m-pos-y" value="0" oninput="updateModel()">
                <input type="number" step="0.5" id="m-pos-z" value="0" oninput="updateModel()">
            </div>
        </div>
        <div class="control-group">
            <label>Model Rot (X, Y, Z - Radian)</label>
            <div class="rot-inputs">
                <input type="number" step="0.1" id="m-rot-x" value="0" oninput="updateModel()">
                <input type="number" step="0.1" id="m-rot-y" value="0" oninput="updateModel()">
                <input type="number" step="0.1" id="m-rot-z" value="0" oninput="updateModel()">
            </div>
        </div>
        <div class="control-group">
            <label>Model Scale</label>
            <input type="number" step="0.1" id="m-scale" value="1" oninput="updateModel()">
        </div>
        <div class="control-group">
            <label>Cam Pos (X, Y, Z)</label>
            <div class="rot-inputs">
                <input type="number" step="1" id="c-pos-x" value="0" oninput="updateCamera()">
                <input type="number" step="1" id="c-pos-y" value="10" oninput="updateCamera()">
                <input type="number" step="1" id="c-pos-z" value="64" oninput="updateCamera()">
            </div>
        </div>
        <div id="coords" style="margin-top:10px; background:#111; padding:10px; border-radius:3px; word-break: break-all; color:#fff; font-family:monospace; border:1px dashed #555;"></div>
    </div>

    <div id="canvas-container"></div>

    <script src="https://unpkg.com/three@0.128.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <script>
        window.__modelUrl = "{{ asset('assets/img/3d_Factory/Type C.glb') }}";
    </script>
    <script src="{{ asset('assets/js/pages/experiments-3d-scroll.js') }}"></script>
@endsection
