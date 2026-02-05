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

// FAQ Accordion Toggle
const faqs = document.querySelectorAll('#faq details');

faqs.forEach((detail) => {
    detail.addEventListener('toggle', () => {
        if (detail.open) {
            document.querySelectorAll('#faq details').forEach((other) => {
                if (other !== detail) other.removeAttribute('open');
            });
        }
    });
});

// Select Input Customization
const projectSelect = document.getElementById('tipo-progetto');
if (projectSelect) {
    projectSelect.addEventListener('change', function () {
        if (this.value !== "") {
            this.classList.remove('text-text-lighter');
            this.classList.add('text-text');
        } else {
            this.classList.add('text-text-lighter');
            this.classList.remove('text-text');
        }
    });
}

// Toast Notification
const toast = document.getElementById('toast');
const toastIcon = document.getElementById('toast-icon');
const toastMessage = document.getElementById('toast-message');
let toastTimeout;

function showToast(message, type = 'error') {
    if (type === 'error') {
        toast.className = "fixed top-6 left-1/2 -translate-x-1/2 z-[60] flex items-center gap-3 px-6 py-3 rounded-full shadow-focus transition-all duration-500 ease-out transform bg-red-100 text-red-800 border border-red-200";
        toastIcon.innerHTML = `<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>`;
    } else {
        // Successo / Info
        toast.className = "fixed top-6 left-1/2 -translate-x-1/2 z-[60] flex items-center gap-3 px-6 py-3 rounded-full shadow-focus transition-all duration-500 ease-out transform bg-accent-light text-text border border-accent";
        toastIcon.innerHTML = `<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
    }
    toastMessage.textContent = message;
    toast.classList.remove('-translate-y-[150%]', 'opacity-0', 'pointer-events-none');
    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        hideToast();
    }, 4000);
}
function hideToast() {
    toast.classList.add('-translate-y-[150%]', 'opacity-0', 'pointer-events-none');
}

// Pageclip Form Submission Handling
const form = document.getElementById('form-contact');
const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
const PAGECLIP_URL = "https://send.pageclip.co/4UlRtxpQf2xCHlJ1Vy6ZAgDSoYa1bkst/contatti";

if (form && submitBtn) {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!form.checkValidity()) {
            e.stopPropagation();
            form.reportValidity();
            return;
        }
        const formData = new FormData(form);
        const messaggio = formData.get('messaggio');
        if (messaggio.trim().length < 10) {
            showToast("Il messaggio è troppo breve. Scrivi almeno 10 caratteri.", "error");
            return;
        }
        if (formData.get('_gotcha')) {
            console.log("Spam intercettato");
            return;
        }
        submitBtn.disabled = true;
        const data = {
            nome: formData.get('nome'),
            email: formData.get('email'),
            tipoProgetto: formData.get('tipo-progetto'),
            messaggio: formData.get('messaggio')
        };
        try {
            const response = await fetch(PAGECLIP_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-REQ-METHOD": "form-v1"
                },
                body: JSON.stringify(data)
            });
            if (response.ok) {
                form.reset();
                showToast("Messaggio inviato con successo!", "success");
            }
        } catch (error) {
            throw new Error("Errore durante l'invio del modulo: " + error.message);
        } finally {
            submitBtn.disabled = false;
        }
    });
}