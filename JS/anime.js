document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('laptop-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const totalFrames = 62;
    const fps = 30;
    const frameInterval = 1000 / fps;

    const images = [];
    let imagesLoaded = 0;
    let currentFrame = 0;
    let animationFrameId = null;
    let lastDrawTime = 0;
    let hasPlayed = false;
    const getImagePath = (index) => {
        const num = String(index).padStart(4, '0');
        return `/AnimationOrdinateur/img4/${num}.png`;
    };
    const drawFrame = (frameIndex) => {
        const img = images[frameIndex];
        if (!img || !img.complete) return;

        if (canvas.width !== img.naturalWidth || canvas.height !== img.naturalHeight) {
            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
        }

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    const resetToFirstFrame = () => {
        if (animationFrameId) {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
        }
        currentFrame = 0;
        hasPlayed = false;
        drawFrame(0);
    };

    const playAnimation = (timestamp) => {
        if (!lastDrawTime) lastDrawTime = timestamp;
        const delta = timestamp - lastDrawTime;

        if (delta >= frameInterval) {
            drawFrame(currentFrame);
            if (currentFrame >= totalFrames - 1) {
                animationFrameId = null;
                return;
            }

            currentFrame++;
            lastDrawTime = timestamp - (delta % frameInterval);
        }

        animationFrameId = requestAnimationFrame(playAnimation);
    };

    const startAnimation = () => {
        if (hasPlayed || animationFrameId) return;
        hasPlayed = true;
        currentFrame = 0;
        lastDrawTime = 0;
        animationFrameId = requestAnimationFrame(playAnimation);
    };
    for (let i = 1; i <= totalFrames; i++) {
        const img = new Image();
        img.src = getImagePath(i);
        img.onload = () => {
            imagesLoaded++;
            if (i === 1) {
                drawFrame(0);
            }
        };
        images.push(img);
    }
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && entry.intersectionRatio >= 1) {
                startAnimation();
            }
            else if (!entry.isIntersecting || entry.intersectionRatio === 0) {
                resetToFirstFrame();
            }
        });
    }, {
        threshold: [0, 1.0]
    });

    observer.observe(canvas);
});

document.addEventListener('DOMContentLoaded', () => {
    const targets = document.querySelectorAll('.Animation');
    if (!targets.length) return;

    let activeElement = null;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            const el = entry.target;
            const isFullyVisible = entry.isIntersecting && entry.intersectionRatio >= 1;

            if (isFullyVisible) {
                if (!activeElement) {
                    activeElement = el;
                    el.classList.add('AnimeBord');
                }
            } else {
                if (el === activeElement) {
                    el.classList.remove('AnimeBord');
                    activeElement = null;
                    for (const target of targets) {
                        if (target !== el) {
                            const rect = target.getBoundingClientRect();
                            const fullyInView = (
                                rect.top >= 0 &&
                                rect.left >= 0 &&
                                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                            );

                            if (fullyInView) {
                                activeElement = target;
                                target.classList.add('AnimeBord');
                                break;
                            }
                        }
                    }
                }
            }
        });
    }, {
        threshold: 1.0
    });
    targets.forEach((target) => observer.observe(target));
});
function gommeMagique(selecteur, { rayon = 40, douceur = 0.6, echelle = 0.5, vitesseReformation = 0.015 } = {}) {
    const boite = document.querySelector(selecteur);
    if (!boite) return;
    boite.style.touchAction = 'none';
    const estFirefox = navigator.userAgent.toLowerCase().includes('firefox');
    let estVisible = false;
    if (estFirefox) {
        boite.style.position = 'relative';
        boite.style.overflow = 'hidden';

        const spotlight = document.createElement('div');
        spotlight.className = 'firefox-spotlight';
        spotlight.style.position = 'absolute';
        spotlight.style.inset = '0';
        spotlight.style.pointerEvents = 'none';
        spotlight.style.transition = 'opacity 0.3s ease';
        spotlight.style.opacity = '0';
        spotlight.style.background = 'radial-gradient(circle var(--rayon, 100px) at var(--x, 50%) var(--y, 50%), rgba(255,255,255,0.8) 0%, transparent 100%)';
        boite.appendChild(spotlight);

        const handlePointerMove = (e) => {
            if (!estVisible) return;
            const r = boite.getBoundingClientRect();
            const x = e.clientX - r.left;
            const y = e.clientY - r.top;
            
            spotlight.style.setProperty('--x', `${x}px`);
            spotlight.style.setProperty('--y', `${y}px`);
            spotlight.style.setProperty('--rayon', `${rayon * 2.5}px`);
            spotlight.style.opacity = '1';
        };
        const handlePointerLeave = () => {
            spotlight.style.opacity = '0';
        };
        boite.addEventListener('pointermove', handlePointerMove);
        boite.addEventListener('pointerleave', handlePointerLeave);
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                estVisible = entry.isIntersecting;
                if (!estVisible) spotlight.style.opacity = '0';
            });
        }, { threshold: 0 });
        observer.observe(boite);
        return;
    }
    const fond = document.createElement('div');
    fond.className = 'gomme-fond';
    fond.style.touchAction = 'none';
    boite.prepend(fond);
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    let dernier = null;
    let enAttente = false;
    let actifJusqua = 0;
    let boucleActive = false;
    let rafId = null;
    function appliquerMasque() {
        if (!estVisible) return;
        const url = `url(${canvas.toDataURL()})`;
        fond.style.webkitMaskImage = url;
        fond.style.maskImage = url;
    }
    function retirerMasque() {
        fond.style.webkitMaskImage = 'none';
        fond.style.maskImage = 'none';
    }
    function planifierMasque() {
        if (enAttente || !estVisible) return;
        enAttente = true;
        requestAnimationFrame(() => {
            enAttente = false;
            appliquerMasque();
        });
    }

    function reinitialiser() {
        const r = boite.getBoundingClientRect();
        canvas.width = Math.max(1, Math.round(r.width * echelle));
        canvas.height = Math.max(1, Math.round(r.height * echelle));
        ctx.globalCompositeOperation = 'source-over';
        ctx.fillStyle = '#000'; 
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        if (estVisible) appliquerMasque();
        else retirerMasque();
    }

    function tampon(x, y) {
        const r = rayon * echelle;
        const g = ctx.createRadialGradient(x, y, r * (1 - douceur), x, y, r);
        g.addColorStop(0, 'rgba(0,0,0,1)');
        g.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(x, y, r, 0, Math.PI * 2);
        ctx.fill();
    }
    function gommer(x, y) {
        if (!estVisible) return;
        ctx.globalCompositeOperation = 'destination-out';
        if (dernier) {
            const dx = x - dernier.x;
            const dy = y - dernier.y;
            const pas = Math.max(1, (rayon * echelle) / 4);
            const n = Math.ceil(Math.hypot(dx, dy) / pas);
            for (let i = 1; i <= n; i++) {
                tampon(dernier.x + (dx * i) / n, dernier.y + (dy * i) / n);
            }
        } else {
            tampon(x, y);
        }
        dernier = { x, y };
        planifierMasque();
    }
    function reveiller() {
        if (!estVisible) return;
        actifJusqua = performance.now() + (4.6 / vitesseReformation) * 16.7;
        if (!boucleActive) {
            boucleActive = true;
            rafId = requestAnimationFrame(boucleReformation);
        }
    }
    function boucleReformation(t) {
        if (!estVisible) {
            boucleActive = false;
            return;
        }
        if (t > actifJusqua) {
            ctx.globalCompositeOperation = 'source-over';
            ctx.fillStyle = '#000';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            appliquerMasque();
            boucleActive = false;
            return;
        }
        ctx.globalCompositeOperation = 'source-over';
        ctx.fillStyle = `rgba(0, 0, 0, ${vitesseReformation})`;
        ctx.fillRect(0, 0, canvas.width, canvas.height);   
        planifierMasque();
        rafId = requestAnimationFrame(boucleReformation);
    }
    const handlePointerMove = (e) => {
        const r = boite.getBoundingClientRect();
        gommer((e.clientX - r.left) * echelle, (e.clientY - r.top) * echelle);
        reveiller();
    };
    const handlePointerLeave = () => { dernier = null; };

    boite.addEventListener('pointermove', handlePointerMove);
    boite.addEventListener('pointerleave', handlePointerLeave);

    const resizeObserver = new ResizeObserver(reinitialiser);
    resizeObserver.observe(boite);

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                estVisible = true;
                reinitialiser();
            } else {
                estVisible = false;
                if (rafId) cancelAnimationFrame(rafId);
                boucleActive = false;
                dernier = null;
                reinitialiser();
                retirerMasque();
            }
        });
    }, { threshold: 0 });

    observer.observe(boite);
}
gommeMagique('#Lesoucisdudetail', { rayon: 40, douceur: 0.6, vitesseReformation: 0.004 });