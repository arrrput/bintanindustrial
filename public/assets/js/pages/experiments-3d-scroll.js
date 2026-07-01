        const statusEl = document.getElementById('status');
        const logsEl = document.getElementById('logs');
        const coordsEl = document.getElementById('coords');

        function addLog(msg) {
            const div = document.createElement('div');
            div.textContent = `> ${msg}`;
            logsEl.appendChild(div);
            logsEl.scrollTop = logsEl.scrollHeight;
            console.log(msg);
        }

        // 1. Scene Setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 2000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.outputEncoding = THREE.sRGBEncoding;
        document.getElementById('canvas-container').appendChild(renderer.domElement);

        // 2. Lighting
        scene.add(new THREE.AmbientLight(0xffffff, 1.5));
        const light = new THREE.DirectionalLight(0xffffff, 2);
        light.position.set(10, 20, 10);
        scene.add(light);

        scene.add(new THREE.GridHelper(100, 10));
        scene.add(new THREE.AxesHelper(20));

        // 3. Load Model
        const loader = new THREE.GLTFLoader();
        let model = null;

        const modelUrl = window.__modelUrl;
        addLog(`Loading: ${modelUrl}`);

        loader.load(modelUrl, 
            (gltf) => {
                model = gltf.scene;
                scene.add(model);
                addLog('Model loaded');
                statusEl.textContent = 'Ready';
                
                updateModel();
                updateCamera();
            },
            (xhr) => {
                const percent = Math.round((xhr.loaded / xhr.total) * 100);
                statusEl.textContent = `Loading ${percent}%`;
            },
            (err) => {
                addLog(`ERROR: ${err.message}`);
                statusEl.textContent = 'Failed';
            }
        );

        const controls = new THREE.OrbitControls(camera, renderer.domElement);
        camera.position.set(0, 0, 0);
        
        // Sync mouse interactions (drag/scroll) back to the UI
        controls.addEventListener('change', () => {
            document.getElementById('c-pos-x').value = Math.round(camera.position.x);
            document.getElementById('c-pos-y').value = Math.round(camera.position.y);
            document.getElementById('c-pos-z').value = Math.round(camera.position.z);
            updateCoords();
        });
        
        controls.update();

        function updateModel() {
            if (!model) return;
            const x = parseFloat(document.getElementById('m-pos-x').value);
            const y = parseFloat(document.getElementById('m-pos-y').value);
            const z = parseFloat(document.getElementById('m-pos-z').value);
            const rx = parseFloat(document.getElementById('m-rot-x').value);
            const ry = parseFloat(document.getElementById('m-rot-y').value);
            const rz = parseFloat(document.getElementById('m-rot-z').value);
            const scale = parseFloat(document.getElementById('m-scale').value);
            
            model.position.set(x, y, z);
            model.rotation.set(rx, ry, rz);
            model.scale.set(scale, scale, scale);
            updateCoords();
        }

        function updateCamera() {
            const x = parseFloat(document.getElementById('c-pos-x').value);
            const y = parseFloat(document.getElementById('c-pos-y').value);
            const z = parseFloat(document.getElementById('c-pos-z').value);
            camera.position.set(x, y, z);
            controls.update();
            updateCoords();
        }

        function updateCoords() {
            if (!model) return;
            const pos = `Pos: ${model.position.x},${model.position.y},${model.position.z}`;
            const rot = `Rot: ${model.rotation.x.toFixed(2)},${model.rotation.y.toFixed(2)},${model.rotation.z.toFixed(2)}`;
            const sc = `Scale: ${model.scale.x}`;
            const cp = `Cam: ${camera.position.x.toFixed(2)},${camera.position.y.toFixed(2)},${camera.position.z.toFixed(2)}`;
            coordsEl.innerText = `${pos}\n${rot}\n${sc}\n${cp}`;
        }

        function animate() {
            requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        }
        animate();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
