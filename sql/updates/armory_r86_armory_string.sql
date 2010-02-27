/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r86';
INSERT INTO `armory_string` VALUES (7, 'Mana', 'Мана'),
(8, 'Rage', 'Ярость'),
(9, 'Energy', 'Энергия'),
(10, 'Runic power', 'Сила рун');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;