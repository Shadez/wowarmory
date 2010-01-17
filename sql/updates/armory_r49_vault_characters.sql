UPDATE `db_version` SET `version` = 'armory_r49';

DROP TABLE IF EXISTS `login_characters`;
CREATE TABLE `login_characters` (
  `account` int(11) NOT NULL,
  `num` int(11) default '1',
  `guid` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `class` smallint(6) NOT NULL,
  `race` smallint(6) NOT NULL,
  `gender` smallint(6) NOT NULL,
  `level` int(11) NOT NULL,
  `selected` int(11) NOT NULL,
  PRIMARY KEY  (`account`,`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `character_bookmarks`;
CREATE TABLE `character_bookmarks` (
  `account` int(11) NOT NULL,
  `guid` int(11) NOT NULL,
  PRIMARY KEY  (`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;