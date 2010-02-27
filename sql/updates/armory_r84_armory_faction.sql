UPDATE `armory_db_version` SET `version`='armory_r84';
ALTER TABLE `armory_faction` ADD `friendlyTo` SMALLINT( 1 ) NOT NULL ,
ADD `hasRewards` SMALLINT( 1 ) NOT NULL ,
ADD `key` VARCHAR( 100 ) NOT NULL ,
ADD `expansion` SMALLINT( 1 ) NOT NULL ;

UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='aldor', `expansion`=1 WHERE `id`=932;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='ashtonguedeathsworn', `expansion`=1 WHERE `id`=1012;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='cenarionexpedition', `expansion`=1 WHERE `id`=942;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='consortium', `expansion`=1 WHERE `id`=933;
UPDATE `armory_faction` SET `friendlyTo`=0, `hasRewards`=1, `key`='honorhold', `expansion`=1 WHERE `id`=946;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='keepersoftime', `expansion`=1 WHERE `id`=989;
UPDATE `armory_faction` SET `friendlyTo`=0, `hasRewards`=1, `key`='kurenai', `expansion`=1 WHERE `id`=978;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='lowercity', `expansion`=1 WHERE `id`=1011;
UPDATE `armory_faction` SET `friendlyTo`=1, `hasRewards`=1, `key`='maghar', `expansion`=1 WHERE `id`=941;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='netherwing', `expansion`=1 WHERE `id`=1015;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='ogrila', `expansion`=1 WHERE `id`=1038;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='scaleofthesands', `expansion`=1 WHERE `id`=990;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='scryers', `expansion`=1 WHERE `id`=934;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='shatar', `expansion`=1 WHERE `id`=935;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='shatariskyguard', `expansion`=1 WHERE `id`=1031;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='shatteredsunoffensive', `expansion`=1 WHERE `id`=1077;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='sporeggar', `expansion`=1 WHERE `id`=970;
UPDATE `armory_faction` SET `friendlyTo`=1, `hasRewards`=1, `key`='thrallmar', `expansion`=1 WHERE `id`=947;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='violeteye', `expansion`=1 WHERE `id`=967;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='argentdawn', `expansion`=0 WHERE `id`=529;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='broodofnozdormu', `expansion`=0 WHERE `id`=910;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='cenarioncircle', `expansion`=0 WHERE `id`=609;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='darkmoonfaire', `expansion`=0 WHERE `id`=909;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='thoriumbrotherhood', `expansion`=0 WHERE `id`=59;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='timbermawhold', `expansion`=0 WHERE `id`=576;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='zandalartribe', `expansion`=0 WHERE `id`=270;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='argentcrusade', `expansion`=2 WHERE `id`=1106;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='frenzyhearttribe', `expansion`=2 WHERE `id`=1104;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='thekaluak', `expansion`=2 WHERE `id`=1073;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='kirintor', `expansion`=2 WHERE `id`=1090;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='knightsoftheebonblade', `expansion`=2 WHERE `id`=1098;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='theoracles', `expansion`=2 WHERE `id`=1105;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='thesonsofhodir', `expansion`=2 WHERE `id`=1119;
UPDATE `armory_faction` SET `friendlyTo`=2, `hasRewards`=1, `key`='thewyrmrestaccord', `expansion`=2 WHERE `id`=1091;
UPDATE `armory_faction` SET `friendlyTo`=0, `hasRewards`=1, `key`='silvercovenant', `expansion`=2 WHERE `id`=1094;
UPDATE `armory_faction` SET `friendlyTo`=1, `hasRewards`=1, `key`='sunreavers', `expansion`=2 WHERE `id`=1124;
UPDATE `armory_faction` SET `friendlyTo`=1, `hasRewards`=1, `key`='theashenverdict', `expansion`=2 WHERE `id`=1156;
UPDATE `armory_faction` SET `friendlyTo`=0, `hasRewards`=1, `key`='alliancevanguard', `expansion`=2 WHERE `id`=1037;
UPDATE `armory_faction` SET `friendlyTo`=1, `hasRewards`=1, `key`='hordeexpedition', `expansion`=2 WHERE `id`=1052;