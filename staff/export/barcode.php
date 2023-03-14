<?php
$backurl = '../../';
require_once($backurl . 'staff/config/settings.php');
require_once($backurl . 'plugins/dompdf/autoload.inc.php');
require_once($backurl . 'plugins/phpqrcode/qrlib.php');

use Dompdf\Dompdf;

// menggunakan class dompdf
$dompdf = new Dompdf();

// $html = get_included_files("kop.php");	
ob_start();

require_once($backurl . 'staff/export/isi-barcode.php');
$script = ob_get_clean();



$dompdf->loadHtml($script);

$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("Barcpde", array("Attachment" => 0));
exit(0);
