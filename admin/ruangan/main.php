<?php
$backurl = '../../';
require_once($backurl . 'admin/config/settings.php');
$pset = array(
  'title' => 'Ruangan',
  'content' => 'Ruangan',
  'breadcrumb' => array(
    'Ruangan' => 'active',
  ),
);

$setSidebar = activedSidebar($setSidebar, 'Ruangan');

if (isset($_POST['delete-ruangan'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM ruangan WHERE id_ruangan = '$_POST[id_ruangan]'");
  if (mysqli_num_rows($cekdata) > 0) {
    $ada = mysqli_fetch_assoc($cekdata);
    if (setDelete('ruangan', ['id_ruangan' => $_POST['id_ruangan']])) {
      $_SESSION['notifikasi'] = 'NOT05';
      header("location:" . $df['home'] . "ruangan/");
      exit();
    } else {
      $_SESSION['notifikasi'] = 'NOT02';
      header("location:" . $df['home'] . "ruangan/");
      exit();
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "ruangan/");
    exit();
  }
} else if (isset($_GET['id_ruangan'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM ruangan WHERE id_ruangan='$_GET[id_ruangan]'");
  $ada = mysqli_fetch_assoc($cekdata);
  if (mysqli_num_rows($cekdata) > 0) {
    $isiVal = [
      'id_gedung' => $ada['id_gedung'],
      'nm_ruangan' => $ada['nm_ruangan'],
    ];
    $pset = [
      'title' => 'Update Ruangan',
      'content' => 'Update Ruangan',
      'breadcrumb' => [
        'Dashboard' => $df['home'],
        'Ruangan' => $df['home'] . 'ruangan/',
        'Update' => 'active',
      ],
    ];

    if (isset($_POST["Simpan"])) {
      $_POST = setData($_POST);
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM ruangan WHERE nm_ruangan='$_POST[nm_ruangan]' AND id_ruangan!='$_GET[id_ruangan]'")) > 0) {
        $_SESSION['duplikasi'] = 'Nama Ruangan';
        $isiVal = [
          'id_gedung' =>  $_POST['id_gedung'],
          'nm_ruangan' =>  $_POST['nm_ruangan'],
        ];
      } else {
        $set = [
          'id_gedung' =>  $_POST['id_gedung'],
          'nm_ruangan' =>  $_POST['nm_ruangan'],
        ];

        $query = setUpdate($set, 'ruangan', ['id_ruangan' => $_GET['id_ruangan']]);
        if (!$query) {
          $_SESSION['notifikasi'] = 'NOT02';
        } else {
          $_SESSION['notifikasi'] = 'NOT04';
          header("location:" . $df['home'] . "ruangan/");
          exit();
        }
      }
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "ruangan/");
    exit();
  }
} else {
  $isiVal = [
    'id_gedung' => '',
    'nm_ruangan' => '',
  ];
  if (isset($_POST["Simpan"])) {
    $_POST = setData($_POST);
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM ruangan WHERE nm_ruangan='$_POST[nm_ruangan]'")) > 0) {
      $_SESSION['duplikasi'] = 'Nama Ruangan';
      $isiVal = [
        'id_gedung' =>  $_POST['id_gedung'],
        'nm_ruangan' =>  $_POST['nm_ruangan'],
      ];
    } else {
      $set = [
        'id_gedung' =>  $_POST['id_gedung'],
        'nm_ruangan' =>  $_POST['nm_ruangan'],
      ];
      $query = setInsert($set, 'ruangan');
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
                                  <label class="float-right" for="id_gedung">Nama Gedung</label>
                                </div>
                                <div class="col-12">
                                  <select name="id_gedung" id="id_gedung" class="form-control custom-select select2" required>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM gedung ORDER BY nm_gedung ASC");
                                    for ($i = 1; $Data = mysqli_fetch_array($sql); $i++) { ?>
                                      <option value="<?= $Data['id_gedung']; ?>" <?= cekSama($isiVal['id_gedung'], $Data['id_gedung']); ?>><?= $Data['nm_gedung']; ?></option>
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
                            <div class="col-md-12">
                              <label class="float-right" for="nm_ruangan">Nama Ruangan</label>
                              <input type="text" name="nm_ruangan" class="form-control" id="nm_ruangan" placeholder="Nama Ruangan" value="<?= $isiVal['nm_ruangan']; ?>" required>
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
                        <select id="column_ruangan" class="form-control custom-select">
                          <option value="0">Ruangan</option>
                          <option value="1">Gedung</option>
                        </select>
                      </div>
                      <div class="col-md-8 mb-2">
                        <input type="text" class="form-control" placeholder="Cari Data" id="field_ruangan">
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="table_ruangan" class="table table-bordered table-hover" style="min-width: 400px;">
                        <thead>
                          <tr>
                            <th>Nama Ruangan</th>
                            <th>Gedung</th>
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





    <div class="modal fade" id="delete-ruangan">
      <form method="POST" class="modal-dialog" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Hapus ruangan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="modal-title">Anda yakin Ingin Menghapus ruangan ini?</h4>
            <input type="hidden" name="id_ruangan" id="did_ruangan">
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button class="btn btn-outline-success" data-dismiss="modal">Batal</button>
              <button type="submit" name="delete-ruangan" class="btn btn-outline-danger">Hapus</button>
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
      var host = "<?= $df['home'] ?>";
      var table_ruangan = $('#table_ruangan').DataTable({
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
            "set_tables": "SELECT nm_ruangan, nm_gedung, id_ruangan FROM ruangan JOIN gedung WHERE ruangan.id_gedung=gedung.id_gedung",
            "query": true
          },
          "type": "POST"
        },
        "columns": [{
          'className': "align-middle",
          "data": "nm_ruangan",
        }, {
          'className': "align-middle text-center",
          "data": "nm_gedung",
          "width": "70px",
        }, {
          'className': "align-middle text-center",
          "data": "id_ruangan",
          "width": "50px",
          "render": function(data, type, row, meta) {
            return '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="$(\'#did_ruangan\').val(\'' + data + '\')" data-target="#delete-ruangan"><i class="fa fa-trash-alt"></i></button><a href="' + host + 'ruangan/' + data + '" class="btn btn-sm bg-info"><i class="fa fa-edit"></i></a></div>';
          }
        }],
      });
      $('#table_ruangan_filter').hide();
      $('#field_ruangan').keyup(function() {
        table_ruangan.columns($('#column_ruangan').val()).search(this.value).draw();
      });
    });
  </script>
</body>

</html>