UPDATE `armory_db_version` SET `version` = 'armory_r168';

DROP TABLE IF EXISTS `armory_realm_data`;
CREATE TABLE `armory_realm_data` (
  `id` smallint(6) NOT NULL,
  `name` text NOT NULL,
  `version` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `armory_realm_data` VALUES 
(1, 'MaNGOS1', 333),
(2, 'MaNGOS2', 333);