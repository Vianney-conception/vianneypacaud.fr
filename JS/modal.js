function toggleModal(id) {
    const element = document.getElementById(id);
    if (!element) return;
    element.classList.toggle('on');
}
document.addEventListener('click', function(event) {
    const menuBurger = document.getElementById('MenuBurger');
    const navElement = document.querySelector('nav');
    if (menuBurger && menuBurger.classList.contains('on')) {
        const cliqueDansNav = navElement && event.target.closest('nav');
        const cliqueDansBurger = event.target.closest('#MenuBurger');

        if (!cliqueDansNav && !cliqueDansBurger) {
            toggleModal('BoutonsNavigation');
            toggleModal('MenuBurger');
        }
    }
});