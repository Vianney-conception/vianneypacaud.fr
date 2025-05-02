<header>
  <div class="logo-container">
    <a href="/Accueil/">
      <img class="img-btn" src="../img/LogoN&B.svg" alt="Logo Vianney Pacaud">
    </a>
    <p class="TitreLogo">Vianney Pacaud</p>
  </div>
  <nav class="btn-container">
    <a class="btn" href="/Accueil/">Accueil</a>
    <a class="btn" href="/Services/">Services</a>
    <a class="btn" href="/Contact/">Contact</a>
  </nav>
  <nav class="btn-Menu" id="menuToggle">
  
  <svg class="icon menu-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
  </svg>
  <svg class="icon close-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
    <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
  </svg>
</nav>
</header>
<div class="mobile-menu" id="mobileMenu">
  <a class="btn" href="/Accueil/">Accueil</a>
  <a class="btn" href="/Services/">Services</a>
  <a class="btn" href="/Contact/">Contact</a>
</div>
<script>
  const menuBtn = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');

  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('active');
    menuBtn.classList.toggle('open'); 
  });

const currentPath = window.location.pathname.split('/')[1].toLowerCase();
const links = document.querySelectorAll('.btn-container .btn, .mobile-menu .btn');

links.forEach(link => {
    const linkText = link.textContent.trim().toLowerCase();
    if (linkText === currentPath) {
        link.classList.add('pageActuel');
    }
});
</script>

