<?php
require '../libraries/vendor/autoload.php';
require '../includes/app.php';
estaAutenticado();
$db = conectarDB();
require '../plantilla-reporte.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

// $HTML = file_get_contents("../plantilla-reporte.php");
$dompdf->loadHtml($HTML);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'vertical');

$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('reporte_ultimos_15dias.pdf', ['Attachment' => false]);
