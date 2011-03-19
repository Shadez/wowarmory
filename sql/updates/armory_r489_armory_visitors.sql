UPDATE `armory_db_version` SET `version` = 'armory_r489';
DROP TABLE IF EXISTS `armory_visitors`;
CREATE TABLE `armory_visitors` (
  `date` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY  (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;