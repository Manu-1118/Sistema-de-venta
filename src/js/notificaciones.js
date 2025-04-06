const btn_modal = document.getElementById('btn-modal');
const toast = document.querySelector('.contenedor-notificacion');


btn_modal.addEventListener('change', function mostrarNotificacion() {

    if (!btn_modal.checked) {
        
        const notificacion = document.createElement('DIV');
        notificacion.classList.add('notificacion');
        notificacion.innerText = 'Notificacion de prueba';
        toast.appendChild(notificacion);
    
        setTimeout(() => notificacion.remove(), 6000);
    }
}
);
