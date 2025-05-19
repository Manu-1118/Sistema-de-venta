function activarModal() {
    
    const btn_activar_modal = document.getElementById('btn-abrir-modal');
    const btn_cerrar_modal = document.getElementById('btn-cerrar-modal');
    const ventana_modal = document.querySelector('.contenedor-modal');

    btn_activar_modal.addEventListener('click', () => {

        ventana_modal.classList.add('activo');
        //incluirCerrar();
    });

    btn_cerrar_modal.addEventListener('click', () => {

        ventana_modal.classList.remove('activo');
    });
}

function incluirCerrar() {
    
    const contenedor = document.querySelector('.botones-modal');

    // const btn_cerrar_modal = document.createElement('BUTTON');
    // btn_cerrar_modal.id = 'btn-cerrar-modal';
    // btn_cerrar_modal.classList.add('boton-rojo');
    // btn_cerrar_modal.textContent = 'Cerrar';

    // contenedor.append(btn_cerrar_modal);

}