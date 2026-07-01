    document.addEventListener("DOMContentLoaded", function() {
      const layers = document.querySelectorAll('#careerBgSlideshow .career-bg-layer');
      let current = 0;
      setInterval(() => {
        layers[current].classList.remove('active');
        current = (current + 1) % layers.length;
        layers[current].classList.add('active');
      }, 3000);
    });
