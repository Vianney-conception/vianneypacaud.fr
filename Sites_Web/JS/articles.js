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
    sommaire.classList.toggle("on");
}
document.addEventListener("click", function(event) {
    const sommaire = document.getElementById("SommaireArticle");
    if (sommaire && sommaire.classList.contains("on") && !sommaire.contains(event.target)) {
        deploieSommaire();
    }
});
//
//navigation dans sommaire
document.addEventListener("DOMContentLoaded", () => {
    // 1. Sélectionner l'article et le conteneur du sommaire
    const article = document.querySelector("article");
    const sommaireUl = document.querySelector("#contenuSommaire nav ul");

    if (!article || !sommaireUl) return;

    // 2. Récupérer tous les h2 de l'article
    const h2Elements = article.querySelectorAll("h2");
    if (h2Elements.length === 0) return;

    // Vider le conteneur au cas où
    sommaireUl.innerHTML = "";

    const linkMap = new Map(); // Associe chaque id de h2 à son élément <a>

    // 3. Parcourir chaque h2 pour lui assigner un repère et créer le lien
    h2Elements.forEach((h2, index) => {
        const repereId = `repere${index + 1}`;
        
        if (!h2.id) {
            h2.id = repereId;
        }

        const li = document.createElement("li");
        const a = document.createElement("a");
        
        a.href = `#${h2.id}`;
        a.textContent = h2.textContent;
        
        // Activer le premier par défaut
        if (index === 0) {
            a.classList.add("active");
        }

        li.appendChild(a);
        sommaireUl.appendChild(li);
        
        linkMap.set(h2.id, a);
    });

    // 4. Gestion de la classe active multiple (Scroll Spy)
    const observerOptions = {
        root: null,
        rootMargin: "0px 0px -20% 0px", // Détecte quand le h2 entre ou est présent dans la vue
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const link = linkMap.get(entry.target.id);
            if (!link) return;

            if (entry.isIntersecting) {
                // Si le h2 devient visible, on ajoute la classe active
                link.classList.add("active");
            } else {
                // S'il sort de l'écran, on la retire
                link.classList.remove("active");
            }
        });
    }, observerOptions);

    // Observer chaque h2 de l'article
    h2Elements.forEach(h2 => observer.observe(h2));
});
//