  // Background slideshow for partials/section-header-overlay:
  // cross-fades the .bg-parallax-layer elements of every .bg-container every 4 seconds.
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bg-container').forEach(container => {
        const layers = container.querySelectorAll('.bg-parallax-layer');
        if (layers.length < 2) return;

        let current = 0;
        setInterval(() => {
            layers[current].classList.remove('active');
            current = (current + 1) % layers.length;
            layers[current].classList.add('active');
        }, 4000);
    });
  });
