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

    // Nommage : 1 -> "0001"
    const getImagePath = (index) => {
        const num = String(index).padStart(4, '0');
        return `/AnimationOrdinateur/img4/${num}.png`;
    };

    // Dessine l'image demandée
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

    // Réinitialise à 0001 uniquement quand le canvas est totalement hors de l'écran
    const resetToFirstFrame = () => {
        if (animationFrameId) {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
        }
        currentFrame = 0;
        hasPlayed = false;
        drawFrame(0); // Affiche 0001.png
    };

    // Boucle d'animation jusqu'à 0062
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

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('Lesoucisdudetail');
    if (!container) return;

    // Création dynamique du canvas
    const canvas = document.createElement('canvas');
    canvas.classList.add('sand-canvas');
    container.appendChild(canvas);
    const ctx = canvas.getContext('2d');

    let width = 0;
    let height = 0;

    const resize = () => {
        const rect = container.getBoundingClientRect();
        // Support Retina / haute résolution
        const dpr = window.devicePixelRatio || 1;
        width = rect.width;
        height = rect.height;
        canvas.width = width * dpr;
        canvas.height = height * dpr;
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';
        ctx.scale(dpr, dpr);
    };

    window.addEventListener('resize', resize);
    resize();

    // Particules de sable projetées
    let grains = [];
    let lastX = null;
    let lastY = null;

    // Dessine le creux du sillon (ombre intérieure + liseré clair sur le bord)
    function drawTrench(x, y, radius = 18) {
        ctx.save();
        
        // 1. Sillon principal (ombre douce couleur sable foncé)
        const grad = ctx.createRadialGradient(x, y, 0, x, y, radius);
        grad.addColorStop(0, 'rgba(175, 145, 105, 0.35)'); // Fond du sillon
        grad.addColorStop(0.6, 'rgba(215, 195, 160, 0.2)');
        grad.addColorStop(0.85, 'rgba(255, 255, 255, 0.25)'); // Bourrelet clair expulsé
        grad.addColorStop(1, 'rgba(255, 255, 255, 0)');

        ctx.fillStyle = grad;
        ctx.beginPath();
        ctx.arc(x, y, radius, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();
    }

    // Ajoute quelques petits grains de sable autour du mouvement
    function addSandGrains(x, y, count = 4) {
        for (let i = 0; i < count; i++) {
            const angle = Math.random() * Math.PI * 2;
            const dist = 12 + Math.random() * 16;
            grains.push({
                x: x + Math.cos(angle) * dist,
                y: y + Math.sin(angle) * dist,
                size: Math.random() * 2 + 0.8,
                alpha: 0.6 + Math.random() * 0.4,
                color: Math.random() > 0.4 ? '180, 150, 110' : '235, 220, 190',
                life: 1.0 // Durée de vie du grain
            });
        }
    }

    // Événement déplacement de souris
    container.addEventListener('mousemove', (e) => {
        const rect = container.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (lastX !== null && lastY !== null) {
            // Interpolation pour relier les points si le mouvement est rapide
            const dist = Math.hypot(x - lastX, y - lastY);
            const step = 4; // Pas de lissage
            const count = Math.ceil(dist / step);

            for (let i = 0; i < count; i++) {
                const interpX = lastX + (x - lastX) * (i / count);
                const interpY = lastY + (y - lastY) * (i / count);
                drawTrench(interpX, interpY, 16);
            }
        } else {
            drawTrench(x, y, 16);
        }

        addSandGrains(x, y, 3);
        lastX = x;
        lastY = y;
    });

    container.addEventListener('mouseleave', () => {
        lastX = null;
        lastY = null;
    });

    // Boucle d'animation : estompe le sable petit à petit et anime les grains
    function render() {
        // Estompe très léger et continu (rebouchage doux façon vent marin)
        ctx.save();
        ctx.globalCompositeOperation = 'destination-out';
        ctx.fillStyle = 'rgba(0, 0, 0, 0.018)'; 
        ctx.fillRect(0, 0, width, height);
        ctx.restore();

        // Rendu des grains de sable
        for (let i = grains.length - 1; i >= 0; i--) {
            const g = grains[i];
            ctx.fillStyle = `rgba(${g.color}, ${g.alpha * g.life})`;
            ctx.beginPath();
            ctx.arc(g.x, g.y, g.size, 0, Math.PI * 2);
            ctx.fill();

            g.life -= 0.008; // Vitesse de disparition des grains
            if (g.life <= 0) {
                grains.splice(i, 1);
            }
        }

        requestAnimationFrame(render);
    }

    requestAnimationFrame(render);
});