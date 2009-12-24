DROP TABLE IF EXISTS `db_version`;
CREATE TABLE `db_version` (
  `armory_r32` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `id` int(11) NOT NULL,
  `guid` int(11) NOT NULL,
  `tooltip_html` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`,`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;