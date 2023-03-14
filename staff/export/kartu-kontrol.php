<?php
$backurl = '../../';
require_once($backurl . 'staff/config/settings.php');
require $backurl . 'plugins/PhpSpreadSheet/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();

$inputFileType = 'Xlsx';
$inputFileName = './kartu-kontrol.xlsx';
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
$spreadsheet = $reader->load($inputFileName);


$judul = "Kartu Kontrol";
$id_ruangan = $_POST['id_ruangan_kontrol'];
$tahun = $_POST['thn_kontrol'];

$no = 1;
$numrow = 7;


$sql = mysqli_query($conn, "SELECT * FROM ruangan JOIN gedung WHERE ruangan.id_gedung=gedung.id_gedung AND ruangan.id_ruangan='$id_ruangan'");
if (mysqli_num_rows($sql) > 0) {
  $data = mysqli_fetch_array($sql);
  $spreadsheet->getActiveSheet()->setCellValue('E2', $data['nm_ruangan']);
  $spreadsheet->getActiveSheet()->setCellValue('E3', $data['nm_gedung']);
  $spreadsheet->getActiveSheet()->setCellValue('E4', $tahun);
  $judul .= ' - ' . $data['nm_ruangan'] . ' Tahun ' . $tahun;
  $sql = mysqli_query($conn, "SELECT barang.kd_barang, mbarang.nm_mbarang,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='1' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `01`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='2' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `02`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='3' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `03`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='4' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `04`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='5' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `05`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='6' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `06`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='7' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `07`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='8' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `08`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='9' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `09`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='10' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `10`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='11' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `11`,
  COALESCE((SELECT kontrol.stt_kontrol FROM kontrol WHERE kontrol.id_barang=barang.id_barang AND MONTH(tgl_kontrol)='12' AND YEAR(tgl_kontrol)='$tahun'),'0') AS `12`
   FROM ((histori JOIN barang) JOIN mbarang) WHERE histori.id_barang=barang.id_barang AND barang.id_mbarang=mbarang.id_mbarang AND histori.id_ruangan='$id_ruangan' AND '$tahun' BETWEEN YEAR(histori.histori_masuk) AND YEAR(histori.histori_keluar) ORDER BY mbarang.nm_mbarang ASC");
  while ($data = mysqli_fetch_array($sql)) {
    $spreadsheet->getActiveSheet()->setCellValue('A' . $numrow, $data['kd_barang']);
    $spreadsheet->getActiveSheet()->setCellValue('B' . $numrow, $data['nm_mbarang']);
    $spreadsheet->getActiveSheet()->setCellValue('C' . $numrow, ($data['01'] == '0') ? '-' : (($data['01'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('D' . $numrow, ($data['02'] == '0') ? '-' : (($data['02'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('E' . $numrow, ($data['03'] == '0') ? '-' : (($data['03'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('F' . $numrow, ($data['04'] == '0') ? '-' : (($data['04'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('G' . $numrow, ($data['05'] == '0') ? '-' : (($data['05'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('H' . $numrow, ($data['06'] == '0') ? '-' : (($data['06'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('I' . $numrow, ($data['07'] == '0') ? '-' : (($data['07'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('J' . $numrow, ($data['08'] == '0') ? '-' : (($data['08'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('K' . $numrow, ($data['09'] == '0') ? '-' : (($data['09'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('L' . $numrow, ($data['10'] == '0') ? '-' : (($data['10'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('M' . $numrow, ($data['11'] == '0') ? '-' : (($data['11'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->setCellValue('N' . $numrow, ($data['12'] == '0') ? '-' : (($data['12'] == 'baik') ? '✅' : '❎'));
    $spreadsheet->getActiveSheet()->insertNewRowBefore($numrow + 1, 1);
    $spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(-1);
    $numrow++;
    $no++;
  }
  (mysqli_num_rows($sql) > 0) ? $spreadsheet->getActiveSheet()->removeRow(($numrow + 1), 1) : '';
}


// $spreadsheet->setActiveSheetIndexByName('Realisasi');
$spreadsheet->getProperties()->setCreator('AndL')->setLastModifiedBy('AndL')->setTitle($judul)->setSubject("Kartu Kontrol")->setDescription("Export Data $judul")->setKeywords("$judul");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $judul . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
