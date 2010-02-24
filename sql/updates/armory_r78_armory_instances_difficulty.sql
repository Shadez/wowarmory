UPDATE `armory_db_version` SET `version` = 'armory_r78';

ALTER TABLE `armory_instances` RENAME `armory_instances_difficulty` ;

DROP TABLE IF EXISTS `armory_instances`;
CREATE TABLE `armory_instances` (
  `map_id` int(11) NOT NULL,
  `instance_name_ru_ru` varchar(255) NOT NULL,
  `instance_name_en_gb` varchar(255) NOT NULL,
  `boss_name_ru_ru` varchar(255) NOT NULL,
  `boss_name_en_gb` varchar(255) NOT NULL,
  `boss_diff_1` int(11) NOT NULL,
  `boss_diff_2` int(11) NOT NULL,
  `boss_diff_3` int(11) NOT NULL,
  `boss_diff_4` int(11) NOT NULL,
  `boss_search_string` varchar(50) NOT NULL,
  PRIMARY KEY  (`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;