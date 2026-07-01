        const factoryData = {
            A: { file: 'Type A.glb', startCam: [-37, 9, 0], endCam: [-20, 9, 35] },
            B: { file: 'Type B.glb', startCam: [80, 9, 0], endCam: [30, 9, 70] },
            C: { file: 'Type C.glb', startCam: [0, 9, 70], endCam: [-49, 9, 50] }
        };

        let currentType = 'A';
        const models = {}; 
        let scene, camera, renderer, controls;
        let totalItemsToLoad = 4; // 1 HDR + 3 Models
        let itemsLoaded = 0;

        function updateProgress() {
            itemsLoaded++;
            const progress = (itemsLoaded / totalItemsToLoad) * 100;
            const fill = document.getElementById('progress-fill');
            if(fill) fill.style.width = progress + '%';
            
            if (itemsLoaded === totalItemsToLoad) {
                const overlay = document.getElementById('loading-overlay');
                if(overlay) {
                    overlay.style.opacity = '0';
                    setTimeout(() => {
                        overlay.style.display = 'none';
                        activateModel('A', false); // Start with A
                    }, 500);
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById('main-canvas');
            if(!container) return;

            // 1. Scene Setup
            scene = new THREE.Scene();
            // FOV 22.5 is exactly 50% zoom from the default 45
            camera = new THREE.PerspectiveCamera(20.5, container.clientWidth / container.clientHeight, 0.1, 1000);
            
            renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setClearColor(0x000000, 0); // Transparent canvas
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.outputEncoding = THREE.sRGBEncoding;
            renderer.toneMapping = THREE.LinearToneMapping; 
            renderer.toneMappingExposure = 0.66; // Brightness
            renderer.physicallyCorrectLights = true;
            container.appendChild(renderer.domElement);

            // 2. Controls
            controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableZoom = false; 
            controls.enablePan = false;
            controls.autoRotate = true; 
            controls.autoRotateSpeed = 3.0; 

            // 3. Lighting
            scene.add(new THREE.AmbientLight(0x000000)); 
            
            const directLight = new THREE.DirectionalLight(0xffffff, 4);
            directLight.position.set(10, 20, 10);
            scene.add(directLight);
            
            const fillLight = new THREE.DirectionalLight(0xffffff, 2);
            fillLight.position.set(-10, 5, -10);
            scene.add(fillLight);

            // HDR Environment
            const pmremGenerator = new THREE.PMREMGenerator(renderer);
            new THREE.RGBELoader().load('https://threejs.org/examples/textures/equirectangular/royal_esplanade_1k.hdr', (texture) => {
                const envMap = pmremGenerator.fromEquirectangular(texture).texture;
                scene.environment = envMap;
                texture.dispose();
                pmremGenerator.dispose();
                updateProgress();
            }, undefined, (e) => {
                updateProgress(); // fail gracefully
            });

            // 4. Asset Loader
            const loader = new THREE.GLTFLoader();
            Object.keys(factoryData).forEach(key => {
                loader.load(`${window.__factoryAssetBase}/${factoryData[key].file}`, (gltf) => {
                    const model = gltf.scene;
                    
                    model.traverse((node) => {
                        if (node.isMesh && node.material) {
                            node.material.envMapIntensity = 1.5; 
                            node.material.depthWrite = true;
                            node.material.transparent = false;
                            node.material.needsUpdate = true;
                        }
                    });

                    model.scale.set(0.75, 0.75, 0.75); // Prevent clipping
                    const box = new THREE.Box3().setFromObject(model);
                    const center = box.getCenter(new THREE.Vector3());
                    model.position.sub(center);
                    model.position.y = 1; // Set model position Y to 5 as requested
                    
                    model.visible = false; 
                    scene.add(model);
                    models[key] = model;
                    updateProgress();
                }, undefined, (e) => {
                    updateProgress();
                });
            });

            function animate() {
                requestAnimationFrame(animate);
                controls.update(); // handles autoRotate natively
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                if(!container) return;
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            });
        });

        // 5. Switching Logic triggered by clicking the cards
        window.switchModel = function(type, event) {
            // Prevent the stretched-link from navigating to another page if clicked outside the actual link text
            if(event.target.tagName !== 'A') {
                event.preventDefault();
            }

            if (type === currentType || !models[type]) return;
            
            // Update Active Card Styling
            document.querySelectorAll('.image-bg-card').forEach(card => card.classList.remove('active-card'));
            document.getElementById(`card-${type}`).classList.add('active-card');

            // Scroll up to the canvas smoothly
            window.scrollTo({
                top: document.getElementById('main-canvas').offsetTop - 80,
                behavior: 'smooth'
            });

            activateModel(type, true);
        };

        function activateModel(type, animateCam = true) {
            // Hide current
            if(models[currentType]) models[currentType].visible = false;
            
            // Show new
            currentType = type;
            models[type].visible = true;
            models[type].rotation.set(0,0,0);

            const conf = factoryData[type];
            
            // Unlock vertical rotation temporarily for smooth GSAP animation
            controls.minPolarAngle = 0;
            controls.maxPolarAngle = Math.PI;

            if(animateCam && typeof gsap !== 'undefined') {
                camera.position.set(...conf.startCam);
                gsap.to(camera.position, {
                    x: conf.endCam[0],
                    y: conf.endCam[1],
                    z: conf.endCam[2],
                    duration: 2.5,
                    ease: "power2.out",
                    onUpdate: () => {
                        camera.lookAt(0,0,0);
                        controls.target.set(0,0,0);
                    },
                    onComplete: () => {
                        // Allow vertical rotation (X/Z equivalent in spherical coords) within +/- 0.2 range
                        const currentPolar = controls.getPolarAngle();
                        controls.minPolarAngle = currentPolar - 0.2;
                        controls.maxPolarAngle = currentPolar + 0.2;
                        controls.autoRotate = true; // Enable autoRotate after move
                    }
                });
            } else {
                camera.position.set(...conf.endCam);
                camera.lookAt(0,0,0);
                controls.target.set(0,0,0);
                controls.update(); 
                
                // Allow vertical rotation within +/- 0.2 range
                const currentPolar = controls.getPolarAngle();
                controls.minPolarAngle = currentPolar - 0.2;
                controls.maxPolarAngle = currentPolar + 0.2;
                controls.autoRotate = true;
            }
        }
