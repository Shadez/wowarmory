<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 343
 * @copyright (c) 2009-2010 Shadez
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

if(!defined('__ARMORY__')) {
    die('Direct access to this file not allowed!');
}

/** Classes **/
define('CLASS_WARRIOR', 0x01);
define('CLASS_PALADIN', 0x02);
define('CLASS_HUNTER',  0x03);
define('CLASS_ROGUE',   0x04);
define('CLASS_PRIEST',  0x05);
define('CLASS_DK',      0x06);
define('CLASS_SHAMAN',  0x07);
define('CLASS_MAGE',    0x08);
define('CLASS_WARLOCK', 0x09);
define('CLASS_DRUID',   0x0B);
define('MAX_CLASSES',   0x0C);

/** Races **/
define('RACE_HUMAN',    0x01);
define('RACE_ORC',      0x02);
define('RACE_DWARF',    0x03);
define('RACE_NIGHTELF', 0x04);
define('RACE_UNDEAD',   0x05);
define('RACE_TAUREN',   0x06);
define('RACE_GNOME',    0x07);
define('RACE_TROLL',    0x08);
define('RACE_BLOODELF', 0x0A);
define('RACE_DRAENEI',  0x0B);
define('MAX_RACES',     0x0C);

/** Achievements **/
define('ACHIEVEMENTS_CATEGORY_GENERAL',     92);
define('ACHIEVEMENTS_CATEGORY_QUESTS',      96);
define('ACHIEVEMENTS_CATEGORY_EXPLORATION', 97);
define('ACHIEVEMENTS_CATEGORY_PVP',         95);
define('ACHIEVEMENTS_CATEGORY_DUNGEONS',    168);
define('ACHIEVEMENTS_CATEGORY_PROFESSIONS', 169);
define('ACHIEVEMENTS_CATEGORY_REPUTATION',  201);
define('ACHIEVEMENTS_CATEGORY_EVENTS',      155);
define('ACHIEVEMENTS_CATEGORY_FEATS',       81);

define('ACHIEVEMENTS_COUNT_SUMMARY',     1058);
define('ACHIEVEMENTS_COUNT_GENERAL',     54);
define('ACHIEVEMENTS_COUNT_QUESTS',      49);
define('ACHIEVEMENTS_COUNT_EXPLORATION', 70);
define('ACHIEVEMENTS_COUNT_PVP',         166);
define('ACHIEVEMENTS_COUNT_DUNGEONS',    458);
define('ACHIEVEMENTS_COUNT_PROFESSIONS', 75);
define('ACHIEVEMENTS_COUNT_REPUTATION',  45);
define('ACHIEVEMENTS_COUNT_EVENTS',      141);

define('ACHIEVEMENT_POINTS_SUMMARY',     11675);
define('ACHIEVEMENT_POINTS_GENERAL',     570);
define('ACHIEVEMENT_POINTS_QUESTS',      530);
define('ACHIEVEMENT_POINTS_EXPLORATION', 830);
define('ACHIEVEMENT_POINTS_PVP',         1930);
define('ACHIEVEMENT_POINTS_DUNGEONS',    4955);
define('ACHIEVEMENT_POINTS_PROFESSIONS', 760);
define('ACHIEVEMENT_POINTS_REPUTATION',  560);
define('ACHIEVEMENT_POINTS_EVENTS',      1540);

/** Achievement Flags **/
define('ACHIEVEMENT_FLAG_COUNTER', 0x0001);
define('ACHIEVEMENT_FLAG_UNK2', 0x0002);
define('ACHIEVEMENT_FLAG_MAX_VALUE', 0x0004);
define('ACHIEVEMENT_FLAG_SUMM', 0x0008);
define('ACHIEVEMENT_FLAG_MAX_USED', 0x0010);
define('ACHIEVEMENT_FLAG_REQ_COUNT', 0x0020);
define('ACHIEVEMENT_FLAG_AVERANGE', 0x0040);
define('ACHIEVEMENT_FLAG_BAR', 0x0080);
define('ACHIEVEMENT_FLAG_REALM_FIRST_REACH', 0x0100); 
define('ACHIEVEMENT_FLAG_REALM_FIRST_KILL', 0x0200);
define('ACHIEVEMENT_CRITERIA_FLAG_SHOW_PROGRESS_BAR', 0x00000001);
define('ACHIEVEMENT_CRITERIA_FLAG_HIDE_CRITERIA', 0x00000002);
define('ACHIEVEMENT_CRITERIA_FLAG_UNK3', 0x00000004);
define('ACHIEVEMENT_CRITERIA_FLAG_UNK4', 0x00000008);
define('ACHIEVEMENT_CRITERIA_FLAG_UNK5', 0x00000010);
define('ACHIEVEMENT_CRITERIA_FLAG_MONEY_COUNTER', 0x00000020);
define('CUSTOM_ACHIEVEMENT_SHOW', ACHIEVEMENT_FLAG_SUMM|ACHIEVEMENT_FLAG_MAX_USED|ACHIEVEMENT_FLAG_REQ_COUNT);

/** Skills **/
define('SKILL_SWORDS', 43);
define('SKILL_AXES', 44);
define('SKILL_BOWS', 45);
define('SKILL_GUNS', 46);
define('SKILL_MACES', 54);
define('SKILL_TWO_HANDED_SWORDS', 55);
define('SKILL_DEFENCE', 95);
define('SKILL_DUAL_WIELD', 118);
define('SKILL_STAVES', 136);
define('SKILL_TWO_HANDED_MACES', 160);
define('SKILL_UNARMED', 162);
define('SKILL_TWO_HANDED_AXE', 172);
define('SKILL_DAGGERS', 173);
define('SKILL_THROWN', 176);
define('SKILL_CROSSBOWS', 226);
define('SKILL_WANDS', 228);
define('SKILL_POLEARMS', 229);
define('SKILL_FIST_WEAPONS', 473);

/** Faction Flags **/
define('FACTION_FLAG_VISIBLE', 0x01);         // makes visible in client (set or can be set at interaction with target of this faction)
define('FACTION_FLAG_AT_WAR', 0x02);          // enable AtWar-button in client. player controlled (except opposition team always war state), Flag only set on initial creation
define('FACTION_FLAG_HIDDEN', 0x04);          // hidden faction from reputation pane in client (player can gain reputation, but this update not sent to client)
define('FACTION_FLAG_INVISIBLE_FORCED', 0x08);// always overwrite FACTION_FLAG_VISIBLE and hide faction in rep.list, used for hide opposite team factions
define('FACTION_FLAG_PEACE_FORCED', 0x10);    // always overwrite FACTION_FLAG_AT_WAR, used for prevent war with own team factions
define('FACTION_FLAG_INACTIVE', 0x20);        // player controlled, state
define('FACTION_FLAG_RIVAL', 0x40);           // flag for the two competing outland factions

/** Stats **/
define('STAT_STRENGTH', 0);
define('STAT_AGILITY', 1);
define('STAT_STAMINA', 2);
define('STAT_INTELLECT', 3);
define('STAT_SPIRIT', 4);
define('MAX_STATS', 5);

/** Powers **/
define('POWER_MANA', 0);
define('POWER_RAGE', 1);
define('POWER_FOCUS', 2);
define('POWER_ENERGY', 3);
define('POWER_HAPPINESS', 4);
define('POWER_RUNE', 5);
define('POWER_RUNIC_POWER', 6);
define('POWER_HEALTH', 0xFFFFFFFE);

/** Attack Types **/
define('BASE_ATTACK', 0);
define('OFF_ATTACK', 1);
define('RANGED_ATTACK', 2);

/** Spell Schools **/
define('SPELL_SCHOOL_NORMAL', 0);
define('SPELL_SCHOOL_HOLY', 1);
define('SPELL_SCHOOL_FIRE', 2);
define('SPELL_SCHOOL_NATURE', 3);
define('SPELL_SCHOOL_FROST', 4);
define('SPELL_SCHOOL_SHADOW', 5);
define('SPELL_SCHOOL_ARCANE', 6);
define('MAX_SPELL_SCHOOL', 7);

/** Unit Mods **/
define('UNIT_MOD_STAT_STRENGTH', 0);
define('UNIT_MOD_STAT_AGILITY', 1);
define('UNIT_MOD_STAT_STAMINA', 2);
define('UNIT_MOD_STAT_INTELLECT', 3);
define('UNIT_MOD_STAT_SPIRIT', 4);
define('UNIT_MOD_HEALTH', 5);
define('UNIT_MOD_MANA', 6);
define('UNIT_MOD_RAGE', 7);
define('UNIT_MOD_FOCUS', 8);
define('UNIT_MOD_ENERGY', 9);
define('UNIT_MOD_HAPPINESS', 10);
define('UNIT_MOD_RUNE', 11);
define('UNIT_MOD_RUNIC_POWER', 12);
define('UNIT_MOD_ARMOR', 13);
define('UNIT_MOD_RESISTANCE_HOLY', 14);
define('UNIT_MOD_RESISTANCE_FIRE', 15);
define('UNIT_MOD_RESISTANCE_NATURE', 16);
define('UNIT_MOD_RESISTANCE_FROST', 17);
define('UNIT_MOD_RESISTANCE_SHADOW', 18);
define('UNIT_MOD_RESISTANCE_ARCANE', 19);
define('UNIT_MOD_ATTACK_POWER', 20);
define('UNIT_MOD_ATTACK_POWER_RANGED', 21);
define('UNIT_MOD_DAMAGE_MAINHAND', 22);
define('UNIT_MOD_DAMAGE_OFFHAND', 23);
define('UNIT_MOD_DAMAGE_RANGED', 24);
define('UNIT_MOD_END', 25);
define('UNIT_MOD_STAT_START', UNIT_MOD_STAT_STRENGTH);
define('UNIT_MOD_STAT_END', UNIT_MOD_STAT_SPIRIT+1);
define('UNIT_MOD_RESISTANCE_START', UNIT_MOD_ARMOR);
define('UNIT_MOD_RESISTANCE_END', UNIT_MOD_RESISTANCE_ARCANE+1);
define('UNIT_MOD_POWER_START', UNIT_MOD_MANA);
define('UNIT_MOD_POWER_END', UNIT_MOD_RUNIC_POWER+1);

/** Unit Modifier Types **/
define('BASE_VALUE', 0);
define('BASE_PCT', 1);
define('TOTAL_VALUE', 2);
define('TOTAL_PCT', 3);
define('MODIFIER_TYPE_END', 4);

/** Player Flags **/
define('PLAYER_FLAGS_HIDE_CLOAK', 2048);
define('PLAYER_FLAGS_HIDE_HELM', 1024);

/** Player Level Constants **/
define('PLAYER_MAX_LEVEL', 80); // Wrath

/** Character Feed **/
define('TYPE_ACHIEVEMENT_FEED', 1);
define('TYPE_ITEM_FEED',        2);
define('TYPE_BOSS_FEED',        3);

/** Item Quality**/
define('ITEM_QUALITY_POOR', 0);
define('ITEM_QUALITY_COMMON', 1);
define('ITEM_QUALITY_UNCOMMON', 2);
define('ITEM_QUALITY_RARE', 3);
define('ITEM_QUALITY_EPIC', 4);
define('ITEM_QUALITY_LEGENDARY', 5);
define('ITEM_QUALITY_ARTEFACT', 6);
define('ITEM_QUALITY_HEIRLOOM', 7);

/** Item Classes **/
define('ITEM_CLASS_CONSUMABLE', 0);
define('ITEM_CLASS_CONTAINER', 1);
define('ITEM_CLASS_WEAPON', 2);
define('ITEM_CLASS_GEM', 3);
define('ITEM_CLASS_ARMOR', 4);
define('ITEM_CLASS_REAGENT', 5);
define('ITEM_CLASS_PROJECTILE', 6);
define('ITEM_CLASS_TRADE_GOODS', 7);
define('ITEM_CLASS_GENERIC', 8);
define('ITEM_CLASS_RECIPE', 9);
define('ITEM_CLASS_MONEY', 10);
define('ITEM_CLASS_QUIVER', 11);
define('ITEM_CLASS_QUEST', 12);
define('ITEM_CLASS_KEY', 13);
define('ITEM_CLASS_PERMANENT', 14);
define('ITEM_CLASS_MISC', 15);
define('ITEM_CLASS_GLYPH', 16);

/** Item mods **/
define('ITEM_MOD_MANA', 0);
define('ITEM_MOD_HEALTH', 1);
define('ITEM_MOD_AGILITY', 3);
define('ITEM_MOD_STRENGTH', 4);
define('ITEM_MOD_INTELLECT', 5);
define('ITEM_MOD_SPIRIT', 6);
define('ITEM_MOD_STAMINA', 7);
define('ITEM_MOD_DEFENSE_SKILL_RATING', 12);
define('ITEM_MOD_DODGE_RATING', 13);
define('ITEM_MOD_PARRY_RATING', 14);
define('ITEM_MOD_BLOCK_RATING', 15);
define('ITEM_MOD_HIT_MELEE_RATING', 16);
define('ITEM_MOD_HIT_RANGED_RATING', 17);
define('ITEM_MOD_HIT_SPELL_RATING', 18);
define('ITEM_MOD_CRIT_MELEE_RATING', 19);
define('ITEM_MOD_CRIT_RANGED_RATING', 20);
define('ITEM_MOD_CRIT_SPELL_RATING', 21);
define('ITEM_MOD_HIT_TAKEN_MELEE_RATING', 22);
define('ITEM_MOD_HIT_TAKEN_RANGED_RATING', 23);
define('ITEM_MOD_HIT_TAKEN_SPELL_RATING', 24);
define('ITEM_MOD_CRIT_TAKEN_MELEE_RATING', 25);
define('ITEM_MOD_CRIT_TAKEN_RANGED_RATING', 26);
define('ITEM_MOD_CRIT_TAKEN_SPELL_RATING', 27);
define('ITEM_MOD_HASTE_MELEE_RATING', 28);
define('ITEM_MOD_HASTE_RANGED_RATING', 29);
define('ITEM_MOD_HASTE_SPELL_RATING', 30);
define('ITEM_MOD_HIT_RATING', 31);
define('ITEM_MOD_CRIT_RATING', 32);
define('ITEM_MOD_HIT_TAKEN_RATING', 33);
define('ITEM_MOD_CRIT_TAKEN_RATING', 34);
define('ITEM_MOD_RESILIENCE_RATING', 35);
define('ITEM_MOD_HASTE_RATING', 36);
define('ITEM_MOD_EXPERTISE_RATING', 37);
define('ITEM_MOD_ATTACK_POWER', 38);
define('ITEM_MOD_RANGED_ATTACK_POWER', 39);
define('ITEM_MOD_FERAL_ATTACK_POWER', 40);  //deprecated
define('ITEM_MOD_SPELL_HEALING_DONE', 41);  //deprecated
define('ITEM_MOD_SPELL_DAMAGE_DONE', 42);   //deprecated
define('ITEM_MOD_MANA_REGENERATION', 43);
define('ITEM_MOD_ARMOR_PENETRATION_RATING', 44);
define('ITEM_MOD_SPELL_POWER', 45);
define('ITEM_MOD_HEALTH_REGEN', 46);
define('ITEM_MOD_SPELL_PENETRATION', 47);
define('ITEM_MOD_BLOCK_VALUE', 48);

/** Item Proto **/
define('MAX_ITEM_PROTO_DAMAGES', 2);    // changed in 3.1.0
define('MAX_ITEM_PROTO_SOCKETS', 3);
define('MAX_ITEM_PROTO_SPELLS', 5);
define('MAX_ITEM_PROTO_STATS', 10);

/** Item Flags **/
define('ITEM_FLAGS_BINDED', 0x00000001); // set in game at binding, not set in template
define('ITEM_FLAGS_CONJURED', 0x00000002);
define('ITEM_FLAGS_OPENABLE', 0x00000004);
define('ITEM_FLAGS_WRAPPED', 0x00000008); // conflicts with heroic flag
define('ITEM_FLAGS_HEROIC', 0x00000008); // weird...
define('ITEM_FLAGS_BROKEN', 0x00000010); // appears red icon (like when item durability==0)
define('ITEM_FLAGS_INDESTRUCTIBLE', 0x00000020); // used for totem. Item can not be destroyed, except by using spell (item can be reagent for spell and then allowed)
define('ITEM_FLAGS_USABLE', 0x00000040); // ?
define('ITEM_FLAGS_NO_EQUIP_COOLDOWN', 0x00000080); // ?
define('ITEM_FLAGS_UNK3', 0x00000100); // saw this on item 47115, 49295...
define('ITEM_FLAGS_WRAPPER', 0x00000200); // used or not used wrapper
define('ITEM_FLAGS_IGNORE_BAG_SPACE', 0x00000400); // ignore bag space at new item creation?
define('ITEM_FLAGS_PARTY_LOOT', 0x00000800); // determines if item is party loot or not
define('ITEM_FLAGS_REFUNDABLE', 0x00001000); // item cost can be refunded within 2 hours after purchase
define('ITEM_FLAGS_CHARTER', 0x00002000); // arena/guild charter
define('ITEM_FLAGS_UNK4', 0x00008000); // a lot of items have this
define('ITEM_FLAGS_UNK1', 0x00010000); // a lot of items have this
define('ITEM_FLAGS_PROSPECTABLE', 0x00040000);
define('ITEM_FLAGS_UNIQUE_EQUIPPED', 0x00080000);
define('ITEM_FLAGS_USEABLE_IN_ARENA', 0x00200000);
define('ITEM_FLAGS_THROWABLE', 0x00400000); // not used in game for check trow possibility, only for item in game tooltip
define('ITEM_FLAGS_SPECIALUSE', 0x00800000); // last used flag in 2.3.0
define('ITEM_FLAGS_BOA', 0x08000000); // bind on account (set in template for items that can binded in like way)
define('ITEM_FLAGS_ENCHANT_SCROLL', 0x10000000); // for enchant scrolls
define('ITEM_FLAGS_MILLABLE', 0x20000000);
define('ITEM_FLAGS_BOP_TRADEABLE', 0x80000000);

/** Item Flags2 **/
define('ITEM_FLAGS2_HORDE_ONLY', 0x00000001); // drop in loot, sell by vendor and equipping only for horde
define('ITEM_FLAGS2_ALLIANCE_ONLY', 0x00000002); // drop in loot, sell by vendor and equipping only for alliance
define('ITEM_FLAGS2_EXT_COST_REQUIRES_GOLD', 0x00000004); // item cost include gold part in case extended cost use also

/** Inventory Slots **/
define('INV_TYPE_HEAD', 1);
define('INV_TYPE_NECK', 2);
define('INV_TYPE_SHOULDER', 3);
define('INV_TYPE_SHIRT', 4);
define('INV_TYPE_CHEST', 4);
define('INV_TYPE_WAIST', 6);
define('INV_TYPE_LEGS', 7);
define('INV_TYPE_FEET', 8);
define('INV_TYPE_WRISTS', 9);
define('INV_TYPE_HANDS', 10);
define('INV_TYPE_FINGER', 11);
define('INV_TYPE_TRINKET', 12);
define('INV_TYPE_WEAPON', 13);
define('INV_TYPE_SHIELD', 14);
define('INV_TYPE_RANGED', 15);
define('INV_TYPE_BACK', 16);
define('INV_TYPE_TWOHAND', 17);
define('INV_TYPE_BAG', 18);
define('INV_TYPE_TABARD', 19);
define('INV_TYPE_ROBE', 20);
define('INV_TYPE_MAINHAND', 21);
define('INV_TYPE_OFFHAND', 22);
define('INV_TYPE_TOME', 23);
define('INV_TYPE_AMMO', 24);
define('INV_TYPE_THROWN', 25);
define('INV_TYPE_RANGED_RIGHT', 26);
define('INV_TYPE_QUIVER', 27);
define('INV_TYPE_RELIC', 28);

/** Invetory Slots (Armory) **/
define('INV_HEAD', 0);
define('INV_NECK', 1);
define('INV_SHOULDER', 2);
define('INV_SHIRT', 3);
define('INV_CHEST', 4);
define('INV_BELT', 5);
define('INV_LEGS', 6);
define('INV_BOOTS', 7);
define('INV_BRACERS', 8);
define('INV_GLOVES', 9);
define('INV_RING_1', 10);
define('INV_RING_2', 11);
define('INV_TRINKET_1', 12);
define('INV_TRINKET_2', 13);
define('INV_BACK', 14);
define('INV_MAIN_HAND', 15);
define('INV_OFF_HAND', 16);
define('INV_RANGED_RELIC', 17);
define('INV_TABARD', 18);

/** Player Item Slots **/
define('PLAYER_SLOT_ITEM_HEAD', PLAYER_FIELD_INV_SLOT_HEAD);
define('PLAYER_SLOT_ITEM_NECK', PLAYER_FIELD_INV_SLOT_HEAD+2);
define('PLAYER_SLOT_ITEM_SHOULDER', PLAYER_FIELD_INV_SLOT_HEAD+4);
define('PLAYER_SLOT_ITEM_SHIRT', PLAYER_FIELD_INV_SLOT_HEAD+6);
define('PLAYER_SLOT_ITEM_CHEST', PLAYER_FIELD_INV_SLOT_HEAD+8);
define('PLAYER_SLOT_ITEM_BELT', PLAYER_FIELD_INV_SLOT_HEAD+10);
define('PLAYER_SLOT_ITEM_LEGS', PLAYER_FIELD_INV_SLOT_HEAD+12);
define('PLAYER_SLOT_ITEM_FEET', PLAYER_FIELD_INV_SLOT_HEAD+14);
define('PLAYER_SLOT_ITEM_WRIST', PLAYER_FIELD_INV_SLOT_HEAD+16);
define('PLAYER_SLOT_ITEM_GLOVES',  PLAYER_FIELD_INV_SLOT_HEAD+18);
define('PLAYER_SLOT_ITEM_FINGER1',PLAYER_FIELD_INV_SLOT_HEAD+20);
define('PLAYER_SLOT_ITEM_FINGER2', PLAYER_FIELD_INV_SLOT_HEAD+22);
define('PLAYER_SLOT_ITEM_TRINKET1', PLAYER_FIELD_INV_SLOT_HEAD+24);
define('PLAYER_SLOT_ITEM_TRINKET2', PLAYER_FIELD_INV_SLOT_HEAD+26);
define('PLAYER_SLOT_ITEM_BACK', PLAYER_FIELD_INV_SLOT_HEAD+28);
define('PLAYER_SLOT_ITEM_MAIN_HAND', PLAYER_FIELD_INV_SLOT_HEAD+30);
define('PLAYER_SLOT_ITEM_OFF_HAND', PLAYER_FIELD_INV_SLOT_HEAD+32);
define('PLAYER_SLOT_ITEM_RANGED', PLAYER_FIELD_INV_SLOT_HEAD+34);
define('PLAYER_SLOT_ITEM_TABARD', PLAYER_FIELD_INV_SLOT_HEAD+36);

/** Misc **/
define('ATTACK_POWER_MAGIC_NUMBER', 14);
define('BLOCK_PER_STRENGTH', 0.5);
define('HEALTH_PER_STAMINA', 10);
define('ARMOR_PER_AGILITY', 2);
define('MANA_PER_INTELLECT', 15);
define('MANA_REGEN_PER_SPIRIT', 0.2);
define('DODGE_PARRY_BLOCK_PERCENT_PER_DEFENSE', 0.04);
define('RESILIENCE_CRIT_CHANCE_TO_DAMAGE_REDUCTION_MULTIPLIER', 2.2);
define('PLAYER_FIELD_DODGE_RATING', PLAYER_FIELD_COMBAT_RATING_1+2);    // CR_DODGE
define('PLAYER_FIELD_PARRY_RATING', PLAYER_FIELD_COMBAT_RATING_1+3);    // CR_PARRY
define('PLAYER_FIELD_CRIT_TAKEN_MELEE_RATING', PLAYER_FIELD_COMBAT_RATING_1+14);    // CR_CRIT_TAKEN_MELEE
define('PLAYER_FIELD_CRIT_TAKEN_RANGED_RATING', PLAYER_FIELD_COMBAT_RATING_1+15);   // CR_CRIT_TAKEN_RANGED
define('PLAYER_FIELD_CRIT_TAKEN_SPELL_RATING', PLAYER_FIELD_COMBAT_RATING_1+16);    // CR_CRIT_TAKEN_SPELL

define('ITEM_FIELD_ENCHANTMENT_3_2', ITEM_FIELD_ENCHANTMENT_3_1+1);
define('ITEM_FIELD_ENCHANTMENT_4_2', ITEM_FIELD_ENCHANTMENT_4_1+1);
define('ITEM_FIELD_ENCHANTMENT_5_2', ITEM_FIELD_ENCHANTMENT_5_1+1);
define('ITEM_FIELD_ENCHANTMENT_6_2', ITEM_FIELD_ENCHANTMENT_6_1+1);

define('CR_WEAPON_SKILL', 0);
define('CR_DEFENSE_SKILL', 1);
define('CR_DODGE', 2);
define('CR_PARRY', 3);
define('CR_BLOCK', 4);
define('CR_HIT_MELEE', 5);
define('CR_HIT_RANGED', 6);
define('CR_HIT_SPELL', 7);
define('CR_CRIT_MELEE', 8);
define('CR_CRIT_RANGED', 9);
define('CR_CRIT_SPELL', 10);
define('CR_HIT_TAKEN_MELEE', 11);
define('CR_HIT_TAKEN_RANGED', 12);
define('CR_HIT_TAKEN_SPELL', 13);
define('CR_CRIT_TAKEN_MELEE', 14);
define('CR_CRIT_TAKEN_RANGED', 15);
define('CR_CRIT_TAKEN_SPELL', 16);
define('CR_HASTE_MELEE', 17);
define('CR_HASTE_RANGED', 18);
define('CR_HASTE_SPELL', 19);
define('CR_WEAPON_SKILL_MAINHAND', 20);
define('CR_WEAPON_SKILL_OFFHAND', 21);
define('CR_WEAPON_SKILL_RANGED', 22);
define('CR_EXPERTISE', 23);
define('CR_ARMOR_PENETRATION', 24);

define('DEFAULT_WORLD_OBJECT_SIZE', 0.388999998569489);
?>