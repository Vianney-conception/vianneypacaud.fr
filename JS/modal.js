function toggleModal(id) {
    const element = document.getElementById(id);
    if (!element) return;
    element.classList.toggle('on');
}