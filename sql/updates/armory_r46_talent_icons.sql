UPDATE `db_version` SET `version` = 'armory_r46';

DROP TABLE IF EXISTS `talent_icons`;
CREATE TABLE `talent_icons` (
  `class` int(11) NOT NULL,
  `spec` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  PRIMARY KEY  (`class`,`spec`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `talent_icons` VALUES (1, 0, 'ability_rogue_eviscerate');
INSERT INTO `talent_icons` VALUES (1, 1, 'ability_warrior_innerrage');
INSERT INTO `talent_icons` VALUES (1, 2, 'inv_shield_06');
INSERT INTO `talent_icons` VALUES (2, 0, 'spell_holy_holybolt');
INSERT INTO `talent_icons` VALUES (2, 1, 'spell_holy_devotionaura');
INSERT INTO `talent_icons` VALUES (2, 2, 'spell_holy_auraoflight');
INSERT INTO `talent_icons` VALUES (3, 0, 'ability_hunter_beasttaming');
INSERT INTO `talent_icons` VALUES (3, 1, 'ability_marksmanship');
INSERT INTO `talent_icons` VALUES (3, 2, 'ability_hunter_swiftstrike');
INSERT INTO `talent_icons` VALUES (4, 0, 'ability_rogue_eviscerate');
INSERT INTO `talent_icons` VALUES (4, 1, 'ability_backstab');
INSERT INTO `talent_icons` VALUES (4, 2, 'ability_stealth');
INSERT INTO `talent_icons` VALUES (5, 0, 'spell_holy_wordfortitude');
INSERT INTO `talent_icons` VALUES (5, 1, 'spell_holy_guardianspirit');
INSERT INTO `talent_icons` VALUES (5, 2, 'spell_shadow_shadowwordpain');
INSERT INTO `talent_icons` VALUES (6, 0, 'spell_deathknight_bloodpresence');
INSERT INTO `talent_icons` VALUES (6, 1, 'spell_deathknight_frostpresence');
INSERT INTO `talent_icons` VALUES (6, 2, 'spell_deathknight_unholypresence');
INSERT INTO `talent_icons` VALUES (7, 0, 'spell_nature_lightning');
INSERT INTO `talent_icons` VALUES (7, 1, 'spell_nature_lightningshield');
INSERT INTO `talent_icons` VALUES (7, 2, 'spell_nature_magicimmunity');
INSERT INTO `talent_icons` VALUES (8, 0, 'spell_holy_magicalsentry');
INSERT INTO `talent_icons` VALUES (8, 1, 'spell_fire_firebolt02');
INSERT INTO `talent_icons` VALUES (8, 2, 'spell_frost_frostbolt02');
INSERT INTO `talent_icons` VALUES (9, 0, 'spell_shadow_deathcoil');
INSERT INTO `talent_icons` VALUES (9, 1, 'spell_shadow_metamorphosis');
INSERT INTO `talent_icons` VALUES (9, 2, 'spell_shadow_rainoffire');
INSERT INTO `talent_icons` VALUES (11, 0, 'spell_nature_starfall');
INSERT INTO `talent_icons` VALUES (11, 1, 'ability_racial_bearform');
INSERT INTO `talent_icons` VALUES (11, 2, 'spell_nature_healingtouch');