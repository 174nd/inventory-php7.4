<?php
$backurl = '../../';
require_once($backurl . 'admin/config/settings.php');
$pset = array(
  'title' => 'Histori',
  'content' => 'Histori',
  'breadcrumb' => array(
    'Histori' => 'active',
  ),
);

$setSidebar = activedSidebar($setSidebar, 'Histori');

if (isset($_POST['delete-histori'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM histori WHERE id_histori = '$_POST[id_histori]'");
  if (mysqli_num_rows($cekdata) > 0) {
    $ada = mysqli_fetch_assoc($cekdata);
    if (setDelete('histori', ['id_histori' => $_POST['id_histori']])) {
      $_SESSION['notifikasi'] = 'NOT05';
      header("location:" . $df['home'] . "histori/");
      exit();
    } else {
      $_SESSION['notifikasi'] = 'NOT02';
      header("location:" . $df['home'] . "histori/");
      exit();
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "histori/");
    exit();
  }
} else if (isset($_GET['id_histori'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM histori WHERE id_histori='$_GET[id_histori]'");
  $ada = mysqli_fetch_assoc($cekdata);
  if (mysqli_num_rows($cekdata) > 0) {
    $isiVal = [
      'id_ruangan' =>  $ada['id_ruangan'],
      'id_barang' =>  $ada['id_barang'],
      'histori_masuk' =>  date('Y-m-d', strtotime($ada['histori_masuk'])),
      'histori_keluar' => (isset($ada['histori_keluar']) && $ada['histori_keluar'] != '') ? date('Y-m-d', strtotime($ada['histori_keluar'])) : "",
      'query_barang' =>  "SELECT * FROM barang JOIN mbarang WHERE barang.id_mbarang=mbarang.id_mbarang AND barang.barang_keluar IS NULL AND id_barang NOT IN (SELECT id_barang FROM histori WHERE histori_keluar IS NULL AND id_histori!='$_GET[id_histori]') ORDER BY ns_barang ASC",
    ];
    $pset = [
      'title' => 'Update Histori',
      'content' => 'Update Histori',
      'breadcrumb' => [
        'Dashboard' => $df['home'],
        'Histori' => $df['home'] . 'histori/',
        'Update' => 'active',
      ],
    ];

    if (isset($_POST["Simpan"])) {
      $_POST = setData($_POST);
      $set = [
        'id_ruangan' =>  $_POST['id_ruangan'],
        'id_barang' =>  $_POST['id_barang'],
        'histori_masuk' =>  $_POST['histori_masuk'],
        'histori_keluar' => ($_POST['histori_keluar'] != '') ? $_POST['histori_keluar'] : NULL,
        'id_user' =>  $_SESSION['id_user'],
      ];

      $query = setUpdate($set, 'histori', ['id_histori' => $_GET['id_histori']]);
      if (!$query) {
        $_SESSION['notifikasi'] = 'NOT02';
      } else {
        $_SESSION['notifikasi'] = 'NOT04';
        header("location:" . $df['home'] . "histori/");
        exit();
      }
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "histori/");
    exit();
  }
} else {
  $isiVal = [
    'id_ruangan' => '',
    'id_barang' => '',
    'histori_masuk' => '',
    'histori_keluar' => '',
    'query_barang' => "SELECT * FROM barang JOIN mbarang WHERE barang.id_mbarang=mbarang.id_mbarang AND barang.barang_keluar IS NULL AND id_barang NOT IN (SELECT id_barang FROM histori WHERE histori_keluar IS NULL) ORDER BY ns_barang ASC",
  ];

  if (isset($_POST["Simpan"])) {
    $_POST = setData($_POST);
    $set = [
      'id_ruangan' =>  $_POST['id_ruangan'],
      'id_barang' =>  $_POST['id_barang'],
      'histori_masuk' =>  $_POST['histori_masuk'],
      'histori_keluar' => ($_POST['histori_keluar'] != '') ? $_POST['histori_keluar'] : null,
      'id_user' =>  $_SESSION['id_user'],
    ];
    $query = setInsert($set, 'histori');
    if (!$query) {
      $_SESSION['notifikasi'] = 'NOT02';
    } else {
      $_SESSION['notifikasi'] = 'NOT03';
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
    <?php include $backurl . 'admin/config/header-sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php include $backurl . 'admin/config/content-header.php'; ?>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <form method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-success card-outline">
                  <div class="card-body">
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item pt-0" style="border-top: 0;">
                        <div class="input-group">
                          <div class="row w-100 ml-0 mr-0">
                            <div class="col-md-12 mb-2">
                              <div class="row">
                                <div class="col-12">
                                  <label class="float-right" for="id_ruangan">Ruangan</label>
                                </div>
                                <div class="col-12">
                                  <select name="id_ruangan" id="id_ruangan" class="form-control custom-select select2" required>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM ruangan JOIN gedung WHERE ruangan.id_gedung=gedung.id_gedung ORDER BY ruangan.nm_ruangan ASC");
                                    for ($i = 1; $Data = mysqli_fetch_array($sql); $i++) { ?>
                                      <option value="<?= $Data['id_ruangan']; ?>" <?= cekSama($isiVal['id_ruangan'], $Data['id_ruangan']); ?>><?= $Data['nm_ruangan'] . ' - ' . $Data['nm_gedung']; ?></option>
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
                            <div class="col-md-12 mb-2">
                              <div class="row">
                                <div class="col-12">
                                  <label class="float-right" for="id_barang">Barang</label>
                                </div>
                                <div class="col-12">
                                  <select name="id_barang" id="id_barang" class="form-control custom-select select2" required>
                                    <?php
                                    $sql = mysqli_query($conn, $isiVal['query_barang']);
                                    for ($i = 1; $Data = mysqli_fetch_array($sql); $i++) { ?>
                                      <option value="<?= $Data['id_barang']; ?>" <?= cekSama($isiVal['id_barang'], $Data['id_barang']); ?>><?= $Data['kd_barang'] . ' - ' . $Data['nm_mbarang']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item pb-0" style="border-bottom: 0;">
                        <div class="input-group">
                          <div class="row w-100 ml-0 mr-0">
                            <div class="col-md-6 mb-2">
                              <label class="float-right" for="histori_masuk">Tanggal Masuk</label>
                              <div class="input-group">
                                <input type="text" name="histori_masuk" id="histori_masuk" class="form-control mydatetoppicker" placeholder="Tanggal Masuk" value="<?= $isiVal['histori_masuk']; ?>" required>
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="float-right" for="histori_keluar">Tanggal Keluar</label>
                              <div class="input-group">
                                <input type="text" name="histori_keluar" id="histori_keluar" class="form-control mydatetoppicker" placeholder="Tanggal Keluar" value="<?= $isiVal['histori_keluar']; ?>">
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
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 mb-2">
                        <select id="column_histori" class="form-control custom-select">
                          <option value="0">Barang</option>
                          <option value="1">Ruang</option>
                        </select>
                      </div>
                      <div class="col-md-8 mb-2">
                        <input type="text" class="form-control" placeholder="Cari Data" id="field_histori">
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="table_histori" class="table table-bordered table-hover" style="min-width: 400px;">
                        <thead>
                          <tr>
                            <th>Barang</th>
                            <th>Ruang</th>
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
                  <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#kontrol-barang">Kontrol</button>
                  <input type="hidden" name="barcode">
                  <button type="submit" class="btn btn-sm btn-primary">Barcode</button>
                </form>
              </li>
              <li class="list-group-item pb-0" style="border-bottom: 0;" id="div_kas_transaksi">
                <div class="table-responsive">
                  <table id="table_dhistori" class="table table-bordered table-hover" style="min-width: 400px;">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
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
    <div class="modal fade" id="delete-kontrol">
      <form method="POST" class="modal-dialog" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Hapus Kontrol</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="modal-title">Anda yakin Ingin Menghapus Kontrol ini?</h4>
            <input type="hidden" name="id_kontrol" id="did_kontrol">
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button class="btn btn-outline-success" data-dismiss="modal">Batal</button>
              <button type="button" id="delete_kontrol" class="btn btn-outline-danger">Hapus</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </form>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="delete-histori">
      <form method="POST" class="modal-dialog" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Hapus histori</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="modal-title">Anda yakin Ingin Menghapus histori ini?</h4>
            <input type="hidden" name="id_histori" id="did_histori">
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button class="btn btn-outline-success" data-dismiss="modal">Batal</button>
              <button type="submit" name="delete-histori" class="btn btn-outline-danger">Hapus</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </form>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <?php include $backurl . 'admin/config/modal.php'; ?>
    <?php include $backurl . 'config/site/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <?php include $backurl . 'config/site/script.php'; ?>
  <!-- page script -->
  <script>
    $(function() {
      var fid_barang, button_set,
        host = "<?= $df['home'] ?>";
      var table_histori = $('#table_histori').DataTable({
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
            "set_tables": "SELECT CONCAT(kd_barang,' - ', nm_mbarang) AS nm_barang, CONCAT(nm_ruangan,' - ', nm_gedung) AS nm_ruangan, id_histori FROM ((((histori JOIN barang) JOIN mbarang) JOIN ruangan) JOIN gedung) WHERE histori.id_barang=barang.id_barang AND barang.id_mbarang=mbarang.id_mbarang AND histori.id_ruangan=ruangan.id_ruangan AND ruangan.id_gedung=gedung.id_gedung",
            "query": true
          },
          "type": "POST"
        },
        "columns": [{
          'className': "align-middle",
          "data": "nm_barang",
        }, {
          'className': "align-middle text-center",
          "data": "nm_ruangan",
          "width": "100px",
        }, {
          'className': "align-middle text-center",
          "data": "id_histori",
          "width": "10px",
          "render": function(data, type, row, meta) {
            return '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#data-histori" id_histori="' + data + '"><i class="fa fa-eye"></i></button></div>';
          }
        }],
      });
      $('#table_histori_filter').hide();
      $('#field_histori').keyup(function() {
        table_histori.columns($('#column_histori').val()).search(this.value).draw();
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
        }, {
          'className': "align-middle text-center",
          "width": "10px",
        }, ],
        "order": [
          [0, "desc"]
        ],

      });
      table_histori.on('click', 'button[data-target="#data-histori"]', function() {
        $('#data-histori .overlay').removeClass('invisible');
        let id_histori = $(this).attr('id_histori');
        $.ajax({
          type: "POST",
          url: host + "get-histori.php",
          dataType: "JSON",
          data: {
            'set': 'get_tables',
            'id_histori': id_histori,
          },
          success: function(data) {
            if (data['status'] == 'done') {
              fid_barang = data['id_barang'];
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
              $('#data-histori .btn-group input[name="barcode"]').val(data['kd_barang']);
              let nomortable = 1;
              $(data['hasil']).each(function(index, hasil) {
                let btn = '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="$(\'#did_histori\').val(\'' + id_histori + '\')" data-target="#delete-histori"><i class="fa fa-trash-alt"></i></button><a href="' + host + 'histori/' + id_histori + '" class="btn btn-sm bg-info"><i class="fa fa-edit"></i></a></div>';
                table_dhistori.row.add([nomortable, hasil['nm_ruangan'] + ' - ' + hasil['nm_gedung'], hasil['histori_masuk'], hasil['histori_keluar'], btn]).draw();
                nomortable++;
              });
              $(data['kontrol']).each(function(index, hasil) {
                if (hasil['tipe_kontrol'] == true) {
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-trash-alt"></i></button><button type="button" class="btn btn-sm btn-info" disabled><i class="fa fa-edit"></i></button></div>';
                } else {
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="$(\'#did_kontrol\').val(\'' + hasil['id_kontrol'] + '\')" data-target="#delete-kontrol"><i class="fa fa-trash-alt"></i></button><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#set-kontrol" id_kontrol="' + hasil['id_kontrol'] + '"><i class="fa fa-edit"></i></button></div>';
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


      var table_kontrol = $('#table_kontrol').DataTable({
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
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-trash-alt"></i></button><button type="button" class="btn btn-sm btn-info" disabled><i class="fa fa-edit"></i></button></div>';
                } else {
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="$(\'#did_kontrol\').val(\'' + hasil['id_kontrol'] + '\')" data-target="#delete-kontrol"><i class="fa fa-trash-alt"></i></button><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#set-kontrol" id_kontrol="' + hasil['id_kontrol'] + '"><i class="fa fa-edit"></i></button></div>';
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
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-trash-alt"></i></button><button type="button" class="btn btn-sm btn-info" disabled><i class="fa fa-edit"></i></button></div>';
                } else {
                  button_set = '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="$(\'#did_kontrol\').val(\'' + hasil['id_kontrol'] + '\')" data-target="#delete-kontrol"><i class="fa fa-trash-alt"></i></button><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#set-kontrol" id_kontrol="' + hasil['id_kontrol'] + '"><i class="fa fa-edit"></i></button></div>';
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
    });
  </script>
</body>

</html>