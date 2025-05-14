function toggleMenu() {
    const links = document.getElementById('navbar-links');
    const toggleButtonContainer = document.querySelector('.navbar-toggle');
    const menuOverlay = document.getElementById('menu-overlay');

    links.classList.toggle('show');

    if (menuOverlay) {
        menuOverlay.classList.toggle('active');
    }

    if (toggleButtonContainer) {
        if (links.classList.contains('show')) {
            toggleButtonContainer.classList.add('hidden-toggle');
        } else {
            toggleButtonContainer.classList.remove('hidden-toggle');
        }
    }

    if (links.classList.contains('show')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

document.addEventListener('click', function (event) {
    const links = document.getElementById('navbar-links');
    const toggleButton = document.querySelector('.navbar-button');
    const toggleButtonContainer = document.querySelector('.navbar-toggle');
    const closeButton = document.querySelector('.close-button');
    const menuOverlay = document.getElementById('menu-overlay');

    let isClickInsideMenu = links && links.contains(event.target);
    let isClickOnToggleButton = toggleButton && toggleButton.contains(event.target);
    let isClickOnCloseButton = closeButton && closeButton.contains(event.target);
    let isClickOnOverlay = menuOverlay && menuOverlay.contains(event.target);

    if ((!isClickInsideMenu && !isClickOnToggleButton && !isClickOnCloseButton && links && links.classList.contains('show')) || isClickOnOverlay) {
        links.classList.remove('show');
        if (toggleButtonContainer) {
            toggleButtonContainer.classList.remove('hidden-toggle');
        }
        if (menuOverlay) {
            menuOverlay.classList.remove('active');
        }
        document.body.style.overflow = '';
    }
});

let lastScrollTop = 0;
const navbar = document.querySelector('.navbar');
const navbarHeight = navbar?.offsetHeight || 0;

window.addEventListener('scroll', function () {
    if (!navbar) return;

    let currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const links = document.getElementById('navbar-links');
    const toggleButtonContainer = document.querySelector('.navbar-toggle');
    const menuOverlay = document.getElementById('menu-overlay');

    // Close menu on scroll
    if (links && links.classList.contains('show')) {
        links.classList.remove('show');
        if (toggleButtonContainer) {
            toggleButtonContainer.classList.remove('hidden-toggle');
        }
        if (menuOverlay) {
            menuOverlay.classList.remove('active');
        }
        document.body.style.overflow = '';
    }

    // Hide/show navbar on scroll
    if (currentScrollTop > lastScrollTop && currentScrollTop > navbarHeight) {
        navbar.classList.add('hidden');
    } else {
        navbar.classList.remove('hidden');
    }
    lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
}, false);

// Add animation effect to hamburger icon
const navbarButton = document.querySelector('.navbar-button');
if (navbarButton) {
    navbarButton.addEventListener('mouseover', function () {
        const spans = this.querySelectorAll('.hamburger-icon span');
        spans.forEach((span, index) => {
            span.style.transition = `transform 0.3s ease ${index * 0.05}s`;
            span.style.transform = 'scaleX(0.8)';
        });
    });

    navbarButton.addEventListener('mouseout', function () {
        const spans = this.querySelectorAll('.hamburger-icon span');
        spans.forEach(span => {
            span.style.transform = '';
        });
    });
}