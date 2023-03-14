/*Table structure for table `asset` */



DROP TABLE IF EXISTS `asset`;



CREATE TABLE `asset` (
  `id_asset` int(11) NOT NULL AUTO_INCREMENT,
  `nm_asset` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_asset`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



/*Data for the table `asset` */



insert  into `asset`(`id_asset`,`nm_asset`) values (2,'Meja');



/*Table structure for table `barang` */



DROP TABLE IF EXISTS `barang`;



CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `kd_barang` varchar(100) DEFAULT NULL,
  `id_mbarang` int(11) DEFAULT NULL,
  `ns_barang` varchar(150) DEFAULT NULL,
  `barang_masuk` date DEFAULT NULL,
  `barang_keluar` date DEFAULT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



/*Data for the table `barang` */



insert  into `barang`(`id_barang`,`kd_barang`,`id_mbarang`,`ns_barang`,`barang_masuk`,`barang_keluar`) values (2,'004#000013',4,NULL,'2021-04-05',NULL);



/*Table structure for table `gedung` */



DROP TABLE IF EXISTS `gedung`;



CREATE TABLE `gedung` (
  `id_gedung` int(11) NOT NULL AUTO_INCREMENT,
  `nm_gedung` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_gedung`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



/*Data for the table `gedung` */



insert  into `gedung`(`id_gedung`,`nm_gedung`) values (3,'Gedung B'),(4,'Gedung A');



/*Table structure for table `histori` */



DROP TABLE IF EXISTS `histori`;



CREATE TABLE `histori` (
  `id_histori` int(11) NOT NULL AUTO_INCREMENT,
  `id_ruangan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `histori_masuk` date DEFAULT NULL,
  `histori_keluar` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_histori`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



/*Data for the table `histori` */



insert  into `histori`(`id_histori`,`id_ruangan`,`id_barang`,`histori_masuk`,`histori_keluar`,`id_user`) values (1,2,2,'2021-04-05','2021-04-25',1);



/*Table structure for table `kontrol` */



DROP TABLE IF EXISTS `kontrol`;



CREATE TABLE `kontrol` (
  `id_kontrol` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `tgl_kontrol` date DEFAULT NULL,
  `stt_kontrol` enum('baik','rusak') DEFAULT NULL,
  PRIMARY KEY (`id_kontrol`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



/*Data for the table `kontrol` */



insert  into `kontrol`(`id_kontrol`,`id_user`,`id_barang`,`tgl_kontrol`,`stt_kontrol`) values (6,1,2,'2021-04-05','baik');



/*Table structure for table `mbarang` */



DROP TABLE IF EXISTS `mbarang`;



CREATE TABLE `mbarang` (
  `id_mbarang` int(11) NOT NULL AUTO_INCREMENT,
  `nm_mbarang` varchar(150) DEFAULT NULL,
  `foto_mbarang` text,
  `id_asset` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mbarang`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



/*Data for the table `mbarang` */



insert  into `mbarang`(`id_mbarang`,`nm_mbarang`,`foto_mbarang`,`id_asset`) values (4,'Meja Kantor L seri 123',NULL,2),(8,'Meja Teller 321',NULL,2);



/*Table structure for table `notifikasi` */



DROP TABLE IF EXISTS `notifikasi`;



CREATE TABLE `notifikasi` (
  `kdn` varchar(10) NOT NULL,
  `jenis` enum('danger','info','warning','success') DEFAULT NULL,
  `dc` enum('alert','callout') DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `head` text,
  `isi` text,
  PRIMARY KEY (`kdn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/*Data for the table `notifikasi` */



insert  into `notifikasi`(`kdn`,`jenis`,`dc`,`icon`,`head`,`isi`) values ('NOT01','danger','alert','icon fas fa-exclamation-triangle','Log-In Gagal!','Username / Password Salah!'),('NOT02','danger','alert','icon fas fa-exclamation-triangle','Data Gagal di Input!','Ada kesalahan pada query, Silahkan cek lagi!!'),('NOT03','success','alert','icon fas fa-check','Data Berhasil di Input!','Data berhasil diinput kedalam Database!'),('NOT04','success','alert','icon fas fa-check','Data Berhasil di Ubah!','Data berhasil Diubah dari Database!'),('NOT05','warning','alert','icon fas fa-exclamation-triangle','Data Berhasil di Hapus!','Data berhasil Dibapus dari Database!'),('NOT06','warning','alert','icon fas fa-exclamation-triangle','Warning!','Masukan File!!'),('NOT07','danger','alert','icon fas fa-exclamation-triangle','Warning!','Esktensi File Tidak diperbolehkan!!'),('NOT08','danger','alert','icon fas fa-exclamation-triangle','Kesalahan!','Password yang Anda Masukan Salah!'),('NOT09','danger','alert','icon fas fa-exclamation-triangle','Kesalahan!','Password Baru Berbeda / Tidak Sama!'),('NOT11','warning','alert','icon fas fa-exclamation-triangle','Warning!','Username Telah Digunakan!');



/*Table structure for table `ruangan` */



DROP TABLE IF EXISTS `ruangan`;



CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL AUTO_INCREMENT,
  `id_gedung` int(11) DEFAULT NULL,
  `nm_ruangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



/*Data for the table `ruangan` */



insert  into `ruangan`(`id_ruangan`,`id_gedung`,`nm_ruangan`) values (2,4,'Ruang A101'),(3,3,'Ruang B301');



/*Table structure for table `user` */



DROP TABLE IF EXISTS `user`;



CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nm_user` varchar(150) DEFAULT NULL,
  `foto_user` text,
  `usrn` varchar(100) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `akses` enum('admin','staff','user') DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



/*Data for the table `user` */



insert  into `user`(`id_user`,`nm_user`,`foto_user`,`usrn`,`pass`,`akses`) values (1,'admin',NULL,'admin','admin','admin'),(3,'staff',NULL,'staff','staff','staff'),(4,'user',NULL,'user','user','user');



/*Table structure for table `login` */



DROP TABLE IF EXISTS `login`;



/*!50001 DROP VIEW IF EXISTS `login` */;

/*!50001 DROP TABLE IF EXISTS `login` */;


/*!50001 CREATE TABLE  `login`(
 `id_user` int(11) ,
 `username` varchar(100) ,
 `password` varchar(32) ,
 `akses` enum('admin','staff','user') ,
 `nm_user` varchar(150) 
)*/;


/*View structure for view login */



/*!50001 DROP TABLE IF EXISTS `login` */;

/*!50001 DROP VIEW IF EXISTS `login` */;



/*!50001 CREATE VIEW `login` AS (select `user`.`id_user` AS `id_user`,`user`.`usrn` AS `username`,md5(`user`.`pass`) AS `password`,`user`.`akses` AS `akses`,`user`.`nm_user` AS `nm_user`, `user`.`foto_user` AS `foto_user` from `user`) */;