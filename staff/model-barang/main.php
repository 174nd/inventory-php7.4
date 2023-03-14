<?php
$backurl = '../../';
require_once($backurl . 'staff/config/settings.php');
$pset = array(
  'title' => 'Model Barang',
  'content' => 'Model Barang',
  'breadcrumb' => array(
    'Model Barang' => 'active',
  ),
);

$setSidebar = activedSidebar($setSidebar, 'Model Barang');

if (isset($_GET['id_mbarang'])) {
  $cekdata = mysqli_query($conn, "SELECT * FROM mbarang WHERE id_mbarang='$_GET[id_mbarang]'");
  $ada = mysqli_fetch_assoc($cekdata);
  if (mysqli_num_rows($cekdata) > 0) {
    $isiVal = [
      'nm_mbarang' => $ada['nm_mbarang'],
      'id_asset' => $ada['id_asset'],
      'foto_mbarang' => ($ada['foto_mbarang'] != '') ? $ada['foto_mbarang'] : 'Choose file',
    ];
    $pset = [
      'title' => 'Update Model Barang',
      'content' => 'Update Model Barang',
      'breadcrumb' => [
        'Dashboard' => $df['home'],
        'Model Barang' => $df['home'] . 'model-barang/',
        'Update' => 'active',
      ],
    ];

    if (isset($_POST["Simpan"])) {
      $_POST = setData($_POST);
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mbarang WHERE nm_mbarang='$_POST[nm_mbarang]' AND id_mbarang!='$_GET[id_mbarang]'")) > 0) {
        $_SESSION['duplikasi'] = 'Nama Model Barang';
        $isiVal = [
          'nm_mbarang' =>  $_POST['nm_mbarang'],
          'id_asset' =>  $_POST['id_asset'],
          'foto_mbarang' =>  $ada['foto_mbarang'],
        ];
      } else {
        $upFile = uploadFile($_FILES['foto_mbarang'], ['jpg', 'jpeg', 'png'], $backurl . "uploads/model-barang", '', $isiVal['foto_mbarang']);
        if ($upFile != 'Wrong Extension') {
          $set = [
            'nm_mbarang' =>  $_POST['nm_mbarang'],
            'id_asset' =>  $_POST['id_asset'],
            'foto_mbarang' =>  $upFile,
          ];

          $query = setUpdate($set, 'mbarang', ['id_mbarang' => $_GET['id_mbarang']]);
          if (!$query) {
            $_SESSION['notifikasi'] = 'NOT02';
          } else {
            $_SESSION['notifikasi'] = 'NOT04';
            header("location:" . $df['home'] . "model-barang/");
            exit();
          }
        } else {
          $_SESSION['notifikasi'] = 'NOT05';
          $isiVal = [
            'nm_mbarang' =>  $_POST['nm_mbarang'],
            'id_asset' =>  $_POST['id_asset'],
            'foto_mbarang' =>  $ada['foto_mbarang'],
          ];
        }
      }
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT02';
    header("location:" . $df['home'] . "model-barang/");
    exit();
  }
} else {
  $isiVal = [
    'nm_mbarang' => '',
    'id_asset' => '',
    'foto_mbarang' => 'Choose file',
  ];
  if (isset($_POST["Simpan"])) {
    $_POST = setData($_POST);
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mbarang WHERE nm_mbarang='$_POST[nm_mbarang]'")) > 0) {
      $_SESSION['duplikasi'] = 'Nama Model Barang';
      $isiVal = [
        'nm_mbarang' =>  $_POST['nm_mbarang'],
        'id_asset' =>  $_POST['id_asset'],
        'foto_mbarang' => 'Choose file',
      ];
    } else {
      $upFile = uploadFile($_FILES['foto_mbarang'], ['jpg', 'jpeg', 'png'], $backurl . "uploads/model-barang");
      if ($upFile != 'Wrong Extension') {
        $set = [
          'nm_mbarang' =>  $_POST['nm_mbarang'],
          'id_asset' =>  $_POST['id_asset'],
          'foto_mbarang' =>  $upFile,
        ];
        $query = setInsert($set, 'mbarang');
        if (!$query) {
          $_SESSION['notifikasi'] = 'NOT02';
        } else {
          $_SESSION['notifikasi'] = 'NOT03';
        }
      } else {
        $_SESSION['notifikasi'] = 'NOT05';
        $isiVal = [
          'nm_mbarang' =>  $_POST['nm_mbarang'],
          'id_asset' =>  $_POST['id_asset'],
          'foto_mbarang' => 'Choose file',
        ];
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
                      <li class="list-group-item pt-0" style="border-top: 0;">
                        <div class="input-group">
                          <div class="row w-100 ml-0 mr-0">
                            <div class="col-md-12 mb-2">
                              <label class="float-right" for="nm_mbarang">Nama Model Barang</label>
                              <input type="text" name="nm_mbarang" class="form-control" id="nm_mbarang" placeholder="Nama Model Barang" value="<?= $isiVal['nm_mbarang']; ?>" required>
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
                                  <label class="float-right" for="id_asset">Asset</label>
                                </div>
                                <div class="col-12">
                                  <select name="id_asset" id="id_asset" class="form-control custom-select select2" required>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM asset ORDER BY nm_asset ASC");
                                    for ($i = 1; $Data = mysqli_fetch_array($sql); $i++) { ?>
                                      <option value="<?= $Data['id_asset']; ?>" <?= cekSama($isiVal['id_asset'], $Data['id_asset']); ?>><?= $Data['nm_asset']; ?></option>
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
                              <label class="float-right" for="foto_mbarang">Foto Pegawai</label>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" name="foto_mbarang" class="custom-file-input" id="foto_mbarang">
                                  <label class="custom-file-label" for="foto_mbarang"><?= $isiVal['foto_mbarang']; ?></label>
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
                      <div class="col-md-12 mb-2">
                        <input type="text" class="form-control" placeholder="Cari Data" id="field_mbarang">
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="table_mbarang" class="table table-bordered table-hover" style="min-width: 400px;">
                        <thead>
                          <tr>
                            <th>Nama Model Barang</th>
                            <th>Asset</th>
                            <th style="width: 50px;">Act</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM mbarang JOIN asset WHERE mbarang.id_asset=asset.id_asset");
                          for ($i = 1; $Data = mysqli_fetch_assoc($sql); $i++) { ?>
                            <tr>
                              <td class="align-middle"><?= $Data['nm_mbarang']; ?></td>
                              <td class="align-middle text-center"><?= $Data['nm_asset']; ?></td>
                              <td class="align-middle text-center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="$('#did_mbarang').val('<?= $Data['id_mbarang']; ?>')" data-target="#delete-mbarang">
                                    <i class="fa fa-trash-alt"></i>
                                  </button>
                                  <a href="<?= $df['home'] . 'model-barang/' . $Data['id_mbarang']; ?>" class="btn btn-sm bg-info"><i class="fa fa-edit"></i></a>
                                </div>
                              </td>
                            </tr>
                          <?php } ?>
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
      var table_mbarang = $('#table_mbarang').DataTable({
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
            "set_tables": "SELECT nm_mbarang, nm_asset, id_mbarang FROM mbarang JOIN asset WHERE mbarang.id_asset=asset.id_asset",
            "query": true
          },
          "type": "POST"
        },
        "columns": [{
          'className': "align-middle",
          "data": "nm_mbarang",
        }, {
          'className': "align-middle text-center",
          "data": "nm_asset",
          "width": "70px",
        }, {
          'className': "align-middle text-center",
          "data": "id_mbarang",
          "width": "10px",
          "render": function(data, type, row, meta) {
            return '<div class="btn-group"><a href="' + host + 'model-barang/' + data + '" class="btn btn-sm bg-info"><i class="fa fa-edit"></i></a></div>';
          }
        }],
      });
      $('#table_mbarang_filter').hide();
      $('#field_mbarang').keyup(function() {
        table_mbarang.columns(0).search(this.value).draw();
      });
    });
  </script>
</body>

</html>