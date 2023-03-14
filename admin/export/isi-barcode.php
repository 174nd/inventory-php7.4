<?php
if (isset($_POST['barcode'])) {
  QRcode::png($_POST['barcode'], $backurl . "admin/export/barcode.png", QR_ECLEVEL_H, 10);
  echo "<img src='" . $backurl . "admin/export/barcode.png' /><br>" . $_POST['barcode'];
} else {
  header("location:" . $df['home'] . "barang/");
  exit();
}
