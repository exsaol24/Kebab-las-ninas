function toggleMenu() {
    const links = document.getElementById('navbar-links');
    const toggleButtonContainer = document.querySelector('.navbar-toggle'); 

    links.classList.toggle('show');

    if (toggleButtonContainer) {
        if (links.classList.contains('show')) {
            toggleButtonContainer.classList.add('hidden-toggle');
        } else {
            toggleButtonContainer.classList.remove('hidden-toggle');
        }
    }
}

document.addEventListener('click', function (event) {
    const links = document.getElementById('navbar-links');
    const toggleButton = document.querySelector('.navbar-button');
    const toggleButtonContainer = document.querySelector('.navbar-toggle');
    const closeButton = document.querySelector('.close-button');

    let isClickInsideMenu = links && links.contains(event.target);
    let isClickOnToggleButton = toggleButton && toggleButton.contains(event.target);
    let isClickOnCloseButton = closeButton && closeButton.contains(event.target);

    if (!isClickInsideMenu && !isClickOnToggleButton && !isClickOnCloseButton && links && links.classList.contains('show')) {
        links.classList.remove('show');
        if (toggleButtonContainer) {
            toggleButtonContainer.classList.remove('hidden-toggle');
        }
    }
});

let lastScrollTop = 0;
const navbar = document.querySelector('.navbar');
const navbarHeight = navbar.offsetHeight;

window.addEventListener('scroll', function () {
    let currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const links = document.getElementById('navbar-links');
    const toggleButtonContainer = document.querySelector('.navbar-toggle');

    if (links && links.classList.contains('show')) {
        links.classList.remove('show');
        if (toggleButtonContainer) {
            toggleButtonContainer.classList.remove('hidden-toggle');
        }
    }

    if (currentScrollTop > lastScrollTop && currentScrollTop > navbarHeight) {
        navbar.classList.add('hidden');
    } else {
        navbar.classList.remove('hidden');
    }
    lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
}, false);
