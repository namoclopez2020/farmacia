<?php
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */
require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/../../includes/load.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    ob_start();
    
    include_once dirname(__FILE__).'/plantilla_inventario.php';
    $products = join_prodct_table();
    $content = ob_get_clean();

    $html2pdf=new HTML2PDF('P','A4','es','true','UTF-8');

    $html2pdf->writeHTML($content);
    $html2pdf->output('inventario.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
