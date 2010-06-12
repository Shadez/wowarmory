/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r240';
DROP TABLE IF EXISTS `armory_news`;
CREATE TABLE `armory_news` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `title_de_de` text NOT NULL,
  `title_en_gb` text NOT NULL,
  `title_es_es` text NOT NULL,
  `title_fr_fr` text NOT NULL,
  `title_ru_ru` text NOT NULL,
  `text_de_de` text NOT NULL,
  `text_en_gb` text NOT NULL,
  `text_es_es` text NOT NULL,
  `text_fr_fr` text NOT NULL,
  `text_ru_ru` text NOT NULL,
  `display` smallint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Armory news' AUTO_INCREMENT=2 ;

INSERT INTO `armory_news` VALUES (1, 1276357456, '', 'WoWArmory news test', '', '', 'Тестирование новостей Оружейной', '', 'This is simple news to test how new module works. Thank you! <a href="http://eu.battle.net/" target="_blank">Battle.Net</a> Link (HTML tags testing)', '', '', 'Это тестовая новость, созданная для проверки работы нового модуля. Спасибо! Ссылка на <a href="http://eu.battle.net/" target="_blank">Battle.Net</a> (проверка HTML тегов)', 1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;