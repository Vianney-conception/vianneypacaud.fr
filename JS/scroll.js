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
window.addEventListener('resize', handleNavResponsive);

function ActiveAhaeder(id) {
  const allActive = document.querySelectorAll('a.active');
  allActive.forEach(a => {
    a.classList.remove('active');
  });

  const aElement = document.getElementById(id);
  if (aElement) {
    aElement.classList.add('active');
}
}
function listNavTargetIds() {
  const navLinks = document.querySelectorAll('nav a[href^="#"]');
  const targetIds = [];
  navLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href.startsWith('#')) targetIds.push(href.substring(1));
  });
  return targetIds;
}
function getVisibleElementIds() {
  const allElements = document.querySelectorAll('[id]');
  const visibleIds = [];
  allElements.forEach(el => {
    const rect = el.getBoundingClientRect();
    if (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    ) {
      visibleIds.push(el.id);
    }
  });
  return visibleIds;
}
function ActiveAheader(id) {
  const allActive = document.querySelectorAll('a.active');
  allActive.forEach(a => {
    a.classList.remove('active');
  });

  const aElement = document.getElementById(id);
  if (aElement) {
    aElement.classList.add('active');
  }
}
function updateVisibleTargetIds() {
  const visibleIds = getVisibleElementIds();
  const visibleTargetIds = visibleIds.filter(id => targetIds.includes(id));
  if (visibleTargetIds.length > 0) {
    const visibleSectionId = visibleTargetIds[0];
    const matchingLink = document.querySelector(`nav a[href="#${visibleSectionId}"]`);
    
    if (matchingLink && matchingLink.id) {
      ActiveAheader(matchingLink.id);
    }
  } 
else {
    ActiveAheader('');
  }
}
let targetIds = [];
window.addEventListener('DOMContentLoaded', () => {
  targetIds = listNavTargetIds();
  updateVisibleTargetIds();
});
window.addEventListener('scroll', updateVisibleTargetIds);
window.addEventListener('resize', updateVisibleTargetIds);