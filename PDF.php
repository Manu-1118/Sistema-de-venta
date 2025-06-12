<?php
require 'libraries/vendor/autoload.php';
require 'includes/template/lista-pdf.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($HTML);
// $dompdf->set_option('isRemoteEnabled', true);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'vertical');
// $dompdf->load_html(utf8_decode($HTML));

// Render the HTML as PDF
$dompdf->render();

// $dompdf->getCanvas()->page_script('$dompdf->get_cpdf()->setMargins(0, 0, 0, 0);');

// Output the generated PDF to Browser
$dompdf->stream('lista_Producto.pdf', ['Attachment' => false]);
