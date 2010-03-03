UPDATE `armory_db_version` SET `version` = 'armory_r101';
ALTER TABLE `armory_races` ADD `modeldata_1` VARCHAR( 50 ) NOT NULL ,
ADD `modeldata_2` VARCHAR( 50 ) NOT NULL ;

UPDATE `armory_races` SET `modeldata_1` = 'scourge', `modeldata_2` = 'sc' WHERE `id` =5 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'orc', `modeldata_2` = 'or' WHERE `id` =2 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'bloodelf', `modeldata_2` = 'be' WHERE `id` =10 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'tauren', `modeldata_2` = 'ta' WHERE `id` =6 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'troll', `modeldata_2` = 'tr' WHERE `id` =8 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'draenei', `modeldata_2` = 'dr' WHERE `id` =11 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'dwarf', `modeldata_2` = 'dw' WHERE `id` =3 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'human', `modeldata_2` = 'hu' WHERE `id` =1 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'nightelf', `modeldata_2` = 'ni' WHERE `id` =4 LIMIT 1 ;
UPDATE `armory_races` SET `modeldata_1` = 'gnome', `modeldata_2` = 'gn' WHERE `id` =7 LIMIT 1 ;