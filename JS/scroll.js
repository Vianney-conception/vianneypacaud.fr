document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('header');
  const btnTop = document.querySelector('.btn-remonter');
  const footer = document.querySelector('footer');
  let isAutoScrolling = false;
  window.toppage = function() {
    if (!btnTop) return;
    isAutoScrolling = true;
    btnTop.classList.remove('scroll');
    window.scrollTo({ top: 0, behavior: 'smooth' });
    const checkTopReached = setInterval(() => {
      if (window.scrollY === 0) {
        clearInterval(checkTopReached);
        setTimeout(() => {
          isAutoScrolling = false;
        }, 100);
      }
    }, 50);
  };
  function checkFooterAndScroll() {
    if (!header || !footer) return;
    const rect = footer.getBoundingClientRect();
    const windowHeight = window.innerHeight || document.documentElement.clientHeight;
    const isFooterFullyVisible = (rect.top >= -1 && rect.bottom <= windowHeight + 1);
    if (isFooterFullyVisible) {
      header.classList.remove('scroll');
    } else {
      if (window.scrollY > 10) {
        header.classList.add('scroll');
      } else {
        header.classList.remove('scroll');
      }
    }
    if (btnTop && !isAutoScrolling) {
      if (!isFooterFullyVisible) {
        if (window.scrollY > 10) {
          btnTop.classList.add('scroll');
        } else {
          btnTop.classList.remove('scroll');
        }
      }
    }
  }

  window.addEventListener('scroll', checkFooterAndScroll);
  window.addEventListener('resize', checkFooterAndScroll);
  checkFooterAndScroll();
});