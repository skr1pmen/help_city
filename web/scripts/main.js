document.querySelector('nav').addEventListener('mousemove', () => {
    document.querySelector('main').classList.remove('deactivate');
})
document.querySelector('nav').addEventListener('mouseout', () => {
    document.querySelector('main').classList.add('deactivate');
})