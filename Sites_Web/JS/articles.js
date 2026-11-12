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
document.addEventListener("DOMContentLoaded", () => {
    const article = document.querySelector("article");
    const sommaireUl = document.querySelector("#contenuSommaire nav ul");

    if (!article || !sommaireUl) return;
    const h2Elements = article.querySelectorAll("h2");
    if (h2Elements.length === 0) return;
    sommaireUl.innerHTML = "";
    const linkMap = new Map();
    const usedIds = new Set();
    h2Elements.forEach(h2 => { if (h2.id) usedIds.add(h2.id); });
    function slugify(text) {
        return text
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .trim()
            .replace(/[^\w\s-]/g, "")
            .replace(/\s+/g, "_");
    }
    function uniqueId(base) {
        base = base || "section";
        let id = base;
        let i = 2;
        while (usedIds.has(id) || document.getElementById(id)) {
            id = `${base}_${i++}`;
        }
        usedIds.add(id);
        return id;
    }
    h2Elements.forEach((h2, index) => {
        if (!h2.id) {
            h2.id = uniqueId(slugify(h2.textContent));
        }

        const li = document.createElement("li");
        const a = document.createElement("a");
        
        a.href = `#${h2.id}`;
        a.textContent = h2.textContent;
        if (index === 0) {
            a.classList.add("active");
        }

        li.appendChild(a);
        sommaireUl.appendChild(li);
        
        linkMap.set(h2.id, a);
    });
    const observerOptions = {
        root: null,
        rootMargin: "0px 0px -20% 0px",
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const link = linkMap.get(entry.target.id);
            if (!link) return;

            if (entry.isIntersecting) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });
    }, observerOptions);
    h2Elements.forEach(h2 => observer.observe(h2));
});