UPDATE `armory_db_version` SET `version` = 'armory_r79';
ALTER TABLE `armory_instances`
  DROP `map_id`,
  DROP `instance_name_ru_ru`,
  DROP `instance_name_en_gb`,
  DROP `boss_name_ru_ru`,
  DROP `boss_name_en_gb`;

ALTER TABLE `armory_instances` ADD `instance_id` INT NOT NULL FIRST ;
ALTER TABLE `armory_instances` ADD PRIMARY KEY ( `instance_id` ) ; ;

CREATE TABLE `armory_instance_template` (
`map` INT NOT NULL ,
`name_ru_ru` VARCHAR( 150 ) NOT NULL ,
`name_en_gb` VARCHAR( 150 ) NOT NULL ,
`expansion` SMALLINT NOT NULL ,
`boss_num` INT NOT NULL ,
PRIMARY KEY ( `map` ) 
);