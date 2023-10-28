<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
try {
    ob_start();
    if (isset($_GET['all'])) {
    include dirname(__FILE__).'/ref/view_all.php';
    }
    elseif (isset($_GET['mode'])) {
    	if ($_GET['mode'] == "pernota") {
    	include dirname(__FILE__).'/ref/view_pernota.php';
    	}
        if ($_GET['mode'] == "pertanggal") {
        include dirname(__FILE__).'/ref/view_pertanggal.php';
        }
    }else{
    	header("Location: index.php");
    }
    
    $content = ob_get_clean();
    $html2pdf = new Html2Pdf('L', 'A4', 'en');
    $html2pdf->writeHTML($content);
    $html2pdf->output('Print Laporan.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
?>