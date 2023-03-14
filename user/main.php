<?php
$backurl = '../';
require_once($backurl . 'user/config/settings.php');
$pset = array(
  'title' => 'Dashboard',
  'content' => 'Dashboard',
  'breadcrumb' => array(
    'Dashboard' => 'active',
  ),
);

if (isset($_POST['u-password'])) {
  $pass = md5($_POST['pass_lama']);
  $cek = mysqli_query($conn, "SELECT * FROM login WHERE username LIKE '$_SESSION[username]' AND password LIKE '$pass'");
  $ketemu = mysqli_num_rows($cek);
  if ($ketemu > 0) {
    if ($_POST['pass_baru1'] == $_POST["pass_baru2"]) {
      $set = array(
        'pass' => $_POST['pass_baru1'],
      );
      $val = array(
        'id_user' => $_SESSION['id_user'],
        'pass' => $_POST['pass_lama'],
      );
      $query = setUpdate($set, 'user', $val);
      if (!$query) {
        $_SESSION['notifikasi'] = 'NOT02';
      } else {
        $_SESSION["password"] = md5($_POST['pass_baru1']);
        $_SESSION['notifikasi'] = 'NOT04';
      }
    } else {
      $_SESSION['notifikasi'] = 'NOT08';
    }
  } else {
    $_SESSION['notifikasi'] = 'NOT07';
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <?php include $backurl . 'config/site/head.php'; ?>
</head>

<body class="hold-transition layout-top-nav text-sm">
  <div class="wrapper">
    <?php include $backurl . 'user/config/header.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php include $backurl . 'user/config/content-header.php'; ?>

      <!-- Main content -->
      <div class="content">
        <div class="container">
          <!-- Main row -->
          <div class="row">

            <section class="col-lg-6 connectedSortable">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="text-center w-100 mb-0">Statistik Gedung</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <div id="statistik-gedung" style="min-width: 350px;height:300px;"></div>
                  </div>
                </div>
              </div>
            </section>

            <section class="col-lg-6 connectedSortable">
              <div class="card">
                <div class="card-body bg-primary">
                  <button class="btn btn-block btn-outline-light" data-toggle="modal" data-target="#scan-barcode">Scan Barcode</button>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.Scan Barcode -->

              <div class="card card-primary">
                <div class="card-header">
                  <h5 class="text-center w-100 mb-0">Print Surat</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 mb-3">
                      <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#surat-peminjaman">Surat Peminjaman</button>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#surat-pengembalian">Surat Pengembalian</button>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.Print Surat -->


              <!-- /.Kartu Kontrol -->
            </section>
          </div>
          <!-- /.row (main row) -->


        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->





    <form class="modal fade" id="scan-barcode" autocomplete="off">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Scan Barcode</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item pt-0" style="border-top: 0;">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12 mb-2 d-flex justify-content-center">
                      <video id="preview" style="object-fit: cover; width: 300px; height: 300px;" paus></video>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12 mb-2">
                      <label class="float-right" for="pilih_kamera">Kamera</label>
                      <select name="pilih_kamera" id="pilih_kamera" class="form-control custom-select">
                      </select>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item pb-0" style="border-bottom: 0;" id="div_kas_transaksi">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12">
                      <input type="text" name="kd_barang" id="kd_barang" class="form-control" placeholder="Kode Barang">
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button type="button" name="cari-barcode" class="btn btn-outline-primary">Simpan</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </form>
    <!-- /.modal -->

    <div class="modal fade" id="data-histori">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Data Barang</h4>
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
              <li class="list-group-item px-0" style="border-top: 0; border-bottom: 0;">
                <div class="table-responsive">
                  <table id="table_kontrol" class="table table-bordered table-hover" style="min-width: 300px; width:100%;">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
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
    <form method="POST" action="<?= $df['home'] . 'export/kartu-kontrol.php' ?>" target="blank" class="modal fade" id="cetak-kontrol" autocomplete="off">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Cetak Kartu Kontrol</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row w-100 ml-0 mr-0">
              <div class="col-md-9">
                <div class="row">
                  <div class="col-12">
                    <label class="float-right" for="id_ruangan_kontrol">Ruangan</label>
                  </div>
                  <div class="col-12">
                    <select name="id_ruangan_kontrol" id="id_ruangan_kontrol" class="form-control custom-select select2" required>
                      <?php
                      $sql = mysqli_query($conn, "SELECT * FROM ruangan JOIN gedung WHERE ruangan.id_gedung=gedung.id_gedung ORDER BY ruangan.nm_ruangan ASC");
                      for ($i = 1; $Data = mysqli_fetch_array($sql); $i++) { ?>
                        <option value="<?= $Data['id_ruangan']; ?>"><?= $Data['nm_ruangan'] . ' - ' . $Data['nm_gedung']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mt-sm-0 mt-2">
                <label class="float-right" for="thn_kontrol">Tahun Kontrol</label>
                <div class="input-group">
                  <input type="text" name="thn_kontrol" id="thn_kontrol" class="form-control myyearpicker" placeholder="Thn" required>
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button type="submit" name="print" class="btn btn-outline-primary">Cetak Kartu Kontrol</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </form>
    <!-- /.modal -->

    <form method="POST" action="<?= $df['home'] . 'export/surat-pinjaman.php' ?>" target="blank" class="modal fade" id="surat-peminjaman" autocomplete="off">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Surat Peminjaman</h4>
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
                      <label class="float-right" for="tujuan_surat">Tujuan Surat</label>
                      <input type="text" name="tujuan_surat" id="tujuan_surat" class="form-control" placeholder="Tujuan Surat">
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12 mb-2">
                      <label class="float-right" for="nm_pengaju">Nama Pengaju</label>
                      <input type="text" name="nm_pengaju" id="nm_pengaju" class="form-control" placeholder="Nama Pengaju">
                      </select>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item pb-0" style="border-bottom: 0;" id="div_kas_transaksi">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12">
                      <label class="float-right" for="nm_alat">Nama Alat</label>
                      <input type="text" name="nm_alat" id="nm_alat" class="form-control" placeholder="Nama Alat">
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button type="submit" name="print" class="btn btn-outline-primary">Print Surat</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </form>
    <!-- /.modal -->

    <form method="POST" action="<?= $df['home'] . 'export/surat-pinjaman.php' ?>" target="blank" class="modal fade" id="surat-pengembalian" autocomplete="off">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="overlay d-flex justify-content-center align-items-center invisible">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">Surat Pengembalian</h4>
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
                      <label class="float-right" for="tujuan_surat">Tujuan Surat</label>
                      <input type="text" name="tujuan_surat" id="tujuan_surat" class="form-control" placeholder="Tujuan Surat">
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12 mb-2">
                      <label class="float-right" for="nm_pengaju">Nama Pengaju</label>
                      <input type="text" name="nm_pengaju" id="nm_pengaju" class="form-control" placeholder="Nama Pengaju">
                      </select>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item pb-0" style="border-bottom: 0;" id="div_kas_transaksi">
                <div class="input-group">
                  <div class="row w-100 ml-0 mr-0">
                    <div class="col-md-12">
                      <label class="float-right" for="nm_alat">Nama Alat</label>
                      <input type="text" name="nm_alat" id="nm_alat" class="form-control" placeholder="Nama Alat">
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <div class="btn-group btn-block">
              <button type="submit" name="print" class="btn btn-outline-primary">Print Surat</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </form>
    <!-- /.modal -->
    <?php include $backurl . 'user/config/modal.php'; ?>
    <?php include $backurl . 'config/site/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <?php include $backurl . 'config/site/script.php'; ?>
  <!-- page script -->
  <script>
    $(function() {
      var scanner, table_kontrol, fid_barang, button_set,
        host = "<?= $df['home'] ?>";
      $('#scan-barcode').on('shown.bs.modal', function() {
        $('#scan-barcode .overlay').removeClass('invisible');
        scanner = new Instascan.Scanner({
          video: document.getElementById('preview'),
          mirror: false,
        }).addListener('scan', function(content) {
          $('#scan-barcode #kd_barang').val(content);
          $('#scan-barcode button[name="cari-barcode"]').click();
        });

        navigator.mediaDevices.getUserMedia({
          video: true,
          audio: false
        }).then(function success(stream) {
          Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
              var pilih_kamera = document.getElementById("pilih_kamera");
              Instascan.Camera.getCameras().then(function(cameras) {
                if (pilih_kamera.options.length == 0) {
                  cameras.forEach(function(value, index) {
                    var option = document.createElement("option");
                    option.text = value['name'];
                    option.value = index;
                    pilih_kamera.add(option, pilih_kamera[index]);
                  });
                }


                scanner.start(cameras[pilih_kamera.value]);

                pilih_kamera.removeEventListener("change", function() {});
                pilih_kamera.addEventListener("change", function() {
                  scanner.stop();
                  scanner.start(cameras[this.value]);
                });
              });

              $('#scan-barcode .overlay').addClass('invisible');
            } else {
              console.error('No cameras found.');
              alert('No cameras found.');
            }
          }).catch(function(e) {
            alert(e);
          })
        }).catch(function(err) {
          alert(err.name);
        });

      }).on("hidden.bs.modal", function() {
        scanner.stop();
      });

      var table_dhistori = $('#table_dhistori').DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'ordering': true,
        bAutoWidth: false,
        'createdRow': function(row, data, dataIndex) {
          $(row).find('td:eq(0)').addClass('text-center');
          $(row).find('td:eq(2)').addClass('text-center');
          $(row).find('td:eq(3)').addClass('text-center');
          $(row).find('td:eq(0)').addClass('align-middle');
          $(row).find('td:eq(1)').addClass('align-middle');
          $(row).find('td:eq(2)').addClass('align-middle');
          $(row).find('td:eq(3)').addClass('align-middle');
        },
        "columnDefs": [{
          "width": "10px",
          "targets": 0,
        }, {
          "width": "100px",
          "targets": 2,
        }, {
          "width": "100px",
          "targets": 3,
        }],
        "order": [
          [0, "desc"]
        ],

      });
      $('#scan-barcode button[name="cari-barcode"]').click(function() {
        $('#data-histori').modal('show');
        $('#data-histori .overlay').removeClass('invisible');
        let kd_barang = $('#scan-barcode #kd_barang').val();
        console.log(kd_barang);
        $.ajax({
          type: "POST",
          url: host + "get-barang.php",
          dataType: "JSON",
          data: {
            'set': 'get_tables_dashboard',
            'kd_barang': kd_barang,
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
                table_dhistori.row.add([nomortable, hasil['nm_ruangan'] + ' - ' + hasil['nm_gedung'], hasil['histori_masuk'], hasil['histori_keluar']]).draw();
                nomortable++;
              });
              $(data['kontrol']).each(function(index, hasil) {
                table_kontrol.row.add([hasil['tgl_kontrol'], hasil['stt_kontrol']]).draw();
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
                table_kontrol.row.add([hasil['tgl_kontrol'], hasil['stt_kontrol']]).draw();
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
                table_kontrol.row.add([hasil['tgl_kontrol'], hasil['stt_kontrol']]).draw();
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


      var data_gedung = [
        <?php
        $sql = mysqli_query($conn, "SELECT COUNT(histori.id_histori) AS banyak, gedung.nm_gedung FROM ((gedung JOIN ruangan) JOIN histori) WHERE gedung.id_gedung=ruangan.id_gedung AND ruangan.id_ruangan=histori.id_ruangan GROUP BY gedung.id_gedung ORDER BY gedung.nm_gedung ASC");
        while ($ada = mysqli_fetch_assoc($sql)) {
          $nm_gedung = str_replace(array("\n", "\r"), array("\\n", "\\r"), $ada['nm_gedung']);
          $banyak = str_replace(array("\n", "\r"), array("\\n", "\\r"), $ada['banyak']); ?> {
            data: [<?= "['$nm_gedung', $banyak]" ?>],
            color: "<?= '#' . substr(md5(mt_rand()), 0, 6); ?>",
            label: "<?= $nm_gedung ?>",
          },
        <?php } ?>
      ];
      var barOpt_gedung = {
        series: {
          bars: {
            show: true,
            barWidth: 0.4,
            align: "center"
          }
        },
        xaxis: {
          mode: "categories",
          tickLength: 0
        },
        grid: {
          clickable: true,
          hoverable: true
        },
        tooltip: true,
        legend: false,
        tooltipOpts: {
          content: function(label, xval, yval, flotItem) {
            return "Gedung " + xval + " : " + yval + ' Unit';
          },
        }
      };
      new ResizeSensor($("#statistik-gedung").parent().parent(), function() {
        $.plot($("#statistik-gedung"), data_gedung, barOpt_gedung);
      });
    });
  </script>
</body>

</html>