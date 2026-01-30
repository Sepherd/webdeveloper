// Mobile Menu Toggle

const menuToggle = document.getElementById('menu-toggle');
const menuClose = document.getElementById('menu-close');
const mobileMenu = document.getElementById('mobile-menu');
const overlay = document.getElementById('overlay');
const navLinks = mobileMenu.querySelectorAll('a');
const nav = document.querySelector('nav');
const logo = document.getElementById('logo');

function openMenu() {
    mobileMenu.classList.remove('translate-x-full');
    overlay.classList.remove('opacity-0', 'pointer-events-none');
    menuToggle.setAttribute('aria-expanded', 'true');
    menuClose.setAttribute('aria-expanded', 'true');
    nav.classList.remove('bg-nav/20', 'backdrop-blur-sm');
    document.body.classList.add('overflow-hidden');
}

function closeMenu() {
    mobileMenu.classList.add('translate-x-full');
    overlay.classList.add('opacity-0', 'pointer-events-none');
    menuToggle.setAttribute('aria-expanded', 'false');
    menuClose.setAttribute('aria-expanded', 'false');
    nav.classList.add('bg-nav/20', 'backdrop-blur-sm');
    document.body.classList.remove('overflow-hidden');
}

menuToggle.addEventListener('click', openMenu);
menuClose.addEventListener('click', closeMenu);
overlay.addEventListener('click', closeMenu);
logo.addEventListener('click', closeMenu);
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
});
navLinks.forEach(link => {
    link.addEventListener('click', closeMenu);
});

let startX = 0;
let currentX = 0;

mobileMenu.addEventListener('touchstart', e => {
    startX = e.touches[0].clientX;
});

mobileMenu.addEventListener('touchmove', e => {
    currentX = e.touches[0].clientX;
});

mobileMenu.addEventListener('touchend', () => {
    if (startX - currentX > 50) {
        closeMenu();
    }
});

// Set Current Year in Footer
const yearSpan = document.getElementById('year');
const currentYear = new Date().getFullYear();
if (yearSpan) yearSpan.textContent = currentYear;