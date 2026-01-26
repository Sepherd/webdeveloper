// Mobile Menu Toggle

const menuToggle = document.getElementById('menu-toggle');
const menuClose = document.getElementById('menu-close');
const mobileMenu = document.getElementById('mobile-menu');

function menuAriaToggle() {
    const isExpanded = menuClose.getAttribute('aria-expanded') === 'true';
    menuClose.setAttribute('aria-expanded', !isExpanded);
    menuToggle.setAttribute('aria-expanded', !isExpanded);
}

menuToggle.addEventListener('click', () => {
    mobileMenu.classList.remove('hidden');
    menuAriaToggle();

});

menuClose.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
    menuAriaToggle();
});