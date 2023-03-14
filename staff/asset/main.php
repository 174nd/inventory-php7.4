<?php
$backurl = '../../';
require_once($backurl . 'staff/config/settings.php');
$pset = array(
  'title' => 'Asset',
  'content' => 'Asset',
  'breadcrumb' => array(
    'Asset' => 'active',
  ),
);

$setSidebar = activedSidebar($setSidebar, 'Asset');

if (isset($_GET['id_asset'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM asset WHERE id_asset='$_GET[id_asset]'");
  $ada = mysqli_fetch_assoc($cekdata);
  if (mysqli_num_rows($cekdata) > 0) {
    $isiVal = [
      'nm_asset' => $ada['nm_asset'],
    ];
    $pset = [
      'title' => 'Update Asset',
      'content' => 'Update Asset',
      'breadcrumb' => [
        'Dashboard' => $df['home'],
        'Asset' => $df['home'] . 'asset/',
        'Update' => 'active',
      ],
    ];

    if (isset($_POST["Simpan"])) {
      $_POST = setData($_POST);
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM asset WHERE nm_asset='$_POST[nm_asset]' AND id_asset!='$_GET[id_asset]'")) > 0) {
        $_SESSION['duplikasi'] = 'Nama Asset';
        $isiVal = [
          'nm_asset' =>  $_POST['nm_asset'],
        ];
      } else {
        $set = [
          'nm_asset' =>  $_POST['nm_asset'],
        ];

        $query = setUpdate($set, 'asset', ['id_asset' => $_GET['id_asset']]);
        if (!$query) {
          $_SESSION['notifikasi'] = 'NOT02';
        } else {
          $_SESSION['notifikasi'] = 'NOT04';
          header("location:" . $df['home'] . "asset/");
          exit();
        }
      }
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "asset/");
    exit();
  }
} else {
  $isiVal = [
    'nm_asset' => '',
  ];
  if (isset($_POST["Simpan"])) {
    $_POST = setData($_POST);
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM asset WHERE nm_asset='$_POST[nm_asset]'")) > 0) {
      $_SESSION['duplikasi'] = 'Nama Asset';
      $isiVal = [
        'nm_asset' =>  $_POST['nm_asset'],
      ];
    } else {
      $set = [
        'nm_asset' =>  $_POST['nm_asset'],
      ];
      $query = setInsert($set, 'asset');
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
                              <label class="float-right" for="nm_asset">Nama Asset</label>
                              <input type="text" name="nm_asset" class="form-control" id="nm_asset" placeholder="Nama Asset" value="<?= $isiVal['nm_asset']; ?>" required>
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
                        <input type="text" class="form-control" placeholder="Cari Data" id="field_asset">
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="table_asset" class="table table-bordered table-hover" style="min-width: 400px;">
                        <thead>
                          <tr>
                            <th>Nama Asset</th>
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



    <?php include $backurl . 'staff/config/modal.php'; ?>
    <?php include $backurl . 'config/site/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <?php include $backurl . 'config/site/script.php'; ?>
  <!-- page script -->
  <script>
    $(function() {
      var host = "<?= $df['home'] ?>";
      var table_asset = $('#table_asset').DataTable({
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
            "set_tables": "asset"
          },
          "type": "POST"
        },
        "columns": [{
          'className': "align-middle",
          "data": "nm_asset",
        }, {
          'className': "align-middle text-center",
          "data": "id_asset",
          "width": "10px",
          "render": function(data, type, row, meta) {
            return '<div class="btn-group"><a href="' + host + 'asset/' + data + '" class="btn btn-sm bg-info"><i class="fa fa-edit"></i></a></div>';
          }
        }],
      });
      $('#table_asset_filter').hide();
      $('#field_asset').keyup(function() {
        table_asset.columns(0).search(this.value).draw();
      });
    });
  </script>
</body>

</html>