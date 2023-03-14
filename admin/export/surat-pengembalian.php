<?php
$backurl = '../../';
require_once($backurl . 'admin/config/settings.php');
require_once($backurl . 'plugins/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$dompdf = new Dompdf();

// $html = get_included_files("kop.php");	
ob_start();
require_once($backurl . 'admin/export/isi-surat-pengembalian.php');
$script = ob_get_clean();

$dompdf->loadHtml($script);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("Surat Pengembalian", array("Attachment" => 0));
exit(0);
