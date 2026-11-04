const comparator = document.getElementById('comparator');
const imgFull = document.getElementById('imgFull');
const sliderBar = document.getElementById('sliderBar');

let isDragging = false;

function updateSlider(clientX) {
    const rect = comparator.getBoundingClientRect();
    let offsetX = clientX - rect.left;

    if (offsetX < 0) offsetX = 0;
    if (offsetX > rect.width) offsetX = rect.width;

    const percentage = (offsetX / rect.width) * 100;
    const rightClip = 100 - percentage;

    sliderBar.style.left = percentage + '%';
    
    imgFull.style.clipPath = `inset(0 ${rightClip}% 0 0)`;
}

// Événements Souris & Tactiles
sliderBar.addEventListener('mousedown', (e) => { isDragging = true; e.preventDefault(); });
window.addEventListener('mouseup', () => isDragging = false);
window.addEventListener('mousemove', (e) => { if (isDragging) updateSlider(e.clientX); });

sliderBar.addEventListener('touchstart', (e) => { isDragging = true; e.preventDefault(); });
window.addEventListener('touchend', () => isDragging = false);
window.addEventListener('touchmove', (e) => { if (isDragging) updateSlider(e.touches[0].clientX); });

comparator.addEventListener('click', (e) => updateSlider(e.clientX));