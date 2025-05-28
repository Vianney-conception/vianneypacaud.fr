window.addEventListener('scroll', function() {
    const btn = document.querySelector('.btn-ModeSombre.on');
    if (!btn) return;

    if (window.scrollY > 150) {
        btn.classList.remove('on');
        btn.classList.add('off');
    } else {
        btn.classList.remove('off');
        btn.classList.add('on');
    }
});