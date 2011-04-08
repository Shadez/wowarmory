DROP TABLE IF EXISTS `armory_character_stats`;
CREATE TABLE `armory_character_stats` (
  `guid` int(11) NOT NULL,
  `data` longtext NOT NULL,
  `save_date` int(11) default NULL,
  PRIMARY KEY  (`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='World of Warcraft Armory table';

DROP TABLE IF EXISTS `character_feed_log`;
CREATE TABLE `character_feed_log` (
  `guid` int(11) NOT NULL,
  `type` smallint(1) NOT NULL,
  `data` int(11) NOT NULL,
  `date` int(11) default NULL,
  `counter` int(11) NOT NULL,
  `difficulty` smallint(6) default '-1',
  `item_guid` int(11) default '-1',
  `item_quality` smallint(6) NOT NULL default '-1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;