/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r67';
INSERT IGNORE INTO `armory_string` ( `id` , `string_en_gb` , `string_ru_ru` ) 
VALUES (
'6', 'Rep. reward', 'Нагр. за репут.'
);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;