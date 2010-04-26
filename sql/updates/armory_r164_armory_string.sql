/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r164';
REPLACE INTO `armory_string` VALUES (13, 'Earned the achievement', 'Заслужено достижение'),
(14, 'Earned the feat of strength', 'Совершен великий подвиг'),
(15, 'Obtained', 'Получено'),
(16, 'Has now completed', 'Завершено'),
(17, 'times', 'раз'),
(18, 'for %d points', 'стоимостью %d очков');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;