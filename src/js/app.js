//funcion para ejecutar las demas funciones cuando se cargue el DOM
document.addEventListener('DOMContentLoaded', function () {
    //Funciones
    slidebar();
    darkmode();
})

//CODE

function slidebar() {
    const menu = document.getElementById('menu');
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    const footer = document.getElementById('footer');

    menu.addEventListener('click', () => {
        sidebar.classList.toggle('menu-toggle');
        menu.classList.toggle('menu-toggle');
        main.classList.toggle('menu-toggle');
        footer.classList.toggle('menu-toggle');
    });
}

function darkmode() {
    const preferencia = window.matchMedia('(prefers-color-scheme: dark)');
    const btnDarkMode = document.querySelector('.btnDarkMode');

    if (preferencia.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    preferencia.addEventListener('change', function () {
        if (preferencia.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    })



    btnDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    });
}