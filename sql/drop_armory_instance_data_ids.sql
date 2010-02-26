/*
	This query will reset ALL lootids in armory_instance_data table. Are you sure that you want to execute it? =)
*/
UPDATE `armory_instance_data` SET `lootid_1`=0, `lootid_2`=0, `lootid_3`=0, `lootid_4`=0;
UPDATE `armory_db_version` SET `loot_builded`=0;