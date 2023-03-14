<?php
$backurl = './';
require_once($backurl . 'config/conn.php');
require_once($backurl . 'config/function.php');
$pset = array('title' => 'Log-In');

if (isset($_POST["login"])) {
  $username = anti_injection($conn, $_POST["username"]);
  $pass     = anti_injection($conn, md5($_POST["password"]));
  if (!$username or !$pass) {
    $_SESSION['notifikasi'] = 'NOT01';
  } else {
    $login = mysqli_query($conn, "SELECT * FROM login WHERE username LIKE '$username' AND password LIKE '$pass'");
    $ketemu = mysqli_num_rows($login);
    if ($ketemu > 0) {
      $r = mysqli_fetch_assoc($login);
      $_SESSION["username"] = $username;
      $_SESSION["password"] = $pass;
      $_SESSION["id_user"] = $r['id_user'];
      $_SESSION["nm_user"] = $r['nm_user'];
      $_SESSION["akses"] = $r['akses'];
      $_SESSION["foto_user"] = '-';
      if ($r["akses"] == 'admin') {
        header('location:./admin/');
      } else if ($r["akses"] == 'staff') {
        header('location:./staff/');
      } else if ($r["akses"] == 'user') {
        header('location:./user/');
      } else {
        header('location:./error/');
      }
    } else {
      $_SESSION['notifikasi'] = 'NOT01';
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <?php include $backurl . 'config/site/head.php'; ?>
</head>

<body class="hold-transition login-page bg-success">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?= $df['host']; ?>" class="text-light"><b>Sistem Inventaris</b><br>Universitas Ibnu Sina</a>
    </div>
    <?php notifikasi('in'); ?>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <form action="" method="POST" autocomplete="off">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 offset-md-8">
              <button type="submit" name="login" class="btn btn-success btn-block">Masuk</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
    </div>
    <!-- /.login-box -->
    <?php include $backurl . 'config/site/script.php'; ?>
</body>

</html>