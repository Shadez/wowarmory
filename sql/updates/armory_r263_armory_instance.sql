/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r263';
INSERT IGNORE INTO `armory_instance_template` VALUES (4987, 724, 'Рубиновое святилище (10)', 'Ruby Sanctum (10)', 'Das Rubinsanktum (10)', 'Le sanctum Rubis (10)', 'El Sagrario Rub&#237; (10)', 2, 1, 1, 'rubysanctum10', 80, 80, 10, 1, 1),
(4987, 724, 'Рубиновое святилище (25)', 'Ruby Sanctum (25)', 'Das Rubinsanktum (25)', 'Le sanctum Rubis (25)', 'El Sagrario Rub&#237; (25)', 2, 1, 1, 'rubysanctum25', 80, 80, 25, 1, 2);

INSERT IGNORE INTO `armory_instance_data` ( `id` , `instance_id` , `name_ru_ru` , `name_en_gb` , `name_de_de` , `name_fr_fr` , `name_es_es` , `name_id` , `lootid_1` , `loot_1_type` , `lootid_2` , `loot_2_type` , `lootid_3` , `loot_3_type` , `lootid_4` , `loot_4_type` , `key` , `type` ) 
VALUES (
'39863', '4987', 'Халион', 'Halion', 'Halion', 'Halion', 'Halion', '39863', '0', '1', '0', '1', '0', '1', '0', '1', 'halion', 'npc'
), (
'39864', '4987', 'Халион', 'Halion', 'Halion', 'Halion', 'Halion', '39863', '0', '1', '0', '1', '0', '1', '0', '1', 'halion', 'npc'
);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;