//gestion du scroll
 document.addEventListener('DOMContentLoaded', () => {
        const header = document.querySelector('header'); const btnTop = document.querySelector('.btn-remonter'); const footer = document.querySelector('footer'); let isAutoScrolling = !1; let lastScrollY = window.scrollY; let accumulatedScroll = 0; window.toppage = function () { if (!btnTop) return; isAutoScrolling = !0; btnTop.classList.remove('scroll'); window.scrollTo({ top: 0, behavior: 'smooth' }); const checkTopReached = setInterval(() => { if (window.scrollY === 0) { clearInterval(checkTopReached); setTimeout(() => { isAutoScrolling = !1 }, 100) } }, 50) }; function checkFooterAndScroll() {
            if (!header || !footer) return; const currentScrollY = window.scrollY; const rect = footer.getBoundingClientRect(); const windowHeight = window.innerHeight || document.documentElement.clientHeight; const isFooterFullyVisible = (rect.top >= -1 && rect.bottom <= windowHeight + 1); if (isFooterFullyVisible) { header.classList.remove('scroll') } else {
                const scrollDifference = currentScrollY - lastScrollY; if ((scrollDifference > 0 && accumulatedScroll < 0) || (scrollDifference < 0 && accumulatedScroll > 0)) { accumulatedScroll = 0 }
                accumulatedScroll += scrollDifference; if (accumulatedScroll >= 10) { header.classList.add('scroll'); accumulatedScroll = 0 } else if (accumulatedScroll <= -10) { header.classList.remove('scroll'); accumulatedScroll = 0 }
                if (currentScrollY <= 10) { header.classList.remove('scroll') }
            }
            lastScrollY = currentScrollY; if (btnTop && !isAutoScrolling) { if (!isFooterFullyVisible) { if (currentScrollY > 10) { btnTop.classList.add('scroll') } else { btnTop.classList.remove('scroll') } } }
        }
        window.addEventListener('scroll', checkFooterAndScroll); window.addEventListener('resize', checkFooterAndScroll); checkFooterAndScroll()
    })
//
//sommaire gestion
function deploieSommaire() {
    const sommaire = document.getElementById("SommaireArticle");
    // Bascule la classe 'on' (si 'on' est présent il la retire, sinon il l'ajoute)
    sommaire.classList.toggle("on");
}
//
