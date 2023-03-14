<?php
$backurl = '../';
require_once($backurl . 'admin/config/settings.php');

if ($_POST['set'] == 'get_barang') {
  $sql = mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang='$_POST[kd_barang]' LIMIT 1");
  if (mysqli_num_rows($sql) > 0) {
    $Data = mysqli_fetch_assoc($sql);
    $hasil = [
      'kd_barang' => $Data['kd_barang'],
      'nm_barang' => $Data['nm_barang'],
      'stt_barang' => $Data['stt_barang'],
      'barang_masuk' => ($Data['barang_masuk'] != '') ? $Data['barang_masuk'] : '-',
      'barang_keluar' => ($Data['barang_keluar'] != '') ? $Data['barang_keluar'] : '-',
      'status' => 'done'
    ];
  } else {
    $hasil['status'] = 'none';
  }
} else if ($_POST['set'] == 'get_tables') {
  $sql = mysqli_query($conn, "SELECT * FROM ((barang JOIN mbarang) JOIN asset) WHERE barang.id_mbarang=mbarang.id_mbarang AND mbarang.id_asset=asset.id_asset AND barang.id_barang='$_POST[id_barang]'");
  if (mysqli_num_rows($sql) > 0) {
    $DataBarang = mysqli_fetch_assoc($sql);
    $sql1 = mysqli_query($conn, "SELECT * FROM (((barang JOIN histori) JOIN ruangan) JOIN gedung) WHERE barang.id_barang=histori.id_barang AND histori.id_ruangan=ruangan.id_ruangan AND ruangan.id_gedung=gedung.id_gedung AND barang.id_barang='$_POST[id_barang]'");
    $set_data = array();
    $set_kontrol = array();
    if (mysqli_num_rows($sql1) > 0) {
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


      $sql2 = mysqli_query($conn, "SELECT * FROM kontrol JOIN barang WHERE kontrol.id_barang=barang.id_barang AND kontrol.id_barang='$_POST[id_barang]'");
      for ($i = 0; $Data = mysqli_fetch_assoc($sql2); $i++) {
        $set_kontrol[] = [
          'id_kontrol' => $Data['id_kontrol'],
          'tgl_kontrol' => $Data['tgl_kontrol'],
          'stt_kontrol' => $Data['stt_kontrol'],
          'tipe_kontrol' => ($Data['tgl_kontrol'] == $Data['barang_masuk']) ? true : false,
        ];
      }
    }
    $hasil = [
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
} else if ($_POST['set'] == 'get_tables_dashboard') {
  $sql = mysqli_query($conn, "SELECT * FROM ((barang JOIN mbarang) JOIN asset) WHERE barang.id_mbarang=mbarang.id_mbarang AND mbarang.id_asset=asset.id_asset AND barang.kd_barang='$_POST[kd_barang]'");
  if (mysqli_num_rows($sql) > 0) {
    $DataBarang = mysqli_fetch_assoc($sql);
    $sql1 = mysqli_query($conn, "SELECT * FROM (((barang JOIN histori) JOIN ruangan) JOIN gedung) WHERE barang.id_barang=histori.id_barang AND histori.id_ruangan=ruangan.id_ruangan AND ruangan.id_gedung=gedung.id_gedung AND barang.id_barang='$DataBarang[id_barang]'");
    $set_data = array();
    $set_kontrol = array();
    if (mysqli_num_rows($sql1) > 0) {
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
} else if ($_POST['set'] == 'get_kd_barang') {
  $sql = mysqli_query($conn, "SELECT * FROM mbarang WHERE id_mbarang='$_POST[id_mbarang]'");
  if (mysqli_num_rows($sql) > 0) {
    $data = mysqli_fetch_assoc($sql);
    $hasil = [
      'kd_barang' => setKode(str_pad($data['id_mbarang'], 3, "0", STR_PAD_LEFT) . '#', 10, "barang WHERE id_mbarang='$data[id_mbarang]'", 'kd_barang'),
      // 'kd_barang' => $DataBarang['ns_barang'],
      'status' => 'done'
    ];
  } else {
    $hasil['status'] = 'none';
  }
} else if ($_POST['set'] == 'get_kontrol') {
  $sql = mysqli_query($conn, "SELECT * FROM kontrol WHERE id_kontrol='$_POST[id_kontrol]'");
  if (mysqli_num_rows($sql) > 0) {
    $data = mysqli_fetch_assoc($sql);
    $hasil = [
      'id_kontrol' => $data['id_kontrol'],
      'tgl_kontrol' => $data['tgl_kontrol'],
      'stt_kontrol' => $data['stt_kontrol'],
      'status' => 'done'
    ];
  } else {
    $hasil['status'] = 'none';
  }
} else if ($_POST['set'] == 'set_kontrol') {
  $sql = ($_POST['status_kontrol'] == 'update') ? mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kontrol WHERE id_barang='$_POST[fid_barang]' AND id_kontrol='$_POST[id_kontrol]'")) : 1;
  if ($sql > 0) {
    $set = [
      'id_user' =>  $_SESSION['id_user'],
      'id_barang' => $_POST['fid_barang'],
      'tgl_kontrol' => $_POST['tgl_kontrol'],
      'stt_kontrol' => $_POST['stt_barang'],
    ];

    if (($_POST['status_kontrol'] == 'update') ? setUpdate($set, 'kontrol', ['id_kontrol' => $_POST['id_kontrol']]) : setInsert($set, 'kontrol')) {
      $set_kontrol = [];
      $sql2 = mysqli_query($conn, "SELECT * FROM kontrol JOIN barang WHERE kontrol.id_barang=barang.id_barang AND kontrol.id_barang='$_POST[fid_barang]'");
      for ($i = 0; $Data = mysqli_fetch_assoc($sql2); $i++) {
        $set_kontrol[] = [
          'id_kontrol' => $Data['id_kontrol'],
          'tgl_kontrol' => $Data['tgl_kontrol'],
          'stt_kontrol' => $Data['stt_kontrol'],
          'tipe_kontrol' => ($Data['tgl_kontrol'] == $Data['barang_masuk']) ? true : false,
        ];
      }
      $hasil = [
        'kontrol' => $set_kontrol,
        'status' => 'done',
      ];
      $hasil['status'] = 'done';
    } else {
      $hasil['status'] = 'none';
    }
  } else {
    $hasil['status'] = 'none';
  }
} else if ($_POST['set'] == 'delete_kontrol') {
  $sql = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kontrol WHERE id_barang='$_POST[fid_barang]' AND id_kontrol='$_POST[id_kontrol]'"));
  if ($sql > 0) {
    if (setDelete('kontrol', ['id_barang' => $_POST['fid_barang'], 'id_kontrol' => $_POST['id_kontrol']])) {
      $set_kontrol = [];
      $sql2 = mysqli_query($conn, "SELECT * FROM kontrol JOIN barang WHERE kontrol.id_barang=barang.id_barang AND kontrol.id_barang='$_POST[fid_barang]'");
      for ($i = 0; $Data = mysqli_fetch_assoc($sql2); $i++) {
        $set_kontrol[] = [
          'id_kontrol' => $Data['id_kontrol'],
          'tgl_kontrol' => $Data['tgl_kontrol'],
          'stt_kontrol' => $Data['stt_kontrol'],
          'tipe_kontrol' => ($Data['tgl_kontrol'] == $Data['barang_masuk']) ? true : false,
        ];
      }
      $hasil = [
        'kontrol' => $set_kontrol,
        'status' => 'done',
      ];
      $hasil['status'] = 'done';
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
