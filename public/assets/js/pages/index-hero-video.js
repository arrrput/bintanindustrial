                    (function() {
                      const v = document.getElementById('heroVideo');
                      const pi = document.getElementById('vPlayIcon');
                      const mi = document.getElementById('vMuteIcon');
                      const ov = document.getElementById('overlayPlayBtn');
                      const pr = document.getElementById('vProgress');
                      const tm = document.getElementById('vTime');
                      const vl = document.getElementById('vVolume');
                      const ct = document.getElementById('videoContainer');

                      const fmt = (s) => {
                        if (s === undefined || isNaN(s) || !isFinite(s)) return "0:00";
                        const m = Math.floor(Math.abs(s) / 60);
                        const sc = Math.floor(Math.abs(s) % 60);
                        return m + ":" + (sc < 10 ? '0' : '') + sc;
                      };

                      window.isSeeking = false;

                      window.toggleHeroVid = (e) => {
                        if(e) { e.preventDefault(); e.stopPropagation(); }
                        if (v.paused) v.play().catch(err => {}); else v.pause();
                        syncUI();
                      };

                      // Preview time while dragging (responsive text)
                      window.previewSeek = (val) => {
                        if(v && v.duration && isFinite(v.duration)) {
                          const previewTime = (parseFloat(val) / 100) * v.duration;
                          if(tm) tm.innerText = fmt(previewTime) + " / " + fmt(v.duration);
                        }
                      };

                      // Actually seek video when slider is released
                      window.commitSeek = (val) => {
                        if(v && v.duration && isFinite(v.duration)) {
                          const seekTo = (parseFloat(val) / 100) * v.duration;
                          // Terapkan waktu baru ke video
                          v.currentTime = Math.max(0, Math.min(seekTo, v.duration));
                        }
                        // Lepaskan kunci slider SETELAH waktu video diubah
                        window.isSeeking = false; 
                      };

                      window.muteHeroVid = (e) => {
                        if(e) e.stopPropagation();
                        v.muted = !v.muted;
                        syncUI();
                      };

                      window.volHeroVid = (val) => {
                        v.volume = val;
                        v.muted = (val == 0);
                        syncUI();
                      };

                      window.skipHeroVid = (sec, e) => {
                        if(e) e.stopPropagation();
                        if(v && v.duration && isFinite(v.duration)) {
                           let newTime = v.currentTime + sec;
                           v.currentTime = Math.max(0.1, Math.min(newTime, v.duration - 0.5));
                        }
                      };

                      window.fullHeroVid = (e) => {
                        if(e) e.stopPropagation();
                        if (!document.fullscreenElement) ct.requestFullscreen().catch(err => {});
                        else if (document.exitFullscreen) document.exitFullscreen();
                      };

                      function syncUI() {
                        if(pi) pi.className = v.paused ? "bi bi-play-fill" : "bi bi-pause-fill";
                        if(ov) ov.style.opacity = v.paused ? "1" : "0";
                        if(mi) mi.className = (v.muted || v.volume == 0) ? "bi bi-volume-mute-fill" : "bi bi-volume-up-fill";
                        if(vl) vl.value = v.muted ? 0 : v.volume;
                      }

                      v.onplay = syncUI;
                      v.onpause = syncUI;
                      v.onvolumechange = syncUI;
                      
                      v.ontimeupdate = () => {
                        if(pr && !window.isSeeking) {
                          if(v.duration && isFinite(v.duration)) {
                            pr.value = (v.currentTime / v.duration) * 100;
                          }
                        }
                        if(tm && !window.isSeeking) {
                          tm.innerText = fmt(v.currentTime) + " / " + fmt(v.duration);
                        }
                      };

                      const initMeta = () => {
                        if(tm) tm.innerText = "0:00 / " + fmt(v.duration);
                        syncUI();
                      };

                      v.onloadedmetadata = initMeta;
                      v.oncanplay = initMeta;
                      
                      // Initial setup
                      v.muted = true;
                      v.volume = 0.5;
                      if(v.readyState >= 1) initMeta();
                    })();
