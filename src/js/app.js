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
    overlay.setAttribute('aria-hidden', 'false');
    menuToggle.setAttribute('aria-expanded', 'true');
    nav.classList.remove('bg-nav/20', 'backdrop-blur-sm');
    document.body.classList.add('overflow-hidden');
    activeFocus();
}
function closeMenu() {
    mobileMenu.classList.add('translate-x-full');
    overlay.classList.add('opacity-0', 'pointer-events-none');
    overlay.setAttribute('aria-hidden', 'true');
    menuToggle.setAttribute('aria-expanded', 'false');
    nav.classList.add('bg-nav/20', 'backdrop-blur-sm');
    document.body.classList.remove('overflow-hidden');
    deactiveFocus();
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

//Window Resize - Close Mobile Menu
const mobileBreakpoint = 768;
let isMobile = window.innerWidth < mobileBreakpoint;

window.addEventListener('resize', () => {
    const nowMobile = window.innerWidth < mobileBreakpoint;
    if (isMobile && !nowMobile) {
        closeMenu();
    }
    isMobile = nowMobile;
});

// Mobile Menu Focus
const focusableSelectors = 'a, button';
let firstEl = null;
let lastEl = null;

function trapFocus(e) {
    if (e.key !== 'Tab') return;
    if (e.shiftKey) {
        if (document.activeElement === firstEl) {
            e.preventDefault();
            lastEl.focus();
        }
    } else {
        if (document.activeElement === lastEl) {
            e.preventDefault();
            firstEl.focus();
        }
    }
}
function activeFocus() {
    const focusableEl = mobileMenu.querySelectorAll(focusableSelectors);
    if (!focusableEl.length) return;
    firstEl = focusableEl[0];
    lastEl = focusableEl[focusableEl.length - 1];
    mobileMenu.addEventListener('keydown', trapFocus);
    firstEl.focus();
}
function deactiveFocus() {
    mobileMenu.removeEventListener('keydown', trapFocus);
    menuToggle.focus();
}

// Swipe Gesture for Mobile Menu
let startX = 0;
let currentX = 0;

mobileMenu.addEventListener('touchstart', e => {
    startX = e.touches[0].clientX;
});
mobileMenu.addEventListener('touchmove', e => {
    currentX = e.touches[0].clientX;
});
mobileMenu.addEventListener('touchend', () => {
    const deltaX = currentX - startX;
    if (deltaX > 50) {
        closeMenu();
    } else if (deltaX < -50) {
        openMenu();
    }
});

// Set Current Year in Footer
const yearSpan = document.getElementById('year');
const currentYear = new Date().getFullYear();
if (yearSpan) yearSpan.textContent = currentYear;

// Smooth Scroll for Anchor Links
const anchorLinks = document.querySelectorAll('a[href^="#"]');

function smoothScroll(target) {
    const targetId = target.getAttribute('href').substring(1);
    const targetEl = document.getElementById(targetId);
    if (targetEl) {
        targetEl.scrollIntoView({ behavior: 'smooth' });
        window.history.pushState(null, null, `#${targetId}`);
    }
}
anchorLinks.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        smoothScroll(link);
    });
});