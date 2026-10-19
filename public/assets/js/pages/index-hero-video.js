/* Hero "Watch video profile" modal player: play/pause, seek, skip ±10s, volume, fullscreen */
(function () {
    const modal = document.getElementById('heroVideoModal');
    const openBtn = document.getElementById('heroVideoOpen');
    if (!modal || !openBtn) return;

    const v = document.getElementById('hvVideo');
    const player = document.getElementById('hvPlayer');
    const center = document.getElementById('hvCenter');
    const playBtn = document.getElementById('hvPlay');
    const progress = document.getElementById('hvProgress');
    const time = document.getElementById('hvTime');
    const muteBtn = document.getElementById('hvMute');
    const volume = document.getElementById('hvVolume');
    let seeking = false;

    const fmt = (s) => {
        if (!isFinite(s)) return '0:00';
        const m = Math.floor(s / 60);
        const sec = Math.floor(s % 60);
        return m + ':' + (sec < 10 ? '0' : '') + sec;
    };

    const setIcon = (btn, icon) => { btn.querySelector('i').className = 'bi ' + icon; };

    const syncPlay = () => {
        const icon = v.paused ? 'bi-play-fill' : 'bi-pause-fill';
        setIcon(playBtn, icon);
        setIcon(center, icon);
        player.classList.toggle('is-paused', v.paused);
    };

    const syncVolume = () => {
        setIcon(muteBtn, v.muted || v.volume === 0 ? 'bi-volume-mute-fill' : 'bi-volume-up-fill');
        volume.value = v.muted ? 0 : v.volume;
    };

    const syncTime = () => {
        if (!v.duration) return;
        if (!seeking) progress.value = (v.currentTime / v.duration) * 100;
        progress.style.setProperty('--fill', progress.value + '%');
        time.textContent = fmt(v.currentTime) + ' / ' + fmt(v.duration);
    };

    const toggle = () => { v.paused ? v.play().catch(() => {}) : v.pause(); };
    const skip = (sec) => {
        if (!v.duration) return;
        v.currentTime = Math.max(0, Math.min(v.currentTime + sec, v.duration));
    };

    const open = () => {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.documentElement.style.overflow = 'hidden';
        v.play().catch(() => {});
    };

    const close = () => {
        v.pause();
        if (document.fullscreenElement) document.exitFullscreen().catch(() => {});
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.documentElement.style.overflow = '';
    };

    openBtn.addEventListener('click', open);
    modal.querySelectorAll('[data-hv-close]').forEach((el) => el.addEventListener('click', close));

    v.addEventListener('click', toggle);
    center.addEventListener('click', toggle);
    playBtn.addEventListener('click', toggle);
    document.getElementById('hvBack').addEventListener('click', () => skip(-10));
    document.getElementById('hvFwd').addEventListener('click', () => skip(10));

    progress.addEventListener('input', () => {
        seeking = true;
        progress.style.setProperty('--fill', progress.value + '%');
        if (v.duration) time.textContent = fmt((progress.value / 100) * v.duration) + ' / ' + fmt(v.duration);
    });
    progress.addEventListener('change', () => {
        if (v.duration) v.currentTime = (progress.value / 100) * v.duration;
        seeking = false;
    });

    muteBtn.addEventListener('click', () => {
        v.muted = !v.muted;
        if (!v.muted && v.volume === 0) v.volume = 0.5;
    });
    volume.addEventListener('input', () => {
        v.volume = parseFloat(volume.value);
        v.muted = v.volume === 0;
    });

    document.getElementById('hvFull').addEventListener('click', () => {
        if (document.fullscreenElement) document.exitFullscreen().catch(() => {});
        else player.requestFullscreen?.().catch(() => {});
    });

    ['play', 'pause', 'ended'].forEach((e) => v.addEventListener(e, syncPlay));
    ['timeupdate', 'loadedmetadata', 'durationchange'].forEach((e) => v.addEventListener(e, syncTime));
    v.addEventListener('volumechange', syncVolume);

    // Keyboard: Esc closes, Space toggles, ←/→ skip 10s
    document.addEventListener('keydown', (e) => {
        if (!modal.classList.contains('is-open')) return;
        if (e.key === 'Escape') close();
        else if (e.key === ' ') { e.preventDefault(); toggle(); }
        else if (e.key === 'ArrowLeft') { e.preventDefault(); skip(-10); }
        else if (e.key === 'ArrowRight') { e.preventDefault(); skip(10); }
    });

    syncPlay();
    syncVolume();
})();
