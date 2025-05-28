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


<div class="btn-ModeSombre on">
  <div class="btn-mode" onclick="changemodeClair()" id="btn-ModeClaire"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M440-800v-120h80v120h-80Zm0 760v-120h80v120h-80Zm360-400v-80h120v80H800Zm-760 0v-80h120v80H40Zm708-252-56-56 70-72 58 58-72 70ZM198-140l-58-58 72-70 56 56-70 72Zm564 0-70-72 56-56 72 70-58 58ZM212-692l-72-70 58-58 70 72-56 56Zm268 452q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q67 0 113.5-46.5T640-480q0-67-46.5-113.5T480-640q-67 0-113.5 46.5T320-480q0 67 46.5 113.5T480-320Zm0-160Z"/></svg></div>
  <div class="btn-mode" onclick="changemodeSombre()" id="btn-ModeSombre"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M484-80q-84 0-157.5-32t-128-86.5Q144-253 112-326.5T80-484q0-146 93-257.5T410-880q-18 99 11 193.5T521-521q71 71 165.5 100T880-410q-26 144-138 237T484-80Zm0-80q88 0 163-44t118-121q-86-8-163-43.5T464-465q-61-61-97-138t-43-163q-77 43-120.5 118.5T160-484q0 135 94.5 229.5T484-160Zm-20-305Z"/></svg></div>
  <div class="btn-mode modeChoisie" onclick="changemodeAuto()" id="btn-ModeAuto"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M396-396q-32-32-58.5-67T289-537q-5 14-6.5 28.5T281-480q0 83 58 141t141 58q14 0 28.5-2t28.5-6q-39-22-74-48.5T396-396Zm57-56q51 51 114 87.5T702-308q-40 51-98 79.5T481-200q-117 0-198.5-81.5T201-480q0-65 28.5-123t79.5-98q20 72 56.5 135T453-452Zm290 72q-20-5-39.5-11T665-405q8-18 11.5-36.5T680-480q0-83-58.5-141.5T480-680q-20 0-38.5 3.5T405-665q-8-19-13.5-38T381-742q24-9 49-13.5t51-4.5q117 0 198.5 81.5T761-480q0 26-4.5 51T743-380ZM440-840v-120h80v120h-80Zm0 840v-120h80V0h-80Zm323-706-57-57 85-84 57 56-85 85ZM169-113l-57-56 85-85 57 57-85 84Zm671-327v-80h120v80H840ZM0-440v-80h120v80H0Zm791 328-85-85 57-57 84 85-56 57ZM197-706l-84-85 56-57 85 85-57 57Zm199 310Z"/></svg></div>
</div>


<div style="height: 190px;"></div>


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

const darkModeCookie = document.cookie.split('; ').find(row => row.startsWith('modeSombre='));
if (darkModeCookie && darkModeCookie.split('=')[1] === 'false') {
  const logoImg = document.querySelector('.logo-container .img-btn');
  if (logoImg) {
    logoImg.src = '../img/LogoCouleur.svg';
    logoImg.alt = 'Logo Vianney Pacaud Couleur';
  }
}
</script>

