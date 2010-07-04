/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r287';
-- TEXT type needs for pvpAlliance/pvpHorde vendor IDs (and maybe something else too)
ALTER TABLE `armory_item_sources` CHANGE `item` `item` TEXT;
-- `item`: VENDOR_ID_ALLANCE/VENDOR_ID_HORDE (because `key` row must be unique)
INSERT IGNORE INTO `armory_item_sources` VALUES ('arena8', -1, '33936', 0, 0),
('arena7', -1, '33927', 0, 0),
('arena6', -1, '33921', 0, 0),
('arena5', -1, '32354, 32355, 32356, 31863, 31864, 31865, 32359, 32360, 32362', 0, 0),
('wintergrasp', -1, '30488, 30489, 32294/30488, 30489, 32296', 0, 0),
('arena4', -1, '26352', 0, 0),
('arena3', -1, '24392', 0, 0),
('arena2', -1, '23396', 0, 0),
('arena1', -1, '24671/24667, 24668', 0, 0),
('honor', -1, '34078, 34075, 34084, 34081, 12781, 12783, 12784, 12785/34038, 34060, 34063, 34043, 12793, 12794, 12795, 12796', 0, 0),
('ab', -1, '15127/15126', 0, 0),
('av', -1, '13217/13219', 0, 0),
('wsg', -1, '14753/14754', 0, 0),
('halaa', -1, '18822/18821', 0, 0),
('thrallmar', -1, '18267', 0, 0),
('honorhold', -1, '18266', 0, 0),
('terrokar', -1, '19773/19772', 0, 0),
('zangarmarsh', -1, '18581/18564', 0, 0);
-- Typo
UPDATE `armory_races` SET `name_ru_ru` = 'Дреней' WHERE `id` =11 LIMIT 1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;