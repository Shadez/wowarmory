UPDATE `armory_db_version` SET `version` = 'armory_r289';
ALTER TABLE `armory_extended_cost` CHANGE `arenaPoints` `honorPoints_tmp` INT( 11 );
ALTER TABLE `armory_extended_cost` CHANGE `honorPoints` `arenaPoints` INT( 11 );
ALTER TABLE `armory_extended_cost` CHANGE `honorPoints_tmp` `honorPoints` INT( 11 ) DEFAULT NULL;