const header = document.querySelector('header');
window.addEventListener('scroll', () => {
  if (window.scrollY > 10) {
    header.classList.add('scroll');
  } else {
    header.classList.remove('scroll');
  }
});
function handleNavResponsive() {
    const header = document.querySelector('header');
    const nav = document.querySelector('header nav, nav.Responsive');

    if (!header || !nav) return;

    if (window.innerWidth < 830) {
        if (nav.parentElement === header) {
            header.removeChild(nav);
            header.after(nav);
            nav.classList.add('Responsive');
        }
    } else {
        if (nav.parentElement !== header && nav.classList.contains('Responsive')) {
            header.appendChild(nav);
            nav.classList.remove('Responsive');
        }
    }
}
window.addEventListener('DOMContentLoaded', handleNavResponsive);
// Au redimensionnement de la fenêtre
window.addEventListener('resize', handleNavResponsive);