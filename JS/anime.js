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

            // Arrêt sur la dernière image (index 61 = 0062.png)
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

    // Préchargement des 62 images
    for (let i = 1; i <= totalFrames; i++) {
        const img = new Image();
        img.src = getImagePath(i);
        img.onload = () => {
            imagesLoaded++;
            if (i === 1) {
                drawFrame(0); // Affiche l'image 0001 dès son chargement
            }
        };
        images.push(img);
    }

    // Observer avec les deux seuils : 0 (totalement masqué) et 1 (totalement visible)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            // 1. Pleinement visible (100%) : on lance la lecture si pas encore jouée
            if (entry.isIntersecting && entry.intersectionRatio >= 1) {
                startAnimation();
            } 
            // 2. Complètement caché (0%) : on remet à zéro pour le prochain passage
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
                // Si aucun élément n'a la classe, on l'attribue à celui-ci
                if (!activeElement) {
                    activeElement = el;
                    el.classList.add('AnimeBord');
                }
                // S'il y a déjà un actif, on ne fait rien (on garde le premier)
            } else {
                // Si l'élément qui perd sa visibilité complète était l'actif
                if (el === activeElement) {
                    el.classList.remove('AnimeBord');
                    activeElement = null;

                    // On vérifie si un autre élément est déjà pleinement visible pour lui passer la main
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
        threshold: 1.0 // Se déclenche uniquement quand un élément est vu à 100 %
    });

    targets.forEach((target) => observer.observe(target));
});

function gommeMagique(selecteur, { rayon = 20, douceur = 0.6, echelle = 0.5 } = {}) {
    const boite = document.querySelector(selecteur);
    if (!boite) return;

    // Calque qui porte le fond + le flou
    const fond = document.createElement('div');
    fond.className = 'gomme-fond';
    boite.prepend(fond);

    // Canvas de masque (résolution réduite pour rester fluide)
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    let dernier = null;
    let enAttente = false;

    function appliquerMasque() {
        const url = `url(${canvas.toDataURL()})`;
        fond.style.webkitMaskImage = url;
        fond.style.maskImage = url;
    }

    function planifierMasque() {
        if (enAttente) return;
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
        ctx.fillStyle = '#000';               // opaque = fond visible
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        appliquerMasque();
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
        ctx.globalCompositeOperation = 'destination-out'; // rend transparent
        if (dernier) {
            // interpolation pour un trait continu même si la souris va vite
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

    boite.addEventListener('pointermove', (e) => {
        const r = boite.getBoundingClientRect();
        gommer((e.clientX - r.left) * echelle, (e.clientY - r.top) * echelle);
    });

    boite.addEventListener('pointerleave', () => { dernier = null; });

    // Initialise le canvas, et le recrée si la boîte change de taille
    new ResizeObserver(reinitialiser).observe(boite);
}

gommeMagique('#Lesoucisdudetail', { rayon: 60, douceur: 0.6 });