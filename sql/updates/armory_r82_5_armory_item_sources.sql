DROP TABLE IF EXISTS `armory_item_sources`;
CREATE TABLE `armory_item_sources` (
  `key` varchar(150) NOT NULL,
  `parent` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `armory_item_sources` VALUES ('dungeon', -1, 0),
('pvpAlliance', -1, 0),
('quest', -1, 0),
('pvpHorde', -1, 0),
('49426', 0, 0),
('47241', 0, 0),
('emblemofconquest', 0, 45624),
('emblemofvalor', 0, 40753),
('emblemofheroism', 0, 40752),
('badgeofjustice', 0, 29434),
('emblemoffrost', 0, 49426),
('emblemoftriumph', 0, 47241);