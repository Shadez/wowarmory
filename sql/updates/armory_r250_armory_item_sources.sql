UPDATE `armory_db_version` SET `version`='armory_r250';
UPDATE `armory_item_sources` SET `key` = 'containers' WHERE `key`='container';
UPDATE `armory_item_sources` SET `subtype` = '5' WHERE `key`='gem';