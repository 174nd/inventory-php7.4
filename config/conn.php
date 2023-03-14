<?php
$db = array(
  'host'   => 'localhost',
  'user'   => 'root',
  'pass'   => '',
  'db'   => 'db_inventaris'
);

$host = 'http://localhost/inventarisX/';
// $host = 'http://192.168.43.140/inventarisX/';
// $host = 'http://inventarisx.test/';

$df = array(
  'host'          => $host,
  'head'          => 'Inventaris Universitas Ibnu Sina',
  'favicon'       => $host . 'dist/img/logo.ico',
  'user-image'    => $host . 'dist/img/user.png',
  'brand-image'   => $host . 'dist/img/logo.png',
);

$conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['db']);
date_default_timezone_set("Asia/Jakarta");
if (mysqli_connect_errno()) {
  echo "Koneksi database gagal : " . mysqli_connect_error();
}
