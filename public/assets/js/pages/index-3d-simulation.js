    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 3D FACTORY SIMULATION LOGIC ---
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

        const container3D = document.getElementById('main-canvas');
        if(container3D) {
            // 1. Scene Setup
            scene = new THREE.Scene();
            const getFov = () => {
                if (window.innerWidth < 576) return 36;
                if (window.innerWidth < 992) return 28;
                return 20.5;
            };
            camera = new THREE.PerspectiveCamera(getFov(), container3D.clientWidth / container3D.clientHeight, 0.1, 1000);
            
            renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setClearColor(0x000000, 0); 
            renderer.setSize(container3D.clientWidth, container3D.clientHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.outputEncoding = THREE.sRGBEncoding;
            renderer.toneMapping = THREE.LinearToneMapping; 
            renderer.toneMappingExposure = 0.66;
            renderer.physicallyCorrectLights = true;
            container3D.appendChild(renderer.domElement);

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
                updateProgress();
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

                    model.scale.set(0.75, 0.75, 0.75); 
                    const box = new THREE.Box3().setFromObject(model);
                    const center = box.getCenter(new THREE.Vector3());
                    model.position.sub(center);
                    model.position.y = 1; 
                    
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
                controls.update(); 
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                if(!container3D) return;
                camera.fov = getFov();
                camera.aspect = container3D.clientWidth / container3D.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container3D.clientWidth, container3D.clientHeight);
            });
        }

        // 5. Switching Logic triggered by clicking the cards
        window.switchModel = function(type, event) {
            // Jika model yang diklik adalah model yang aktif atau data model tidak tersedia, batalkan proses
            if (type === currentType || !models[type]) return;
            activateModel(type, true);
        };

        function activateModel(type, animateCam = true) {
            if(models[currentType]) models[currentType].visible = false;

            // Update Active Card Styling
            document.querySelectorAll('#factype .image-bg-card').forEach(card => card.classList.remove('active-card'));
            const cardEl = document.getElementById(`card-${type}`);
            if(cardEl) cardEl.classList.add('active-card');

            currentType = type;
            models[type].visible = true;

            models[type].rotation.set(0,0,0);

            const conf = factoryData[type];
            
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
                        const currentPolar = controls.getPolarAngle();
                        controls.minPolarAngle = currentPolar - 0.2;
                        controls.maxPolarAngle = currentPolar + 0.2;
                        controls.autoRotate = true; 
                    }
                });
            } else {
                camera.position.set(...conf.endCam);
                camera.lookAt(0,0,0);
                controls.target.set(0,0,0);
                controls.update(); 
                
                const currentPolar = controls.getPolarAngle();
                controls.minPolarAngle = currentPolar - 0.2;
                controls.maxPolarAngle = currentPolar + 0.2;
                controls.autoRotate = true;
            }
        }


        // Register GSAP Plugins
        gsap.registerPlugin(ScrollTrigger, Draggable);

        const scrollContent = document.querySelector('.horizontal-scroll-content');
        const scrollWrapper = document.querySelector('.horizontal-scroll-wrapper');
        const clientsSection = document.getElementById('clients');
        
        if (scrollContent && scrollWrapper && clientsSection) {
            scrollContent.style.willChange = 'transform';
            let currentX = 0;
            let amountToScroll = 0;

            const handleWheel = (e) => {
                // Ignore horizontal wheel (trackpad) to let it work naturally if needed
                if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return; 
                
                const delta = e.deltaY;
                const isAtStart = currentX >= 0;
                const isAtEnd = currentX <= -amountToScroll;
                
                // If we are within horizontal scroll boundaries, prevent vertical scroll and move horizontally
                if ((delta > 0 && !isAtEnd) || (delta < 0 && !isAtStart)) {
                    e.preventDefault();
                    currentX = Math.max(-amountToScroll, Math.min(0, currentX - delta));
                    gsap.to(scrollContent, { 
                        x: currentX, 
                        duration: 0.5, 
                        ease: "power2.out",
                        overwrite: "auto"
                    });
                }
            };
            
            clientsSection.addEventListener('wheel', handleWheel, { passive: false });
            
            const initScroll = () => {
                const isMobile = window.innerWidth <= 991;
                
                // Calculate amountToScroll and initial padding
                const initialOffset = isMobile ? 20 : (window.innerWidth / 2) - (scrollContent.querySelector('.testimonial-horizontal-item').offsetWidth / 2);
                scrollContent.style.paddingLeft = `${initialOffset}px`;
                
                amountToScroll = scrollContent.scrollWidth - window.innerWidth;
                currentX = 0;
                gsap.set(scrollContent, { x: 0 });

                // Drag Logic
                Draggable.create(scrollContent, {
                    type: "x",
                    trigger: scrollWrapper,
                    bounds: { minX: -amountToScroll, maxX: 0 },
                    onDrag: function() {
                        currentX = this.x;
                    },
                    onPress: function() {
                        scrollWrapper.style.cursor = 'grabbing';
                    },
                    onRelease: function() {
                        scrollWrapper.style.cursor = 'grab';
                    }
                });
            };

            initScroll();

            const updateLayout = () => {
                // Kill all ScrollTrigger instances for this section if any exist
                ScrollTrigger.getAll().forEach(st => {
                    if (st.vars.trigger === "#clients" || (st.animation && st.animation.targets().includes(scrollContent))) {
                        st.kill();
                    }
                });

                // Kill all Draggable instances for this content
                Draggable.getAll().forEach(d => {
                    if (d.target === scrollContent || d.vars.trigger === scrollWrapper) {
                        d.kill();
                    }
                });
                
                // Clear inline styles
                gsap.set(scrollContent, { clearProps: "all" });
                
                // Re-initialize after a short delay
                setTimeout(() => {
                    initScroll();
                    ScrollTrigger.refresh();
                }, 100);
            };

            // Fix Resize Issue: Recalculate without refresh
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(updateLayout, 250);
            });
            
            scrollWrapper.style.cursor = 'grab';
        }

        // Fix Isotope Layout on Resize
        window.addEventListener('resize', function() {
            const isotopeContainer = document.querySelector('.isotope-container');
            if (isotopeContainer && typeof Isotope !== 'undefined') {
                const iso = Isotope.data(isotopeContainer);
                if (iso) {
                    iso.layout();
                }
            }
        });

        // Ensure Isotope triggers layout after images load
        const isotopeContainer = document.querySelector('.isotope-container');
        if (isotopeContainer && typeof imagesLoaded !== 'undefined') {
            imagesLoaded(isotopeContainer, function() {
                if (typeof Isotope !== 'undefined') {
                    const iso = Isotope.data(isotopeContainer);
                    if (iso) iso.layout();
                }
            });
        }

        // Custom Video Player Logic
        const container = document.getElementById('videoContainer');
        // --- ULTIMATE VIDEO FIX REMOVED ---
        });
