UPDATE `armory_db_version` SET `version` = 'armory_r198';

DROP TABLE IF EXISTS `armory_bookmarks`;
CREATE TABLE `armory_bookmarks` (
  `account` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `classId` smallint(6) default NULL,
  `level` smallint(6) NOT NULL,
  `realm` text NOT NULL,
  `url` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `armory_login_characters`;
CREATE TABLE `armory_login_characters` (
  `account` int(11) NOT NULL,
  `num` int(11) default '1',
  `guid` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `class` smallint(6) NOT NULL,
  `race` smallint(6) NOT NULL,
  `gender` smallint(6) NOT NULL,
  `level` int(11) NOT NULL,
  `realm_id` int(11) NOT NULL default '0',
  `selected` int(11) NOT NULL,
  PRIMARY KEY  (`account`,`guid`,`realm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;