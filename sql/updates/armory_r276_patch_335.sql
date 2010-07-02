/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r276';

-- Achievement.dbc
REPLACE INTO `armory_achievement` VALUES (4815, -1, 0, 'Der Zwielichtzerstorer (25 Spieler)', 'The Twilight Destroyer (25 player)', 'El Destructor del Crepusculo (25 j.)', 'Le destructeur du Crepuscule (25 joueurs)', 'Сумеречный разрушитель (25 игроков)', '0', 'Defeat Halion in The Ruby Sanctum in 25-player mode.', 'Derrota a Halion en El Sagrario Rubi en el modo de 25 jugadores.', 'Vaincre Halion au sanctum Rubis en mode 25 joueurs.', 'Убейте Халиона в Рубиновом святилище в рейде на 25 игроков.', 14923, 10, 35, 0, 164, 'spell_shadow_twilight', '', '', '', '', ''),
(4816, -1, 4815, 'Heroisch: Der Zwielichtzerstorer (25 Spieler)', 'Heroic: The Twilight Destroyer (25 player)', 'Heroico: El Destructor del Crepusculo (25 j.)', 'Le destructeur du Crepuscule : mode heroique (25 joueurs)', 'Сумеречный разрушитель (героич., 25 игроков)', '0', 'Defeat Halion in The Ruby Sanctum in 25-player Heroic mode.', 'Derrota a Halion en El Sagrario Rubi en el modo de 25 jugadores en dificultad heroica.', 'Vaincre Halion au sanctum Rubis en mode heroique a 25 joueurs.', 'Убейте Халиона в Рубиновом святилище в рейде на 25 игроков в героическом режиме.', 14923, 10, 36, 0, 164, 'spell_shadow_twilight', '', '', '', '', ''),
(4817, -1, 0, 'Der Zwielichtzerstorer (10 Spieler)', 'The Twilight Destroyer (10 player)', 'El Destructor del Crepusculo (10 j.)', 'Le destructeur du Crepuscule (10 joueurs)', 'Сумеречный разрушитель (10 игроков)', '0', 'Defeat Halion in The Ruby Sanctum in 10-player mode.', 'Derrota a Halion en El Sagrario Rubi en el modo de 10 jugadores.', 'Vaincre Halion au sanctum Rubis en mode 10 joueurs.', 'Убейте Халиона в Рубиновом святилище в рейде на 10 игроков.', 14922, 10, 35, 0, 164, 'spell_shadow_twilight', '', '', '', '', ''),
(4818, -1, 4817, 'Heroisch: Der Zwielichtzerstorer (10 Spieler)', 'Heroic: The Twilight Destroyer (10 player)', 'Heroico: El Destructor del Crepusculo (10 j.)', 'Le destructeur du Crepuscule : mode heroique (10 joueurs)', 'Сумеречный разрушитель (героич., 10 игроков)', '0', 'Defeat Halion in The Ruby Sanctum in 10-player Heroic mode.', 'Derrota a Halion en El Sagrario Rubi en el modo de 10 jugadores en dificultad heroica.', 'Vaincre Halion au sanctum Rubis en mode heroique a 10 joueurs.', 'Убейте Халиона в Рубиновом святилище в рейде на 10 игроков в героическом режиме.', 14922, 10, 36, 0, 164, 'spell_shadow_twilight', '', '', '', '', ''),
(4820, -1, 0, 'Siege uber Halion (Rubinsanktum', 'Halion kills (Ruby Sanctum 25 player)', 'Muertes de Halion (El Sagrario Rubi 25 j.)', 'Morts de Halion (Sanctum Rubis a 25)', 'Убийства Халиона (Рубиновое святилище, 25 игроков)', 'Siege uber Halion (Rubinsanktum', 'Halion kills (Ruby Sanctum 25 player)', 'Muertes de Halion (El Sagrario Rubi 25 j.)', 'Morts de Halion (sanctum Rubis a 25)', 'Убийства Халиона (Рубиновое святилище, 25 игроков)', 15062, 0, 69, 1, 1, '', '0', '', '', '', ''),
(4821, -1, 0, 'Siege uber Halion (Rubinsanktum', 'Halion kills (Ruby Sanctum 10 player)', 'Muertes de Halion (El Sagrario Rubi 10 j.)', 'Morts de Halion (Sanctum Rubis a 10)', 'Убийства Халиона (Рубиновое святилище, 10 игроков)', 'Siege uber Halion (Rubinsanktum', 'Halion kills (Ruby Sanctum 10 player)', 'Muertes de Halion (El Sagrario Rubi 10 j.)', 'Morts de Halion (sanctum Rubis a 10)', 'Убийства Халиона (Рубиновое святилище, 10 игроков)', 15062, 0, 67, 1, 1, '', '0', '', '', '', ''),
(4822, -1, 0, 'Siege uber Halion (Heroisches Rubinsanktum', 'Halion kills (Heroic Ruby Sanctum 10 player)', 'Muertes de Halion (El Sagrario Rubi heroica 10 j.)', 'Morts de Halion (Sanctum Rubis heroique a 10)', 'Убийства Халиона (Рубиновое святилище, 10 игроков, героич.)', 'Siege uber Halion (Heroisches Rubinsanktum', 'Halion kills (Heroic Ruby Sanctum 10 player)', 'Muertes de Halion (El Sagrario Rubi heroica 10 j.)', 'Morts de Halion (sanctum Rubis heroique a 10)', 'Убийства Халиона (Рубиновое святилище, 10 игроков, героич.)', 15062, 0, 68, 1, 1, '', '0', '', '', '', ''),
(4823, -1, 0, 'Siege uber Halion (Heroisches Rubinsanktum', 'Halion kills (Heroic Ruby Sanctum 25 player)', 'Muertes de Halion (El Sagrario Rubi heroica 25 j.)', 'Morts de Halion (Sanctum Rubis heroique a 25)', 'Убийства Халиона (Рубиновое святилище, 25 игроков, героич.)', 'Siege uber Halion (Heroisches Rubinsanktum', 'Halion kills (Heroic Ruby Sanctum 25 player)', 'Muertes de Halion (El Sagrario Rubi heroica 25 j.)', 'Morts de Halion (sanctum Rubis heroique a 25)', 'Убийства Халиона (Рубиновое святилище, 25 игроков, героич.)', 15062, 0, 70, 1, 1, '', '0', '', '', '', '');

-- ItemDisplayInfo.dbc
REPLACE INTO `armory_icons` VALUES (68106, 'inv_misc_rubysanctum2'),
(68107, 'inv_misc_rubysanctum3'),
(68108, 'inv_misc_rubysanctum1'),
(68109, 'inv_misc_rubysanctum4'),
(68328, 'inv_sigil_thorim'),
(68742, 't_roboticon');

-- remove empty icon entries
DELETE FROM `armory_icons` WHERE `icon`='';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;