UPDATE `armory_db_version` SET `version` = 'armory_r471';
ALTER TABLE `armory_instance_template` CHANGE `name_fr_fr` `name_es_es_tmp` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `armory_instance_template` CHANGE `name_es_es` `name_fr_fr` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;
ALTER TABLE `armory_instance_template` CHANGE `name_es_es_tmp` `name_es_es` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;