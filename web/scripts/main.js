document.querySelector('nav').addEventListener('mousemove', () => {
    document.querySelector('main').classList.remove('deactivate');
})
document.querySelector('nav').addEventListener('mouseout', () => {
    document.querySelector('main').classList.add('deactivate');
})

// Смена темы сайта
const toggleTheme = document.querySelector('#theme');
const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;

if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);
    document.querySelector('.btn__theme').classList.add('fa-sun');
    document.querySelector('.btn__theme').classList.remove('fa-moon');

    if (currentTheme === 'dark') {
        toggleTheme.checked = true;
        document.querySelector('.btn__theme').classList.remove('fa-sun');
        document.querySelector('.btn__theme').classList.add('fa-moon');
    }
}

function switchTheme(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        document.querySelector('.btn__theme').classList.remove('fa-sun');
        document.querySelector('.btn__theme').classList.add('fa-moon');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
        document.querySelector('.btn__theme').classList.remove('fa-moon');
        document.querySelector('.btn__theme').classList.add('fa-sun');
    }
}

toggleTheme.addEventListener('change', switchTheme, false);


try {
    document.querySelector('.btn_verification').addEventListener('click', () => {
        document.querySelector('.btn_verification').remove();
        document.querySelector('.form_deactivate').classList.remove('form_deactivate');
    })
} catch (e) {
    console.log(e)
}

let swiper = new Swiper(".mySwiper", {
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});