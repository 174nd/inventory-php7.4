<?php
$backurl = '../../';
require_once($backurl . 'admin/config/settings.php');
$pset = array(
  'title' => 'Gedung',
  'content' => 'Gedung',
  'breadcrumb' => array(
    'Gedung' => 'active',
  ),
);

$setSidebar = activedSidebar($setSidebar, 'Gedung');

if (isset($_POST['delete-gedung'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM gedung WHERE id_gedung = '$_POST[id_gedung]'");
  if (mysqli_num_rows($cekdata) > 0) {
    $ada = mysqli_fetch_assoc($cekdata);
    if (setDelete('gedung', ['id_gedung' => $_POST['id_gedung']])) {
      $_SESSION['notifikasi'] = 'NOT05';
      header("location:" . $df['home'] . "gedung/");
      exit();
    } else {
      $_SESSION['notifikasi'] = 'NOT02';
      header("location:" . $df['home'] . "gedung/");
      exit();
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "gedung/");
    exit();
  }
} else if (isset($_GET['id_gedung'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM gedung WHERE id_gedung='$_GET[id_gedung]'");
  $ada = mysqli_fetch_assoc($cekdata);
  if (mysqli_num_rows($cekdata) > 0) {
    $isiVal = [
      'nm_gedung' => $ada['nm_gedung'],
    ];
    $pset = [
      'title' => 'Update Gedung',
      'content' => 'Update Gedung',
      'breadcrumb' => [
        'Dashboard' => $df['home'],
        'Gedung' => $df['home'] . 'gedung/',
        'Update' => 'active',
      ],
    ];

    if (isset($_POST["Simpan"])) {
      $_POST = setData($_POST);
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM gedung WHERE nm_gedung='$_POST[nm_gedung]' AND id_gedung!='$_GET[id_gedung]'")) > 0) {
        $_SESSION['duplikasi'] = 'Nama Gedung';
      } else {
        $set = [
          'nm_gedung' =>  $_POST['nm_gedung'],
        ];

        $query = setUpdate($set, 'gedung', ['id_gedung' => $_GET['id_gedung']]);
        if (!$query) {
          $_SESSION['notifikasi'] = 'NOT02';
        } else {
          $_SESSION['notifikasi'] = 'NOT04';
          header("location:" . $df['home'] . "gedung/");
          exit();
        }
      }
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "gedung/");
    exit();
  }
} else {
  $isiVal = [
    'nm_gedung' => '',
  ];
  if (isset($_POST["Simpan"])) {
    $_POST = setData($_POST);
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM gedung WHERE nm_gedung='$_POST[nm_gedung]'")) > 0) {
      $_SESSION['duplikasi'] = 'Nama Gedung';
      $isiVal = [
        'nm_gedung' =>  $_POST['nm_gedung'],
      ];
    } else {
      $set = [
        'nm_gedung' =>  $_POST['nm_gedung'],
      ];
      $query = setInsert($set, 'gedung');
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
                      <li class="list-group-item pt-0 pb-0" style="border-top: 0;border-bottom: 0;">
                        <div class="input-group">
                          <div class="row w-100 ml-0 mr-0">
                            <div class="col-md-12">
                              <label class="float-right" for="nm_gedung">Nama Gedung</label>
                              <input type="text" name="nm_gedung" class="form-control" id="nm_gedung" placeholder="Nama Gedung" value="<?= $isiVal['nm_gedung']; ?>" required>
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
                      <div class="col-md-12 mb-2">
                        <input type="text" class="form-control" placeholder="Cari Data" id="field_gedung">
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="table_gedung" class="table table-bordered table-hover" style="min-width: 400px;">
                        <thead>
                          <tr>
                            <th>Nama Gedung</th>
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





    <div class="modal fade" id="delete-gedung">
      <form method="POST" class="modal-dialog" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Hapus gedung</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="modal-title">Anda yakin Ingin Menghapus gedung ini?</h4>
            <input type="hidden" name="id_gedung" id="did_gedung">
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button class="btn btn-outline-success" data-dismiss="modal">Batal</button>
              <button type="submit" name="delete-gedung" class="btn btn-outline-danger">Hapus</button>
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
      var table_gedung = $('#table_gedung').DataTable({
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
            "set_tables": "gedung"
          },
          "type": "POST"
        },
        "columns": [{
          'className': "align-middle",
          "data": "nm_gedung",
        }, {
          'className': "align-middle text-center",
          "data": "id_gedung",
          "width": "50px",
          "render": function(data, type, row, meta) {
            return '<div class="btn-group"><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="$(\'#did_gedung\').val(\'' + data + '\')" data-target="#delete-gedung"><i class="fa fa-trash-alt"></i></button><a href="' + host + 'gedung/' + data + '" class="btn btn-sm bg-info"><i class="fa fa-edit"></i></a></div>';
          }
        }],
      });
      $('#table_gedung_filter').hide();
      $('#field_gedung').keyup(function() {
        table_gedung.columns(0).search(this.value).draw();
      });
    });
  </script>
</body>

</html>