/** funcion para ejecutar las demas funciones cuando se
 * cargue el DOM el HTML para evitar problemas de carga **/
document.addEventListener('DOMContentLoaded', () => {

    activarUser() ? insertAdmin() : insertCliente(); // verificar si estamos en la interfaz de cliente o de administrador

    // mantener la posicion en la pagina de creacion de listas (para el PDF)
    window.location.pathname.includes('lista.php') ? guardarPosicion() : window.scrollTo(0, 0);

    obtenerDatosUsuario(); // funcion para obtener los datos al iniciar la sesion (como la foto, nombre, etc)

    // filtrar datos mediante la barra de busqueda con fetch
    const campoBuscar = document.getElementById('campo-buscar');
    obtenerDatos();
    campoBuscar.addEventListener('input', obtenerDatos);

    // const listaProducto = document.getElementById('buscar-producto');
    // busquedaProductos();
    // listaProducto.addEventListener('keyup', busquedaProductos);

}); // Fin loadDOM

function insertAdmin() {

    //Cambiar el enlace del logo
    const btnHome = document.querySelector('.enlace-logo');
    btnHome.href = "/admin";

    // variables para seleccionar contenedores principales
    var contenedor_derecho = document.querySelector('.contenido-derecha'); // contenedor derecha del menu superi
    const boton_ayuda = document.querySelector('.btn-Ayuda');

    /** BOTON REPORTES **/

    const img_pdf = document.createElement('IMG');
    img_pdf.src = '/build/img/icons/pdf.png';

    const textbtn = document.createElement('SPAN');
    textbtn.textContent = "Generar Reporte";

    const btn_reporte = document.createElement('A');
    btn_reporte.classList.add('boton-verde');
    btn_reporte.classList.add('btn-pdf');
    btn_reporte.classList.add('btn-admin');
    btn_reporte.href = '/admin/reportes.php';

    btn_reporte.appendChild(img_pdf);
    btn_reporte.appendChild(textbtn);

    contenedor_derecho.appendChild(btn_reporte);
    contenedor_derecho.insertBefore(btn_reporte, boton_ayuda);

    /** FIN BOTON REPORTES **/

    /** INICIO PERFIL**/
    const contenedor_perfil = document.createElement('DIV');
    contenedor_perfil.classList.add('perfil');

    const img_perfil = document.createElement('IMG');
    img_perfil.classList.add('usuario');
    img_perfil.alt = 'Foto user';

    const nombre_usuario = document.createElement('SPAN');
    nombre_usuario.classList.add('usuario-nombre');
    // añadir la foto al menu superior derecho
    contenedor_perfil.appendChild(nombre_usuario);
    contenedor_perfil.appendChild(img_perfil);

    contenedor_derecho.appendChild(contenedor_perfil);
    /** FIN PERFIL **/


} // Fin insertAdmin()

function insertCliente() {

    var contenedor_derecho = document.querySelector('.contenido-derecha');
    const boton_ayuda = document.querySelector('.btn-Ayuda');

    /** HEADER **/
    /** BOTON LISTA PRODUCTOS **/
    // Imagen del boton
    const img_lista = document.createElement('IMG');
    img_lista.src = "/build/img/icons/lista.png";
    img_lista.alt = "boton lista";
    img_lista.classList.add('icono-principal-inverso');

    // texto del boton
    const texto_lista = document.createElement('SPAN');
    texto_lista.textContent = "Lista de productos";

    // Enlace del boton
    const btn_lista = document.createElement('A');
    btn_lista.href = "lista.php";
    btn_lista.classList.add('btn-lista');
    btn_lista.appendChild(texto_lista);
    btn_lista.appendChild(img_lista);

    // Insertar el boton lista
    contenedor_derecho.appendChild(btn_lista); // al contenedor derecho del menu superior
    contenedor_derecho.insertBefore(btn_lista, boton_ayuda); // antes del boton darkmode

    /** FIN BOTON LISTA PRODUCTOS**/

    /** BOTON SOBRE NOSOTROS **/
    // texto del boton
    const texto_nosotros = document.createElement('SPAN');
    texto_nosotros.textContent = "Sobre nosotros";

    // Enlace del boton
    const btn_nosotros = document.createElement('A');
    btn_nosotros.classList.add('btn-nosotros');
    btn_nosotros.href = "nosotros.php";
    btn_nosotros.appendChild(texto_nosotros);
    contenedor_derecho.appendChild(btn_nosotros); // al contenedor derecho del menu superior
    contenedor_derecho.insertBefore(btn_nosotros, boton_ayuda); // despues del boton de lista

    /** FIN BOTON SOBRE NOSOTROS **/
    //Verificar si no estamos en el login:
    const login = document.getElementById('main');
    if (!login.classList.contains('main-login')) {

        // Crear el enlace hacia el login 
        const btn_sesion = document.createElement('A');
        btn_sesion.classList.add('boton');
        btn_sesion.classList.add('boton-verde');
        btn_sesion.classList.add('btn-inicio');
        // btn_sesion.classList.add('desactivado'); // agregando la clase desactivado en el boton desaparece
        btn_sesion.textContent = 'Iniciar Sesión';
        btn_sesion.href = "login.php";

        // añadirlo al menu superior derecho
        contenedor_derecho.appendChild(btn_sesion);
    } // fin if 'main-login'

    /** FOOTER **/
    const contenedor_footer = document.querySelector('.navegacion-footer');
    const nav2 = contenedor_derecho.cloneNode(true);

    // Seleccionar los dos últimos elementos <a> en el clon
    const elementosAEliminar = nav2.querySelectorAll('a');
    const ultimoElemento = elementosAEliminar[elementosAEliminar.length - 1];

    if (!login.classList.contains('main-login')) {
        ultimoElemento.remove();
    }
    // // Eliminar los elementos del clon
    contenedor_footer.appendChild(nav2);

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


function guardarPosicion() {
    // JavaScript
    window.addEventListener('beforeunload', () => {
        // Guarda la posición actual de scroll vertical
        sessionStorage.setItem('scrollpos', window.scrollY);
    });

    window.addEventListener('load', () => {
        // Recupera la posición guardada
        const scrollpos = sessionStorage.getItem('scrollpos');
        if (scrollpos) {
            // Desplaza la ventana a esa posición
            window.scrollTo(0, parseInt(scrollpos));
            // Opcional: Elimina el valor para que no afecte futuras cargas sin recarga
            sessionStorage.removeItem('scrollpos');
        }
    });
} // Fin guardarPosicion()

/** USAR AJAX PARA OBTENER LA IMAGEN DEL ADMINISTRADOR **/
// function obtenerFotoAdmin() {

//     fetch('login.php')
//         .then(response => response.json())
//         .then(data => {
//             const nombre = data.nombre;
//             const foto = data.imagen;
//             const estado = data.login;

//             if (estado) {
//                 const contenedor_derecho = document.querySelector('.contenido-derecha'); // contenedor derecha del menu superior

//                 /** INICIO IMAGEN PERFIL (luego se hara con php)**/
//                 const perfil = document.createElement('IMG');
//                 perfil.src = '/fotos-perfil/' + foto;
//                 perfil.classList.add('usuario');
//                 perfil.alt = 'Foto user';
//                 // añadir la foto al menu superior derecho
//                 contenedor_derecho.appendChild(perfil);
//             }
//         })
//         .catch(error => {
//             console.error("Error al obtener los datos de la sesion: ", error);
//         });
// }

/** EL OBJETIVO ES IDENTIFICAR EN LA RUTA QUE SE ENCUENTRA EL USUARIO Y ASIGNAR EL DOCUMENTO AL
 * IFRAME DE HTML PARA QUE SE VEA ESE
 * **/
function mostrarAyuda() {

}