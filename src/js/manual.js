function generarIframePDF(rutaActual) {
    let pdfSrc = '';
    let tituloPDF = ''; // Opcional: para mostrar un título o descripción del PDF

    // Normalizamos la ruta para asegurar que las comparaciones sean consistentes
    const rutaNormalizada = rutaActual.toLowerCase();

    // Clientes
    if (rutaNormalizada.includes('admin/control/cliente/clientes.php')) {
        pdfSrc = '/docs/Cliente.pdf';

    } else if (rutaNormalizada.includes('admin/control/cliente/deudas.php')) {
        pdfSrc = '/docs/ClienteCreditos.pdf';

    } else if (rutaNormalizada.includes('admin/control/cliente/crear.php')) {
        pdfSrc = '/docs/ClienteCrear.pdf';

        // Administradores
    } else if (rutaNormalizada.includes('admin/control/administrador/administradores.php')) {
        pdfSrc = '/docs/Administrador.pdf';

    } else if (rutaNormalizada.includes('admin/control/administrador/crear.php')) {
        pdfSrc = '/docs/AdminCrear.pdf';

    } else if (rutaNormalizada.includes('admin/control/administrador/perfil.php')) {
        pdfSrc = '/docs/AdminPerfil.pdf';

        //Consumidos
    } else if (rutaNormalizada.includes('admin/control/consumido/consumidos.php')) {
        pdfSrc = '/docs/Consumido.pdf';

    } else if (rutaNormalizada.includes('admin/control/consumido/crear.php')) {
        pdfSrc = '/docs/ConsumidosCrear.pdf';

    } else if (rutaNormalizada.includes('admin/control/consumido/detalles.php')) {
        pdfSrc = '/docs/ConsumidosDetalles.pdf';

        //Proveedores
    } else if (rutaNormalizada.includes('/admin/control/proveedor/proveedores.php')) {
        pdfSrc = '/docs/Proveedores.pdf';

    } else if (rutaNormalizada.includes('admin/control/proveedor/editar.php')) {
        pdfSrc = '/docs/ProvCrear.pdf';

    } else if (rutaNormalizada.includes('admin/control/proveedor/crear.php')) {
        pdfSrc = '/docs/ProvEditar.pdf';

        //Lista
    } else if (rutaNormalizada.includes('lista.php')) {
        pdfSrc = '/docs/Lista.pdf';
        //Login
    } else if (rutaNormalizada.includes('login.php')) {
        pdfSrc = '/docs/Login.pdf';
        //Sobre Nosotros
    } else if (rutaNormalizada.includes('nosotros.php')) {
        pdfSrc = '/docs/SobreNosotros.pdf';

        //admin
    } else if (rutaNormalizada.endsWith('admin') || rutaNormalizada.endsWith('admin/')) {
        pdfSrc = '/docs/PanelControl.pdf';

        //index
    } else {
        pdfSrc = '/docs/presentacion.pdf';
    }

    // Creamos el elemento iframe
    const contenedorIframe = document.querySelector('.modal-body');
    const iframe = document.createElement('iframe');
    iframe.src = pdfSrc;
    iframe.width = '100%';
    iframe.height = '100%';
    contenedorIframe.appendChild(iframe);
}