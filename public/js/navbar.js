function toggleMenu() {
    const links = document.getElementById('navbar-links');
    links.classList.toggle('show');
}

document.addEventListener('click', function (event) {
    const links = document.getElementById('navbar-links');
    const toggleButton = document.querySelector('.navbar-button');
    if (!links.contains(event.target) && !toggleButton.contains(event.target)) {
        links.classList.remove('show');
    }
});
