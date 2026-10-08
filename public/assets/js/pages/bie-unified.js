  document.addEventListener('DOMContentLoaded', function() {
    
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
