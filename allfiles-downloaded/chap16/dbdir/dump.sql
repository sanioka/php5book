BEGIN TRANSACTION;
CREATE TABLE tblresources(
    id INTEGER PRIMARY KEY,
    url VARCHAR(255) NOT NULL UNIQUE default '',
    email VARCHAR(70) NOT NULL default '', 
    precedingcopy VARCHAR(100) NOT NULL default '',
    linktext VARCHAR(255) NOT NULL default '',
    followingcopy VARCHAR(255) NOT NULL default '',
    target VARCHAR(35) default '_blank',
    category VARCHAR(100) NOT NULL default '', 
    theirlinkpage VARCHAR(100) default NULL,
    whenaltered TIMESTAMP default '0000-00-00',
    reviewed BOOLEAN default 0,
    whenadded DATE default '2005-01-01');
CREATE INDEX tblresources_linktext_idx ON tblresources(linktext);
INSERT INTO tblresources VALUES(1,'http://php.net','','','php.net','- the source','','Software','','2005-10-20 17:27:07',1,'');
INSERT INTO tblresources VALUES(2,'http://sqlite.org','','','SQLite','','','','','2005-10-20 17:27:07',1,'');
INSERT INTO tblresources VALUES(3,'http://phparchitect.com/','','','php | architect','','','Miscellaneous','http://','2005-10-20 20:50:23',1,'');
INSERT INTO tblresources VALUES(4,'http://www.phpkitchen.com/index.php','lavin.peter@gmail.com','','phpkitchen','- come see what''s cooking','_blank','','http://','2005-10-20 17:27:07',1,'');
INSERT INTO tblresources VALUES(5,'http://seagull.phpkitchen.com/','lavin.peter@gmail.com','','Seagull PHP Framework','','_blank','','http://','2005-10-20 17:27:07',1,'');
INSERT INTO tblresources VALUES(6,'http://www.unixreview.com','lavin.peter@gmail.com','','Unix Review','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(7,'http://linuxweblog.com/','lavin.peter@gmail.com','','Linux Weblog','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(8,'http://www.phpmyadmin.net/','lavin.peter@gmail.com','','phpMyAdmin','','','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(9,'http://phpsec.org/','lavin.peter@gmail.com','','PHP Security Consortium','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(11,'http://www.phpclasses.org/','lavin.peter@gmail.com','','PHP Classses','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(12,'http://php.resourceindex.com/','lavin.peter@gmail.com','','PHP Resources','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(13,'http://www.linux-magazine.com','lavin.peter@gmail.com','','Linux Magazine','','','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(14,'http://www.zend.com/','lavin.peter@gmail.com','','Zend - the PHP company','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(15,'http://opensourcecms.com/index.php','lavin.peter@gmail.com','','Open-source CMS','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(16,'http://www.phpbb.com/','lavin.peter@gmail.com','','phpBB','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(17,'http://www.mozilla.org/products/firefox/','lavin.peter@gmail.com','','Firefox',' - the standards-compliant browser','','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(18,'http://www.phpcareer.com','','','PHP Career','','','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(19,'http://www.planet-php.org/','','','Planet PHP','','_blank','','http://','2005-10-20 17:27:08',1,'');
INSERT INTO tblresources VALUES(20,'http://www.php-editors.com/','','','PHP Editors','','','Software','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(21,'http://www.phpwebthings.org/','','','phpWebThings','','','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(23,'http://www.php-mag.net/','','','International PHP Magazine','','','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(24,'http://www.phpfreaks.com/','','','php freaks','','_blank','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(25,'http://www.alistapart.com/','','','A List Apart Magazine',' - Designing with web standards','','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(26,'http://www.nostarch.com','','','No Starch Press','- publisher of computer books that make a difference','','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(27,'http://teamphp.com/','','','Team PHP','','','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(28,'http://www.phpriot.com/','','','phpRiot','','','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(29,'http://www.phpnerds.com/','','','phpnerds','','_blank','','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(30,'http://www.opensourcematters.org/','','','opensourcematters','','','Development','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(31,'http://phpwebsite.appstate.edu/','','','Open source, community-driven webware','','','Software','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(32,'http://www.greenorange.org/public/index.php','','','Green Orange PHP Framework','','','Development','http://','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(33,'http://www.xaraya.com/','','','Xaraya - PHP Application Framework','','','Software','','2005-10-20 17:27:09',1,'');
INSERT INTO tblresources VALUES(34,'http://phpcommunity.org/','','','php community','','','','http://','2005-10-20 17:27:10',1,'');
INSERT INTO tblresources VALUES(35,'http://www.phphub.com/','','','php hub','','','Miscellaneous','http://','2005-10-20 17:27:10',1,'');
INSERT INTO tblresources VALUES(36,'http://www.phpn.org/','','','PHP News Network','','','Development','','2005-10-21 12:10:55',1,'');
CREATE VIEW alphabet AS
    SELECT DISTINCT UPPER(SUBSTR(linktext,1,1)) AS letter
    FROM tblresources
    WHERE reviewed = 1 ORDER BY letter;
CREATE VIEW specific_link AS
    SELECT id, url,
    (precedingcopy || ' ' || linktext || ' ' || followingcopy)
    AS copy
    FROM tblresources;
CREATE TRIGGER delete_link INSTEAD OF DELETE ON specific_link
FOR EACH ROW
BEGIN
    DELETE FROM tblresources
    WHERE id = old.id;
END;
CREATE TRIGGER insert_resources AFTER INSERT ON tblresources
BEGIN
    UPDATE tblresources SET whenaltered = DATETIME('NOW','LOCALTIME')
    WHERE id = new.id;
END;
CREATE TRIGGER update_resources AFTER UPDATE ON tblresources
BEGIN
    UPDATE tblresources SET whenaltered = DATETIME('NOW','LOCALTIME')
    WHERE id = new.id;
END;
CREATE TRIGGER add_date AFTER INSERT ON tblresources
BEGIN
    UPDATE tblresources SET whenadded = DATE('NOW','LOCALTIME')
    WHERE id = new.id;
END;
COMMIT;
