document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("laptop-canvas");
    if (!canvas) return;

    const context = canvas.getContext("2d");
    const frameCount = 62; 
    const currentFrame = index => `AnimationOrdinateur/img4/${index.toString().padStart(4, '0')}.png`;

    const images = [];
    let targetFrameFloat = 0;
    let currentFrameFloat = 0;
    const lerpFactor = 0.15;

    canvas.width = 1920;
    canvas.height = 1080;

    const zoneScroll = document.getElementById("ZoneScrollLaptop");

    let imagesLoaded = 0;
    for (let i = 1; i <= frameCount; i++) {
        const img = new Image();
        img.src = currentFrame(i);
        images.push(img);
        img.onload = () => {
            imagesLoaded++;
            if (imagesLoaded === frameCount) {
                render(0);
                window.addEventListener('scroll', handleAppleScrollAnimation, { passive: true });
                updateLaptopLoop();
            }
        };
    }

    function render(frame) {
        context.clearRect(0, 0, canvas.width, canvas.height);
        if (images[frame]) {
            context.drawImage(images[frame], 0, 0);
        }
    }

    // LOGIQUE DE SCROLL APPLE OPTIMISÉE POUR TON ID #MaPhilosophie :
    function handleAppleScrollAnimation() {
        if (!zoneScroll) return;

        const zoneRect = zoneScroll.getBoundingClientRect();
        const stickyHeight = 500; // Hauteur fixe désormais forcée en CSS
        
        // Seuil exact du blocage au centre de l'écran (50vh - 250px)
        const stickyStartThreshold = window.innerHeight / 2 - stickyHeight / 2;
        
        // Distance totale pendant laquelle le bloc reste fixé à l'écran
        const totalStickyDistance = zoneRect.height - stickyHeight;

        if (totalStickyDistance <= 0) return;

        // Mesure de la progression uniquement quand la div ARRÊTE de monter
        let scrolledInsideSticky = stickyStartThreshold - zoneRect.top;
        let progress = scrolledInsideSticky / totalStickyDistance;

        // On bloque strict entre 0 (fermé) et 1 (ouvert)
        progress = Math.min(Math.max(progress, 0), 1);

        targetFrameFloat = progress * (frameCount - 1);
    }

    function updateLaptopLoop() {
        currentFrameFloat += (targetFrameFloat - currentFrameFloat) * lerpFactor;
        const roundedFrame = Math.round(currentFrameFloat);
        const currentDisplayedFrame = Math.min(frameCount - 1, Math.max(0, roundedFrame));
        render(currentDisplayedFrame);

        requestAnimationFrame(updateLaptopLoop);
    }
});