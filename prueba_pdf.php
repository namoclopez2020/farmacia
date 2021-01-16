<?php
    require 'vendor/autoload.php';
    require_once('includes/load.php');
    use Dompdf\Dompdf;
    
    // Introducimos HTML de prueba
    
    
    // Instanciamos un objeto de la clase DOMPDF.
    ob_start();
    $pdf = new DOMPDF();
    $sucursal = ($_GET['suc'] != '') ? $_GET['suc'] : null;
    $laboratorio = ($_GET['lab'] != '') ? $_GET['lab'] : null;
    $products = join_product_table_reporte($sucursal,$laboratorio);
    
    

    include('reportes/plantilla_inventario.php');
    
    // Definimos el tamaño y orientación del papel que queremos.
    $pdf->set_paper("A4", "portrait");
    
    // Cargamos el contenido HTML.
    $pdf->load_html(ob_get_clean());
    
    // Renderizamos el documento PDF.
    $pdf->render();
    
    // Enviamos el fichero PDF al navegador.
    $pdf->stream('FicheroEjemplo.pdf');
?>