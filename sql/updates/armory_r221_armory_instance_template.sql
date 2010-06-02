UPDATE `armory_db_version` SET `version` = 'armory_r221';
ALTER TABLE `armory_instance_template` CHANGE `name_es_es` `name_de_de_tmp` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `armory_instance_template` CHANGE `name_ru_ru` `name_es_es_tmp` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `armory_instance_template` CHANGE `name_de_de` `name_ru_ru_tmp` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `armory_instance_template` CHANGE `name_de_de_tmp` `name_de_de` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;
ALTER TABLE `armory_instance_template` CHANGE `name_ru_ru_tmp` `name_ru_ru` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;
ALTER TABLE `armory_instance_template` CHANGE `name_es_es_tmp` `name_es_es` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;