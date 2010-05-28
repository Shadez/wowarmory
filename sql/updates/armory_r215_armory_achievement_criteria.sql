UPDATE `armory_db_version` SET `version` = 'armory_r215';
ALTER TABLE `armory_achievement_criteria` DROP `name_es_es`;
UPDATE `armory_achievement_category` SET `name_ru_ru` = 'Lich King (5)' WHERE `id` =14921 LIMIT 1;