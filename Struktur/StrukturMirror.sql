-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mirror
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
-- Table structure for table `agama`
--

DROP TABLE IF EXISTS `agama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agama` (
  `AGA_KODAGA` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `AGA_NAMAGA` varchar(15) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eselon`
--

DROP TABLE IF EXISTS `eselon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eselon` (
  `ESE_KODESL` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `ESE_NAMESL` varchar(5) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gaji_pokok`
--

DROP TABLE IF EXISTS `gaji_pokok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gaji_pokok` (
  `GOLONGAN_ID` varchar(2) COLLATE utf8_bin NOT NULL,
  `MKG` tinyint(2) NOT NULL,
  `GAJI_POKOK` int(9) NOT NULL,
  `TAHUN_BUAT` smallint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `golru`
--

DROP TABLE IF EXISTS `golru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `golru` (
  `GOL_KODGOL` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `GOL_GOLNAM` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `GOL_PKTNAM` varchar(30) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `instansi`
--

DROP TABLE IF EXISTS `instansi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instansi` (
  `INS_KODINS` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `INS_NAMINS` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jabfun`
--

DROP TABLE IF EXISTS `jabfun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jabfun` (
  `JBF_KODJAB` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `JBF_NAMJAB` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `JBF_LOWRNK` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `JBF_HIGRNK` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `JBF_USIPEN` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jenis_id_dokumen`
--

DROP TABLE IF EXISTS `jenis_id_dokumen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_id_dokumen` (
  `JDK_JDKKOD` varchar(7) COLLATE utf8_bin DEFAULT NULL,
  `JDK_JDKNAM` varchar(30) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jenis_kp`
--

DROP TABLE IF EXISTS `jenis_kp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_kp` (
  `JKP_JPNKOD` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `JKP_JPNNAMA` varchar(60) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jenis_pengadaan`
--

DROP TABLE IF EXISTS `jenis_pengadaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_pengadaan` (
  `JPG_JPGKOD` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `JPG_JPGNAMA` varchar(60) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jenis_pensiun`
--

DROP TABLE IF EXISTS `jenis_pensiun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_pensiun` (
  `JPN_JPNKOD` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `JPN_JPNNAMA` varchar(35) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jenjab`
--

DROP TABLE IF EXISTS `jenjab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenjab` (
  `JJB_JJBKOD` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `JJB_JJBNAM` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jenpeg`
--

DROP TABLE IF EXISTS `jenpeg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenpeg` (
  `JPG_JPGKOD` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `JPG_JPGNAM` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jsp2cms_pengguna`
--

DROP TABLE IF EXISTS `jsp2cms_pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jsp2cms_pengguna` (
  `ID_PENGGUNA` decimal(22,0) NOT NULL,
  `PENGGUNA` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `SANDI` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID_PENGGUNA`),
  UNIQUE KEY `SYS_C0011087` (`PENGGUNA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kedhuk`
--

DROP TABLE IF EXISTS `kedhuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kedhuk` (
  `KED_KEDKOD` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `KED_KEDNAM` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `label_pengalihan`
--

DROP TABLE IF EXISTS `label_pengalihan`;
/*!50001 DROP VIEW IF EXISTS `label_pengalihan`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `label_pengalihan` AS SELECT 
 1 AS `PNS_NIPBARU`,
 1 AS `PNS_PNSNAM`,
 1 AS `PNS_GLRDPN`,
 1 AS `PNS_GLRBLK`,
 1 AS `PNS_ALAMAT`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lokker`
--

DROP TABLE IF EXISTS `lokker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lokker` (
  `LOK_LOKKOD` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `LOK_LOKNAM` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `LOK_KANREG` varchar(2) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_additional_properties`
--

DROP TABLE IF EXISTS `md_additional_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_additional_properties` (
  `ID` decimal(22,0) NOT NULL,
  `CONNECTION_ID_FK` decimal(22,0) NOT NULL,
  `REF_ID_FK` decimal(22,0) NOT NULL,
  `REF_TYPE` text COLLATE utf8_bin NOT NULL,
  `PROPERTY_ORDER` decimal(22,0) DEFAULT NULL,
  `PROP_KEY` text COLLATE utf8_bin NOT NULL,
  `VALUE` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_ADDITIONAL_PROPERTIES__FK1` (`CONNECTION_ID_FK`),
  CONSTRAINT `MD_ADDITIONAL_PROPERTIES__FK1` FOREIGN KEY (`CONNECTION_ID_FK`) REFERENCES `md_connections` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_applicationfiles`
--

DROP TABLE IF EXISTS `md_applicationfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_applicationfiles` (
  `ID` decimal(22,0) NOT NULL,
  `APPLICATIONS_ID_FK` decimal(22,0) NOT NULL,
  `NAME` varchar(200) COLLATE utf8_bin NOT NULL,
  `URI` text COLLATE utf8_bin NOT NULL,
  `TYPE` varchar(100) COLLATE utf8_bin NOT NULL,
  `STATE` varchar(100) COLLATE utf8_bin NOT NULL,
  `LANGUAGE` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `LOC` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` text COLLATE utf8_bin,
  `UPDATED_ON` datetime DEFAULT NULL,
  `UPDATED_BY` text COLLATE utf8_bin,
  PRIMARY KEY (`ID`),
  KEY `MD_APP_FILE_TYPE_IDX` (`TYPE`,`ID`),
  KEY `MD_STATE_TYPE__ID` (`STATE`,`TYPE`,`ID`),
  KEY `MD_FILE_APP_FK` (`APPLICATIONS_ID_FK`),
  CONSTRAINT `MD_FILE_APP_FK` FOREIGN KEY (`APPLICATIONS_ID_FK`) REFERENCES `md_applications` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_applications`
--

DROP TABLE IF EXISTS `md_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_applications` (
  `ID` decimal(22,0) NOT NULL,
  `NAME` text COLLATE utf8_bin,
  `DESCRIPTION` text COLLATE utf8_bin,
  `BASE_DIR` text COLLATE utf8_bin,
  `OUTPUT_DIR` text COLLATE utf8_bin,
  `BACKUP_DIR` text COLLATE utf8_bin,
  `INPLACE` decimal(22,0) DEFAULT NULL,
  `PROJECT_ID_FK` decimal(22,0) NOT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_APP_PROJ_FK` (`PROJECT_ID_FK`),
  CONSTRAINT `MD_APP_PROJ_FK` FOREIGN KEY (`PROJECT_ID_FK`) REFERENCES `md_projects` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_catalogs`
--

DROP TABLE IF EXISTS `md_catalogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_catalogs` (
  `ID` decimal(22,0) NOT NULL,
  `CONNECTION_ID_FK` decimal(22,0) NOT NULL,
  `CATALOG_NAME` text COLLATE utf8_bin,
  `DUMMY_FLAG` varchar(1) COLLATE utf8_bin DEFAULT 'N',
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_CATALOGS_MD_CONNECTION_FK1` (`CONNECTION_ID_FK`),
  CONSTRAINT `MD_CATALOGS_MD_CONNECTION_FK1` FOREIGN KEY (`CONNECTION_ID_FK`) REFERENCES `md_connections` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_code_regex`
--

DROP TABLE IF EXISTS `md_code_regex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_code_regex` (
  `ID` decimal(22,0) NOT NULL,
  `REGEX` varchar(100) COLLATE utf8_bin NOT NULL,
  `DESCRIPTION` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_columns`
--

DROP TABLE IF EXISTS `md_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_columns` (
  `ID` decimal(22,0) NOT NULL,
  `TABLE_ID_FK` decimal(22,0) NOT NULL,
  `COLUMN_NAME` text COLLATE utf8_bin NOT NULL,
  `COLUMN_ORDER` decimal(22,0) NOT NULL,
  `COLUMN_TYPE` text COLLATE utf8_bin,
  `PRECISION` decimal(22,0) DEFAULT NULL,
  `SCALE` decimal(22,0) DEFAULT NULL,
  `NULLABLE` varchar(1) COLLATE utf8_bin NOT NULL,
  `DEFAULT_VALUE` text COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `DATATYPE_TRANSFORMED_FLAG` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_COLUMNS_MD_TABLES_FK1` (`TABLE_ID_FK`),
  CONSTRAINT `MD_COLUMNS_MD_TABLES_FK1` FOREIGN KEY (`TABLE_ID_FK`) REFERENCES `md_tables` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_connections`
--

DROP TABLE IF EXISTS `md_connections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_connections` (
  `ID` decimal(22,0) NOT NULL,
  `PROJECT_ID_FK` decimal(22,0) NOT NULL,
  `TYPE` text COLLATE utf8_bin,
  `HOST` text COLLATE utf8_bin,
  `PORT` decimal(22,0) DEFAULT NULL,
  `USERNAME` text COLLATE utf8_bin,
  `PASSWORD` text COLLATE utf8_bin,
  `DBURL` text COLLATE utf8_bin,
  `NAME` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `STATUS` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `NUM_CATALOGS` decimal(22,0) DEFAULT NULL,
  `NUM_COLUMNS` decimal(22,0) DEFAULT NULL,
  `NUM_CONSTRAINTS` decimal(22,0) DEFAULT NULL,
  `NUM_GROUPS` decimal(22,0) DEFAULT NULL,
  `NUM_ROLES` decimal(22,0) DEFAULT NULL,
  `NUM_INDEXES` decimal(22,0) DEFAULT NULL,
  `NUM_OTHER_OBJECTS` decimal(22,0) DEFAULT NULL,
  `NUM_PACKAGES` decimal(22,0) DEFAULT NULL,
  `NUM_PRIVILEGES` decimal(22,0) DEFAULT NULL,
  `NUM_SCHEMAS` decimal(22,0) DEFAULT NULL,
  `NUM_SEQUENCES` decimal(22,0) DEFAULT NULL,
  `NUM_STORED_PROGRAMS` decimal(22,0) DEFAULT NULL,
  `NUM_SYNONYMS` decimal(22,0) DEFAULT NULL,
  `NUM_TABLES` decimal(22,0) DEFAULT NULL,
  `NUM_TABLESPACES` decimal(22,0) DEFAULT NULL,
  `NUM_TRIGGERS` decimal(22,0) DEFAULT NULL,
  `NUM_USER_DEFINED_DATA_TYPES` decimal(22,0) DEFAULT NULL,
  `NUM_USERS` decimal(22,0) DEFAULT NULL,
  `NUM_VIEWS` decimal(22,0) DEFAULT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_CONNECTIONS_MD_PROJECT_FK1` (`PROJECT_ID_FK`),
  CONSTRAINT `MD_CONNECTIONS_MD_PROJECT_FK1` FOREIGN KEY (`PROJECT_ID_FK`) REFERENCES `md_projects` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_constraint_details`
--

DROP TABLE IF EXISTS `md_constraint_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_constraint_details` (
  `ID` decimal(22,0) NOT NULL,
  `REF_FLAG` varchar(1) COLLATE utf8_bin DEFAULT 'N',
  `CONSTRAINT_ID_FK` decimal(22,0) NOT NULL,
  `COLUMN_ID_FK` decimal(22,0) DEFAULT NULL,
  `COLUMN_PORTION` decimal(22,0) DEFAULT NULL,
  `CONSTRAINT_TEXT` longtext COLLATE utf8_bin,
  `DETAIL_ORDER` decimal(22,0) NOT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_CONSTRAINT_DETAILS_MD__FK1` (`CONSTRAINT_ID_FK`),
  KEY `MD_CONSTRAINT_DETAILS_MD__FK2` (`COLUMN_ID_FK`),
  CONSTRAINT `MD_CONSTRAINT_DETAILS_MD__FK1` FOREIGN KEY (`CONSTRAINT_ID_FK`) REFERENCES `md_constraints` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MD_CONSTRAINT_DETAILS_MD__FK2` FOREIGN KEY (`COLUMN_ID_FK`) REFERENCES `md_columns` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_constraints`
--

DROP TABLE IF EXISTS `md_constraints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_constraints` (
  `ID` decimal(22,0) NOT NULL,
  `DELETE_CLAUSE` text COLLATE utf8_bin,
  `NAME` text COLLATE utf8_bin,
  `CONSTRAINT_TYPE` text COLLATE utf8_bin,
  `TABLE_ID_FK` decimal(22,0) NOT NULL,
  `REFTABLE_ID_FK` decimal(22,0) DEFAULT NULL,
  `CONSTRAINT_TEXT` longtext COLLATE utf8_bin,
  `LANGUAGE` varchar(40) COLLATE utf8_bin NOT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_CONSTRAINTS_MD_TABLES_FK1` (`TABLE_ID_FK`),
  CONSTRAINT `MD_CONSTRAINTS_MD_TABLES_FK1` FOREIGN KEY (`TABLE_ID_FK`) REFERENCES `md_tables` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_derivatives`
--

DROP TABLE IF EXISTS `md_derivatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_derivatives` (
  `ID` decimal(22,0) NOT NULL,
  `SRC_ID` decimal(22,0) NOT NULL,
  `SRC_TYPE` text COLLATE utf8_bin,
  `DERIVED_ID` decimal(22,0) NOT NULL,
  `DERIVED_TYPE` text COLLATE utf8_bin,
  `DERIVED_CONNECTION_ID_FK` decimal(22,0) NOT NULL,
  `TRANSFORMED` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `ORIGINAL_IDENTIFIER` text COLLATE utf8_bin,
  `NEW_IDENTIFIER` text COLLATE utf8_bin,
  `DERIVED_OBJECT_NAMESPACE` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `DERIVATIVE_REASON` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ENABLED` varchar(1) COLLATE utf8_bin DEFAULT 'Y',
  PRIMARY KEY (`ID`),
  KEY `MD_DERIVATIVES_MD_CONNECT_FK1` (`DERIVED_CONNECTION_ID_FK`),
  CONSTRAINT `MD_DERIVATIVES_MD_CONNECT_FK1` FOREIGN KEY (`DERIVED_CONNECTION_ID_FK`) REFERENCES `md_connections` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_file_artifacts`
--

DROP TABLE IF EXISTS `md_file_artifacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_file_artifacts` (
  `ID` decimal(22,0) NOT NULL,
  `APPLICATIONFILES_ID` decimal(22,0) NOT NULL,
  `PATTERN` text COLLATE utf8_bin,
  `STRING_FOUND` text COLLATE utf8_bin,
  `STRING_REPLACED` text COLLATE utf8_bin,
  `TYPE` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `STATUS` text COLLATE utf8_bin,
  `LINE` decimal(22,0) DEFAULT NULL,
  `PATTERN_START` decimal(22,0) DEFAULT NULL,
  `PATTERN_END` decimal(22,0) DEFAULT NULL,
  `DUE_DATE` datetime DEFAULT NULL,
  `DB_TYPE` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `CODE_TYPE` text COLLATE utf8_bin,
  `DESCRIPTION` text COLLATE utf8_bin,
  `PRIORITY` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` text COLLATE utf8_bin,
  `LAST_UPDATED` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` text COLLATE utf8_bin,
  PRIMARY KEY (`ID`),
  KEY `MD_ARTIFACT_FILE_FK` (`APPLICATIONFILES_ID`),
  CONSTRAINT `MD_ARTIFACT_FILE_FK` FOREIGN KEY (`APPLICATIONFILES_ID`) REFERENCES `md_applicationfiles` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_group_members`
--

DROP TABLE IF EXISTS `md_group_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_group_members` (
  `ID` decimal(22,0) NOT NULL,
  `GROUP_ID_FK` decimal(22,0) NOT NULL,
  `USER_ID_FK` decimal(22,0) DEFAULT NULL,
  `GROUP_MEMBER_ID_FK` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_GROUPMEMBERS_MD_GROUPS_FK1` (`GROUP_ID_FK`),
  KEY `MD_GROUPMEMBERS_MD_GROUPS_FK2` (`GROUP_MEMBER_ID_FK`),
  KEY `MD_GROUPMEMBERS_MD_USERS_FK1` (`USER_ID_FK`),
  CONSTRAINT `MD_GROUPMEMBERS_MD_GROUPS_FK1` FOREIGN KEY (`GROUP_ID_FK`) REFERENCES `md_groups` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MD_GROUPMEMBERS_MD_GROUPS_FK2` FOREIGN KEY (`GROUP_MEMBER_ID_FK`) REFERENCES `md_groups` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MD_GROUPMEMBERS_MD_USERS_FK1` FOREIGN KEY (`USER_ID_FK`) REFERENCES `md_users` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_group_privileges`
--

DROP TABLE IF EXISTS `md_group_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_group_privileges` (
  `ID` decimal(22,0) NOT NULL,
  `GROUP_ID_FK` decimal(22,0) NOT NULL,
  `PRIVILEGE_ID_FK` decimal(22,0) NOT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_GROUP_PRIVILEGES_MD_PR_FK1` (`PRIVILEGE_ID_FK`),
  KEY `MD_GROUP_PRIVILEGES_MD_GR_FK1` (`GROUP_ID_FK`),
  CONSTRAINT `MD_GROUP_PRIVILEGES_MD_GR_FK1` FOREIGN KEY (`GROUP_ID_FK`) REFERENCES `md_groups` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MD_GROUP_PRIVILEGES_MD_PR_FK1` FOREIGN KEY (`PRIVILEGE_ID_FK`) REFERENCES `md_privileges` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_groups`
--

DROP TABLE IF EXISTS `md_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_groups` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `GROUP_NAME` text COLLATE utf8_bin,
  `GROUP_FLAG` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_GROUPS_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_GROUPS_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_index_details`
--

DROP TABLE IF EXISTS `md_index_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_index_details` (
  `ID` decimal(22,0) NOT NULL,
  `INDEX_ID_FK` decimal(22,0) NOT NULL,
  `COLUMN_ID_FK` decimal(22,0) NOT NULL,
  `INDEX_PORTION` decimal(22,0) DEFAULT NULL,
  `DETAIL_ORDER` decimal(22,0) NOT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_INDEX_DETAILS_MD_INDEX_FK1` (`INDEX_ID_FK`),
  KEY `MD_INDEX_DETAILS_MD_COLUM_FK1` (`COLUMN_ID_FK`),
  CONSTRAINT `MD_INDEX_DETAILS_MD_COLUM_FK1` FOREIGN KEY (`COLUMN_ID_FK`) REFERENCES `md_columns` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MD_INDEX_DETAILS_MD_INDEX_FK1` FOREIGN KEY (`INDEX_ID_FK`) REFERENCES `md_indexes` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_indexes`
--

DROP TABLE IF EXISTS `md_indexes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_indexes` (
  `ID` decimal(22,0) NOT NULL,
  `INDEX_TYPE` text COLLATE utf8_bin,
  `TABLE_ID_FK` decimal(22,0) NOT NULL,
  `INDEX_NAME` text COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` text COLLATE utf8_bin,
  PRIMARY KEY (`ID`),
  KEY `MD_INDEXES_MD_TABLES_FK1` (`TABLE_ID_FK`),
  CONSTRAINT `MD_INDEXES_MD_TABLES_FK1` FOREIGN KEY (`TABLE_ID_FK`) REFERENCES `md_tables` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_migr_dependency`
--

DROP TABLE IF EXISTS `md_migr_dependency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_migr_dependency` (
  `ID` decimal(22,0) NOT NULL,
  `CONNECTION_ID_FK` decimal(22,0) NOT NULL,
  `PARENT_ID` decimal(22,0) NOT NULL,
  `CHILD_ID` decimal(22,0) NOT NULL,
  `PARENT_OBJECT_TYPE` text COLLATE utf8_bin NOT NULL,
  `CHILD_OBJECT_TYPE` text COLLATE utf8_bin NOT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MIGR_DEPENDENCY_FK` (`CONNECTION_ID_FK`),
  CONSTRAINT `MIGR_DEPENDENCY_FK` FOREIGN KEY (`CONNECTION_ID_FK`) REFERENCES `md_connections` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_migr_parameter`
--

DROP TABLE IF EXISTS `md_migr_parameter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_migr_parameter` (
  `ID` decimal(22,0) NOT NULL,
  `CONNECTION_ID_FK` decimal(22,0) NOT NULL,
  `OBJECT_ID` decimal(22,0) NOT NULL,
  `OBJECT_TYPE` text COLLATE utf8_bin NOT NULL,
  `PARAM_EXISTING` decimal(22,0) NOT NULL,
  `PARAM_ORDER` decimal(22,0) NOT NULL,
  `PARAM_NAME` text COLLATE utf8_bin NOT NULL,
  `PARAM_TYPE` text COLLATE utf8_bin NOT NULL,
  `PARAM_DATA_TYPE` text COLLATE utf8_bin NOT NULL,
  `PERCISION` decimal(22,0) DEFAULT NULL,
  `SCALE` decimal(22,0) DEFAULT NULL,
  `NULLABLE` varchar(1) COLLATE utf8_bin NOT NULL,
  `DEFAULT_VALUE` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MIGR_PARAMETER_FK` (`CONNECTION_ID_FK`),
  CONSTRAINT `MIGR_PARAMETER_FK` FOREIGN KEY (`CONNECTION_ID_FK`) REFERENCES `md_connections` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_migr_weakdep`
--

DROP TABLE IF EXISTS `md_migr_weakdep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_migr_weakdep` (
  `ID` decimal(22,0) NOT NULL,
  `CONNECTION_ID_FK` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `PARENT_ID` decimal(22,0) NOT NULL,
  `CHILD_NAME` text COLLATE utf8_bin NOT NULL,
  `PARENT_TYPE` text COLLATE utf8_bin NOT NULL,
  `CHILD_TYPE` text COLLATE utf8_bin NOT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MIGR_WEAKDEP_FK1` (`CONNECTION_ID_FK`),
  KEY `MIGR_WEAKDEP_FK2` (`SCHEMA_ID_FK`),
  CONSTRAINT `MIGR_WEAKDEP_FK1` FOREIGN KEY (`CONNECTION_ID_FK`) REFERENCES `md_connections` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MIGR_WEAKDEP_FK2` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_numrow$source`
--

DROP TABLE IF EXISTS `md_numrow$source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_numrow$source` (
  `NUMROWS` bigint(10) DEFAULT NULL,
  `NAME` text COLLATE utf8_bin,
  `OBJID` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_numrow$target`
--

DROP TABLE IF EXISTS `md_numrow$target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_numrow$target` (
  `NUMROWS` bigint(10) DEFAULT NULL,
  `NAME` text COLLATE utf8_bin,
  `OBJID` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_other_objects`
--

DROP TABLE IF EXISTS `md_other_objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_other_objects` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `NAME` text COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_OTHER_OBJECTS_MD_SCHEM_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_OTHER_OBJECTS_MD_SCHEM_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_packages`
--

DROP TABLE IF EXISTS `md_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_packages` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `PACKAGE_HEADER` longtext COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `LANGUAGE` varchar(40) COLLATE utf8_bin NOT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_PACKAGES_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_PACKAGES_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_partitions`
--

DROP TABLE IF EXISTS `md_partitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_partitions` (
  `ID` decimal(22,0) NOT NULL,
  `TABLE_ID_FK` decimal(22,0) NOT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `PARTITION_EXPRESSION` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_PARTITIONS_MD_TABLES_FK1` (`TABLE_ID_FK`),
  CONSTRAINT `MD_PARTITIONS_MD_TABLES_FK1` FOREIGN KEY (`TABLE_ID_FK`) REFERENCES `md_tables` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_privileges`
--

DROP TABLE IF EXISTS `md_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_privileges` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `PRIVILEGE_NAME` text COLLATE utf8_bin NOT NULL,
  `PRIVELEGE_OBJECT_ID` decimal(22,0) DEFAULT NULL,
  `PRIVELEGEOBJECTTYPE` text COLLATE utf8_bin NOT NULL,
  `PRIVELEGE_TYPE` text COLLATE utf8_bin NOT NULL,
  `ADMIN_OPTION` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin NOT NULL,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_PRIVILEGES_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_PRIVILEGES_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_projects`
--

DROP TABLE IF EXISTS `md_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_projects` (
  `ID` decimal(22,0) NOT NULL,
  `PROJECT_NAME` text COLLATE utf8_bin NOT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_registry`
--

DROP TABLE IF EXISTS `md_registry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_registry` (
  `OBJECT_TYPE` varchar(30) COLLATE utf8_bin NOT NULL,
  `OBJECT_NAME` varchar(30) COLLATE utf8_bin NOT NULL,
  `DESC_OBJECT_NAME` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`OBJECT_TYPE`,`OBJECT_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_repoversions`
--

DROP TABLE IF EXISTS `md_repoversions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_repoversions` (
  `REVISION` decimal(22,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_schemas`
--

DROP TABLE IF EXISTS `md_schemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_schemas` (
  `ID` decimal(22,0) NOT NULL,
  `CATALOG_ID_FK` decimal(22,0) NOT NULL,
  `NAME` text COLLATE utf8_bin,
  `TYPE` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `CHARACTER_SET` text COLLATE utf8_bin,
  `VERSION_TAG` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_SCHEMAS_MD_CATALOGS_FK1` (`CATALOG_ID_FK`),
  CONSTRAINT `MD_SCHEMAS_MD_CATALOGS_FK1` FOREIGN KEY (`CATALOG_ID_FK`) REFERENCES `md_catalogs` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_sequences`
--

DROP TABLE IF EXISTS `md_sequences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_sequences` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SEQ_START` decimal(22,0) NOT NULL,
  `INCR` decimal(22,0) NOT NULL DEFAULT '1',
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_SEQUENCES_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_SEQUENCES_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_stored_programs`
--

DROP TABLE IF EXISTS `md_stored_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_stored_programs` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `PROGRAMTYPE` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `NAME` text COLLATE utf8_bin,
  `PACKAGE_ID_FK` decimal(22,0) DEFAULT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `LANGUAGE` varchar(40) COLLATE utf8_bin NOT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `LINECOUNT` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_STORED_PROGRAMS_MD_PAC_FK1` (`PACKAGE_ID_FK`),
  KEY `MD_STORED_PROGRAMS_MD_SCH_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_STORED_PROGRAMS_MD_PAC_FK1` FOREIGN KEY (`PACKAGE_ID_FK`) REFERENCES `md_packages` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MD_STORED_PROGRAMS_MD_SCH_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_synonyms`
--

DROP TABLE IF EXISTS `md_synonyms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_synonyms` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SYNONYM_FOR_ID` decimal(22,0) NOT NULL,
  `FOR_OBJECT_TYPE` text COLLATE utf8_bin NOT NULL,
  `PRIVATE_VISIBILITY` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_SYNONYMS_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_SYNONYMS_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_tables`
--

DROP TABLE IF EXISTS `md_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_tables` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `TABLE_NAME` text COLLATE utf8_bin NOT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `QUALIFIED_NATIVE_NAME` text COLLATE utf8_bin NOT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_TABLES_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_TABLES_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_tablespaces`
--

DROP TABLE IF EXISTS `md_tablespaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_tablespaces` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `TABLESPACE_NAME` text COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_TABLESPACES_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_TABLESPACES_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_triggers`
--

DROP TABLE IF EXISTS `md_triggers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_triggers` (
  `ID` decimal(22,0) NOT NULL,
  `TABLE_OR_VIEW_ID_FK` decimal(22,0) NOT NULL,
  `TRIGGER_ON_FLAG` varchar(1) COLLATE utf8_bin NOT NULL,
  `TRIGGER_NAME` text COLLATE utf8_bin,
  `TRIGGER_TIMING` text COLLATE utf8_bin,
  `TRIGGER_OPERATION` text COLLATE utf8_bin,
  `TRIGGER_EVENT` text COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `LANGUAGE` varchar(40) COLLATE utf8_bin NOT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `LINECOUNT` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_user_defined_data_types`
--

DROP TABLE IF EXISTS `md_user_defined_data_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_user_defined_data_types` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `DATA_TYPE_NAME` text COLLATE utf8_bin NOT NULL,
  `DEFINITION` text COLLATE utf8_bin NOT NULL,
  `NATIVE_SQL` longtext COLLATE utf8_bin NOT NULL,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_USER_DEFINED_DATA_TYPE_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_USER_DEFINED_DATA_TYPE_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_user_privileges`
--

DROP TABLE IF EXISTS `md_user_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_user_privileges` (
  `ID` decimal(22,0) NOT NULL,
  `USER_ID_FK` decimal(22,0) NOT NULL,
  `PRIVILEGE_ID_FK` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UDPATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_USER_PRIVILEGES_MD_USE_FK1` (`USER_ID_FK`),
  KEY `MD_USER_PRIVILEGES_MD_PRI_FK1` (`PRIVILEGE_ID_FK`),
  CONSTRAINT `MD_USER_PRIVILEGES_MD_PRI_FK1` FOREIGN KEY (`PRIVILEGE_ID_FK`) REFERENCES `md_privileges` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `MD_USER_PRIVILEGES_MD_USE_FK1` FOREIGN KEY (`USER_ID_FK`) REFERENCES `md_users` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_users`
--

DROP TABLE IF EXISTS `md_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_users` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `USERNAME` text COLLATE utf8_bin NOT NULL,
  `PASSWORD` text COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `COMMENTS` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_USERS_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_USERS_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md_views`
--

DROP TABLE IF EXISTS `md_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_views` (
  `ID` decimal(22,0) NOT NULL,
  `SCHEMA_ID_FK` decimal(22,0) NOT NULL,
  `VIEW_NAME` text COLLATE utf8_bin,
  `NATIVE_SQL` longtext COLLATE utf8_bin,
  `NATIVE_KEY` text COLLATE utf8_bin,
  `LANGUAGE` varchar(40) COLLATE utf8_bin NOT NULL,
  `COMMENTS` text COLLATE utf8_bin,
  `LINECOUNT` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MD_VIEWS_MD_SCHEMAS_FK1` (`SCHEMA_ID_FK`),
  CONSTRAINT `MD_VIEWS_MD_SCHEMAS_FK1` FOREIGN KEY (`SCHEMA_ID_FK`) REFERENCES `md_schemas` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migr_datatype_transform_map`
--

DROP TABLE IF EXISTS `migr_datatype_transform_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migr_datatype_transform_map` (
  `ID` decimal(22,0) NOT NULL,
  `PROJECT_ID_FK` decimal(22,0) NOT NULL,
  `MAP_NAME` text COLLATE utf8_bin,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MIGR_DATATYPE_TRANSFORM_M_FK1` (`PROJECT_ID_FK`),
  CONSTRAINT `MIGR_DATATYPE_TRANSFORM_M_FK1` FOREIGN KEY (`PROJECT_ID_FK`) REFERENCES `md_projects` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migr_datatype_transform_rule`
--

DROP TABLE IF EXISTS `migr_datatype_transform_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migr_datatype_transform_rule` (
  `ID` decimal(22,0) NOT NULL,
  `MAP_ID_FK` decimal(22,0) NOT NULL,
  `SOURCE_DATA_TYPE_NAME` text COLLATE utf8_bin NOT NULL,
  `SOURCE_PRECISION` decimal(22,0) DEFAULT NULL,
  `SOURCE_SCALE` decimal(22,0) DEFAULT NULL,
  `TARGET_DATA_TYPE_NAME` text COLLATE utf8_bin NOT NULL,
  `TARGET_PRECISION` decimal(22,0) DEFAULT NULL,
  `TARGET_SCALE` decimal(22,0) DEFAULT NULL,
  `SECURITY_GROUP_ID` decimal(22,0) NOT NULL DEFAULT '0',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `LAST_UPDATED_ON` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MIGR_DATATYPE_TRANSFORM_R_FK1` (`MAP_ID_FK`),
  CONSTRAINT `MIGR_DATATYPE_TRANSFORM_R_FK1` FOREIGN KEY (`MAP_ID_FK`) REFERENCES `migr_datatype_transform_map` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migr_generation_order`
--

DROP TABLE IF EXISTS `migr_generation_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migr_generation_order` (
  `ID` decimal(22,0) NOT NULL,
  `CONNECTION_ID_FK` decimal(22,0) NOT NULL,
  `OBJECT_ID` decimal(22,0) NOT NULL,
  `OBJECT_TYPE` text COLLATE utf8_bin NOT NULL,
  `GENERATION_ORDER` decimal(22,0) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `MIGR_GENERATION_ORDER_UK` (`OBJECT_ID`),
  KEY `MIGR_GENERATION_ORDER_MD__FK1` (`CONNECTION_ID_FK`),
  CONSTRAINT `MIGR_GENERATION_ORDER_MD__FK1` FOREIGN KEY (`CONNECTION_ID_FK`) REFERENCES `md_connections` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrlog`
--

DROP TABLE IF EXISTS `migrlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrlog` (
  `ID` decimal(22,0) NOT NULL,
  `PARENT_LOG_ID` decimal(22,0) DEFAULT NULL,
  `LOG_DATE` datetime NOT NULL,
  `SEVERITY` smallint(4) NOT NULL,
  `LOGTEXT` text COLLATE utf8_bin,
  `PHASE` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `REF_OBJECT_ID` decimal(22,0) DEFAULT NULL,
  `REF_OBJECT_TYPE` text COLLATE utf8_bin,
  `CONNECTION_ID_FK` decimal(22,0) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MIGR_MIGRLOG_FK` (`PARENT_LOG_ID`),
  CONSTRAINT `MIGR_MIGRLOG_FK` FOREIGN KEY (`PARENT_LOG_ID`) REFERENCES `migrlog` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pendik`
--

DROP TABLE IF EXISTS `pendik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pendik` (
  `DIK_KODIK` varchar(7) COLLATE utf8_bin DEFAULT NULL,
  `DIK_NMDIK` varchar(60) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupns`
--

DROP TABLE IF EXISTS `pupns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupns` (
  `PNS_PNSNIP` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PNS_NIPBARU` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `PNS_PNSNAM` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `PNS_GLRDPN` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `PNS_GLRBLK` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TEMLHR` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TGLLHR` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TGLLHRDT` datetime DEFAULT NULL,
  `PNS_PNSSEX` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TKTDIK` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PNS_GOLAWL` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TMTCPN` datetime DEFAULT NULL,
  `PNS_TMTPNS` datetime DEFAULT NULL,
  `PNS_JENPEG` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PNS_INSDUK` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `PNS_INSKER` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `PNS_UNITOR` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `PNS_JNSJAB` tinyint(1) DEFAULT NULL,
  `PNS_KODESL` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PNS_JABFUN` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TMTFUN` datetime DEFAULT NULL,
  `PNS_GOLRU` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TMTGOL` datetime DEFAULT NULL,
  `PNS_THNKER` tinyint(2) DEFAULT NULL,
  `PNS_BLNKER` tinyint(2) DEFAULT NULL,
  `PNS_TEMKRJ` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `PNS_STSWIN` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_JMLIST` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_JMLANK` tinyint(2) DEFAULT NULL,
  `PNS_KEDHUK` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PNS_RUMAH` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_TAPRUM` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_GUNRUM` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_ALAMAT` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `PNS_KODPOS` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `PNS_UNOR` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `PNS_KODAGA` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_JENDOK` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_NOMDOK` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `PNS_STCPNS` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PNS_EMAIL` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `PNS_NOMHP` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `PNS_NOMTEL` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `PNS_KARPEG` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `PNS_LATSTR` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `SK_KONV_NOMOR` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SK_KONV_TANGGAL` datetime DEFAULT NULL,
  `SK_KONV_URUT` int(8) DEFAULT NULL,
  `PNS_KANREG` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `ORANG_ID` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  KEY `IX_PNS_NIPBARU` (`PNS_NIPBARU`),
  KEY `IX_PNSNIP` (`PNS_PNSNIP`),
  KEY `IX_PNS_UNITOR` (`PNS_UNITOR`),
  KEY `IX_PNS_INSKER` (`PNS_INSKER`),
  KEY `PNS_NIPBARU` (`PNS_NIPBARU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupns_kinerja`
--

DROP TABLE IF EXISTS `pupns_kinerja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupns_kinerja` (
  `PNK_PNSNIP` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PNK_NIPBARU` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `PNK_SATKER` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `PNK_PROSECAT` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PNK_PROSENAMA` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `PNK_TANGGAL` datetime DEFAULT NULL,
  `PNK_JUMLAH` mediumint(5) DEFAULT NULL,
  KEY `IX_PNK_PNSNIP` (`PNK_PNSNIP`),
  KEY `IX_NIPBARU` (`PNK_NIPBARU`),
  KEY `IX_PNK_TANGGAL` (`PNK_TANGGAL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupns_kp_info`
--

DROP TABLE IF EXISTS `pupns_kp_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupns_kp_info` (
  `PKI_PNSNIP` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PKI_NIPBARU` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `PKI_TGL_USUL` datetime DEFAULT NULL,
  `PKI_NOM_USUL` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `JJB_JJBKOD` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `JKP_JPNKOD` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `PKI_SK_NOMOR` varchar(70) COLLATE utf8_bin DEFAULT NULL,
  `PKI_SK_TANGGAL` datetime DEFAULT NULL,
  `PKI_GOLONGAN_LAMA_ID` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PKI_GOLONGAN_BARU_ID` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PKI_TMT_GOLONGAN_BARU` datetime DEFAULT NULL,
  `NOTA_PERSETUJUAN_KP` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `TGL_NOTA_PERSETUJUAN_KP` datetime DEFAULT NULL,
  KEY `IX_PKI_PNSNIP` (`PKI_PNSNIP`),
  KEY `IX_PKI_NIPBARU` (`PKI_NIPBARU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupns_pendidikan`
--

DROP TABLE IF EXISTS `pupns_pendidikan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupns_pendidikan` (
  `PNS_PNSNIP` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PNS_NIPBARU` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `PEN_PENKOD` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PEN_TAHLUL` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupns_pengadaan_info`
--

DROP TABLE IF EXISTS `pupns_pengadaan_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupns_pengadaan_info` (
  `NIP` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `JABATAN_NAMA` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `UNIT_KERJA_NAMA` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `IJASAH_NAMA` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `TAHUN_IJAZAH` smallint(4) DEFAULT NULL,
  `GOLONGAN_AWAL_ID` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `TMT_CPNS` datetime DEFAULT NULL,
  `PERSETUJUAN_TEKNIS_NOMOR` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `PERSETUJUAN_TEKNIS_TANGGAL` datetime DEFAULT NULL,
  `DITETAPKAN_TANGGAL` datetime DEFAULT NULL,
  KEY `IX_PPI_PNSNIP` (`NIP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupns_pensiun_info`
--

DROP TABLE IF EXISTS `pupns_pensiun_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupns_pensiun_info` (
  `PNI_PNSNIP` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PNI_NIPBARU` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `PNI_TGL_USUL` datetime DEFAULT NULL,
  `PNI_NOM_USUL` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `JPN_JPNKOD` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `PNI_SK_NOMOR` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `PNI_SK_TANGGAL` datetime DEFAULT NULL,
  `PNI_TMT_PENSIUN` datetime DEFAULT NULL,
  `GOLONGAN` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `MASA_KERJA_GOLONGAN` smallint(3) DEFAULT NULL,
  `MASA_KERJA_PENSIUN` smallint(3) DEFAULT NULL,
  `GAJI_POKOK_TERAKHIR` bigint(10) DEFAULT NULL,
  `ALAMAT_SESUDAH` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `DIUSULKAN_KPP` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  KEY `IX_PNI_PNSNIP` (`PNI_PNSNIP`),
  KEY `IX_PNI_NIPBARU` (`PNI_NIPBARU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupns_prosedur`
--

DROP TABLE IF EXISTS `pupns_prosedur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupns_prosedur` (
  `PNP_PNSNIP` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PNP_NIPBARU` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `PNP_CATEGORY` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `PNP_NAMA` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `PNP_STEP` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  KEY `IX_PNP_PNSNIP` (`PNP_PNSNIP`),
  KEY `IX_PNP_NIPBARU` (`PNP_NIPBARU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `skkonversi`
--

DROP TABLE IF EXISTS `skkonversi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skkonversi` (
  `PNS_NIPLAMA` varchar(9) DEFAULT NULL,
  `PNS_NIPBARU` varchar(18) DEFAULT NULL,
  `PNS_PNSNAM` varchar(40) DEFAULT NULL,
  `PNS_GLRDPN` varchar(15) DEFAULT NULL,
  `PNS_GLRBLK` varchar(15) DEFAULT NULL,
  `PNS_TGLLHR` varchar(10) DEFAULT NULL,
  `PNS_TMTCPN` tinytext,
  `PNS_TMTPNS` tinytext,
  `PNS_PNSSEX` varchar(1) DEFAULT NULL,
  `PNS_INSKER` varchar(4) DEFAULT NULL,
  `PNS_NOMSK` varchar(30) DEFAULT NULL,
  `PNS_TGLSK` tinytext,
  `PNS_STATUS` varchar(1) DEFAULT NULL,
  `PNS_TTD` varchar(2) DEFAULT NULL,
  `PNS_NOURUT` tinytext,
  `PNS_USER` varchar(15) DEFAULT NULL,
  `PNS_UNITOR` varchar(10) DEFAULT NULL,
  `PNS_TTDPTK` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `skkonversi_bak`
--

DROP TABLE IF EXISTS `skkonversi_bak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skkonversi_bak` (
  `PNS_NIPLAMA` varchar(9) DEFAULT NULL,
  `PNS_NIPBARU` varchar(18) NOT NULL,
  `PNS_PNSNAM` varchar(40) DEFAULT NULL,
  `PNS_GLRDPN` varchar(15) DEFAULT NULL,
  `PNS_GLRBLK` varchar(15) DEFAULT NULL,
  `PNS_TGLLHR` varchar(10) DEFAULT NULL,
  `PNS_TMTCPN` tinytext,
  `PNS_TMTPNS` tinytext,
  `PNS_PNSSEX` varchar(1) DEFAULT NULL,
  `PNS_INSKER` varchar(4) DEFAULT NULL,
  `PNS_NOMSK` varchar(30) DEFAULT NULL,
  `PNS_TGLSK` tinytext,
  `PNS_STATUS` varchar(1) DEFAULT NULL,
  `PNS_TTD` varchar(2) DEFAULT NULL,
  `PNS_NOURUT` decimal(19,0) DEFAULT NULL,
  `PNS_USER` varchar(15) DEFAULT NULL,
  `PNS_UNITOR` varchar(10) DEFAULT NULL,
  `PNS_TTDPTK` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `skkonversibaik`
--

DROP TABLE IF EXISTS `skkonversibaik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skkonversibaik` (
  `PNS_NIPLAMA` varchar(9) DEFAULT NULL,
  `PNS_NIPBARU` varchar(18) DEFAULT NULL,
  `PNS_PNSNAM` varchar(90) DEFAULT NULL,
  `PNS_TGLLHR` varchar(10) DEFAULT NULL,
  `PNS_TMTCPN` tinytext,
  `PNS_TMTPNS` tinytext,
  `PNS_PNSSEX` varchar(1) DEFAULT NULL,
  `PNS_INSKER` varchar(4) DEFAULT NULL,
  `PNS_NOMSK` varchar(30) DEFAULT NULL,
  `PNS_TTD` varchar(2) DEFAULT NULL,
  `PNS_NOURUT` tinytext,
  `PNS_USER` varchar(15) DEFAULT NULL,
  `SK_STATUS` varchar(10) DEFAULT NULL,
  `SURAT_NO` tinytext,
  `SURAT_TGL` varchar(10) DEFAULT NULL,
  `SURAT_HAL` tinytext,
  `TGL_SIMPAN` varchar(10) DEFAULT NULL,
  `INS_USUL` tinytext,
  `KET_SK` tinytext,
  `TGL_DIPERBAIKI` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stage_migrlog`
--

DROP TABLE IF EXISTS `stage_migrlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stage_migrlog` (
  `SVRID_FK` decimal(22,0) DEFAULT NULL,
  `DBID_GEN_FK` decimal(22,0) DEFAULT NULL,
  `ID` decimal(22,0) NOT NULL,
  `REF_OBJECT_ID` decimal(22,0) DEFAULT NULL,
  `REF_OBJECT_TYPE` text COLLATE utf8_bin,
  `LOG_DATE` datetime NOT NULL,
  `SEVERITY` smallint(4) NOT NULL,
  `LOGTEXT` text COLLATE utf8_bin,
  `PHASE` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tktpendik`
--

DROP TABLE IF EXISTS `tktpendik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tktpendik` (
  `DIK_TKTDIK` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `DIK_NAMDIK` varchar(30) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unor`
--

DROP TABLE IF EXISTS `unor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unor` (
  `UNO_INSTAN` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `UNO_KODUNO` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `UNO_NAMUNO` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `UNO_NAMJAB` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `UNO_ID` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `UNO_DIATASAN_ID` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `UNO_ORDER` smallint(4) DEFAULT NULL,
  `UNO_KODESL` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  KEY `IX_UNO_INSTAN` (`UNO_INSTAN`),
  KEY `IX_UNO_KODUNO` (`UNO_KODUNO`),
  KEY `IX_UNO_NAMUNO` (`UNO_NAMUNO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `xi_pupns`
--

DROP TABLE IF EXISTS `xi_pupns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xi_pupns` (
  `COLUMN1` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `label_pengalihan`
--

/*!50001 DROP VIEW IF EXISTS `label_pengalihan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `label_pengalihan` AS select `a`.`PNS_NIPBARU` AS `PNS_NIPBARU`,`a`.`PNS_PNSNAM` AS `PNS_PNSNAM`,`a`.`PNS_GLRDPN` AS `PNS_GLRDPN`,`a`.`PNS_GLRBLK` AS `PNS_GLRBLK`,`a`.`PNS_ALAMAT` AS `PNS_ALAMAT` from (`mirror`.`pupns` `a` left join `pengalihan_pns`.`sk_pengalihan` `b` on((`a`.`PNS_NIPBARU` = convert(`b`.`nip` using utf8)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-06 13:58:26
