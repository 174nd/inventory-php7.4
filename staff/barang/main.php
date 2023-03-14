<?php
$backurl = '../../';
require_once($backurl . 'staff/config/settings.php');
$pset = array(
  'title' => 'Barang',
  'content' => 'Barang',
  'breadcrumb' => array(
    'Barang' => 'active',
  ),
);

$setSidebar = activedSidebar($setSidebar, 'Barang');

if (isset($_GET['id_barang'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$_GET[id_barang]'");
  $ada = mysqli_fetch_assoc($cekdata);
  if (mysqli_num_rows($cekdata) > 0) {
    $get = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_kontrol, stt_kontrol FROM kontrol WHERE id_barang='$_GET[id_barang]' AND tgl_kontrol='$ada[barang_masuk]'"));
    $isiVal = [
      'kd_barang' =>  $ada['kd_barang'],
      'id_mbarang' =>  $ada['id_mbarang'],
      'ns_barang' =>  $ada['ns_barang'],
      'stt_barang' =>  $get['stt_kontrol'],
      'barang_masuk' =>  date('Y-m-d', strtotime($ada['barang_masuk'])),
      'barang_keluar' => (isset($ada['barang_keluar']) && $ada['barang_keluar'] != '') ? date('Y-m-d', strtotime($ada['barang_keluar'])) : "",
    ];

    $pset = [
      'title' => 'Update Barang',
      'content' => 'Update Barang',
      'breadcrumb' => [
        'Dashboard' => $df['home'],
        'Barang' => $df['home'] . 'barang/',
        'Update' => 'active',
      ],
    ];

    if (isset($_POST["Simpan"])) {
      $_POST = setData($_POST);
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang='$_POST[kd_barang]' AND id_barang!='$_GET[id_barang]'")) > 0) {
        $_SESSION['duplikasi'] = 'Kode Barang';
        $isiVal = [
          'kd_barang' =>  $_POST['kd_barang'],
          'id_mbarang' =>  $_POST['id_mbarang'],
          'ns_barang' =>  $_POST['ns_barang'],
          'barang_masuk' =>  $_POST['barang_masuk'],
          'barang_keluar' =>  $_POST['barang_keluar'],
        ];
      } else {
        $set = [
          'kd_barang' =>  $_POST['kd_barang'],
          'id_mbarang' =>  $_POST['id_mbarang'],
          'ns_barang' =>  $_POST['ns_barang'],
          'barang_masuk' =>  $_POST['barang_masuk'],
          'barang_keluar' => ($_POST['barang_keluar'] != '') ? $_POST['barang_keluar'] : null,
        ];
        $query = setUpdate($set, 'barang', ['id_barang' => $_GET['id_barang']]) && setUpdate(['tgl_kontrol' => $_POST['barang_masuk'], 'stt_kontrol' => $_POST['stt_barang']], 'kontrol', ['id_kontrol' => $get['id_kontrol']]);
        if (!$query) {
          $_SESSION['notifikasi'] = 'NOT02';
        } else {
          $_SESSION['notifikasi'] = 'NOT04';
          header("location:" . $df['home'] . "barang/");
          exit();
        }
      }
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "barang/");
    exit();
  }
} else {
  $isiVal = [
    'kd_barang' => '',
    'id_mbarang' => '',
    'ns_barang' => '',
    'stt_barang' => '',
    'barang_masuk' => '',
    'barang_keluar' => '',
  ];
  if (isset($_POST["Simpan"])) {
    $_POST = setData($_POST);
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang='$_POST[kd_barang]'")) > 0) {
      $_SESSION['duplikasi'] = 'Kode Barang';
      $isiVal = [
        'kd_barang' =>  $_POST['kd_barang'],
        'id_mbarang' =>  $_POST['id_mbarang'],
        'ns_barang' =>  $_POST['ns_barang'],
        'barang_masuk' =>  $_POST['barang_masuk'],
        'barang_keluar' =>  $_POST['barang_keluar'],
      ];
    } else {
      $get = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `AUTO_INCREMENT` AS id FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db[db]' AND TABLE_NAME = 'barang'"));
      $set = [
        'kd_barang' =>  $_POST['kd_barang'],
        'id_mbarang' =>  $_POST['id_mbarang'],
        'ns_barang' =>  $_POST['ns_barang'],
        'barang_masuk' =>  $_POST['barang_masuk'],
        'barang_keluar' => ($_POST['barang_keluar'] != '') ? $_POST['barang_keluar'] : null,
      ];
      $query = setInsert($set, 'barang') && setInsert(['id_barang' => $get['id'], 'tgl_kontrol' => $_POST['barang_masuk'], 'stt_kontrol' => $_POST['stt_barang']], 'kontrol');
      if (!$query) {
        $_SESSION['notifikasi'] = 'NOT02';
      } else {
        $_SESSION['notifikasi'] = 'NOT03';
      }
    }
  }
}


?>
<!DOCTYPE html>
<html>

<head>
  <?php include $backurl . 'config/site/head.php'; ?>
</head>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open text-sm">
  <div class="wrapper">
    <?php include $backurl . 'staff/config/header-sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php include $backurl . 'staff/config/content-header.php'; ?>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <form method="POST" enctype="multipart/form-data" autocomplete="off" id="form_barang">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-success card-outline">
                  <div class="overlay d-flex justify-content-center align-items-center invisible">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                  </div>
                  <div class="card-body">
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item pt-0" style="border-top: 0;">
                        <div class="input-group">
                          <div class="row w-100 ml-0 mr-0">
                            <div class="col-md-4 mb-2">
                              <label class="float-right" for="kd_barang">Kode Barang</label>
                              <input type="text" name="kd_barang" class="form-control" id="kd_barang" placeholder="Kode Barang" disabled>
                            </div>
                            <div class="col-md-8 mb-2">
                              <div class="row">
                                <div class="col-12">
                                  <label class="float-right" for="id_mbarang">Model Barang</label>
                                </div>
                                <div class="col-12">
                                  <select name="id_mbarang" id="id_mbarang" class="form-control custom-select select2" required>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM mbarang ORDER BY nm_mbarang ASC");
                                    for ($i = 1; $Data = mysqli_fetch_array($sql); $i++) { ?>
                                      <option value="<?= $Data['id_mbarang']; ?>" <?= cekSama($isiVal['id_mbarang'], $Data['id_mbarang']); ?>><?= $Data['nm_mbarang']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="input-group">
                          <div class="row w-100 ml-0 mr-0">
                            <div class="col-md-8 mb-2">
                              <label class="float-right" for="ns_barang">Nomor Seri Barang</label>
                              <input type="text" name="ns_barang" class="form-control" id="ns_barang" placeholder="Nomor Seri Barang" value="<?= $isiVal['ns_barang']; ?>">
                            </div>
                            <div class="col-md-4 mb-2">
                              <label class="float-right" for="stt_barang">Status Barang</label>
                              <select name="stt_barang" id="stt_barang" class="form-control custom-select" required>
                                <option value="baik" <?= cekSama($isiVal['stt_barang'], 'baik'); ?>>Baik</option>
                                <option value="rusak" <?= cekSama($isiVal['stt_barang'], 'rusak'); ?>>Rusak</option>
                              </select>
                            </div>
                          </div>
                      </li>
                      <li class="list-group-item pb-0" style="border-bottom: 0;">
                        <div class="input-group">
                          <div class="row w-100 ml-0 mr-0">
                            <div class="col-md-6 mb-2">
                              <label class="float-right" for="barang_masuk">Tanggal Masuk</label>
                              <div class="input-group">
                                <input type="text" name="barang_masuk" id="barang_masuk" class="form-control mydatetoppicker" placeholder="Tanggal Masuk" value="<?= $isiVal['barang_masuk']; ?>" required>
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="float-right" for="barang_keluar">Tanggal Keluar</label>
                              <div class="input-group">
                                <input type="text" name="barang_keluar" id="barang_keluar" class="form-control mydatetoppicker" placeholder="Tanggal Keluar" value="<?= $isiVal['barang_keluar']; ?>">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" name="Simpan" class="btn btn-block btn-success">Simpan</button>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="card card-success card-outline">
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-4 mb-2">
                        <select id="column_barang" class="form-control custom-select">
                          <option value="1">Nomor Seri Barang</option>
                          <option value="0">Nomor</option>
                        </select>
                      </div>
                      <div class="col-md-8 mb-2">
                        <input type="text" class="form-control" placeholder="Cari Data" id="field_barang">
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="table_barang" class="table table-bordered table-hover" style="min-width: 400px;">
                        <thead>
                          <tr>
                            <th>Nomor</th>
                            <th>Nama Model Barang</th>
                            <th>Act</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->




    <div class="modal fade" id="data-histori">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Data histori</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item pt-0" style="border-top: 0;">
                <b>Nama Barang</b><span class="float-right" id="nm_mbarang">x</span>
              </li>
              <li class="list-group-item">
                <b>Asset</b><span class="float-right" id="nm_asset">x</span>
              </li>
              <li class="list-group-item">
                <b>Kode Barang</b><span class="float-right" id="kd_barang">x</span>
              </li>
              <li class="list-group-item">
                <b>Nomor Seri Barang</b><span class="float-right" id="ns_barang">x</span>
              </li>
              <li class="list-group-item">
                <b>Ruangan</b><span class="float-right" id="nm_ruangan">x</span>
              </li>
              <li class="list-group-item">
                <b>Gedung</b><span class="float-right" id="nm_gedung">x</span>
              </li>
              <li class="list-group-item d-none" id="foto_mbarang">
                <img src="#" class="foto_barang_histori">
              </li>
              <li class="list-group-item">
                <form method="POST" action="<?= $df['home'] . 'export/barcode.php' ?>" target="blank" class="btn-group w-100">
                  <input type="hidden" name="barcode">
                  <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#kontrol-barang">Kontrol</button>
                  <button type="submit" class="btn btn-sm btn-primary">Barcode</button>
                  <a href="#" class="btn btn-sm bg-info">Update</a>
                </form>
              </li>
              <li class="list-group-item pb-0" style="border-bottom: 0;" id="div_kas_transaksi">
                <div class="table-responsive">
                  <table id="table_dhistori" class="table table-bordered table-hover" style="min-width: 400px;width:100%;">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="kontrol-barang">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Data Kontrol Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item pt-0" style="border-top: 0;">
                <button type="button" class="btn btn-sm btn-primary w-100" data-toggle="modal" data-target="#set-kontrol" onclick="$('#set-kontrol #submit_kontrol').attr('status_kontrol', 'simpan').attr('id_kontrol', '#');">Input Kontrol</button>
              </li>
              <li class="list-group-item pb-0" style="border-bottom: 0;">
                <div class="table-responsive">
                  <table id="table_kontrol" class="table table-bordered table-hover" style="min-width: 300px; width:100%;">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Act</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="set-kontrol">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Kontrol Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item pt-0" style="border-top: 0;">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12 mb-2">
                      <label class="float-right" for="tgl_kontrol">Tanggal Kontrol</label>
                      <div class="input-group">
                        <input type="text" name="tgl_kontrol" id="tgl_kontrol" class="form-control mydatepicker" placeholder="Tanggal Masuk" required>
                        <div class="input-group-append">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item pb-0" style="border-bottom: 0;">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12 mb-2">
                      <label class="float-right" for="stt_kontrol">Status Kontrol</label>
                      <select name="stt_kontrol" id="stt_kontrol" class="form-control custom-select" required>
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                      </select>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
              <button type="submit" name="simpan-kontrol" id="submit_kontrol" class="btn btn-outline-success" status_kontrol='#' id_kontrol='#'>Simpan</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <?php include $backurl . 'staff/config/modal.php'; ?>
    <?php include $backurl . 'config/site/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <?php include $backurl . 'config/site/script.php'; ?>
  <!-- page script -->
  <script>
    $(function() {
      var table_kontrol, fid_barang, button_set,
        host = "<?= $df['home'] ?>";
      var table_barang = $('#table_barang').DataTable({
        'paging': true,
        'lengthChange': false,
        "pageLength": 10,
        'info': true,
        "order": [
          [0, "desc"]
        ],
        'searching': true,
        'ordering': true,
        "language": {
          "paginate": {
            "previous": "<",
            "next": ">"
          }
        },



        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": host + "../config/get-tables.php",
          "data": {
            "set_tables": "SELECT kd_barang, nm_mbarang, id_barang FROM barang JOIN mbarang WHERE barang.id_mbarang=mbarang.id_mbarang",
            "query": true
          },
          "type": "POST"
        },
        "columns": [{
          'className': "align-middle text-center",
          "data": "kd_barang",
          "width": "70px",
        }, {
          'className': "align-middle",
          "data": "nm_mbarang",
        }, {
          'className': "align-middle text-center",
          "data": "id_barang",
          "width": "10px",
          "render": function(data, type, row, meta) {
            return '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#data-histori" id_barang="' + data + '"><i class="fa fa-eye"></i></button></div>';
          }
        }],
      });
      $('#table_barang_filter').hide();
      $('#field_barang').keyup(function() {
        table_barang.columns($('#column_barang').val()).search(this.value).draw();
      });

      var table_dhistori = $('#table_dhistori').DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'ordering': true,
        bAutoWidth: false,
        "columns": [{
          'className': "align-middle text-center",
          "width": "10px",
        }, {
          'className': "align-middle",
        }, {
          'className': "align-middle text-center",
          "width": "100px",
        }, {
          'className': "align-middle text-center",
          "width": "100px",
        }, ],
        "order": [
          [0, "desc"]
        ],

      });
      table_barang.on('click', 'button[data-target="#data-histori"]', function() {
        $('#data-histori .overlay').removeClass('invisible');
        let id_barang = $(this).attr('id_barang');
        $.ajax({
          type: "POST",
          url: host + "get-barang.php",
          dataType: "JSON",
          data: {
            'set': 'get_tables',
            'id_barang': id_barang,
          },
          success: function(data) {
            if (data['status'] == 'done') {
              fid_barang = id_barang;
              table_kontrol.clear().draw();
              table_dhistori.clear().draw();
              $('#data-histori #nm_mbarang').html(data['nm_mbarang']);
              $('#data-histori #nm_asset').html(data['nm_asset']);
              $('#data-histori #kd_barang').html(data['kd_barang']);
              $('#data-histori #ns_barang').html(data['ns_barang']);
              $('#data-histori #nm_ruangan').html(data['nm_ruangan']);
              $('#data-histori #nm_gedung').html(data['nm_gedung']);
              if (data['foto_mbarang'] != '-') {
                $('#data-histori #foto_mbarang').removeClass('d-none');
                $('#data-histori #foto_mbarang .foto_barang_histori').attr('src', data['foto_mbarang']);
              } else {
                $('#data-histori #foto_mbarang').addClass('d-none');
                $('#data-histori #foto_mbarang .foto_barang_histori').attr('src', '#');
              }
              $('#data-histori .btn-group a').attr('href', host + 'barang/' + id_barang);
              $('#data-histori .btn-group input[name="barcode"]').val(data['kd_barang']);
              $('#data-histori .btn-group button[data-target="#delete-barang"]').unbind().click(function() {
                $('#delete-barang #did_barang').val(id_barang);
              });
              let nomortable = 1;
              $(data['hasil']).each(function(index, hasil) {
                table_dhistori.row.add([nomortable, hasil['nm_ruangan'] + ' - ' + hasil['nm_gedung'], hasil['histori_masuk'], hasil['histori_keluar']]).draw();
                nomortable++;
              });
              $(data['kontrol']).each(function(index, hasil) {
                if (hasil['tipe_kontrol'] == true) {
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-info" disabled><i class="fa fa-edit"></i></button></div>';
                } else {
                  button_set = '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#set-kontrol" id_kontrol="' + hasil['id_kontrol'] + '"><i class="fa fa-edit"></i></button></div>';
                }
                table_kontrol.row.add([hasil['tgl_kontrol'], hasil['stt_kontrol'], button_set]).draw();
              });
              $('#data-histori .overlay').addClass('invisible')
            }
          },
          error: function(request, status, error) {
            console.log(request.responseText);
          }
        });
      });

      table_kontrol = $('#table_kontrol').DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'ordering': true,
        "autoWidth": false,
        "columns": [{
          'className': "align-middle text-center",
          "width": "10px",
        }, {
          'className': "align-middle",
        }, {
          'className': "align-middle text-center",
          "width": "10px",
        }],
        "order": [
          [0, "desc"]
        ],
      });

      table_kontrol.on('click', 'button[data-target="#set-kontrol"]', function() {
        $('#set-kontrol .overlay').removeClass('invisible');
        let id_kontrol = $(this).attr('id_kontrol');
        $.ajax({
          type: "POST",
          url: host + "get-barang.php",
          dataType: "JSON",
          data: {
            'set': 'get_kontrol',
            'id_kontrol': id_kontrol,
          },
          success: function(data) {
            console.log(data);
            if (data['status'] == 'done') {
              $('#set-kontrol .modal-body #tgl_kontrol').val(data['tgl_kontrol']);
              $('#set-kontrol .modal-body #stt_kontrol').val(data['stt_kontrol']);
              $('#set-kontrol #submit_kontrol').attr('status_kontrol', 'update').attr('id_kontrol', data['id_kontrol']);
              $('#set-kontrol .overlay').addClass('invisible');
            }
          },
          error: function(request, status, error) {
            console.log(request.responseText);
          }
        });
      });
      $('#set-kontrol #submit_kontrol').click(function() {
        $('#set-kontrol .overlay').removeClass('invisible');
        let id_kontrol = $(this).attr('id_kontrol');
        let status_kontrol = $(this).attr('status_kontrol');
        let tgl_kontrol = $('#set-kontrol .modal-body #tgl_kontrol').val();
        let stt_barang = $('#set-kontrol .modal-body #stt_kontrol').val();
        $.ajax({
          type: "POST",
          url: host + "get-barang.php",
          dataType: "JSON",
          data: {
            'set': 'set_kontrol',
            'status_kontrol': status_kontrol,
            'id_kontrol': id_kontrol,
            'fid_barang': fid_barang,
            'tgl_kontrol': tgl_kontrol,
            'stt_barang': stt_barang,
          },
          success: function(data) {
            if (data['status'] == 'done') {
              if (status_kontrol == 'simpan') {
                toastr.success('Data Kontrol Berhasil Disimpan!');
              } else if (status_kontrol == 'update') {
                toastr.warning('Data Kontrol Berhasil Diubah!');
              }
              $('#set-kontrol .modal-body #tgl_kontrol').val('');
              $('#set-kontrol .modal-body #stt_kontrol').val('baik');
              table_kontrol.clear().draw();
              $('#kontrol-barang .overlay').removeClass('invisible');
              $(data['kontrol']).each(function(index, hasil) {
                if (hasil['tipe_kontrol'] == true) {
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-info" disabled><i class="fa fa-edit"></i></button></div>';
                } else {
                  button_set = '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#set-kontrol" id_kontrol="' + hasil['id_kontrol'] + '"><i class="fa fa-edit"></i></button></div>';
                }
                table_kontrol.row.add([hasil['tgl_kontrol'], hasil['stt_kontrol'], button_set]).draw();
              });
              $('#set-kontrol .overlay').addClass('invisible');
              $('#kontrol-barang .overlay').addClass('invisible');
              $('#set-kontrol').modal('hide');
            }
          },
          error: function(request, status, error) {
            console.log(request.responseText);
          }
        });
      });
      $('#delete-kontrol #delete_kontrol').click(function() {
        $('#delete-kontrol .overlay').removeClass('invisible');
        let id_kontrol = $('#delete-kontrol #did_kontrol').val();
        $.ajax({
          type: "POST",
          url: host + "get-barang.php",
          dataType: "JSON",
          data: {
            'set': 'delete_kontrol',
            'id_kontrol': id_kontrol,
            'fid_barang': fid_barang,
          },
          success: function(data) {
            if (data['status'] == 'done') {
              toastr.error('Data Kontrol Berhasil Dihapus!');
              table_kontrol.clear().draw();
              $('#kontrol-barang .overlay').removeClass('invisible');
              $(data['kontrol']).each(function(index, hasil) {
                if (hasil['tipe_kontrol'] == true) {
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-info" disabled><i class="fa fa-edit"></i></button></div>';
                } else {
                  button_set = '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#set-kontrol" id_kontrol="' + hasil['id_kontrol'] + '"><i class="fa fa-edit"></i></button></div>';
                }
                table_kontrol.row.add([hasil['tgl_kontrol'], hasil['stt_kontrol'], button_set]).draw();
              });
              $('#delete-kontrol .overlay').addClass('invisible');
              $('#kontrol-barang .overlay').addClass('invisible');
              $('#delete-kontrol').modal('hide');
            }
          },
          error: function(request, status, error) {
            console.log(request.responseText);
          }
        });
      });




      $('#id_mbarang').change(function() {
        $('#form_barang .overlay').removeClass('invisible')
        $.ajax({
          type: "POST",
          url: host + "get-barang.php",
          dataType: "JSON",
          data: {
            'set': 'get_kd_barang',
            'id_mbarang': this.value
          },
          success: function(data) {
            if (data['status'] == 'done') {
              $('#form_barang #kd_barang').val(data['kd_barang']);
              $('#form_barang .overlay').addClass('invisible')
            }
          },
          error: function(request, status, error) {
            console.log(request.responseText);
          }
        });
      });

      $('#id_mbarang').trigger('change');
    });
  </script>
</body>

</html>