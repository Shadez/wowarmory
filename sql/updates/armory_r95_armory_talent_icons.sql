/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

UPDATE `armory_db_version` SET `version` = 'armory_r95';
ALTER TABLE `armory_talent_icons` ADD `name_ru_ru` VARCHAR( 100 ) NOT NULL ,
ADD `name_en_gb` VARCHAR( 100 ) NOT NULL ;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Оружие', `name_en_gb`='Arms' WHERE `class`=1 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Неистовство', `name_en_gb`='Fury' WHERE `class`=1 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Защита', `name_en_gb`='Protection' WHERE `class`=1 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Свет', `name_en_gb`='Holy' WHERE `class`=2 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Защита', `name_en_gb`='Protection' WHERE `class`=2 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Воздаяние', `name_en_gb`='Retribution' WHERE `class`=2 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Чувство зверя', `name_en_gb`='Beast mastery' WHERE `class`=3 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Стрельба', `name_en_gb`='Marksmanship' WHERE `class`=3 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Выживание', `name_en_gb`='Survival' WHERE `class`=3 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Ликвидация', `name_en_gb`='Assassination' WHERE `class`=4 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Бой', `name_en_gb`='Combat' WHERE `class`=4 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Скрытность', `name_en_gb`='Subletly' WHERE `class`=4 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Послушание', `name_en_gb`='Discipline' WHERE `class`=5 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Свет', `name_en_gb`='Holy' WHERE `class`=5 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Тьма', `name_en_gb`='Shadow' WHERE `class`=5 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Кровь', `name_en_gb`='Blood' WHERE `class`=6 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Лед', `name_en_gb`='Frost' WHERE `class`=6 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Нечестивость', `name_en_gb`='Unholy' WHERE `class`=6 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Стихии', `name_en_gb`='Elemental' WHERE `class`=7 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Совершенствование', `name_en_gb`='Enhancement' WHERE `class`=7 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Исцеление', `name_en_gb`='Restoration' WHERE `class`=7 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Тайная магия', `name_en_gb`='Arcane' WHERE `class`=8 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Огонь', `name_en_gb`='Fire' WHERE `class`=8 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Лед', `name_en_gb`='Frost' WHERE `class`=8 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Колдовство', `name_en_gb`='Affliction' WHERE `class`=9 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Демонология', `name_en_gb`='Demonology' WHERE `class`=9 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Разрушение', `name_en_gb`='Destruction' WHERE `class`=9 AND `spec`=2;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Баланс', `name_en_gb`='Balance' WHERE `class`=11 AND `spec`=0;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Сила зверя', `name_en_gb`='Feral Combat' WHERE `class`=11 AND `spec`=1;
UPDATE `armory_talent_icons` SET `name_ru_ru`='Исцеление', `name_en_gb`='Restoration' WHERE `class`=11 AND `spec`=2;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;