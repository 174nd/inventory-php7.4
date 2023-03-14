<?php
$backurl = '../../';
require_once($backurl . 'staff/config/settings.php');
require_once($backurl . 'plugins/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$dompdf = new Dompdf();


ob_start();
require_once($backurl . 'staff/export/isi-surat-pinjaman.php');
$script = ob_get_clean();

$dompdf->loadHtml($script);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("Surat Peminjaman", array("Attachment" => 0));
exit(0);
