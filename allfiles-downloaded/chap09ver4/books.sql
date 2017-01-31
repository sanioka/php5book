-- MySQL dump 10.9
--
-- Host: localhost    Database: books
-- ------------------------------------------------------
-- Server version	4.1.12a-nt

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblbooks`
--

DROP TABLE IF EXISTS `tblbooks`;
CREATE TABLE `tblbooks` (
  `inventorynumber` int(11) NOT NULL auto_increment,
  `cat` char(3) NOT NULL default '',
  `title` varchar(150) NOT NULL default '',
  `author` varchar(100) NOT NULL default '',
  `publisher` varchar(4) NOT NULL default '',
  `sold` tinyint(1) default NULL,
  PRIMARY KEY  (`inventorynumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbooks`
--


/*!40000 ALTER TABLE `tblbooks` DISABLE KEYS */;
LOCK TABLES `tblbooks` WRITE;
INSERT INTO `tblbooks` VALUES (1,'PHI','Paris Lectures, The','Husserl, Edmund','MHIJ',0),(3,'LIT','How late it was, how late','Kelman, James','SW',0),(4,'LIT','Last Word, The','Greene, Graham','LOD',0),(5,'LIT','Slow Learner','Pynchon, Thomas','LB',0),(6,'LIT','Mangan Inheritance, The','Moore, Brian','FSG',0),(7,'LIT','Message in the Bottle, The','Percy, Walker','FSG',0),(8,'LIT','Key to My Heart, The','Pritchett, V.S.','RAND',0),(9, 'LIT', 'Let Us Compare Mythologies','Cohen, Leonard','MPS', 0);
UNLOCK TABLES;

DROP TABLE IF EXISTS `tblpublishers`;
CREATE TABLE `tblpublishers` (
  `pub` varchar(4) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `contact` varchar(30) default NULL,
  PRIMARY KEY  (`pub`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpublishers`
--


/*!40000 ALTER TABLE `tblpublishers` DISABLE KEYS */;
LOCK TABLES `tblpublishers` WRITE;
INSERT INTO `tblpublishers` VALUES ('ABB','Abbeville','New York','\r'),('ABR','Abrams','New York','\r'),('ALL','Allen and Unwin','London','\r'),('ANAN','House of Anansi','Toronto','\r'),('ARCH','Archon','Hamden','\r'),('ATH','Athena','New York','\r'),('AWC','Addison-Wesley Canada','Don Mills','\r'),('BASI','Basic Books','New York','\r'),('BLA','Basil Blackwell','Oxford','\r'),('BOH','Bodley Head','London','\r'),('CAL','Callaway','New York','\r'),('CAM','Cambridge University Press','Cambridge','\r'),('CAND','Candlewick Press','Cambridge','\r'),('CAR','Carcanet Press','Cheadle, Chesire','\r'),('CARM','Carswell Methuen','Toronto','\r'),('CBC','Canadian Broadcasting Corporation','Toronto','\r'),('CHAT','Chatto and Windus','London','\r'),('CHI','University of Chicago Press','Chicago','\r'),('CLIR','Clarke Irwin','Toronto','\r'),('CM','Collier-Macmillan Publishers','London','\r'),('COR','Cornell University Press','Ithaca','\r'),('DAW','Dawn Horse Press','San Francisco','\r'),('DOU','Doubleday','Garden City','\r'),('EMET','Eyre Methuen','London','\r'),('FOF','Facts on File','New York','\r'),('FSG','Farrar, Straus and Giroux','New York','\r'),('FW','Fitzhenry & Whiteside','Toronto','\r'),('GD','Grosset and Dunlap','New York','\r'),('GEN','General Publishing','Toronto','\r'),('GOD','David R. Godine','Boston','\r'),('GRA','Grafton','London','\r'),('GRO','Grove Weidenfeld','New York','\r'),('HAF','Hafner Publishing Co.','New York','\r'),('HAR','Harper & Row','New York','\r'),('HBJ','Harcourt, Brace Jovanovich','San Diego','\r'),('HEI','Heinemann','London','\r'),('HOUM','Houghton Mifflin','Boston','\r'),('HRW','Holt Rinehart and Winston','Toronto','\r'),('HUR','Hurtig','Edmonton','\r'),('KNOP','Knopf','New York','\r'),('LB','Little, Brown & Company','Boston','\r'),('LOD','Lester & Orpen Dennys','Toronto','\r'),('LOU','Louisiana State University','Baton Rouge','\r'),('MAC','Macmillan','London','\r'),('MH','McGraw Hill','New York','\r'),('MHIJ','Martinus Nijhoff','The Hague','\r'),('MJ','Michael Joseph','London','\r'),('MOD','Modern Library','New York','\r'),('MOR','William Morrow','New York','\r'),('MPS','McGill Poetry Series','Montreal','\r'),('MQP','McGill Queens University Press','Montreal','\r'),('MS','McClelland & Stewart','Toronto','\r'),('MUP','Marquette University Press','Milwaukee','\r'),('MWR','Mcfarlane Walter & Ross','Toronto','\r'),('NDP','New Directions Publishing','New York','\r'),('NIM','Nimbus','Halifax','\r'),('NOR','Norton','Boston','\r'),('NWU','Northwestern University Press','Evanston','\r'),('NYZ','New York Zoetrope','New York','\r'),('OBER','Oberon Press','Toronto','\r'),('OCT','October House','New York','\r'),('OX','Oxford University Press','Oxford','\r'),('PANT','Pantheon','New York','\r'),('PGW','Publishers Group West','San Francisco','\r'),('POSE','Poseidon Press','New York','\r'),('PUTN','Putnam','London','\r'),('RAND','Random House','New York','\r'),('RKP','Routledge & Kegan Paul','London','\r'),('SCH','Schocken Books','New York','\r'),('SIM','Simon & Schuster','New York','\r'),('SINC','Sinclair-Stevenson','London','\r'),('SUM','Summit','New York','\r'),('SW','Secker & Warburg','London','\r'),('TF','Ticknor & Fields','New York','\r'),('TUN','Tundra Books','Toronto','\r'),('UNI','Unicorn Publishing House','New Jersey','\r'),('UOO','University of Oklahoma','Norman','\r'),('VIK','Viking Press','New York','\r'),('VNR','Van Nostrand Reinhold','New York','\r'),('WES','Wesleyan University Press','Middletown','\r'),('WIL','John Wiley and Sons','Toronto','\r'),('WN','Weidenfeld & Nicolson','London','\r'),('SCHU','Henry Schuman','New York',NULL),('PRI','Prion','London',NULL),('HH','Hamish Hamilton','London',NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `tblpublishers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

