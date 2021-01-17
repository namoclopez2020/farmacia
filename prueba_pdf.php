<?php
    require 'vendor/autoload.php';
    require_once('includes/load.php');
    use Dompdf\Dompdf;
    
    // Introducimos HTML de prueba
    
    
    // Instanciamos un objeto de la clase DOMPDF.
    ob_start();
    $pdf = new DOMPDF();
    $datos = 6;
    $sucursal = ($_GET['suc'] != '') ? $_GET['suc'] : null;
    $laboratorio = ($_GET['lab'] != '') ? $_GET['lab'] : null;
    $datos = join_product_table_reporte($sucursal,$laboratorio);
    $products = $datos['productos'];
    $sucursal_info = $datos['sucursal'];
    // return var_dump($datos);

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