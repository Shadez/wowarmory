/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r191';
DROP TABLE IF EXISTS `armory_petcalc`;
CREATE TABLE `armory_petcalc` (
  `id` smallint(6) NOT NULL,
  `catId` smallint(6) NOT NULL default '0',
  `name_de_de` text NOT NULL,
  `name_en_gb` text NOT NULL,
  `name_es_es` text NOT NULL,
  `name_fr_fr` text NOT NULL,
  `name_ru_ru` text NOT NULL,
  `icon` text NOT NULL,
  `key` text NOT NULL,
  PRIMARY KEY  (`catId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `armory_petcalc` VALUES (30, 8, 'Drachenfalke', 'Dragonhawk', 'Dracohalc&#243;n', 'Faucon-dragon', 'Дракондор', 'ability_hunter_pet_dragonhawk', 'Cunning'),
(35, 16, 'Schlange', 'Serpent', 'Serpiente', 'Serpent', 'Змей', 'spell_nature_guardianward', 'Cunning'),
(17, 22, 'Windnatter', 'Wind Serpent', 'Serpiente alada', 'Serpent des vents', 'Крылатый змей', 'ability_hunter_pet_windserpent', 'Cunning'),
(24, 0, 'Fledermaus', 'Bat', 'Murci&#233;lago', 'Chauve-souris', 'Летучая мышь', 'ability_hunter_pet_bat', 'Cunning'),
(31, 14, 'Felshetzer', 'Ravager', 'Devastador', 'Ravageur', 'Опустошитель', 'ability_hunter_pet_ravager', 'Cunning'),
(13, 17, 'Spinne', 'Spider', 'Ara&#241;a', 'Araign&#233;e', 'Паук', 'ability_hunter_pet_spider', 'Cunning'),
(41, 63, 'Silithid', 'Silithid', 'Sil&#237;tido', 'Silithide', 'Силитид', 'ability_hunter_pet_silithid', 'Cunning'),
(34, 12, 'Netherrochen', 'Nether Ray', 'Raya abisal', 'Raie du N&#233;ant', 'Скат Пустоты', 'ability_hunter_pet_netherray', 'Cunning'),
(0, 2, 'Raubvogel', 'Bird of Prey', 'Ave rapaz', 'Oiseau de proie', 'Сова', 'ability_hunter_pet_owl', 'Cunning'),
(33, 18, 'Sporensegler', 'Sporebat', 'Espori&#233;lago', 'Sporopt&#232;re', 'Спороскат', 'ability_hunter_pet_sporebat', 'Cunning'),
(38, 24, 'Schim&#228;re', 'Chimaera', 'Quimera', 'Chim&#232;re', 'Химера', 'ability_hunter_pet_chimera', 'Cunning'),
(5, 3, 'Eber', 'Boar', 'Jabal&#237;', 'Sanglier', 'Вепрь', 'ability_hunter_pet_boar', 'Tenacity'),
(9, 9, 'Gorilla', 'Gorilla', 'Gorila', 'Gorille', 'Горилла', 'ability_hunter_pet_gorilla', 'Tenacity'),
(8, 6, 'Krebs', 'Crab', 'Cangrejo', 'Crabe', 'Краб', 'ability_hunter_pet_crab', 'Tenacity'),
(6, 7, 'Krokilisk', 'Crocolisk', 'Crocolisco', 'Crocilisque', 'Кроколиск', 'ability_hunter_pet_crocolisk', 'Tenacity'),
(43, 61, 'Rhinozeros', 'Rhino', 'Rinoceronte', 'Rhinoc&#233;ros', 'Люторог', 'ability_hunter_pet_rhino', 'Tenacity'),
(4, 1, 'B&#228;r', 'Bear', 'Oso', 'Ours', 'Медведь', 'ability_hunter_pet_bear', 'Tenacity'),
(21, 21, 'Sph&#228;renj&#228;ger', 'Warp Stalker', 'Tortuga', 'Traqueur dim.', 'Черепаха', 'ability_hunter_pet_turtle', 'Tenacity'),
(20, 15, 'Skorpid', 'Scorpid', 'Esc&#243;rpido', 'Scorpide', 'Скорпид', 'ability_hunter_pet_scorpid', 'Tenacity'),
(42, 62, 'Wurm', 'Worm', 'Gusano', 'Ver', 'Червь', 'ability_hunter_pet_worm', 'Tenacity'),
(1, 23, 'Wolf', 'Wolf', 'Lobo', 'Loup', 'Волк', 'ability_hunter_pet_wolf', 'Ferocity'),
(25, 10, 'Hy&#228;ne', 'Hyena', 'Hiena', 'Hy&#232;ne', 'Гиена', 'ability_hunter_pet_hyena', 'Ferocity'),
(45, 59, 'Kernhund', 'Core Hound', 'Can del N&#250;cleo', 'Chien du Magma', 'Гончая Недр', 'ability_hunter_pet_corehound', 'Ferocity'),
(12, 19, 'Weitschreiter', 'Tallstrider', 'Zancaalta', 'Haut-trotteur', 'Долгоног', 'ability_hunter_pet_tallstrider', 'Ferocity'),
(46, 58, 'Geisterbestie', 'Spirit Beast', 'Bestia esp&#237;ritu', 'Esprit de b&#234;te', 'Дух зверя', 'ability_druid_primalprecision', 'Ferocity'),
(39, 25, 'Teufelssaurier', 'Devilsaur', 'Demosaurio', 'Diablosaure', 'Дьявозавр', 'ability_hunter_pet_devilsaur', 'Ferocity'),
(2, 5, 'Katze', 'Cat', 'Felino', 'F&#233;lin', 'Кошка', 'ability_hunter_pet_cat', 'Ferocity'),
(37, 11, 'Motte', 'Moth', 'Palomilla', 'Phal&#232;ne', 'Мотылек', 'ability_hunter_pet_moth', 'Ferocity'),
(44, 60, 'Wespe', 'Wasp', 'Avispa', 'Gu&#234;pe', 'Оса', 'ability_hunter_pet_wasp', 'Ferocity'),
(7, 4, 'Aasvogel', 'Carrion Bird', 'Carro&#241;ero', 'Charognard', 'Падальщик', 'ability_hunter_pet_vulture', 'Ferocity'),
(11, 13, 'Raptor', 'Raptor', 'Raptor', 'Raptor', 'Ящер', 'ability_hunter_pet_raptor', 'Ferocity'),
(-1, -1, '', 'Cunning', 'Astucia', '', 'Свирепость', '', 'cunning'),
(-1, -2, '', 'Tenacity', 'Tenacidad', '', 'Упорство', '', 'tenacity'),
(-1, -3, '', 'Ferocity', 'Ferocidad', '', 'Хитрость', '', 'ferocity');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;