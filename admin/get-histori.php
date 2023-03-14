<?php
$backurl = '../';
require_once($backurl . 'admin/config/settings.php');

if ($_POST['set'] == 'get_tables') {
  $sql = mysqli_query($conn, "SELECT * FROM (((histori JOIN barang) JOIN mbarang) JOIN asset) WHERE histori.id_barang=barang.id_barang AND barang.id_mbarang=mbarang.id_mbarang AND mbarang.id_asset=asset.id_asset AND histori.id_histori='$_POST[id_histori]'");
  if (mysqli_num_rows($sql) > 0) {
    $DataBarang = mysqli_fetch_assoc($sql);
    $sql1 = mysqli_query($conn, "SELECT * FROM (((histori JOIN barang) JOIN ruangan) JOIN gedung) WHERE histori.id_barang=barang.id_barang AND histori.id_ruangan=ruangan.id_ruangan AND ruangan.id_gedung=gedung.id_gedung AND barang.id_barang='$DataBarang[id_barang]'");
    if (mysqli_num_rows($sql1) > 0) {
      $set_data = array();
      $set_kontrol = array();
      for ($i = 0; $Data = mysqli_fetch_assoc($sql1); $i++) {
        $set_data[] = [
          'id_histori' => $Data['id_histori'],
          'nm_ruangan' => $Data['nm_ruangan'],
          'nm_gedung' => $Data['nm_gedung'],
          'histori_masuk' => ($Data['histori_masuk'] != '') ? tanggal_indo($Data['histori_masuk']) : '-',
          'histori_keluar' => ($Data['histori_keluar'] != '') ? tanggal_indo($Data['histori_keluar']) : '-',
        ];

        if ($Data['histori_keluar'] == '') {
          $DataBarang['nm_ruangan'] = $Data['nm_ruangan'];
          $DataBarang['nm_gedung'] = $Data['nm_gedung'];
        } else {
          $DataBarang['nm_ruangan'] = '-';
          $DataBarang['nm_gedung'] = '-';
        }
      }


      $sql2 = mysqli_query($conn, "SELECT * FROM kontrol JOIN barang WHERE kontrol.id_barang=barang.id_barang AND kontrol.id_barang='$DataBarang[id_barang]'");
      for ($i = 0; $Data = mysqli_fetch_assoc($sql2); $i++) {
        $set_kontrol[] = [
          'id_kontrol' => $Data['id_kontrol'],
          'tgl_kontrol' => $Data['tgl_kontrol'],
          'stt_kontrol' => $Data['stt_kontrol'],
          'tipe_kontrol' => ($Data['tgl_kontrol'] == $Data['barang_masuk']) ? true : false,
        ];
      }
      $hasil = [
        'id_barang' => $DataBarang['id_barang'],
        'nm_mbarang' => $DataBarang['nm_mbarang'],
        'nm_asset' => $DataBarang['nm_asset'],
        'kd_barang' => $DataBarang['kd_barang'],
        'foto_mbarang' => ($DataBarang['foto_mbarang'] != '') ? $df['host'] . 'uploads/model-barang/' . $DataBarang['foto_mbarang'] : '-',
        'ns_barang' => ($DataBarang['ns_barang'] != '') ? $DataBarang['ns_barang'] : '-',
        'nm_ruangan' => (isset($DataBarang['nm_ruangan'])) ? $DataBarang['nm_ruangan'] : '-',
        'nm_gedung' => (isset($DataBarang['nm_gedung'])) ? $DataBarang['nm_gedung'] : '-',
        'hasil' => $set_data,
        'kontrol' => $set_kontrol,
        'status' => 'done'
      ];
    } else {
      $hasil['status'] = 'none';
    }
  } else {
    $hasil['status'] = 'none';
  }
} else {
  $hasil['status'] = 'none';
}

echo json_encode($hasil);
