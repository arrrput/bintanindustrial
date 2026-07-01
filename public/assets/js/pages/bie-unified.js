  document.addEventListener('DOMContentLoaded', function() {
    
    // Parallax Slideshows Logic
    const slideshows = ['bieBgSlideshow', 'bintanBgSlideshow', 'workBgSlideshow'];
    
    slideshows.forEach(id => {
        const container = document.getElementById(id);
        if(container) {
            const layers = container.querySelectorAll('.bg-parallax-layer');
            if(layers.length > 1) {
                let current = 0;
                setInterval(() => {
                    layers[current].classList.remove('active');
                    current = (current + 1) % layers.length;
                    layers[current].classList.add('active');
                }, 4000);
            }
        }
    });

    // Bintan Swiper Logic
    const descItems = document.querySelectorAll('.bintan-desc-item');
    function syncDescription(index) {
        descItems.forEach((item) => {
            if (parseInt(item.getAttribute('data-index')) === index) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    if(document.querySelector('.bintan-img-slider')) {
        var bintanSwiper = new Swiper(".bintan-img-slider", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        initialSlide: 1,
        coverflowEffect: {
            rotate: 0,
            stretch: -20,
            depth: 150,
            modifier: 1.2,
            slideShadows: false,
        },
        pagination: {
            el: ".bintan-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".bintan-next",
            prevEl: ".bintan-prev",
        },
        on: {
            init: function () { syncDescription(this.activeIndex); },
            slideChange: function () { syncDescription(this.activeIndex); }
        }
        });
    }
  });
