window.addEventListener('load', () => {
    Promise.all([document.fonts.ready, window.binReady]).then(() => {
        const globalSite = document.getElementById('GlobalSite');
        const chargement = document.getElementById('Chargement');
        if (globalSite) {
            globalSite.style.removeProperty('display');
        }
        if (chargement) {
            chargement.classList.add('cache');
        }
    });
});