(function() {
    const style = document.createElement('style');
    style.textContent = `
        .grille-fond {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: none;
            background-color: #F6F6F6;
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: 0px 0px;
            will-change: background-position;
        }

        /* CONTENEUR FIXÉ À L'ÉCRAN : Règle le problème du scroll */
        .particle-container {
            position: fixed; /* Reste visible à l'écran peu importe le scroll */
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden; /* Empêche les barres de scroll */
            pointer-events: none;
            z-index: 9999;
        }

        /* Style individuel de chaque graine */
        .particule {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            pointer-events: none;
        }
    `;
    document.head.appendChild(style);
    const grille = document.createElement('div');
    grille.classList.add('grille-fond');
    document.body.prepend(grille);
    window.addEventListener('scroll', () => {
        const offset = window.scrollY;
        grille.style.backgroundPosition = `0px ${-(offset * 0.3)}px`;
    });
    const couleursDisponibles = ['#002060', '#007211'];

    document.addEventListener('click', (e) => {
        const mouseX = e.clientX;
        const mouseY = e.clientY;

        const container = document.createElement('div');
        container.classList.add('particle-container');
        document.body.appendChild(container);

        const nbParticules = 20;
        const dureeAnimation = 1800;
        const startTime = performance.now();

        const grainesData = [];

        for (let i = 0; i < nbParticules; i++) {
            const el = document.createElement('div');
            el.classList.add('particule');
            container.appendChild(el);

            el.style.backgroundColor = couleursDisponibles[Math.floor(Math.random() * couleursDisponibles.length)];

            const angleInitial = Math.random() * Math.PI * 2;
            const vitesseInitiale = Math.random() * 8 + 3;

            grainesData.push({
                el,
                x: mouseX,
                y: mouseY,
                vx: Math.cos(angleInitial) * vitesseInitiale,
                vy: Math.sin(angleInitial) * vitesseInitiale,
                turbulenceIntensity: Math.random() * 0.15 + 0.05,
                turbulencePhase: Math.random() * 100
            });
        }

        function animerChaos(timestamp) {
            const progress = (timestamp - startTime) / dureeAnimation;

            if (progress < 1) {
                grainesData.forEach(g => {
                    g.vx *= (0.97 - Math.random() * 0.02);
                    g.vy *= (0.97 - Math.random() * 0.02);

                    const turbulenceX = (Math.random() - 0.5) * g.turbulenceIntensity;
                    const turbulenceY = (Math.random() - 0.5) * g.turbulenceIntensity;
                    g.vx += turbulenceX;
                    g.vy += turbulenceY;

                    g.vy -= 0.03 * Math.random(); 

                    g.x += g.vx;
                    g.y += g.vy;

                    g.el.style.left = `${g.x}px`;
                    g.el.style.top = `${g.y}px`;
                    
                    g.el.style.opacity = 1 - progress;
                    g.el.style.transform = `scale(${1 - (progress * 0.4)})`;
                });

                requestAnimationFrame(animerChaos);
            } else {
                container.remove();
            }
        }

        requestAnimationFrame(animerChaos);
    });
})();