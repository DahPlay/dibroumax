function toggleMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenu.classList.toggle('active');
    document.querySelectorAll('.menu-bar').forEach(item => {
        item.classList.contains('menu-active') ? item.classList.remove('menu-active') : item.classList.add('menu-active')
    })
    document.querySelector('.menu').classList.toggle('menu-active')
}