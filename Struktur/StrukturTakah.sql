-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: takah
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action` (
  `id_action` int(11) NOT NULL AUTO_INCREMENT,
  `nama_action` varchar(20) NOT NULL,
  PRIMARY KEY (`id_action`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `action_disposisi`
--

DROP TABLE IF EXISTS `action_disposisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_disposisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_disposisi` text NOT NULL,
  `id_surat` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_surat` (`id_surat`),
  CONSTRAINT `action_disposisi_ibfk_1` FOREIGN KEY (`id_surat`) REFERENCES `surat_masuk` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3908 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_user`
--

DROP TABLE IF EXISTS `app_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `level` varchar(20) NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `id_seksi` int(11) NOT NULL,
  `dms_user` varchar(100) DEFAULT NULL,
  `dms_password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_seksi` (`id_seksi`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bar_chart`
--

DROP TABLE IF EXISTS `bar_chart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bar_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` date NOT NULL,
  `fillColor` varchar(50) NOT NULL,
  `strokeColor` varchar(50) NOT NULL,
  `pointColor` varchar(50) NOT NULL,
  `pointStrokeColor` varchar(50) NOT NULL,
  `pointHighlightFill` varchar(50) NOT NULL,
  `pointHighlightStroke` varchar(50) NOT NULL,
  `Y1` int(11) NOT NULL,
  `Y2` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kd_instansi` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=457 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bup`
--

DROP TABLE IF EXISTS `bup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(50) NOT NULL,
  `instansi` varchar(10) NOT NULL,
  `tmt` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keterangan` text,
  `tgl_sk` date DEFAULT NULL,
  `nomor_sk` varchar(200) DEFAULT NULL,
  `nip_lama` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `bup_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5864 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cpns`
--

DROP TABLE IF EXISTS `cpns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cpns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instansi` varchar(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `no_sk` varchar(100) NOT NULL,
  `tgl_sk` date NOT NULL,
  `tmt` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `cpns_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9601 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dms_nip`
--

DROP TABLE IF EXISTS `dms_nip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_nip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `prascanning` varchar(1) DEFAULT NULL,
  `scanning` varchar(1) DEFAULT NULL,
  `id_app_user` int(11) NOT NULL,
  `pradate` datetime DEFAULT NULL,
  `scandate` datetime DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `kode_instansi` varchar(10) NOT NULL,
  `nama_instansi` varchar(200) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nama` varchar(200) NOT NULL,
  `id_pelaksana` int(11) NOT NULL,
  `uuid` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_app_user` (`id_app_user`),
  KEY `id_pelaksana` (`id_pelaksana`),
  KEY `nip` (`nip`),
  CONSTRAINT `dms_nip_ibfk_1` FOREIGN KEY (`id_app_user`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1720 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dms_scan`
--

DROP TABLE IF EXISTS `dms_scan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_scan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dms_nip` int(11) NOT NULL,
  `path` varchar(200) NOT NULL,
  `jenis_doc` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_doc` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_dms_nip` (`id_dms_nip`),
  CONSTRAINT `dms_scan_ibfk_1` FOREIGN KEY (`id_dms_nip`) REFERENCES `dms_nip` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=138051 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `formulir_pinjam`
--

DROP TABLE IF EXISTS `formulir_pinjam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formulir_pinjam` (
  `telp` varchar(15) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field1` int(11) DEFAULT NULL,
  `field2` int(11) DEFAULT NULL,
  `field3` int(11) DEFAULT NULL,
  `field4` int(11) DEFAULT NULL,
  `field5` int(11) DEFAULT NULL,
  `field6` int(11) DEFAULT NULL,
  `field7` int(11) DEFAULT NULL,
  `field8` int(11) DEFAULT NULL,
  `field9` int(11) DEFAULT NULL,
  `field10` int(11) DEFAULT NULL,
  `field11` int(11) DEFAULT NULL,
  `field12` int(11) DEFAULT NULL,
  `field13` int(11) DEFAULT NULL,
  `field14` int(11) DEFAULT NULL,
  `field15` int(11) DEFAULT NULL,
  `field16` int(11) DEFAULT NULL,
  `field17` int(11) DEFAULT NULL,
  `field18` int(11) DEFAULT NULL,
  `field19` int(11) DEFAULT NULL,
  `field20` int(11) DEFAULT NULL,
  `field21` int(11) DEFAULT NULL,
  `field22` int(11) DEFAULT NULL,
  `field23` int(11) DEFAULT NULL,
  `field24` int(11) DEFAULT NULL,
  `field25` int(11) DEFAULT NULL,
  `field26` int(11) DEFAULT NULL,
  `field27` int(11) DEFAULT NULL,
  `field28` int(11) DEFAULT NULL,
  `field29` int(11) DEFAULT NULL,
  `field30` int(11) DEFAULT NULL,
  `field31` int(11) DEFAULT NULL,
  `field32` int(11) DEFAULT NULL,
  `field33` int(11) DEFAULT NULL,
  `field34` int(11) DEFAULT NULL,
  `field35` int(11) DEFAULT NULL,
  `field36` int(11) DEFAULT NULL,
  `field37` int(11) DEFAULT NULL,
  `field38` int(11) DEFAULT NULL,
  `field39` int(11) DEFAULT NULL,
  `kode_instansi` int(11) NOT NULL,
  `dari` varchar(5) NOT NULL,
  `nip_pns` varchar(20) NOT NULL,
  `nip_peminjam` varchar(20) NOT NULL,
  `nip_yang_menerima` varchar(20) DEFAULT NULL,
  `nip_mengetahui` varchar(20) NOT NULL,
  `nip_yang_menyerahkan` varchar(20) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_kembali` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `formulir_pinjam_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=698 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hukuman`
--

DROP TABLE IF EXISTS `hukuman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hukuman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instansi` varchar(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `sampai_tgl` date DEFAULT NULL,
  `tmt` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `jenis_hukuman` text,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jenis_statistik`
--

DROP TABLE IF EXISTS `jenis_statistik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_statistik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_statistik` varchar(150) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kantor_bkn`
--

DROP TABLE IF EXISTS `kantor_bkn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kantor_bkn` (
  `kode` varchar(5) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nama_kantor` varchar(500) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kantor_instansi`
--

DROP TABLE IF EXISTS `kantor_instansi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kantor_instansi` (
  `kode_instansi` varchar(50) NOT NULL,
  `nama_instansi` varchar(500) NOT NULL,
  `kode_kantor_wilayah` varchar(10) NOT NULL,
  `nama_wilayah` varchar(500) NOT NULL,
  PRIMARY KEY (`kode_instansi`),
  KEY `kode_kantor_wilayah` (`kode_kantor_wilayah`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `last_login`
--

DROP TABLE IF EXISTS `last_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `last_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app_user` int(11) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_app_user` (`id_app_user`),
  KEY `id_app_user_2` (`id_app_user`),
  CONSTRAINT `last_login_ibfk_1` FOREIGN KEY (`id_app_user`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5347 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `line_chart`
--

DROP TABLE IF EXISTS `line_chart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `line_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL,
  `fillColor` varchar(50) NOT NULL,
  `strokeColor` varchar(50) NOT NULL,
  `pointColor` varchar(50) NOT NULL,
  `pointStrokeColor` varchar(50) NOT NULL,
  `pointHighlightFill` varchar(50) NOT NULL,
  `pointHighlightStroke` varchar(50) NOT NULL,
  `kd_ins` varchar(10) NOT NULL,
  `Q1` int(11) NOT NULL,
  `Q2` int(11) NOT NULL,
  `Q3` int(11) NOT NULL,
  `Q4` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `line_chart_asal`
--

DROP TABLE IF EXISTS `line_chart_asal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `line_chart_asal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL,
  `fillColor` varchar(50) NOT NULL,
  `strokeColor` varchar(50) NOT NULL,
  `pointColor` varchar(50) NOT NULL,
  `pointStrokeColor` varchar(50) NOT NULL,
  `pointHighlightFill` varchar(50) NOT NULL,
  `pointHighlightStroke` varchar(50) NOT NULL,
  `kd_ins` varchar(10) NOT NULL,
  `Q1` int(11) NOT NULL,
  `Q2` int(11) NOT NULL,
  `Q3` int(11) NOT NULL,
  `Q4` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `npkp`
--

DROP TABLE IF EXISTS `npkp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `npkp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `tgl_input` date NOT NULL,
  `kode_instansi` varchar(20) NOT NULL,
  `tmt` date NOT NULL,
  `aksi` varchar(10) NOT NULL,
  `keterangan` text,
  `no_lg` varchar(20) NOT NULL,
  `tgl_lg` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_npkp` varchar(10) DEFAULT NULL,
  `gol_lama_id` varchar(10) NOT NULL,
  `gol_baru_id` varchar(10) NOT NULL,
  `id_pelaksana` int(11) NOT NULL,
  `lokasi_kerja` varchar(20) NOT NULL,
  `jenis_kp` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pelaksana` (`id_pelaksana`),
  CONSTRAINT `npkp_ibfk_1` FOREIGN KEY (`id_pelaksana`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55549 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `online_user`
--

DROP TABLE IF EXISTS `online_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_app_user` (`id_app_user`),
  KEY `id_app_user_2` (`id_app_user`),
  CONSTRAINT `online_user_ibfk_1` FOREIGN KEY (`id_app_user`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5347 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pengalihan`
--

DROP TABLE IF EXISTS `pengalihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengalihan` (
  `nama` varchar(100) NOT NULL,
  `nip` varchar(200) NOT NULL,
  `jabatan` varchar(200) NOT NULL,
  `unit` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pengalihan_pns`
--

DROP TABLE IF EXISTS `pengalihan_pns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengalihan_pns` (
  `nip` varchar(50) NOT NULL,
  `nomor_sk` varchar(200) NOT NULL,
  `tgl_sk` date NOT NULL,
  `kode_instansi` varchar(10) NOT NULL,
  KEY `nip` (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permintaan_takah`
--

DROP TABLE IF EXISTS `permintaan_takah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permintaan_takah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `ins_lama` varchar(20) DEFAULT NULL,
  `ins_baru` varchar(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `tmt_pi` date DEFAULT NULL,
  `sk_bkn` varchar(50) DEFAULT NULL,
  `ket` text NOT NULL,
  `data_pi` tinyint(5) DEFAULT NULL,
  `fisik_takah` tinyint(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pie_chart`
--

DROP TABLE IF EXISTS `pie_chart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pie_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `highlight` varchar(10) NOT NULL,
  `label` varchar(150) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kd_instansi` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pwk`
--

DROP TABLE IF EXISTS `pwk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pwk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instansi_asal` varchar(10) NOT NULL,
  `instansi_tujuan` varchar(10) NOT NULL,
  `tmt` date NOT NULL,
  `nip` varchar(100) NOT NULL,
  `tgl_sk` date NOT NULL,
  `no_sk` varchar(100) NOT NULL,
  `keterangan` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `pwk_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11507 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rekon`
--

DROP TABLE IF EXISTS `rekon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rekon` (
  `id` int(11) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statistik_data`
--

DROP TABLE IF EXISTS `statistik_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistik_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis1` int(11) NOT NULL,
  `jumlah1` int(11) NOT NULL,
  `id_jenis2` int(11) NOT NULL,
  `jumlah2` int(11) NOT NULL,
  `id_jenis3` int(11) NOT NULL,
  `jumlah3` int(11) NOT NULL,
  `id_jenis4` int(11) NOT NULL,
  `jumlah4` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_jenis5` int(11) NOT NULL,
  `jumlah5` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `surat_masuk`
--

DROP TABLE IF EXISTS `surat_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_terima` date NOT NULL,
  `nomor_surat` varchar(150) NOT NULL,
  `tgl_surat` date NOT NULL,
  `perihal` text,
  `keterangan` text,
  `nip` varchar(20) NOT NULL,
  `kode_instansi` varchar(25) NOT NULL,
  `id_pengirim` int(11) NOT NULL,
  `id_penerima` int(11) NOT NULL,
  `jumlah_surat` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_penerima` int(11) DEFAULT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_penerima` (`id_penerima`),
  KEY `id_pengirim` (`id_pengirim`),
  CONSTRAINT `surat_masuk_ibfk_1` FOREIGN KEY (`id_pengirim`) REFERENCES `app_user` (`id`),
  CONSTRAINT `surat_masuk_ibfk_2` FOREIGN KEY (`id_penerima`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2918 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-06 13:57:32
