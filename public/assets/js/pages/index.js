    // Home page: testimonial horizontal scroll (Global Partnership) and isotope layout (News & Media).
    // Requires GSAP with ScrollTrigger and Draggable.
    document.addEventListener('DOMContentLoaded', function() {
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

    });
