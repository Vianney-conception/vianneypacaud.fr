<?php
$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$is_home = ($current_page === '' || $current_page === 'index.php' || $current_page === 'index');
?>
<header class="">
    <a href="/" class="lienVersAcceuil">
        <div class="logo">
            <img src="https://vianneypacaud.fr/img/LogoCouleur.png" alt="Logo Vianney Pacaud"
                class="h-full w-auto object-contain"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        </div>

        <h1><strong class="Bleu">Vianney</strong> <strong class="Vert">Pacaud</strong><strong class="Bleu">.</strong>
        </h1>
    </a>
    <button id="MenuBurger" onclick="toggleModal('BoutonsNavigation');toggleModal('MenuBurger')"
        class="MenuBurger Clic-Particule"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
            viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-menu-icon lucide-menu">
            <path d="M4 5h16" class="line-top" />
            <path d="M4 12h16" class="line-mid" />
            <path d="M4 19h16" class="line-bot" />
        </svg></button>

    <nav id="BoutonsNavigation">
        <?php if ($is_home): ?>
            <a id="btnApropos" class="animation Clic-Particule" href="#A_proposRepere">À PROPOS</a>
            <a class="animation Clic-Particule" id="btnProjet" href="#Projet">PROJETS</a>
            <a class="animation Clic-Particule" id="btnContact" href="#Contact">CONTACT</a>
            <a class="animation Clic-Particule" href="/Client/">ESPACE CLIENT</a>
        <?php else: ?>
            <a class="animation Clic-Particule" href="/">ACCUEIL</a>
            <a class="animation Clic-Particule" href="/Articles/Recherche">RECHERCHER</a>
            <a class="animation Clic-Particule" href="/#Contact">CONTACT</a>
            <a class="animation Clic-Particule" href="/Client/">ESPACE CLIENT</a>
        <?php endif; ?>
    </nav>
</header>
<?php if ($is_home): ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const navLinks = document.querySelectorAll("#BoutonsNavigation a[href^='#']"); let isScrollingToSection = !1; const observerOptions = { root: null, rootMargin: "-20% 0px -50% 0px", threshold: 0.1 }; const observer = new IntersectionObserver((entries) => { if (isScrollingToSection) return; entries.forEach(entry => { if (entry.isIntersecting) { const targetId = entry.target.getAttribute('id'); navLinks.forEach(link => { link.classList.remove('active'); if (link.getAttribute('href') === `#${targetId}`) { link.classList.add('active') } }) } }) }, observerOptions); navLinks.forEach(link => {
            const href = link.getAttribute('href'); const targetSection = document.querySelector(href); if (targetSection) { observer.observe(targetSection) }
            link.addEventListener('click', (e) => { isScrollingToSection = !0; navLinks.forEach(l => l.classList.remove('active')); link.classList.add('active'); setTimeout(() => { isScrollingToSection = !1 }, 800) })
        }); window.addEventListener('scroll', () => {
            if (isScrollingToSection) return; const scrollPosition = window.scrollY; const documentHeight = document.documentElement.scrollHeight - window.innerHeight; if (scrollPosition < 50) { navLinks.forEach(link => link.link.classList.remove('active')) }
            if (scrollPosition >= documentHeight - 50) { navLinks.forEach(link => link.classList.remove('active')) }
        })
    })
</script>
<?php endif; ?>
<div id="" style="height: 100px;"></div>