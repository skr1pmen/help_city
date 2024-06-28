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
    }
}

function switchTheme(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
}

toggleTheme.addEventListener('change', switchTheme, false);

document.querySelector('.btn_edit').addEventListener('click', () => {
    const edit = document.querySelector('.edit');
    edit.style.display = 'block';
    edit.style.position = 'absolute';
});