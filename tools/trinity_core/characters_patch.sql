DROP TABLE IF EXISTS `armory_character_stats`;
CREATE TABLE `armory_character_stats` (
  `guid` int(11) NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY  (`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='World of Warcraft Armory table';

DROP TABLE IF EXISTS `character_feed_log`;
CREATE TABLE `character_feed_log` (
  `guid` int(11) NOT NULL,
  `type` smallint(1) NOT NULL,
  `data` int(11) NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `counter` int(11) NOT NULL,
  PRIMARY KEY  (`guid`,`type`,`data`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;