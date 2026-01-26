// Mobile Menu Toggle

const menuToggle = document.getElementById('menu-toggle');
const menuClose = document.getElementById('menu-close');
const mobileMenu = document.getElementById('mobile-menu');
const overlay = document.getElementById('overlay');

function menuAriaToggle() {
    const isExpanded = menuClose.getAttribute('aria-expanded') === 'true';
    menuClose.setAttribute('aria-expanded', !isExpanded);
    menuToggle.setAttribute('aria-expanded', !isExpanded);
}

function hideMobileMenu() {
    mobileMenu.classList.add('hidden');
    overlay.classList.add('hidden');
    menuAriaToggle();
}

menuToggle.addEventListener('pointerdown', () => {
    mobileMenu.classList.remove('hidden');
    overlay.classList.remove('hidden');
    menuAriaToggle();

});

menuClose.addEventListener('pointerdown', () => {
    hideMobileMenu();
});

overlay.addEventListener('pointerdown', (event) => {
    hideMobileMenu();
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
        hideMobileMenu();
    }
});