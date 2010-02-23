/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r77';
UPDATE `armory_titles` SET `title_M_ru_ru` = ', звездный странник' WHERE `id` =130 LIMIT 1 ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;