document.addEventListener("DOMContentLoaded", function() {
    // --- 1. INJECTION DES STYLES CSS UNIVERSELS ---
    const styleSheet = document.createElement("style");
    styleSheet.type = "text/css";
    styleSheet.innerHTML = `
        .Caroussels, .carrousel {
            position: relative !important;
            overflow: hidden !important;
            display: block !important;
            box-sizing: border-box !important;
        }
        /* Piste interne générée automatiquement */
        .carrousel-track {
            display: flex !important;
            transition: transform 0.5s ease-in-out !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            gap: 0 !important;
            flex-wrap: nowrap !important;
        }
        .Caroussels img, .carrousel img {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            flex-shrink: 0 !important;
            display: block !important;
            height: auto !important;
            object-fit: cover !important;
        }
        /* Boutons de navigation (Flèches) */
        .carrousel-btn {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            border: none !important;
            cursor: pointer !important;
            z-index: 9999 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            background: rgba(0, 0, 0, 0.6) !important;
            border-radius: 50% !important;
            padding: 0 !important;
        }
        .carrousel-btn svg {
            width: 24px !important;
            height: 24px !important;
            fill: #ffffff !important;
        }
        .btn-prev { left: 10px !important; }
        .btn-next { right: 10px !important; }
        .btn-next svg { transform: rotate(90deg); }
        .btn-prev svg { transform: rotate(-90deg); }

        /* Points indicateurs (Dots) */
        .carousel-dots {
            position: absolute !important;
            bottom: 15px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            display: flex !important;
            gap: 6px !important;
            z-index: 9999 !important;
        }
        .dot {
            width: 12px !important;
            height: 12px !important;
            background-color: rgba(255, 255, 255, 0.5) !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            transition: background-color 0.3s, transform 0.3s;
        }
        .dot:hover { background-color: rgba(255, 255, 255, 0.8) !important; }
        .dot.active { background-color: #ffffff !important; transform: scale(1.2); }
    `;
    document.head.appendChild(styleSheet);

    // --- 2. TRAITEMENT AUTOMATIQUE DE TOUS LES CARROUSELS ---
    const carousels = document.querySelectorAll('.Caroussels, .carrousel');

    const arrowSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="m256-424-56-56 280-280 280 280-56 56-224-223-224 223Z" />
        </svg>
    `;

    carousels.forEach(carrousel => {
        // Récupère toutes les images présentes dans l'élément
        const images = carrousel.querySelectorAll('img');

        // S'il y a 1 image ou moins, on ne fait rien
        if (images.length <= 1) return;

        // Si les images ne sont pas déjà enveloppées dans une "track" (div), on les y place
        let track = carrousel.querySelector('.carrousel-track');
        if (!track) {
            track = document.createElement('div');
            track.classList.add('carrousel-track');
            // Déplace toutes les images et autres éléments internes dans la piste
            Array.from(carrousel.children).forEach(child => {
                if (!child.classList.contains('carrousel-btn') && !child.classList.contains('carousel-dots')) {
                    track.appendChild(child);
                }
            });
            carrousel.appendChild(track);
        }

        // --- 3. ANALYSE DES CLASSES (Insensible à la casse : Auto, auto, 3S, 3s, etc.) ---
        let isAuto = false;
        let intervalTime = 2000; // Par défaut 2 secondes[cite: 1]

        carrousel.classList.forEach(cls => {
            const lowerCls = cls.toLowerCase();
            if (lowerCls === 'auto') {
                isAuto = true;
            }
            // Vérifie si la classe est un nombre suivi de 's' (ex: 3s, 5s)[cite: 1]
            if (/^\d+s\$/i.test(lowerCls)) {
                const seconds = parseInt(lowerCls, 10);
                if (!isNaN(seconds)) {
                    intervalTime = seconds * 1000;
                    isAuto = true; // Si une durée est spécifiée, on active l'autoplay par sécurité
                }
            }
        });

        // --- 4. CRÉATION DES FLÈCHES ET DES POINTS ---
        const btnPrev = document.createElement('button');
        btnPrev.type = 'button';
        btnPrev.classList.add('carrousel-btn', 'btn-prev');
        btnPrev.innerHTML = arrowSVG;

        const btnNext = document.createElement('button');
        btnNext.type = 'button';
        btnNext.classList.add('carrousel-btn', 'btn-next');
        btnNext.innerHTML = arrowSVG;

        carrousel.appendChild(btnPrev);
        carrousel.appendChild(btnNext);

        const dotsContainer = document.createElement('div');
        dotsContainer.classList.add('carousel-dots');
        
        const dots = [];

        images.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active');

            dot.addEventListener('click', () => {
                stopAutoPlay();
                currentIndex = index;
                updateCarousel();
            });

            dotsContainer.appendChild(dot);
            dots.push(dot);
        });

        carrousel.appendChild(dotsContainer);

        // --- 5. LOGIQUE DE NAVIGATION ---
        let currentIndex = 0;
        let intervalId = null;

        const updateCarousel = () => {
            const translateX = -(currentIndex * 100);
            track.style.transform = `translateX(${translateX}%)`;

            dots.forEach(dot => dot.classList.remove('active'));
            if (dots[currentIndex]) {
                dots[currentIndex].classList.add('active');
            }
        };

        const showNext = () => {
            currentIndex = (currentIndex + 1) % images.length;
            updateCarousel();
        };

        const showPrev = () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCarousel();
        };

        const startAutoPlay = () => {
            if (isAuto && !intervalId) {
                intervalId = setInterval(showNext, intervalTime);
            }
        };

        const stopAutoPlay = () => {
            if (intervalId) {
                clearInterval(intervalId);
                intervalId = null;
            }
        };

        btnNext.addEventListener('click', () => {
            stopAutoPlay();
            showNext();
        });

        btnPrev.addEventListener('click', () => {
            stopAutoPlay();
            showPrev();
        });

        // Pause au survol de la souris
        carrousel.addEventListener('mouseenter', stopAutoPlay);
        carrousel.addEventListener('mouseleave', () => {
            if (isAuto) startAutoPlay();
        });

        // Démarrage de l'autoplay si activé
        if (isAuto) {
            startAutoPlay();
        }
    });
});