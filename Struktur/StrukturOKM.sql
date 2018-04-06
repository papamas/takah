-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: okmdb
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
-- Table structure for table `jbpm_action`
--

DROP TABLE IF EXISTS `jbpm_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_action` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `class` char(1) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `ISPROPAGATIONALLOWED_` bit(1) DEFAULT NULL,
  `ACTIONEXPRESSION_` varchar(255) DEFAULT NULL,
  `ISASYNC_` bit(1) DEFAULT NULL,
  `REFERENCEDACTION_` bigint(20) DEFAULT NULL,
  `ACTIONDELEGATION_` bigint(20) DEFAULT NULL,
  `EVENT_` bigint(20) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `EXPRESSION_` varchar(4000) DEFAULT NULL,
  `TIMERNAME_` varchar(255) DEFAULT NULL,
  `DUEDATE_` varchar(255) DEFAULT NULL,
  `REPEAT_` varchar(255) DEFAULT NULL,
  `TRANSITIONNAME_` varchar(255) DEFAULT NULL,
  `TIMERACTION_` bigint(20) DEFAULT NULL,
  `EVENTINDEX_` int(11) DEFAULT NULL,
  `EXCEPTIONHANDLER_` bigint(20) DEFAULT NULL,
  `EXCEPTIONHANDLERINDEX_` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_ACTION_ACTNDL` (`ACTIONDELEGATION_`),
  KEY `IDX_ACTION_PROCDF` (`PROCESSDEFINITION_`),
  KEY `IDX_ACTION_EVENT` (`EVENT_`),
  KEY `FK_ACTION_REFACT` (`REFERENCEDACTION_`),
  KEY `FK_CRTETIMERACT_TA` (`TIMERACTION_`),
  KEY `FK_ACTION_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `FK_ACTION_EVENT` (`EVENT_`),
  KEY `FK_ACTION_ACTNDEL` (`ACTIONDELEGATION_`),
  KEY `FK_ACTION_EXPTHDL` (`EXCEPTIONHANDLER_`),
  CONSTRAINT `FK_ACTION_ACTNDEL` FOREIGN KEY (`ACTIONDELEGATION_`) REFERENCES `jbpm_delegation` (`ID_`),
  CONSTRAINT `FK_ACTION_EVENT` FOREIGN KEY (`EVENT_`) REFERENCES `jbpm_event` (`ID_`),
  CONSTRAINT `FK_ACTION_EXPTHDL` FOREIGN KEY (`EXCEPTIONHANDLER_`) REFERENCES `jbpm_exceptionhandler` (`ID_`),
  CONSTRAINT `FK_ACTION_PROCDEF` FOREIGN KEY (`PROCESSDEFINITION_`) REFERENCES `jbpm_processdefinition` (`ID_`),
  CONSTRAINT `FK_ACTION_REFACT` FOREIGN KEY (`REFERENCEDACTION_`) REFERENCES `jbpm_action` (`ID_`),
  CONSTRAINT `FK_CRTETIMERACT_TA` FOREIGN KEY (`TIMERACTION_`) REFERENCES `jbpm_action` (`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_bytearray`
--

DROP TABLE IF EXISTS `jbpm_bytearray`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_bytearray` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `NAME_` varchar(255) DEFAULT NULL,
  `FILEDEFINITION_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `FK_BYTEARR_FILDEF` (`FILEDEFINITION_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_byteblock`
--

DROP TABLE IF EXISTS `jbpm_byteblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_byteblock` (
  `PROCESSFILE_` bigint(20) NOT NULL,
  `BYTES_` blob,
  `INDEX_` int(11) NOT NULL,
  PRIMARY KEY (`PROCESSFILE_`,`INDEX_`),
  KEY `FK_BYTEBLOCK_FILE` (`PROCESSFILE_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_comment`
--

DROP TABLE IF EXISTS `jbpm_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_comment` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VERSION_` int(11) NOT NULL,
  `ACTORID_` varchar(255) DEFAULT NULL,
  `TIME_` datetime DEFAULT NULL,
  `MESSAGE_` varchar(4000) DEFAULT NULL,
  `TOKEN_` bigint(20) DEFAULT NULL,
  `TASKINSTANCE_` bigint(20) DEFAULT NULL,
  `TOKENINDEX_` int(11) DEFAULT NULL,
  `TASKINSTANCEINDEX_` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_COMMENT_TSK` (`TASKINSTANCE_`),
  KEY `IDX_COMMENT_TOKEN` (`TOKEN_`),
  KEY `FK_COMMENT_TOKEN` (`TOKEN_`),
  KEY `FK_COMMENT_TSK` (`TASKINSTANCE_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_decisionconditions`
--

DROP TABLE IF EXISTS `jbpm_decisionconditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_decisionconditions` (
  `DECISION_` bigint(20) NOT NULL,
  `TRANSITIONNAME_` varchar(255) DEFAULT NULL,
  `EXPRESSION_` varchar(255) DEFAULT NULL,
  `INDEX_` int(11) NOT NULL,
  PRIMARY KEY (`DECISION_`,`INDEX_`),
  KEY `FK_DECCOND_DEC` (`DECISION_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_delegation`
--

DROP TABLE IF EXISTS `jbpm_delegation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_delegation` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASSNAME_` varchar(4000) DEFAULT NULL,
  `CONFIGURATION_` varchar(4000) DEFAULT NULL,
  `CONFIGTYPE_` varchar(255) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_DELEG_PRCD` (`PROCESSDEFINITION_`),
  KEY `FK_DELEGATION_PRCD` (`PROCESSDEFINITION_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_event`
--

DROP TABLE IF EXISTS `jbpm_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_event` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `EVENTTYPE_` varchar(255) DEFAULT NULL,
  `TYPE_` char(1) DEFAULT NULL,
  `GRAPHELEMENT_` bigint(20) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `NODE_` bigint(20) DEFAULT NULL,
  `TRANSITION_` bigint(20) DEFAULT NULL,
  `TASK_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `FK_EVENT_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `FK_EVENT_TRANS` (`TRANSITION_`),
  KEY `FK_EVENT_NODE` (`NODE_`),
  KEY `FK_EVENT_TASK` (`TASK_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_exceptionhandler`
--

DROP TABLE IF EXISTS `jbpm_exceptionhandler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_exceptionhandler` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `EXCEPTIONCLASSNAME_` varchar(4000) DEFAULT NULL,
  `TYPE_` char(1) DEFAULT NULL,
  `GRAPHELEMENT_` bigint(20) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `GRAPHELEMENTINDEX_` int(11) DEFAULT NULL,
  `NODE_` bigint(20) DEFAULT NULL,
  `TRANSITION_` bigint(20) DEFAULT NULL,
  `TASK_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_job`
--

DROP TABLE IF EXISTS `jbpm_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_job` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `VERSION_` int(11) NOT NULL,
  `DUEDATE_` datetime DEFAULT NULL,
  `PROCESSINSTANCE_` bigint(20) DEFAULT NULL,
  `TOKEN_` bigint(20) DEFAULT NULL,
  `TASKINSTANCE_` bigint(20) DEFAULT NULL,
  `ISSUSPENDED_` bit(1) DEFAULT NULL,
  `ISEXCLUSIVE_` bit(1) DEFAULT NULL,
  `LOCKOWNER_` varchar(255) DEFAULT NULL,
  `LOCKTIME_` datetime DEFAULT NULL,
  `EXCEPTION_` varchar(4000) DEFAULT NULL,
  `RETRIES_` int(11) DEFAULT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `REPEAT_` varchar(255) DEFAULT NULL,
  `TRANSITIONNAME_` varchar(255) DEFAULT NULL,
  `ACTION_` bigint(20) DEFAULT NULL,
  `GRAPHELEMENTTYPE_` varchar(255) DEFAULT NULL,
  `GRAPHELEMENT_` bigint(20) DEFAULT NULL,
  `NODE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_JOB_TSKINST` (`TASKINSTANCE_`),
  KEY `IDX_JOB_TOKEN` (`TOKEN_`),
  KEY `IDX_JOB_PRINST` (`PROCESSINSTANCE_`),
  KEY `FK_JOB_PRINST` (`PROCESSINSTANCE_`),
  KEY `FK_JOB_ACTION` (`ACTION_`),
  KEY `FK_JOB_TOKEN` (`TOKEN_`),
  KEY `FK_JOB_NODE` (`NODE_`),
  KEY `FK_JOB_TSKINST` (`TASKINSTANCE_`),
  CONSTRAINT `FK_JOB_ACTION` FOREIGN KEY (`ACTION_`) REFERENCES `jbpm_action` (`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_log`
--

DROP TABLE IF EXISTS `jbpm_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_log` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `INDEX_` int(11) DEFAULT NULL,
  `DATE_` datetime DEFAULT NULL,
  `TOKEN_` bigint(20) DEFAULT NULL,
  `PARENT_` bigint(20) DEFAULT NULL,
  `MESSAGE_` varchar(4000) DEFAULT NULL,
  `EXCEPTION_` varchar(4000) DEFAULT NULL,
  `ACTION_` bigint(20) DEFAULT NULL,
  `NODE_` bigint(20) DEFAULT NULL,
  `ENTER_` datetime DEFAULT NULL,
  `LEAVE_` datetime DEFAULT NULL,
  `DURATION_` bigint(20) DEFAULT NULL,
  `NEWLONGVALUE_` bigint(20) DEFAULT NULL,
  `TRANSITION_` bigint(20) DEFAULT NULL,
  `CHILD_` bigint(20) DEFAULT NULL,
  `SOURCENODE_` bigint(20) DEFAULT NULL,
  `DESTINATIONNODE_` bigint(20) DEFAULT NULL,
  `VARIABLEINSTANCE_` bigint(20) DEFAULT NULL,
  `OLDBYTEARRAY_` bigint(20) DEFAULT NULL,
  `NEWBYTEARRAY_` bigint(20) DEFAULT NULL,
  `OLDDATEVALUE_` datetime DEFAULT NULL,
  `NEWDATEVALUE_` datetime DEFAULT NULL,
  `OLDDOUBLEVALUE_` double DEFAULT NULL,
  `NEWDOUBLEVALUE_` double DEFAULT NULL,
  `OLDLONGIDCLASS_` varchar(255) DEFAULT NULL,
  `OLDLONGIDVALUE_` bigint(20) DEFAULT NULL,
  `NEWLONGIDCLASS_` varchar(255) DEFAULT NULL,
  `NEWLONGIDVALUE_` bigint(20) DEFAULT NULL,
  `OLDSTRINGIDCLASS_` varchar(255) DEFAULT NULL,
  `OLDSTRINGIDVALUE_` varchar(255) DEFAULT NULL,
  `NEWSTRINGIDCLASS_` varchar(255) DEFAULT NULL,
  `NEWSTRINGIDVALUE_` varchar(255) DEFAULT NULL,
  `OLDLONGVALUE_` bigint(20) DEFAULT NULL,
  `OLDSTRINGVALUE_` varchar(4000) DEFAULT NULL,
  `NEWSTRINGVALUE_` varchar(4000) DEFAULT NULL,
  `TASKINSTANCE_` bigint(20) DEFAULT NULL,
  `TASKACTORID_` varchar(255) DEFAULT NULL,
  `TASKOLDACTORID_` varchar(255) DEFAULT NULL,
  `SWIMLANEINSTANCE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `FK_LOG_SOURCENODE` (`SOURCENODE_`),
  KEY `FK_LOG_DESTNODE` (`DESTINATIONNODE_`),
  KEY `FK_LOG_TOKEN` (`TOKEN_`),
  KEY `FK_LOG_TRANSITION` (`TRANSITION_`),
  KEY `FK_LOG_TASKINST` (`TASKINSTANCE_`),
  KEY `FK_LOG_CHILDTOKEN` (`CHILD_`),
  KEY `FK_LOG_OLDBYTES` (`OLDBYTEARRAY_`),
  KEY `FK_LOG_SWIMINST` (`SWIMLANEINSTANCE_`),
  KEY `FK_LOG_NEWBYTES` (`NEWBYTEARRAY_`),
  KEY `FK_LOG_ACTION` (`ACTION_`),
  KEY `FK_LOG_VARINST` (`VARIABLEINSTANCE_`),
  KEY `FK_LOG_NODE` (`NODE_`),
  KEY `FK_LOG_PARENT` (`PARENT_`),
  CONSTRAINT `FK_LOG_ACTION` FOREIGN KEY (`ACTION_`) REFERENCES `jbpm_action` (`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_moduledefinition`
--

DROP TABLE IF EXISTS `jbpm_moduledefinition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_moduledefinition` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `STARTTASK_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_MODDEF_PROCDF` (`PROCESSDEFINITION_`),
  KEY `FK_MODDEF_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `FK_TSKDEF_START` (`STARTTASK_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_moduleinstance`
--

DROP TABLE IF EXISTS `jbpm_moduleinstance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_moduleinstance` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `VERSION_` int(11) NOT NULL,
  `PROCESSINSTANCE_` bigint(20) DEFAULT NULL,
  `TASKMGMTDEFINITION_` bigint(20) DEFAULT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_MODINST_PRINST` (`PROCESSINSTANCE_`),
  KEY `FK_MODINST_PRCINST` (`PROCESSINSTANCE_`),
  KEY `FK_TASKMGTINST_TMD` (`TASKMGMTDEFINITION_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_node`
--

DROP TABLE IF EXISTS `jbpm_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_node` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `DESCRIPTION_` varchar(4000) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `ISASYNC_` bit(1) DEFAULT NULL,
  `ISASYNCEXCL_` bit(1) DEFAULT NULL,
  `ACTION_` bigint(20) DEFAULT NULL,
  `SUPERSTATE_` bigint(20) DEFAULT NULL,
  `SUBPROCNAME_` varchar(255) DEFAULT NULL,
  `SUBPROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `DECISIONEXPRESSION_` varchar(255) DEFAULT NULL,
  `DECISIONDELEGATION` bigint(20) DEFAULT NULL,
  `SCRIPT_` bigint(20) DEFAULT NULL,
  `PARENTLOCKMODE_` varchar(255) DEFAULT NULL,
  `SIGNAL_` int(11) DEFAULT NULL,
  `CREATETASKS_` bit(1) DEFAULT NULL,
  `ENDTASKS_` bit(1) DEFAULT NULL,
  `NODECOLLECTIONINDEX_` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_PSTATE_SBPRCDEF` (`SUBPROCESSDEFINITION_`),
  KEY `IDX_NODE_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `IDX_NODE_ACTION` (`ACTION_`),
  KEY `IDX_NODE_SUPRSTATE` (`SUPERSTATE_`),
  KEY `FK_DECISION_DELEG` (`DECISIONDELEGATION`),
  KEY `FK_NODE_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `FK_NODE_ACTION` (`ACTION_`),
  KEY `FK_PROCST_SBPRCDEF` (`SUBPROCESSDEFINITION_`),
  KEY `FK_NODE_SCRIPT` (`SCRIPT_`),
  KEY `FK_NODE_SUPERSTATE` (`SUPERSTATE_`),
  CONSTRAINT `FK_NODE_ACTION` FOREIGN KEY (`ACTION_`) REFERENCES `jbpm_action` (`ID_`),
  CONSTRAINT `FK_NODE_SCRIPT` FOREIGN KEY (`SCRIPT_`) REFERENCES `jbpm_action` (`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_pooledactor`
--

DROP TABLE IF EXISTS `jbpm_pooledactor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_pooledactor` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VERSION_` int(11) NOT NULL,
  `ACTORID_` varchar(255) DEFAULT NULL,
  `SWIMLANEINSTANCE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_TSKINST_SWLANE` (`SWIMLANEINSTANCE_`),
  KEY `IDX_PLDACTR_ACTID` (`ACTORID_`),
  KEY `FK_POOLEDACTOR_SLI` (`SWIMLANEINSTANCE_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_processdefinition`
--

DROP TABLE IF EXISTS `jbpm_processdefinition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_processdefinition` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `DESCRIPTION_` varchar(4000) DEFAULT NULL,
  `VERSION_` int(11) DEFAULT NULL,
  `ISTERMINATIONIMPLICIT_` bit(1) DEFAULT NULL,
  `STARTSTATE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_PROCDEF_STRTST` (`STARTSTATE_`),
  KEY `FK_PROCDEF_STRTSTA` (`STARTSTATE_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_processinstance`
--

DROP TABLE IF EXISTS `jbpm_processinstance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_processinstance` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VERSION_` int(11) NOT NULL,
  `KEY_` varchar(255) DEFAULT NULL,
  `START_` datetime DEFAULT NULL,
  `END_` datetime DEFAULT NULL,
  `ISSUSPENDED_` bit(1) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `ROOTTOKEN_` bigint(20) DEFAULT NULL,
  `SUPERPROCESSTOKEN_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_PROCIN_SPROCTK` (`SUPERPROCESSTOKEN_`),
  KEY `IDX_PROCIN_ROOTTK` (`ROOTTOKEN_`),
  KEY `IDX_PROCIN_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `IDX_PROCIN_KEY` (`KEY_`),
  KEY `FK_PROCIN_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `FK_PROCIN_ROOTTKN` (`ROOTTOKEN_`),
  KEY `FK_PROCIN_SPROCTKN` (`SUPERPROCESSTOKEN_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_runtimeaction`
--

DROP TABLE IF EXISTS `jbpm_runtimeaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_runtimeaction` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VERSION_` int(11) NOT NULL,
  `EVENTTYPE_` varchar(255) DEFAULT NULL,
  `TYPE_` char(1) DEFAULT NULL,
  `GRAPHELEMENT_` bigint(20) DEFAULT NULL,
  `PROCESSINSTANCE_` bigint(20) DEFAULT NULL,
  `ACTION_` bigint(20) DEFAULT NULL,
  `PROCESSINSTANCEINDEX_` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_RTACTN_ACTION` (`ACTION_`),
  KEY `IDX_RTACTN_PRCINST` (`PROCESSINSTANCE_`),
  KEY `FK_RTACTN_PROCINST` (`PROCESSINSTANCE_`),
  KEY `FK_RTACTN_ACTION` (`ACTION_`),
  CONSTRAINT `FK_RTACTN_ACTION` FOREIGN KEY (`ACTION_`) REFERENCES `jbpm_action` (`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_swimlane`
--

DROP TABLE IF EXISTS `jbpm_swimlane`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_swimlane` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `NAME_` varchar(255) DEFAULT NULL,
  `ACTORIDEXPRESSION_` varchar(255) DEFAULT NULL,
  `POOLEDACTORSEXPRESSION_` varchar(255) DEFAULT NULL,
  `ASSIGNMENTDELEGATION_` bigint(20) DEFAULT NULL,
  `TASKMGMTDEFINITION_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `FK_SWL_ASSDEL` (`ASSIGNMENTDELEGATION_`),
  KEY `FK_SWL_TSKMGMTDEF` (`TASKMGMTDEFINITION_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_swimlaneinstance`
--

DROP TABLE IF EXISTS `jbpm_swimlaneinstance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_swimlaneinstance` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VERSION_` int(11) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `ACTORID_` varchar(255) DEFAULT NULL,
  `SWIMLANE_` bigint(20) DEFAULT NULL,
  `TASKMGMTINSTANCE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_SWIMLINST_SL` (`SWIMLANE_`),
  KEY `FK_SWIMLANEINST_TM` (`TASKMGMTINSTANCE_`),
  KEY `FK_SWIMLANEINST_SL` (`SWIMLANE_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_task`
--

DROP TABLE IF EXISTS `jbpm_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_task` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `NAME_` varchar(255) DEFAULT NULL,
  `DESCRIPTION_` varchar(4000) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `ISBLOCKING_` bit(1) DEFAULT NULL,
  `ISSIGNALLING_` bit(1) DEFAULT NULL,
  `CONDITION_` varchar(255) DEFAULT NULL,
  `DUEDATE_` varchar(255) DEFAULT NULL,
  `PRIORITY_` int(11) DEFAULT NULL,
  `ACTORIDEXPRESSION_` varchar(255) DEFAULT NULL,
  `POOLEDACTORSEXPRESSION_` varchar(255) DEFAULT NULL,
  `TASKMGMTDEFINITION_` bigint(20) DEFAULT NULL,
  `TASKNODE_` bigint(20) DEFAULT NULL,
  `STARTSTATE_` bigint(20) DEFAULT NULL,
  `ASSIGNMENTDELEGATION_` bigint(20) DEFAULT NULL,
  `SWIMLANE_` bigint(20) DEFAULT NULL,
  `TASKCONTROLLER_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_TASK_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `IDX_TASK_TSKNODE` (`TASKNODE_`),
  KEY `IDX_TASK_TASKMGTDF` (`TASKMGMTDEFINITION_`),
  KEY `FK_TASK_STARTST` (`STARTSTATE_`),
  KEY `FK_TASK_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `FK_TASK_ASSDEL` (`ASSIGNMENTDELEGATION_`),
  KEY `FK_TASK_SWIMLANE` (`SWIMLANE_`),
  KEY `FK_TASK_TASKNODE` (`TASKNODE_`),
  KEY `FK_TASK_TASKMGTDEF` (`TASKMGMTDEFINITION_`),
  KEY `FK_TSK_TSKCTRL` (`TASKCONTROLLER_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_taskactorpool`
--

DROP TABLE IF EXISTS `jbpm_taskactorpool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_taskactorpool` (
  `TASKINSTANCE_` bigint(20) NOT NULL,
  `POOLEDACTOR_` bigint(20) NOT NULL,
  PRIMARY KEY (`TASKINSTANCE_`,`POOLEDACTOR_`),
  KEY `FK_TASKACTPL_TSKI` (`TASKINSTANCE_`),
  KEY `FK_TSKACTPOL_PLACT` (`POOLEDACTOR_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_taskcontroller`
--

DROP TABLE IF EXISTS `jbpm_taskcontroller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_taskcontroller` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `TASKCONTROLLERDELEGATION_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `FK_TSKCTRL_DELEG` (`TASKCONTROLLERDELEGATION_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_taskinstance`
--

DROP TABLE IF EXISTS `jbpm_taskinstance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_taskinstance` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `VERSION_` int(11) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `DESCRIPTION_` varchar(4000) DEFAULT NULL,
  `ACTORID_` varchar(255) DEFAULT NULL,
  `CREATE_` datetime DEFAULT NULL,
  `START_` datetime DEFAULT NULL,
  `END_` datetime DEFAULT NULL,
  `DUEDATE_` datetime DEFAULT NULL,
  `PRIORITY_` int(11) DEFAULT NULL,
  `ISCANCELLED_` bit(1) DEFAULT NULL,
  `ISSUSPENDED_` bit(1) DEFAULT NULL,
  `ISOPEN_` bit(1) DEFAULT NULL,
  `ISSIGNALLING_` bit(1) DEFAULT NULL,
  `ISBLOCKING_` bit(1) DEFAULT NULL,
  `TASK_` bigint(20) DEFAULT NULL,
  `TOKEN_` bigint(20) DEFAULT NULL,
  `PROCINST_` bigint(20) DEFAULT NULL,
  `SWIMLANINSTANCE_` bigint(20) DEFAULT NULL,
  `TASKMGMTINSTANCE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_TSKINST_TMINST` (`TASKMGMTINSTANCE_`),
  KEY `IDX_TSKINST_SLINST` (`SWIMLANINSTANCE_`),
  KEY `IDX_TASKINST_TOKN` (`TOKEN_`),
  KEY `IDX_TASK_ACTORID` (`ACTORID_`),
  KEY `IDX_TASKINST_TSK` (`TASK_`,`PROCINST_`),
  KEY `FK_TSKINS_PRCINS` (`PROCINST_`),
  KEY `FK_TASKINST_TMINST` (`TASKMGMTINSTANCE_`),
  KEY `FK_TASKINST_TOKEN` (`TOKEN_`),
  KEY `FK_TASKINST_SLINST` (`SWIMLANINSTANCE_`),
  KEY `FK_TASKINST_TASK` (`TASK_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_token`
--

DROP TABLE IF EXISTS `jbpm_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_token` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VERSION_` int(11) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `START_` datetime DEFAULT NULL,
  `END_` datetime DEFAULT NULL,
  `NODEENTER_` datetime DEFAULT NULL,
  `NEXTLOGINDEX_` int(11) DEFAULT NULL,
  `ISABLETOREACTIVATEPARENT_` bit(1) DEFAULT NULL,
  `ISTERMINATIONIMPLICIT_` bit(1) DEFAULT NULL,
  `ISSUSPENDED_` bit(1) DEFAULT NULL,
  `LOCK_` varchar(255) DEFAULT NULL,
  `NODE_` bigint(20) DEFAULT NULL,
  `PROCESSINSTANCE_` bigint(20) DEFAULT NULL,
  `PARENT_` bigint(20) DEFAULT NULL,
  `SUBPROCESSINSTANCE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_TOKEN_PARENT` (`PARENT_`),
  KEY `IDX_TOKEN_PROCIN` (`PROCESSINSTANCE_`),
  KEY `IDX_TOKEN_NODE` (`NODE_`),
  KEY `IDX_TOKEN_SUBPI` (`SUBPROCESSINSTANCE_`),
  KEY `FK_TOKEN_SUBPI` (`SUBPROCESSINSTANCE_`),
  KEY `FK_TOKEN_PROCINST` (`PROCESSINSTANCE_`),
  KEY `FK_TOKEN_NODE` (`NODE_`),
  KEY `FK_TOKEN_PARENT` (`PARENT_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_tokenvariablemap`
--

DROP TABLE IF EXISTS `jbpm_tokenvariablemap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_tokenvariablemap` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VERSION_` int(11) NOT NULL,
  `TOKEN_` bigint(20) DEFAULT NULL,
  `CONTEXTINSTANCE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_TKVVARMP_TOKEN` (`TOKEN_`),
  KEY `IDX_TKVARMAP_CTXT` (`CONTEXTINSTANCE_`),
  KEY `FK_TKVARMAP_TOKEN` (`TOKEN_`),
  KEY `FK_TKVARMAP_CTXT` (`CONTEXTINSTANCE_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_transition`
--

DROP TABLE IF EXISTS `jbpm_transition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_transition` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `NAME_` varchar(255) DEFAULT NULL,
  `DESCRIPTION_` varchar(4000) DEFAULT NULL,
  `PROCESSDEFINITION_` bigint(20) DEFAULT NULL,
  `FROM_` bigint(20) DEFAULT NULL,
  `TO_` bigint(20) DEFAULT NULL,
  `CONDITION_` varchar(255) DEFAULT NULL,
  `FROMINDEX_` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_TRANS_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `IDX_TRANSIT_FROM` (`FROM_`),
  KEY `IDX_TRANSIT_TO` (`TO_`),
  KEY `FK_TRANSITION_FROM` (`FROM_`),
  KEY `FK_TRANS_PROCDEF` (`PROCESSDEFINITION_`),
  KEY `FK_TRANSITION_TO` (`TO_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_variableaccess`
--

DROP TABLE IF EXISTS `jbpm_variableaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_variableaccess` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `VARIABLENAME_` varchar(255) DEFAULT NULL,
  `ACCESS_` varchar(255) DEFAULT NULL,
  `MAPPEDNAME_` varchar(255) DEFAULT NULL,
  `SCRIPT_` bigint(20) DEFAULT NULL,
  `PROCESSSTATE_` bigint(20) DEFAULT NULL,
  `TASKCONTROLLER_` bigint(20) DEFAULT NULL,
  `INDEX_` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `FK_VARACC_PROCST` (`PROCESSSTATE_`),
  KEY `FK_VARACC_SCRIPT` (`SCRIPT_`),
  KEY `FK_VARACC_TSKCTRL` (`TASKCONTROLLER_`),
  CONSTRAINT `FK_VARACC_SCRIPT` FOREIGN KEY (`SCRIPT_`) REFERENCES `jbpm_action` (`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jbpm_variableinstance`
--

DROP TABLE IF EXISTS `jbpm_variableinstance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jbpm_variableinstance` (
  `ID_` bigint(20) NOT NULL AUTO_INCREMENT,
  `CLASS_` char(1) NOT NULL,
  `VERSION_` int(11) NOT NULL,
  `NAME_` varchar(255) DEFAULT NULL,
  `CONVERTER_` char(1) DEFAULT NULL,
  `TOKEN_` bigint(20) DEFAULT NULL,
  `TOKENVARIABLEMAP_` bigint(20) DEFAULT NULL,
  `PROCESSINSTANCE_` bigint(20) DEFAULT NULL,
  `BYTEARRAYVALUE_` bigint(20) DEFAULT NULL,
  `DATEVALUE_` datetime DEFAULT NULL,
  `DOUBLEVALUE_` double DEFAULT NULL,
  `LONGIDCLASS_` varchar(255) DEFAULT NULL,
  `LONGVALUE_` bigint(20) DEFAULT NULL,
  `STRINGIDCLASS_` varchar(255) DEFAULT NULL,
  `STRINGVALUE_` varchar(255) DEFAULT NULL,
  `TASKINSTANCE_` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_`),
  KEY `IDX_VARINST_TK` (`TOKEN_`),
  KEY `IDX_VARINST_TKVARMP` (`TOKENVARIABLEMAP_`),
  KEY `IDX_VARINST_PRCINS` (`PROCESSINSTANCE_`),
  KEY `FK_VARINST_PRCINST` (`PROCESSINSTANCE_`),
  KEY `FK_VARINST_TKVARMP` (`TOKENVARIABLEMAP_`),
  KEY `FK_VARINST_TK` (`TOKEN_`),
  KEY `FK_BYTEINST_ARRAY` (`BYTEARRAYVALUE_`),
  KEY `FK_VAR_TSKINST` (`TASKINSTANCE_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_activity`
--

DROP TABLE IF EXISTS `okm_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_activity` (
  `ACT_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ACT_ACTION` varchar(127) DEFAULT NULL,
  `ACT_DATE` datetime DEFAULT NULL,
  `ACT_ITEM` varchar(64) DEFAULT NULL,
  `ACT_PARAMS` varchar(4000) DEFAULT NULL,
  `ACT_PATH` longtext,
  `ACT_USER` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ACT_ID`),
  KEY `IDX_ACTIVITY_DATE` (`ACT_DATE`),
  KEY `IDX_ACTIVITY_USRACT` (`ACT_USER`,`ACT_ACTION`),
  KEY `IDX_ACTIVITY_DATACT` (`ACT_DATE`,`ACT_ACTION`)
) ENGINE=InnoDB AUTO_INCREMENT=1764029 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_auto_action`
--

DROP TABLE IF EXISTS `okm_auto_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_auto_action` (
  `AAC_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AAC_ACTIVE` char(1) NOT NULL,
  `AAC_ORDER` int(11) DEFAULT NULL,
  `AAC_TYPE` bigint(20) DEFAULT NULL,
  `AAC_RULE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`AAC_ID`),
  KEY `FK329CD57874C40738` (`AAC_RULE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_auto_action_params`
--

DROP TABLE IF EXISTS `okm_auto_action_params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_auto_action_params` (
  `AAP_VALIDATION` bigint(20) NOT NULL,
  `AAP_PARAM` longtext,
  `AAP_ORDER` int(11) NOT NULL,
  PRIMARY KEY (`AAP_VALIDATION`,`AAP_ORDER`),
  KEY `FK1F747E2D721D97C2` (`AAP_VALIDATION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_auto_metadata`
--

DROP TABLE IF EXISTS `okm_auto_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_auto_metadata` (
  `AMD_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AMD_AT` varchar(32) DEFAULT NULL,
  `AMD_CLASS_NAME` varchar(255) DEFAULT NULL,
  `AMD_DESC00` varchar(32) DEFAULT NULL,
  `AMD_DESC01` varchar(32) DEFAULT NULL,
  `AMD_GROUP` varchar(255) DEFAULT NULL,
  `AMD_NAME` varchar(255) DEFAULT NULL,
  `AMD_SRC00` varchar(32) DEFAULT NULL,
  `AMD_SRC01` varchar(32) DEFAULT NULL,
  `AMD_TYPE00` varchar(32) DEFAULT NULL,
  `AMD_TYPE01` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`AMD_ID`),
  UNIQUE KEY `AMD_AT` (`AMD_AT`,`AMD_CLASS_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_auto_rule`
--

DROP TABLE IF EXISTS `okm_auto_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_auto_rule` (
  `ARL_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ARL_ACTIVE` char(1) NOT NULL,
  `ARL_AT` varchar(32) DEFAULT NULL,
  `ARL_EVENT` varchar(32) DEFAULT NULL,
  `ARL_EXCLUSIVE` char(1) NOT NULL,
  `ARL_NAME` varchar(255) DEFAULT NULL,
  `ARL_ORDER` int(11) DEFAULT NULL,
  PRIMARY KEY (`ARL_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_auto_validation`
--

DROP TABLE IF EXISTS `okm_auto_validation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_auto_validation` (
  `AVL_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AVL_ACTIVE` char(1) NOT NULL,
  `AVL_ORDER` int(11) DEFAULT NULL,
  `AVL_TYPE` bigint(20) DEFAULT NULL,
  `AVL_RULE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`AVL_ID`),
  KEY `FKD3E426BBDB028124` (`AVL_RULE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_auto_validation_params`
--

DROP TABLE IF EXISTS `okm_auto_validation_params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_auto_validation_params` (
  `AVP_VALIDATION` bigint(20) NOT NULL,
  `AVP_PARAM` varchar(255) DEFAULT NULL,
  `AVP_ORDER` int(11) NOT NULL,
  PRIMARY KEY (`AVP_VALIDATION`,`AVP_ORDER`),
  KEY `FK3F6ECB8A23B4689A` (`AVP_VALIDATION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_bookmark`
--

DROP TABLE IF EXISTS `okm_bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_bookmark` (
  `BM_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `BM_NAME` varchar(127) DEFAULT NULL,
  `BM_NODE` varchar(64) DEFAULT NULL,
  `BM_TYPE` varchar(64) DEFAULT NULL,
  `BM_USER` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`BM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_config`
--

DROP TABLE IF EXISTS `okm_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_config` (
  `CFG_KEY` varchar(64) NOT NULL,
  `CFG_TYPE` varchar(32) DEFAULT NULL,
  `CFG_VALUE` longtext,
  PRIMARY KEY (`CFG_KEY`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_cron_tab`
--

DROP TABLE IF EXISTS `okm_cron_tab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_cron_tab` (
  `CT_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CT_NAME` varchar(255) NOT NULL,
  `CT_EXPRESSION` varchar(255) NOT NULL,
  `CT_FILE_CONTENT` longtext NOT NULL,
  `CT_FILE_NAME` varchar(255) NOT NULL,
  `CT_FILE_MIME` varchar(255) NOT NULL,
  `CT_MAIL` varchar(255) NOT NULL,
  `CT_ACTIVE` char(1) NOT NULL,
  `CT_LAST_BEGIN` datetime DEFAULT NULL,
  `CT_LAST_END` datetime DEFAULT NULL,
  PRIMARY KEY (`CT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_css`
--

DROP TABLE IF EXISTS `okm_css`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_css` (
  `CSS_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CSS_ACTIVE` char(1) NOT NULL,
  `CSS_CONTENT` longtext,
  `CSS_CONTEXT` varchar(64) DEFAULT NULL,
  `CSS_NAME` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`CSS_ID`),
  UNIQUE KEY `CSS_NAME` (`CSS_NAME`,`CSS_CONTEXT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_dashboard`
--

DROP TABLE IF EXISTS `okm_dashboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_dashboard` (
  `DB_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `DB_USER` varchar(64) NOT NULL,
  `DB_SOURCE` varchar(64) NOT NULL,
  `DB_NODE` varchar(64) NOT NULL,
  `DB_DATE` datetime NOT NULL,
  PRIMARY KEY (`DB_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_dashboard_activity`
--

DROP TABLE IF EXISTS `okm_dashboard_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_dashboard_activity` (
  `DAC_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `DAC_ACTION` varchar(127) DEFAULT NULL,
  `DAC_DATE` datetime DEFAULT NULL,
  `DAC_ITEM` varchar(64) DEFAULT NULL,
  `DAC_PATH` varchar(4000) DEFAULT NULL,
  `DAC_USER` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`DAC_ID`),
  KEY `IDX_DASH_ACTI_USRACT` (`DAC_USER`,`DAC_ACTION`),
  KEY `IDX_DASH_ACTI_DATACT` (`DAC_DATE`,`DAC_ACTION`),
  KEY `IDX_DASH_ACTI_DATE` (`DAC_DATE`)
) ENGINE=InnoDB AUTO_INCREMENT=62670 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_db_metadata_sequence`
--

DROP TABLE IF EXISTS `okm_db_metadata_sequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_db_metadata_sequence` (
  `DMS_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `DMS_COLUMN` varchar(32) DEFAULT NULL,
  `DMS_TABLE` varchar(32) DEFAULT NULL,
  `DMS_VALUE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`DMS_ID`),
  UNIQUE KEY `DMS_TABLE` (`DMS_TABLE`,`DMS_COLUMN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_db_metadata_type`
--

DROP TABLE IF EXISTS `okm_db_metadata_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_db_metadata_type` (
  `DMT_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `DMT_REAL_COLUMN` varchar(6) DEFAULT NULL,
  `DMT_TABLE` varchar(32) DEFAULT NULL,
  `DMT_TYPE` varchar(32) DEFAULT NULL,
  `DMT_VIRTUAL_COLUMN` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`DMT_ID`),
  UNIQUE KEY `DMT_TABLE` (`DMT_TABLE`,`DMT_REAL_COLUMN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_db_metadata_value`
--

DROP TABLE IF EXISTS `okm_db_metadata_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_db_metadata_value` (
  `DMV_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `DMV_COL00` varchar(512) DEFAULT NULL,
  `DMV_COL01` varchar(512) DEFAULT NULL,
  `DMV_COL02` varchar(512) DEFAULT NULL,
  `DMV_COL03` varchar(512) DEFAULT NULL,
  `DMV_COL04` varchar(512) DEFAULT NULL,
  `DMV_COL05` varchar(512) DEFAULT NULL,
  `DMV_COL06` varchar(512) DEFAULT NULL,
  `DMV_COL07` varchar(512) DEFAULT NULL,
  `DMV_COL08` varchar(512) DEFAULT NULL,
  `DMV_COL09` varchar(512) DEFAULT NULL,
  `DMV_COL10` varchar(512) DEFAULT NULL,
  `DMV_COL11` varchar(512) DEFAULT NULL,
  `DMV_COL12` varchar(512) DEFAULT NULL,
  `DMV_COL13` varchar(512) DEFAULT NULL,
  `DMV_COL14` varchar(512) DEFAULT NULL,
  `DMV_TABLE` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`DMV_ID`),
  KEY `IDX_DB_MD_VAL_COL07` (`DMV_COL07`),
  KEY `IDX_DB_MD_VAL_TABLE` (`DMV_TABLE`),
  KEY `IDX_DB_MD_VAL_COL08` (`DMV_COL08`),
  KEY `IDX_DB_MD_VAL_COL09` (`DMV_COL09`),
  KEY `IDX_DB_MD_VAL_COL14` (`DMV_COL14`),
  KEY `IDX_DB_MD_VAL_COL11` (`DMV_COL11`),
  KEY `IDX_DB_MD_VAL_COL10` (`DMV_COL10`),
  KEY `IDX_DB_MD_VAL_COL13` (`DMV_COL13`),
  KEY `IDX_DB_MD_VAL_COL12` (`DMV_COL12`),
  KEY `IDX_DB_MD_VAL_COL01` (`DMV_COL01`),
  KEY `IDX_DB_MD_VAL_COL02` (`DMV_COL02`),
  KEY `IDX_DB_MD_VAL_COL00` (`DMV_COL00`),
  KEY `IDX_DB_MD_VAL_COL05` (`DMV_COL05`),
  KEY `IDX_DB_MD_VAL_COL06` (`DMV_COL06`),
  KEY `IDX_DB_MD_VAL_COL03` (`DMV_COL03`),
  KEY `IDX_DB_MD_VAL_COL04` (`DMV_COL04`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_dropbox_token`
--

DROP TABLE IF EXISTS `okm_dropbox_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_dropbox_token` (
  `DBT_USER` varchar(64) NOT NULL,
  `DBT_KEY` varchar(64) DEFAULT NULL,
  `DBT_SECRET` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`DBT_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_extension`
--

DROP TABLE IF EXISTS `okm_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_extension` (
  `EXT_UUID` varchar(64) NOT NULL,
  `EXT_NAME` varchar(255) NOT NULL,
  PRIMARY KEY (`EXT_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_mail_account`
--

DROP TABLE IF EXISTS `okm_mail_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_mail_account` (
  `MA_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `MA_USER` varchar(64) COLLATE utf8_bin NOT NULL,
  `MA_MPROTOCOL` varchar(255) COLLATE utf8_bin NOT NULL,
  `MA_MHOST` varchar(255) COLLATE utf8_bin NOT NULL,
  `MA_MFOLDER` varchar(255) COLLATE utf8_bin NOT NULL,
  `MA_MUSER` varchar(255) COLLATE utf8_bin NOT NULL,
  `MA_MPASSWORD` varchar(255) COLLATE utf8_bin NOT NULL,
  `MA_MMARK_SEEN` bit(1) NOT NULL,
  `MA_MMARK_DELETED` bit(1) NOT NULL,
  `MA_MLAST_UID` bigint(20) NOT NULL,
  `MA_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`MA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_mail_filter`
--

DROP TABLE IF EXISTS `okm_mail_filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_mail_filter` (
  `MF_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `MF_PATH` longtext COLLATE utf8_bin NOT NULL,
  `MF_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `MF_GROUPING` bit(1) NOT NULL,
  `MF_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  `MF_MAIL_ACCOUNT` bigint(20) NOT NULL,
  PRIMARY KEY (`MF_ID`),
  KEY `FK89DD61B2D99BBF14` (`MF_MAIL_ACCOUNT`),
  CONSTRAINT `FK89DD61B2D99BBF14` FOREIGN KEY (`MF_MAIL_ACCOUNT`) REFERENCES `okm_mail_account` (`MA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_mail_filter_rule`
--

DROP TABLE IF EXISTS `okm_mail_filter_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_mail_filter_rule` (
  `MFR_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `MFR_FIELD` varchar(255) COLLATE utf8_bin NOT NULL,
  `MFR_OPERATION` varchar(255) COLLATE utf8_bin NOT NULL,
  `MFR_VALUE` varchar(255) COLLATE utf8_bin NOT NULL,
  `MFR_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  `MFR_MAIL_FILTER` bigint(20) NOT NULL,
  PRIMARY KEY (`MFR_ID`),
  KEY `FKD3772569BF5FB556` (`MFR_MAIL_FILTER`),
  CONSTRAINT `FKD3772569BF5FB556` FOREIGN KEY (`MFR_MAIL_FILTER`) REFERENCES `okm_mail_filter` (`MF_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_mime_type`
--

DROP TABLE IF EXISTS `okm_mime_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_mime_type` (
  `MT_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `MT_DESCRIPTION` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `MT_IMAGE_CONTENT` longtext COLLATE utf8_bin,
  `MT_IMAGE_MIME` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `MT_NAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `MT_SEARCH` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`MT_ID`),
  UNIQUE KEY `MT_DESCRIPTION` (`MT_DESCRIPTION`),
  UNIQUE KEY `MT_NAME` (`MT_NAME`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_mime_type_extension`
--

DROP TABLE IF EXISTS `okm_mime_type_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_mime_type_extension` (
  `MTE_ID` bigint(20) NOT NULL,
  `MTE_NAME` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK198BAD77C645F9B7` (`MTE_ID`),
  CONSTRAINT `FK198BAD77C645F9B7` FOREIGN KEY (`MTE_ID`) REFERENCES `okm_mime_type` (`MT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_base`
--

DROP TABLE IF EXISTS `okm_node_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_base` (
  `NBS_UUID` varchar(64) COLLATE utf8_bin NOT NULL,
  `NBS_AUTHOR` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NBS_CONTEXT` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `NBS_CREATED` datetime DEFAULT NULL,
  `NBS_NAME` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `NBS_PARENT` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NBS_PATH` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `NDC_SCRIPT_CODE` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `NDC_SCRIPTING` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NBS_UUID`),
  KEY `IDX_NODE_BASE_PARENT` (`NBS_PARENT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_category`
--

DROP TABLE IF EXISTS `okm_node_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_category` (
  `NCT_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NCT_CATEGORY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK79CB24CD7EC0E7A2` (`NCT_NODE`),
  CONSTRAINT `FK79CB24CD7EC0E7A2` FOREIGN KEY (`NCT_NODE`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_document`
--

DROP TABLE IF EXISTS `okm_node_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_document` (
  `NDC_CHECKED_OUT` char(1) COLLATE utf8_bin NOT NULL,
  `NDC_DESCRIPTION` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `NDC_LANGUAGE` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `NDC_LAST_MODIFIED` datetime DEFAULT NULL,
  `NLK_CREATED` datetime DEFAULT NULL,
  `NLK_OWNER` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NLK_TOKEN` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NDC_LOCKED` char(1) COLLATE utf8_bin NOT NULL,
  `NDC_MIME_TYPE` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `NDC_TEXT` longtext COLLATE utf8_bin,
  `NDC_TEXT_EXTRACTED` char(1) COLLATE utf8_bin NOT NULL,
  `NDC_TITLE` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `NBS_UUID` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NBS_UUID`),
  KEY `FKAA2538EA4829197B` (`NBS_UUID`),
  CONSTRAINT `FKAA2538EA4829197B` FOREIGN KEY (`NBS_UUID`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_document_version`
--

DROP TABLE IF EXISTS `okm_node_document_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_document_version` (
  `NDV_UUID` varchar(64) COLLATE utf8_bin NOT NULL,
  `NDV_AUTHOR` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NDV_CHECKSUM` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `NDV_COMMENT` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `NDV_CONTENT` longblob,
  `NDV_CREATED` datetime DEFAULT NULL,
  `NDV_CURRENT` char(1) COLLATE utf8_bin NOT NULL,
  `NDV_MIME_TYPE` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `NDV_NAME` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NDV_PARENT` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NDV_PREVIOUS` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NDV_SIZE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`NDV_UUID`),
  UNIQUE KEY `NDV_PARENT` (`NDV_PARENT`,`NDV_NAME`),
  KEY `IDX_NOD_DOC_VER_PARENT` (`NDV_PARENT`),
  KEY `IDX_NOD_DOC_VER_PARCUR` (`NDV_PARENT`,`NDV_CURRENT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_folder`
--

DROP TABLE IF EXISTS `okm_node_folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_folder` (
  `NFL_DESCRIPTION` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `NBS_UUID` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NBS_UUID`),
  KEY `FKBE9C2FFD4829197B` (`NBS_UUID`),
  CONSTRAINT `FKBE9C2FFD4829197B` FOREIGN KEY (`NBS_UUID`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_keyword`
--

DROP TABLE IF EXISTS `okm_node_keyword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_keyword` (
  `NKW_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NKW_KEYWORD` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FKD187C1A2B114B87` (`NKW_NODE`),
  CONSTRAINT `FKD187C1A2B114B87` FOREIGN KEY (`NKW_NODE`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_mail`
--

DROP TABLE IF EXISTS `okm_node_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_mail` (
  `NML_CONTENT` longtext COLLATE utf8_bin,
  `NML_FROM` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `NML_MIME_TYPE` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NML_RECEIVED_DATE` datetime DEFAULT NULL,
  `NML_SENT_DATE` datetime DEFAULT NULL,
  `NML_SIZE` bigint(20) DEFAULT NULL,
  `NML_SUBJECT` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `NBS_UUID` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NBS_UUID`),
  KEY `FKF20B5064829197B` (`NBS_UUID`),
  CONSTRAINT `FKF20B5064829197B` FOREIGN KEY (`NBS_UUID`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_mail_bcc`
--

DROP TABLE IF EXISTS `okm_node_mail_bcc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_mail_bcc` (
  `NMB_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NML_BCC` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK763EF169710CFBE4` (`NMB_NODE`),
  CONSTRAINT `FK763EF169710CFBE4` FOREIGN KEY (`NMB_NODE`) REFERENCES `okm_node_mail` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_mail_cc`
--

DROP TABLE IF EXISTS `okm_node_mail_cc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_mail_cc` (
  `NMC_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NML_CC` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK6F2B523972C1D483` (`NMC_NODE`),
  CONSTRAINT `FK6F2B523972C1D483` FOREIGN KEY (`NMC_NODE`) REFERENCES `okm_node_mail` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_mail_reply`
--

DROP TABLE IF EXISTS `okm_node_mail_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_mail_reply` (
  `NMT_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NML_REPLY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FKE32AD6518FC43712` (`NMT_NODE`),
  CONSTRAINT `FKE32AD6518FC43712` FOREIGN KEY (`NMT_NODE`) REFERENCES `okm_node_mail` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_mail_to`
--

DROP TABLE IF EXISTS `okm_node_mail_to`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_mail_to` (
  `NMT_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NML_TO` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK6F2B54548FC43712` (`NMT_NODE`),
  CONSTRAINT `FK6F2B54548FC43712` FOREIGN KEY (`NMT_NODE`) REFERENCES `okm_node_mail` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_note`
--

DROP TABLE IF EXISTS `okm_node_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_note` (
  `NNT_UUID` varchar(64) COLLATE utf8_bin NOT NULL,
  `NNT_AUTHOR` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NNT_CREATED` datetime DEFAULT NULL,
  `NNT_PARENT` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `NNT_TEXT` longtext COLLATE utf8_bin,
  PRIMARY KEY (`NNT_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_property`
--

DROP TABLE IF EXISTS `okm_node_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_property` (
  `NPG_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NPG_GROUP` varchar(64) COLLATE utf8_bin NOT NULL,
  `NPG_NAME` varchar(64) COLLATE utf8_bin NOT NULL,
  `NPG_VALUE` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `NPG_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NPG_ID`),
  UNIQUE KEY `NPG_NODE` (`NPG_NODE`,`NPG_GROUP`,`NPG_NAME`),
  KEY `FK3B9645A41842E9DC` (`NPG_NODE`),
  CONSTRAINT `FK3B9645A41842E9DC` FOREIGN KEY (`NPG_NODE`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_role_permission`
--

DROP TABLE IF EXISTS `okm_node_role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_role_permission` (
  `NRP_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NRP_PERMISSION` int(11) DEFAULT NULL,
  `NRP_ROLE` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NRP_NODE`,`NRP_ROLE`),
  KEY `FKF4FBBA89916AFDF5` (`NRP_NODE`),
  CONSTRAINT `FKF4FBBA89916AFDF5` FOREIGN KEY (`NRP_NODE`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_subscriptor`
--

DROP TABLE IF EXISTS `okm_node_subscriptor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_subscriptor` (
  `NSB_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NSB_SUBSCRIPTOR` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK159C2BDFAE6D6084` (`NSB_NODE`),
  CONSTRAINT `FK159C2BDFAE6D6084` FOREIGN KEY (`NSB_NODE`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_node_user_permission`
--

DROP TABLE IF EXISTS `okm_node_user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_node_user_permission` (
  `NUP_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `NUP_PERMISSION` int(11) DEFAULT NULL,
  `NUP_USER` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NUP_NODE`,`NUP_USER`),
  KEY `FK68755814301DAFB8` (`NUP_NODE`),
  CONSTRAINT `FK68755814301DAFB8` FOREIGN KEY (`NUP_NODE`) REFERENCES `okm_node_base` (`NBS_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_omr`
--

DROP TABLE IF EXISTS `okm_omr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_omr` (
  `OMR_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `OMR_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  `OMR_ASC_FILE_CONTENT` longblob,
  `OMR_FILE_ASC_MIME` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `OMR_ASC_FILENAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `OMR_CONFIG_FILE_CONTENT` longblob,
  `OMR_FILE_CONFIG_MIME` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `OMR_CONFIG_FILENAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `OMR_FIELDS_FILE_CONTENT` longblob,
  `OMR_FILE_FIELDS_MIME` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `OMR_FIELDS_FILENAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `OMR_NAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `OMR_TEMPLATE_FILE_CONTENT` longblob,
  `OMR_FILE_TEMPLATE_MIME` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `OMR_TEMPLATE_FILENAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`OMR_ID`),
  UNIQUE KEY `OMR_NAME` (`OMR_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_omr_property`
--

DROP TABLE IF EXISTS `okm_omr_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_omr_property` (
  `OMP_OMR` bigint(20) NOT NULL,
  `OMP_PROPERTY` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FKC29BAF0E7E82264E` (`OMP_OMR`),
  CONSTRAINT `FKC29BAF0E7E82264E` FOREIGN KEY (`OMP_OMR`) REFERENCES `okm_omr` (`OMR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_pending_task`
--

DROP TABLE IF EXISTS `okm_pending_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_pending_task` (
  `PTK_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PTK_CREATED` datetime DEFAULT NULL,
  `PTK_NODE` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `PTK_PARAMS` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `PTK_STATUS` longtext COLLATE utf8_bin,
  `PTK_TASK` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`PTK_ID`),
  KEY `IDX_PENDING_NODETASK` (`PTK_NODE`,`PTK_TASK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_profile`
--

DROP TABLE IF EXISTS `okm_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_profile` (
  `PRF_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PRF_NAME` varchar(255) COLLATE utf8_bin NOT NULL,
  `PRF_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  `PRF_MSC_ADVANCED_FILTERS` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_MSC_USER_QUOTA` bigint(20) DEFAULT '0',
  `PRF_MSC_WEB_SKIN` varchar(255) COLLATE utf8_bin DEFAULT 'default',
  `PRF_MSC_PRINT_PREVIEW` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MSC_KEYWORDS_EN` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MSC_UPLD_NOTI_USR` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MSC_NOTI_EXTERNAL_USR` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_MSC_ACRO_PLUGIN_PRE` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_MSC_INCREASE_VER` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_CHT_CHAT_EN` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_CHT_AUTO_LOGIN_EN` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_PAG_PAGINATION_EN` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_PAG_PAGE_LIST` varchar(255) COLLATE utf8_bin DEFAULT '10;25;50;100',
  `PRF_PAG_TYPE_FILTER_EN` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_PAG_MISC_FILTER_EN` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_PAG_SHOW_FLDS_EN` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_PAG_SHOW_DOCS_EN` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_PAG_SHOW_MAILS_EN` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_WZRD_KEYWORDS_EN` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_WZRD_CATEGORIES_EN` char(1) COLLATE utf8_bin DEFAULT 'F',
  `PRF_STCK_TAXONOMY_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_STCK_CATEGORIES_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_STCK_THESAURUS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_STCK_TEMPLATES_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_STCK_PERSONAL_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_STCK_MAIL_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_STCK_METADATA_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_STCK_TRASH_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DEFAULT` varchar(255) COLLATE utf8_bin DEFAULT 'desktop',
  `PRF_TB_DESKTOP_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_SEARCH_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DASHBOARD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ADMIN_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOC_PROPS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOC_SECURITY_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOC_NOTES_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOC_VERSIONS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOC_VERSION_DOWN_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOC_PREVIEW_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOC_PROP_GRPS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_FLD_PROPS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_FLD_SECURITY_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_FLD_NOTES_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ML_PROPS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ML_PREVIEW_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ML_SECURITY_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ML_NOTES_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_DB_USER_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_DB_MAIL_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_DB_NEWS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_DB_GENERAL_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_DB_WORKFLOW_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_DB_KEYWORDS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FILE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_EDIT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TOOLS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_BOOKMARKS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TEMPLATES_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_HELP_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_CREATE_FLD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_FIND_FLD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_FIND_DOC_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_SIMILAR_DOC_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_GO_FLD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_DOWNLOAD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_DOWNLOAD_PDF_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_ADD_DOC_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_START_WORKFLOW_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_REFRESH_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_SCANNER_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_UPLOADER_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_PURGE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_PURGE_TRASH_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_RESTORE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_EXPORT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_CREATE_FROM_TPL_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_SEND_DOC_LINK_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_SEND_DOC_ATTACH_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_FI_FORWARD_MAIL_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_LOCK_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_UNLOCK_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_CIN_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_COUT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_CANCEL_COUT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_DELETE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_RENAME_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_COPY_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_MOVE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_ADD_SUBS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_REM_SUBS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_ADD_PROP_GRP_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_UPDATE_PROP_GRP_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_REM_PROP_GRP_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_ADD_NOTE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_REM_NOTE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_ADD_CATEGORY_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_REM_CATEGORY_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_ADD_KEYWORD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_REM_KEYWORD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_ED_MERGE_PDF_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_BM_MNG_BOOKMARKS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_BM_ADD_BOOKMARK_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_BM_SET_HOME_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_BM_GO_HOME_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TL_LANGS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TL_SKIN_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TL_DEBUG_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TL_ADMIN_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TL_PREFS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TL_OMR_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_TL_CONVERT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_HLP_DOC_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_HLP_BUG_TRACKING_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_HLP_SUPPORT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_HLP_FORUM_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_HLP_CHANGELOG_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MN_HLP_WEB_SITE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_MNU_HLP_ABOUT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_CREATE_FLD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_FIND_FLD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_FIND_DOC_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_SIMILAR_DOC_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOWNLOAD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DOWNLOAD_PDF_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_PRINT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_LOCK_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_UNLOCK_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ADD_DOC_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_COUT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_CIN_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_CANCEL_COUT_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_DELETE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ADD_PROP_GRP_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_REM_PROP_GRP_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_START_WORKFLOW_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_ADD_SUBS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_REM_SUBS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_REFRESH_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_HOME_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_SCANNER_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_UPLOADER_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_SPLITTER_RS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_TB_OMR_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_STATUS_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_MASSIVE_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_ICON_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_NAME_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_SIZE_PDF_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_LAST_MOD_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_AUTHOR_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_VERSION_VIS` char(1) COLLATE utf8_bin DEFAULT 'T',
  `PRF_FB_STATUS_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '60',
  `PRF_FB_MASSIVE_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '30',
  `PRF_FB_ICON_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '25',
  `PRF_FB_NAME_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '250',
  `PRF_FB_SIZE_PDF_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '60',
  `PRF_FB_LAST_MOD_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '150',
  `PRF_FB_AUTHOR_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '120',
  `PRF_FB_VERSION_WIDTH` varchar(255) COLLATE utf8_bin DEFAULT '60',
  PRIMARY KEY (`PRF_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_profile_msc_extension`
--

DROP TABLE IF EXISTS `okm_profile_msc_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_profile_msc_extension` (
  `PEX_ID` bigint(20) NOT NULL,
  `PEX_EXTENSION` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK92E57DB9DE9B36F3` (`PEX_ID`),
  CONSTRAINT `FK92E57DB9DE9B36F3` FOREIGN KEY (`PEX_ID`) REFERENCES `okm_profile` (`PRF_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_profile_msc_report`
--

DROP TABLE IF EXISTS `okm_profile_msc_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_profile_msc_report` (
  `PRP_ID` bigint(20) NOT NULL,
  `PRP_REPORT` bigint(20) DEFAULT NULL,
  KEY `FK1C67EDDADF4EC588` (`PRP_ID`),
  CONSTRAINT `FK1C67EDDADF4EC588` FOREIGN KEY (`PRP_ID`) REFERENCES `okm_profile` (`PRF_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_profile_msc_workflow`
--

DROP TABLE IF EXISTS `okm_profile_msc_workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_profile_msc_workflow` (
  `PMW_ID` bigint(20) NOT NULL,
  `PMW_WORKFLOW` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FKBDB3DAE5DF0B7E9C` (`PMW_ID`),
  CONSTRAINT `FKBDB3DAE5DF0B7E9C` FOREIGN KEY (`PMW_ID`) REFERENCES `okm_profile` (`PRF_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_profile_wzrd_prop_grp`
--

DROP TABLE IF EXISTS `okm_profile_wzrd_prop_grp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_profile_wzrd_prop_grp` (
  `PPG_ID` bigint(20) NOT NULL,
  `PPG_PROPERTY_GROUP` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK86D64A8FDF2E7F2F` (`PPG_ID`),
  CONSTRAINT `FK86D64A8FDF2E7F2F` FOREIGN KEY (`PPG_ID`) REFERENCES `okm_profile` (`PRF_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_profile_wzrd_workflow`
--

DROP TABLE IF EXISTS `okm_profile_wzrd_workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_profile_wzrd_workflow` (
  `PWF_ID` bigint(20) NOT NULL,
  `PWF_WORKFLOW` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FKC4189C65DF90AF57` (`PWF_ID`),
  CONSTRAINT `FKC4189C65DF90AF57` FOREIGN KEY (`PWF_ID`) REFERENCES `okm_profile` (`PRF_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_query_params`
--

DROP TABLE IF EXISTS `okm_query_params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_query_params` (
  `QP_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `QP_QUERY_NAME` varchar(255) COLLATE utf8_bin NOT NULL,
  `QP_USER` varchar(64) COLLATE utf8_bin NOT NULL,
  `QP_NAME` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_CONTENT` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_MIME_TYPE` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_AUTHOR` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_PATH` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_DASHBOARD` char(1) COLLATE utf8_bin DEFAULT NULL,
  `QP_LAST_MODIFIED_FROM` datetime DEFAULT NULL,
  `QP_LAST_MODIFIED_TO` datetime DEFAULT NULL,
  `QP_MAIL_SUBJECT` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_MAIL_FROM` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_MAIL_TO` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QP_STATEMENT_QUERY` longtext COLLATE utf8_bin,
  `QP_STATEMENT_TYPE` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`QP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_query_params_category`
--

DROP TABLE IF EXISTS `okm_query_params_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_query_params_category` (
  `QPC_ID` bigint(20) NOT NULL,
  `QPC_NAME` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FKE27BE632200C4397` (`QPC_ID`),
  CONSTRAINT `FKE27BE632200C4397` FOREIGN KEY (`QPC_ID`) REFERENCES `okm_query_params` (`QP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_query_params_keyword`
--

DROP TABLE IF EXISTS `okm_query_params_keyword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_query_params_keyword` (
  `QPK_ID` bigint(20) NOT NULL,
  `QPK_NAME` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK4A477A15200FE68F` (`QPK_ID`),
  CONSTRAINT `FK4A477A15200FE68F` FOREIGN KEY (`QPK_ID`) REFERENCES `okm_query_params` (`QP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_query_params_property`
--

DROP TABLE IF EXISTS `okm_query_params_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_query_params_property` (
  `QPP_ID` bigint(20) NOT NULL,
  `QPP_VALUE` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `QPP_NAME` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`QPP_ID`,`QPP_NAME`),
  KEY `FKA447070920122C6A` (`QPP_ID`),
  CONSTRAINT `FKA447070920122C6A` FOREIGN KEY (`QPP_ID`) REFERENCES `okm_query_params` (`QP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_query_params_shared`
--

DROP TABLE IF EXISTS `okm_query_params_shared`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_query_params_shared` (
  `QPS_ID` bigint(20) NOT NULL,
  `QPS_USER` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  KEY `FK20AF969920138987` (`QPS_ID`),
  CONSTRAINT `FK20AF969920138987` FOREIGN KEY (`QPS_ID`) REFERENCES `okm_query_params` (`QP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_reg_property`
--

DROP TABLE IF EXISTS `okm_reg_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_reg_property` (
  `RPR_GROUP` varchar(64) COLLATE utf8_bin NOT NULL,
  `RPR_TYPE` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `RPR_NAME` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`RPR_GROUP`,`RPR_NAME`),
  KEY `FKB3632CCED4ABA44F` (`RPR_GROUP`),
  CONSTRAINT `FKB3632CCED4ABA44F` FOREIGN KEY (`RPR_GROUP`) REFERENCES `okm_reg_property_group` (`RPG_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_reg_property_group`
--

DROP TABLE IF EXISTS `okm_reg_property_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_reg_property_group` (
  `RPG_NAME` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`RPG_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_report`
--

DROP TABLE IF EXISTS `okm_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_report` (
  `RP_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `RP_NAME` varchar(255) COLLATE utf8_bin NOT NULL,
  `RP_FILE_CONTENT` longtext COLLATE utf8_bin NOT NULL,
  `RP_FILE_MIME` varchar(255) COLLATE utf8_bin NOT NULL,
  `RP_FILE_NAME` varchar(255) COLLATE utf8_bin NOT NULL,
  `RP_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`RP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_role`
--

DROP TABLE IF EXISTS `okm_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_role` (
  `ROL_ID` varchar(64) COLLATE utf8_bin NOT NULL,
  `ROL_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ROL_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_translation`
--

DROP TABLE IF EXISTS `okm_translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_translation` (
  `TR_MODULE` varchar(64) COLLATE utf8_bin NOT NULL,
  `TR_KEY` varchar(127) COLLATE utf8_bin NOT NULL,
  `TR_LANGUAGE` varchar(8) COLLATE utf8_bin NOT NULL,
  `TR_TEXT` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`TR_MODULE`,`TR_KEY`,`TR_LANGUAGE`),
  KEY `FK91A2B543DE0D861E` (`TR_LANGUAGE`),
  CONSTRAINT `FK91A2B543DE0D861E` FOREIGN KEY (`TR_LANGUAGE`) REFERENCES `okm_language` (`LG_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_twitter_account`
--

DROP TABLE IF EXISTS `okm_twitter_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_twitter_account` (
  `TA_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TA_USER` varchar(64) COLLATE utf8_bin NOT NULL,
  `TA_TUSER` varchar(255) COLLATE utf8_bin NOT NULL,
  `TA_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`TA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_user`
--

DROP TABLE IF EXISTS `okm_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_user` (
  `USR_ID` varchar(64) COLLATE utf8_bin NOT NULL,
  `USR_NAME` varchar(255) COLLATE utf8_bin NOT NULL,
  `USR_PASSWORD` varchar(255) COLLATE utf8_bin NOT NULL,
  `USR_EMAIL` varchar(255) COLLATE utf8_bin NOT NULL,
  `USR_ACTIVE` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`USR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_user_config`
--

DROP TABLE IF EXISTS `okm_user_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_user_config` (
  `UC_USER` varchar(64) COLLATE utf8_bin NOT NULL,
  `UC_HOME_PATH` longtext COLLATE utf8_bin NOT NULL,
  `UC_HOME_NODE` varchar(64) COLLATE utf8_bin NOT NULL,
  `UC_HOME_TYPE` varchar(32) COLLATE utf8_bin NOT NULL,
  `UC_PROFILE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`UC_USER`),
  KEY `FK7798F4E88FDAFE34` (`UC_PROFILE`),
  CONSTRAINT `FK7798F4E88FDAFE34` FOREIGN KEY (`UC_PROFILE`) REFERENCES `okm_profile` (`PRF_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_user_items`
--

DROP TABLE IF EXISTS `okm_user_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_user_items` (
  `UI_USER` varchar(255) COLLATE utf8_bin NOT NULL,
  `UI_DOCUMENTS` bigint(20) DEFAULT NULL,
  `UI_FOLDERS` bigint(20) DEFAULT NULL,
  `UI_MAILS` bigint(20) DEFAULT NULL,
  `UI_SIZE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`UI_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_user_role`
--

DROP TABLE IF EXISTS `okm_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_user_role` (
  `UR_USER` varchar(64) COLLATE utf8_bin NOT NULL,
  `UR_ROLE` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`UR_USER`,`UR_ROLE`),
  KEY `FK79C279CF1BE829B` (`UR_ROLE`),
  KEY `FK79C279CF1C15945` (`UR_USER`),
  CONSTRAINT `FK79C279CF1BE829B` FOREIGN KEY (`UR_ROLE`) REFERENCES `okm_role` (`ROL_ID`),
  CONSTRAINT `FK79C279CF1C15945` FOREIGN KEY (`UR_USER`) REFERENCES `okm_user` (`USR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `okm_zoho_token`
--

DROP TABLE IF EXISTS `okm_zoho_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `okm_zoho_token` (
  `ZOT_ID` varchar(255) COLLATE utf8_bin NOT NULL,
  `ZOT_CREATION` datetime DEFAULT NULL,
  `ZOT_NODE` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `ZOT_USER` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ZOT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-06 13:58:48
