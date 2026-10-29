window.addEventListener('load', () => {
    document.fonts.ready.then(() => {
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