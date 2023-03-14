<?php
require_once($backurl . 'config/conn.php');
require_once($backurl . 'config/function.php');
$df['home'] = $df['host'] . 'admin/';
kicked("admin");

$setSidebar = array(
  'Dashboard' => array('fas fa-window-restore', $df['home']),
  'Histori' => array('fas fa-history', $df['home'] . 'histori/'),
  'Barang' => array('fas fa-box-open', $df['home'] . 'barang/'),
  'Model Barang' => array('fas fa-boxes', $df['home'] . 'model-barang/'),
  'Asset' => array('fas fa-truck-loading', $df['home'] . 'asset/'),
  'Ruangan' => array('fas fa-person-booth', $df['home'] . 'ruangan/'),
  'Gedung' => array('fas fa-city', $df['home'] . 'gedung/'),
  'User' => array('fas fa-user', $df['home'] . 'user/'),
);
