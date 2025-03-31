<?php

require './includes/app.php';
incluirTemplate('header', true);

?>

<main class="principal main-nosotros fondo" id="main">
    <div class="contenedor-informacion">
        <h2>Acerca de nosotros</h2>
        <p>En El Pilar, encontrarás todo lo que necesitas para tu día a día, desde productos frescos hasta artículos de limpieza y cuidado personal. Somos tu pulpería de confianza, donde encontrarás una amplia variedad de productos a precios accesibles y un servicio cercano y amable.</p>
        <br>
        <p>En El Pilar, nos preocupamos por ofrecerte productos frescos y de calidad. Nuestra selección de verduras, carnes, lácteos y panadería es cuidadosamente seleccionada para garantizar tu satisfacción. En El Pilar, nos esforzamos por ofrecer precios accesibles para todos nuestros productos. Queremos que puedas encontrar todo lo que necesitas sin tener que gastar una fortuna.</p>
        <h3>¡Visítanos hoy!</h3>
        <p>En El Pilar, nos esforzamos por ofrecer precios accesibles para todos nuestros productos. Queremos que puedas encontrar todo lo que necesitas sin tener que gastar una fortuna.</p>
        <h3>Horarios de atención</h3>
        <p>Lunes a Domingos de 6:00 am a 9:00 pm</p>
    </div>

    <section class="direcciones">
        <h3>Direcciones</h3>
        <div class="referencia icono-direccion">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="48" height="48" stroke-width="2">
                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
            </svg>
            <p>Del puente La Reynaga 4c. abajo, 2c. al lago, 1/2c. abajo.</p>
        </div>
        <div class="referencia icono-direccion">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="48" height="48" stroke-width="2">
                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
            </svg>
            <p>Del edificio Armando Guido 1c. abajo, 4c. al sur, 1/2c. abajo.</p>
        </div>
    </section>

    <section class="mapa">
        <h3>Ubicación exacta</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d626.8920201132728!2d-86.24513543759863!3d12.14827740723307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTLCsDA4JzU0LjIiTiA4NsKwMTQnNDIuMCJX!5e0!3m2!1ses-419!2sni!4v1743314569420!5m2!1ses-419!2sni" width="400" height="300" style="border:1px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
</main>

<?php
incluirTemplate('footer');
?>