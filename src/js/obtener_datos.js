function obtenerDatos() {

    let busqueda = document.getElementById('campo-buscar').value;
    let contenido = document.getElementById('cuerpo-tabla');
    let URL = '/data/obtener_datos.php';
    let datos = new FormData();
    datos.append('campo-buscar', busqueda);

    //peticion
    fetch(URL, {
        method: "POST",
        body: datos

    })
        .then(response => response.json())
        .then(info => {
            contenido.innerHTML = info;
        })
        .catch(e => console.error("Error: ", e));
}

// Obtener la imagen del usuario y mostrarla como foto de perfil
function obtenerDatosUsuario() {

    let URL = '/data/obtener_sesion.php';
    let ruta = '/img/administradores/';
    let imagen_perfil = document.querySelector('.usuario');
    let nombre_perfil = document.querySelector('.usuario-nombre');

    fetch(URL)
        .then(response => response.json())
        .then(sesion => {
            imagen_perfil.src = ruta + sesion.imagen;
            nombre_perfil.textContent = sesion.nombre;

        })
        .catch(e => console.error('Error: ', e));
}

function busquedaProductos() {

    // document.getElementById('txtProducto').addEventListener('keyup', () => {

    let contenido = document.getElementById('lista-productos');
    let busqueda = document.getElementById('buscar-producto').value;

    if (busqueda != '') {

        let URL = '/data/productos/listado.php';
        let datos = new FormData();
        datos.append('buscar-producto', busqueda);

        fetch(URL, {
            method: "POST",
            body: datos,
            // mode: "cors"
        })
            .then(response => response.json())
            .then(info => {
                contenido.style.display = 'block';
                contenido.innerHTML = JSON.parse(info);

            })
            .catch(e => console.log("Error: ", e));

    } else {
        contenido.style.display = 'none';
        contenido.innerHTML = '';
    }

    // });
}