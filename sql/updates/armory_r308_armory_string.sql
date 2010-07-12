/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- db_version change not required

UPDATE `armory_races` SET `modeldata_1` = 'draenei' WHERE `id` =11 LIMIT 1 ;
DROP TABLE IF EXISTS `armory_string`;
CREATE TABLE `armory_string` (
  `id` int(11) NOT NULL auto_increment,
  `string_de_de` text NOT NULL,
  `string_en_gb` text NOT NULL,
  `string_es_es` text NOT NULL,
  `string_fr_fr` text NOT NULL,
  `string_ru_ru` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33342 DEFAULT CHARSET=utf8 AUTO_INCREMENT=33342 ;

INSERT INTO `armory_string` VALUES (13, 'Erhielt den Erfolg', 'Earned the achievement', 'Merecido el logro', 'A obtenu le haut fait', 'Заслужено достижение'),
(14, 'Vollf&#252;hrte die Heldentat', 'Earned the feat of strength', 'Merecido la proeza de fuerza', 'A obtenu le tour de force', 'Совершен великий подвиг'),
(15, 'Erhielt', 'Obtained', 'Logrado', 'A obtenu', 'Получено'),
(16, 'Hat jetzt beendet', 'Has now completed', 'Ha completado', 'A termin&#233;', 'Завершено'),
(17, 'mal', 'times', 'veces', 'fois', 'раз'),
(18, 'f&#252;r %d Punkte', 'for %d points', 'por %d puntos', 'pour %d points', 'стоимостью %d очков'),
(19, '(Heroisch)', '(Heroic)', '(Her&#243;ica)', '(H&#233;ro&#239;que)', '(Героическое)');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;