/** funcion para ejecutar las demas funciones cuando se
 * cargue el DOM el HTML para evitar problemas de carga **/
document.addEventListener('DOMContentLoaded', () => {

    darkmode();
    activarUser() ? insertAdmin() : insertCliente();
    slidebar();
    
}); // Fin loadDOM

/* Agrega el icono que despliega el menu de opciones del administrador */
function slidebar() {
    const menu = document.querySelector('.menu');
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    const footer = document.getElementById('footer');

    // Obtener el estado del menú desde localStorage (si existe)
    let menuActivo = localStorage.getItem('menuActivo') === 'true';

    // Aplicar el estado inicial
    if (menuActivo) {
        sidebar.classList.add('menu-toggle');
        menu.classList.add('menu-toggle');
        main.classList.add('menu-toggle');
        footer.classList.add('menu-toggle');
    }

    menu.addEventListener('click', () => {
        menuActivo = !menuActivo; // Invertir el estado

        if (menuActivo) {
            sidebar.classList.add('menu-toggle');
            menu.classList.add('menu-toggle');
            main.classList.add('menu-toggle');
            footer.classList.add('menu-toggle');
        } else {
            sidebar.classList.remove('menu-toggle');
            menu.classList.remove('menu-toggle');
            main.classList.remove('menu-toggle');
            footer.classList.remove('menu-toggle');
        }

        // Guardar el estado en localStorage
        localStorage.setItem('menuActivo', menuActivo);
    });
} // Fin slidebar()

function insertAdmin() {

    //Cambiar el enlace del logo
    const btnHome = document.querySelector('.enlace-logo');
    btnHome.href = "/admin";
    // variables para seleccionar contenedores principales
    var contenedor_derecho = document.querySelector('.contenido-derecha'); // contenedor derecha del menu superior
    var btnDarkMode = document.querySelector('.btnDarkMode'); // boton del darkmode

    /** INICIO BOTON MENU **/
    // seleccionar el contenedor del boton del menu desplegable y añadirlo
    const contenedor_btnMenu_desplegable = document.querySelector('.nav-admin');
    const btnMenu = document.createElement('DIV');
    btnMenu.classList.add('menu');
    btnMenu.id = 'menu';

    // Crear el diseño del boton del menu desplegable
    for (let i = 0; i < 3; i++) {
        const contenido_btnMenu = document.createElement('DIV');
        btnMenu.appendChild(contenido_btnMenu);
    }
    contenedor_btnMenu_desplegable.appendChild(btnMenu);
    /** FIN BOTON MENU **/

    /** INICIO BARRA BUSCADORA **/
    // Contenedor de todos los elementos de la barra buscadora
    const contenedor_barra_buscadora = document.createElement('DIV');
    contenedor_barra_buscadora.classList.add('buscador');

    // contenedor para la imagen
    const contenedor_img_lupa = document.createElement('DIV');
    contenedor_img_lupa.classList.add('icono-lupa');
    contenedor_img_lupa.classList.add('icono-principal-inverso');

    // Imagen del buscador
    const img_buscador = document.createElement('IMG');
    img_buscador.src = "/build/img/icons/buscar.png";

    // Input para insertar la busqueda
    const input_buscador = document.createElement('INPUT');
    input_buscador.type = "search";
    input_buscador.placeholder = "Buscar algún producto";
    input_buscador.classList.add('barra');

    // Insertar la imagen a su contenedor
    contenedor_img_lupa.appendChild(img_buscador);

    // Insertar la imagen de la lupa y el input
    contenedor_barra_buscadora.appendChild(contenedor_img_lupa);
    contenedor_barra_buscadora.appendChild(input_buscador);

    // Insertar la barra buscadora al contenedor derecho del menu superior y antes del boton darkmode
    contenedor_derecho.appendChild(contenedor_barra_buscadora);
    contenedor_derecho.insertBefore(contenedor_barra_buscadora, btnDarkMode);
    /** FIN BARRA BUSCADORA **/

    /** INICIO IMAGEN PERFIL (luego se hara con php)**/
    const perfil = document.createElement('IMG');
    perfil.src = '/build/img/usuario-default.png'
    perfil.classList.add('usuario');
    perfil.alt = 'Foto user';
    // añadir la foto al menu superior derecho
    contenedor_derecho.appendChild(perfil);
    /** FIN IMAGEN PERFIL **/

} // Fin insertAdmin()

function insertCliente() {

    var btnDarkMode = document.querySelector('.btnDarkMode'); // boton del darkmode
    var contenedor_derecho = document.querySelector('.contenido-derecha');
    //Verificar si no estamos en el login:
    const login = document.getElementById('main');

    if (!login.classList.contains('main-login')) {

        // Crear el enlace hacia el login 
        const btn_sesion = document.createElement('A');
        btn_sesion.classList.add('boton');
        btn_sesion.classList.add('boton-verde');
        btn_sesion.classList.add('btn-inicio');
        btn_sesion.textContent = 'Iniciar Sesión';
        btn_sesion.href = "login.php";

        // añadirlo al menu superior derecho
        contenedor_derecho.appendChild(btn_sesion);
    } // fin if 'main-login'

    /** BOTON LISTA PRODUCTOS **/
    // Imagen del boton
    const img_lista = document.createElement('IMG');
    img_lista.src = "/build/img/icons/lista.png";
    img_lista.alt = "boton lista";
    img_lista.classList.add('icono-principal-inverso');

    // Enlace del boton
    const btn_lista = document.createElement('A');
    btn_lista.classList.add('btn-lista');
    btn_lista.appendChild(img_lista);

    // Insertar el boton lista
    contenedor_derecho.appendChild(btn_lista); // al contenedor derecho del menu superior
    contenedor_derecho.insertBefore(btn_lista, btnDarkMode); // antes del boton darkmode
    /** FIN BOTON LISTA PRODUCTOS**/
} // Fin inserCLiente()

/* Determina que funcion se va a ejecutar 
    true: admin, false: cliente
*/
function activarUser() {
    const header = document.querySelector('.header');

    // si la clase inicio-usuario esta presente en el index user no activar el panel admin
    if (header.classList.contains('inicio-usuario')) {
        return false;
    }
    // sino activarlo
    return true;

} // Fin activarAdmin()

// Activa el modo segun las preferencias del sistema y tambien segun la opcion que se seleccione
function darkmode() {
    // Obtener la preferencias del tema del navegador
    const preferencia = window.matchMedia('(prefers-color-scheme: dark)');
    const btnDarkMode = document.querySelector('.btnDarkMode');
    const icon = document.querySelector('.moon');

    // Obtener el estado del modo oscuro desde localStorage (si existe)
    let darkModeActivo = localStorage.getItem('darkModeActivo') === 'true';

    // Aplicar el estado inicial
    if (darkModeActivo) {
        document.body.classList.add('dark-mode');
        icon.src = "/build/img/icons/sun.png";
    } else {
        document.body.classList.remove('dark-mode');
        icon.src = "/build/img/icons/moon.png";
    }

    preferencia.addEventListener('change', function () {
        if (preferencia.matches) {
            document.body.classList.add('dark-mode');
            icon.src = "/build/img/icons/sun.png";
            darkModeActivo = true;
        } else {
            document.body.classList.remove('dark-mode');
            icon.src = "/build/img/icons/moon.png";
            darkModeActivo = false;
        }
        localStorage.setItem('darkModeActivo', darkModeActivo);
    });

    btnDarkMode.addEventListener('click', () => {
        darkModeActivo = !darkModeActivo; // Invertir el estado

        if (darkModeActivo) {
            document.body.classList.add('dark-mode');
            icon.src = "/build/img/icons/sun.png";
        } else {
            document.body.classList.remove('dark-mode');
            icon.src = "/build/img/icons/moon.png";
        }

        // Guardar el estado en localStorage
        localStorage.setItem('darkModeActivo', darkModeActivo);
    });
} // Fin darkmode()