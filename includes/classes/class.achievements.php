<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 65
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

Class Achievements extends Connector {
    
    /**
     * Character guid
     **/
    public $guid;
    
    /**
     * Character achievement points
     **/
    public $pts;
    
    /**
     * Achievement ID
     **/
    public $achId;
    
    /**
     * Calculate total character achievement points
     * @category Achievements class
     * @example Achievements::calculateAchievementPoints()
     * @return int
     **/
    public function calculateAchievementPoints($guid='') {
        if($guid == '') {
            $guid = $this->guid;
        }
        if(!$guid) {
            return false;
        }
        $pts = $this->aDB->selectCell("
        SELECT SUM(`points`)
            FROM `armory_achievement`
                WHERE `id` IN 
                (
                    SELECT `achievement` 
                    FROM `" . $this->mysqlconfig['name_characters'] . "`.`character_achievement`
                    WHERE `guid`=?
                )
                ", $guid);
        $this->pts = $pts;
        return $pts;
    }
    
    /**
     * Returns % (0-100) for achievement progress bar width.
     * @category Achievements class
     * @example Achievements::getAchievementProgressBar(150)
     * @todo Check ACH_MAX_COUNT_GAME
     * @return int
     **/
    public function getAchievementProgressBar($sum) {
        $percent = ACH_MAX_COUNT_GAME / 100;
        $progressPercent = $sum / $percent;
        return $progressPercent;
    }
    
    /**
     * Returns number of character completed achievements.
     * @category Achievements class
     * @example Achievements::countCharacterAchievements()
     * @return int
     **/
    public function countCharacterAchievements() {
        if(!$this->guid) {
            return false;
        }
        $row = $this->cDB->selectPage($total, "SELECT `achievement` FROM `character_achievement` WHERE `guid`=?", $this->guid);
        return $total;
    }
    
    /**
     * Returns number of achievements completed in $category. Requires $this->guid!
     * @category Achievements class
     * @example Achievemens::sortAchievements(5)
     * @return int
     **/
    public function sortAchievements($category) {
        if(!$this->guid) {
            return false;
        }
        switch($category) {
            case 1:
                // General
                $achs = ACH_CATEGORY_GENERAL;
                break;
            case 2:
                // Quests
                $achs = ACH_CATEGORY_QUESTS.', '.ACH_CATEGORY_QUESTS_EA.', '.ACH_CATEGORY_QUESTS_TBC.', '.ACH_CATEGORY_QUESTS_WOTLK;
                break;
            case 3:
                // Exploration
                $achs = ACH_CATEGORY_EXPLORATION.', '.ACH_CATEGORY_EXPLORATION_EK.', '.ACH_CATEGORY_EXPLORATION_KALIMDOR.', '.ACH_CATEGORY_EXPLORATION_OUTLAND.', '.ACH_CATEGORY_EXPLORATION_NORTHREND;
                break;
            case 4:
                // PvP
                $achs = ACH_CATEGORY_PVP.', '.ACH_CATEGORY_PVP_ARENA.', '.ACH_CATEGORY_PVP_AV.', '.ACH_CATEGORY_PVP_AB.', '.ACH_CATEGORY_PVP_EOTS.', '.ACH_CATEGORY_PVP_WG.', '.ACH_CATEGORY_PVP_SA.', '.ACH_CATEGORY_PVP_WINTERGRASP.', '.ACH_CATEGORY_PVP_IC;
                break;
            case 5:
                // Dungeons & raids
                $achs = ACH_CATEGORY_DUNGEONS.', '.ACH_CATEGORY_DUNGEONS_CLASSIC.', '.ACH_CATEGORY_DUNGEONS_TBC.', '.ACH_CATEGORY_DUNGEONS_WOTLK.', '.ACH_CATEGORY_DUNGEONS_WOTLK_H.', '.ACH_CATEGORY_DUNGEONS_WOTLK_RAID.', '.ACH_CATEGORY_DUNGEONS_WOTLK_RAID_H.', '.ACH_CATEGORY_DUNGEONS_ULDUAR.', '.ACH_CATEGORY_DUNGEONS_ULDUAR_H.', '.ACH_CATEGORY_DUNGEONS_CRUSADE.', '.ACH_CATEGORY_DUNGEONS_CRUSADE_H.', '.ACH_CATEGORY_DUNGEONS_FALL_OF_THE_LICH_KING.', '.ACH_CATEGORY_DUNGEONS_FALL_OF_THE_LICH_KING_H;
                break;
            case 6:
                // Professions
                $achs = ACH_CATEGORY_PROFESSIONS.', '.ACH_CATEGORY_PROFESSIONS_COOKING.', '.ACH_CATEGORY_PROFESSIONS_FISHING.', '.ACH_CATEGORY_PROFESSIONS_FIRST_AID;
                break;
            case 7:
                // Reputation
                $achs = ACH_CATEGORY_REPUTATION.', '.ACH_CATEGORY_REPUTATION_CLASSIC.', '.ACH_CATEGORY_REPUTATION_TBC.', '.ACH_CATEGORY_REPUTATION_WOTLK;
                break;
            case 8:
                // Game events
                $achs = ACH_CATEGORY_EVENTS.', '.ACH_CATEGORY_EVENTS_LUNAR_FESTIVAL.', '.ACH_CATEGORY_EVENTS_LOVE.', '.ACH_CATEGORY_EVENTS_NOBLEGARDEN.', '.ACH_CATEGORY_EVENTS_CHILDRENS.', '.ACH_CATEGORY_EVENTS_MIDSUMMER.', '.ACH_CATEGORY_EVENTS_BREWFEST.', '.ACH_CATEGORY_EVENTS_HALLOWEEN.', '.ACH_CATEGORY_EVENTS_PILIGRIM.', '.ACH_CATEGORY_EVENTS_WINTER_VEIL.', '.ACH_CATEGORY_EVENTS_ARGENT_TOURNAMENT;
                break;
            case 9:
                // Feats of strenght
                $achs = ACH_CATEGORY_FEATS_OF_STRENGHT;
                break;
            default:
                $achs = 0;
                break;
        }
        $achievementsCount = $this->aDB->selectCell("
        SELECT COUNT(`achievement`)
            FROM `".$this->mysqlconfig['name_characters']."`.`character_achievement`
            WHERE `achievement` IN 
            (
                SELECT `id` 
                FROM `".$this->mysqlconfig['name_armory']."`.`armory_achievement` 
                WHERE `categoryId` IN (".$achs.")
            )
            AND `guid`=?", $this->guid);
        return $achievementsCount;
    }
    
    /**
     * Returns array with 5 latest completed achievements. Requires $this->guid!
     * @category Achievements class
     * @example Achievements::GetLastAchievements()
     * @todo Full rewrite
     * @return array
     **/
    public function GetLastAchievements() {
        if(!$this->guid) {
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $achievements = $this->cDB->select("SELECT `achievement`, `date` FROM `character_achievement` WHERE `guid`=? ORDER BY `date` DESC LIMIT 5", $this->guid);
        $aCount = count($achievements);
        for($i=0;$i<$aCount;$i++) {
            $achievements[$i] = $this->GetAchievementInfo($achievements[$i]);
        }
        return $achievements;
    }
    
    /**
     * Returns achievement date. If $guid not provided, function will use $this->guid.
     * @category Achievements class
     * @example Achievements::GetAchievementDate(17, false)
     * @return string
     **/
    public function GetAchievementDate($guid='', $achId='') {
        if(empty($guid)) {
            $guid = $this->guid;
        }
        if(empty($achId)) {
            $achId = $this->achId;
        }
        $achievement_date = $this->cDB->selectCell("
        SELECT `date`
            FROM `character_achievement`
                WHERE `achievement`=? AND `guid`=? LIMIT 1", $achId, $guid);
        if(!$achievement_date) {
            return false;
        }
        $stringDate = date('d/m/Y', $achievement_date);
        return $stringDate;
    }
    
    /**
     * Returns achievement criteria & progress info. Requires $this->achId!
     * @category Achievements class
     * @example Achievements::AchievementProgress()
     * @todo Sort with achievement criteria types
     * @return string
     **/
    public function AchievementProgress() {
        $string_return = '';
        $tmp_str       = '';
        $data = $this->aDB->select("SELECT * FROM `armory_achievement_criteria` WHERE `referredAchievement`=?", $this->achId);
        
        $progress_bar_string = "<ul class='criteria'><div class='critbar'><div class='prog_bar '><div class='progress_cap'></div><div class='progress_cap_r'></div><div class='progress_int'><div class='progress_fill' style='width:{PERCENT}%'></div><div class='prog_int_text'>{CURRENT_NUM} / {FULLCOUNT}</div></div></div></div></ul>";
        $progress_list_string = "<ul class='criteria c_list'>{CRITERIA_LIST}</ul>";
        // Check if data exists
        
        // Hack
        error_reporting(0);
        
        $character_progress = $this->cDB->selectCell("
        SELECT `counter`
            FROM `character_achievement_progress`
                WHERE `criteria`=? AND `guid`=? LIMIT 1", $data['0']['id'], $this->guid);
        if(empty($character_progress) || !$character_progress) {
            $character_progress = 0;
        }
        switch($data[0]['requiredType']) {
            /** COUNTERS **/
            case ACHIEVEMENT_CRITERIA_TYPE_REACH_SKILL_LEVEL:
            case ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_QUEST_COUNT:
            case ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_DAILY_QUEST_DAILY:
            case ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_QUESTS_IN_ZONE:
            case ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_DAILY_QUEST:
            case ACHIEVEMENT_CRITERIA_TYPE_CAST_SPELL:
            case ACHIEVEMENT_CRITERIA_TYPE_DAMAGE_DONE:
            case ACHIEVEMENT_CRITERIA_TYPE_WIN_RATED_ARENA:
            case ACHIEVEMENT_CRITERIA_TYPE_USE_ITEM:
            case ACHIEVEMENT_CRITERIA_TYPE_LOOT_ITEM:
            case ACHIEVEMENT_CRITERIA_TYPE_BUY_BANK_SLOT:
            case ACHIEVEMENT_CRITERIA_TYPE_GAIN_EXALTED_REPUTATION:
            case ACHIEVEMENT_CRITERIA_TYPE_GET_KILLING_BLOWS:
            case ACHIEVEMENT_CRITERIA_TYPE_MONEY_FROM_QUEST_REWARD:
            case ACHIEVEMENT_CRITERIA_TYPE_LOOT_MONEY:
            case ACHIEVEMENT_CRITERIA_TYPE_LEARN_SKILLLINE_SPELLS:
            case ACHIEVEMENT_CRITERIA_TYPE_LOOT_TYPE:
            case ACHIEVEMENT_CRITERIA_TYPE_EARN_HONORABLE_KILL:
            case ACHIEVEMENT_CRITERIA_TYPE_LFD_PASSED:
            case ACHIEVEMENT_CRITERIA_TYPE_BE_SPELL_TARGET2:
                if($data[0]['requiredType'] == ACHIEVEMENT_CRITERIA_TYPE_MONEY_FROM_QUEST_REWARD || $data[0]['requiredType'] == ACHIEVEMENT_CRITERIA_TYPE_LOOT_MONEY) {
                    $money = Mangos::getMoney($character_progress);
                    $money_need = Mangos::getMoney($data[0]['value']);
                    $progress_bar_string = "<ul class='criteria'><div class='critbar'><div class='prog_bar '><div class='progress_cap'></div><div class='progress_cap_r'></div><div class='progress_int'><div class='progress_fill' style='width:{PERCENT}%'></div><div class='prog_int_text'>";
                    if($money['gold'] > 0) {
                        $progress_bar_string .= $money['gold']." <img alt='' class='p' src='images/icons/money-gold-small.png'/>";
                    }
                    if($money['silver'] > 0) {
                        $progress_bar_string .= $money['silver']." <img alt='' class='p' src='images/icons/money-silver-small.png'/>";
                    }
                    if($money['copper'] > 0) {
                        $progress_bar_string .= $money['copper']." <img alt='' class='p' src='images/icons/money-copper-small.png'/>";
                    }
                    $progress_bar_string .= " / ".$money_need['gold']."<img alt='' class='p' src='images/icons/money-gold-small.png'/></div></div></div></div></ul>";
                }
                if($data[0]['requiredType'] == ACHIEVEMENT_CRITERIA_TYPE_BE_SPELL_TARGET2 && $data[0]['value'] == 1) {
                    return;
                }
                $percent_value = floor(Utils::getPercent($data['0']['value'], $character_progress));
                $progress_bar_string = str_replace("{PERCENT}", $percent_value, $progress_bar_string);
                $progress_bar_string = str_replace("{CURRENT_NUM}", $character_progress, $progress_bar_string);
                $progress_bar_string = str_replace("{FULLCOUNT}", $data[0]['value'], $progress_bar_string);
                $string_return = $progress_bar_string;
                break;
            case ACHIEVEMENT_CRITERIA_TYPE_KILL_CREATURE:
            case ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_ACHIEVEMENT:
            case ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_QUEST:
            case ACHIEVEMENT_CRITERIA_TYPE_BE_SPELL_TARGET:
            case ACHIEVEMENT_CRITERIA_TYPE_OWN_ITEM:
            case ACHIEVEMENT_CRITERIA_TYPE_EXPLORE_AREA:
            case ACHIEVEMENT_CRITERIA_TYPE_GAIN_REPUTATION:
            case ACHIEVEMENT_CRITERIA_TYPE_EQUIP_EPIC_ITEM:
            case ACHIEVEMENT_CRITERIA_TYPE_HK_CLASS:
            case ACHIEVEMENT_CRITERIA_TYPE_HK_RACE:
            case ACHIEVEMENT_CRITERIA_TYPE_DO_EMOTE:
            case ACHIEVEMENT_CRITERIA_TYPE_USE_GAMEOBJECT:
            case ACHIEVEMENT_CRITERIA_TYPE_BE_SPELL_TARGET2:
            case ACHIEVEMENT_CRITERIA_TYPE_SPECIAL_PVP_KILL:
            case ACHIEVEMENT_CRITERIA_TYPE_FISH_IN_GAMEOBJECT:
                $i=0;
                foreach($data as $criteria) {
                    $counter = $this->cDB->selectCell("SELECT `counter` FROM `character_achievement_progress` WHERE `criteria`=? AND `guid`=?", $criteria['id'], $this->guid);
                    $tmp_str .= "<li class='c_list_col";
                    if(!empty($counter)) {
                        $tmp_str .= " criteriamet'";
                    }
                    else {
                        $tmp_str .= "'";
                    }
                    if($i%2) {
                        $tmp_str .= " style='float:left;'";
                    }
                    $_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
                    $tmp_str .= '>'.$criteria['name_'.$_locale].'</li>';
                    $i++;
                }
                $string_return = str_replace("{CRITERIA_LIST}", $tmp_str, $progress_list_string);
                break;
            }
        // Hack
        error_reporting(E_ALL);
        return $string_return;
    }
    
    /**
     * Returns progress bar width % (0-100) for selected category ($achType)
     * @category Achievements class
     * @example Achievements::CountAchievementPercent(15, 4)
     * @return int
     **/
    public function CountAchievementPercent($sum, $achType) {
        switch($achType) {
            case 1:
                $maxAch = 54;
				break;
			case 2:
				$maxAch = 49;
				break;
			case 3:
				$maxAch = 70;
				break;
			case 4:
				$maxAch = 166;
				break;
			case 5:
				$maxAch = 454;
				break;
			case 6:
				$maxAch = 75;
				break;
			case 7:
				$maxAch = 45;
				break;
			case 8:
				$maxAch = 141;
				break;
			case 9:
				$maxAch = 126;
				break;
        }
        $percent = $maxAch / 100;
        $progressPercent = $sum / $percent;
        return $progressPercent;
    }
    
    /**
     * Generates achievement categories menu (for character-achievements.php)
     * @category Achievements class
     * @example Achievements::buildAchievementsTree()
     * @return string
     **/
    public function buildAchievementsTree() {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $categoryIds = $this->aDB->select("SELECT `id`, `name_".$locale."` FROM `armory_achievement_category` WHERE `parentCategory`=-1");
        $achievementTree = '';
        foreach($categoryIds as $cat) {
            $i = 0;
            $achievementTree .= '<div>
            <a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, \''.$cat['id'].'\'); loadAchievements(\''.Characters::GetCharacterName($this->guid).'\', '.$cat['id'].')">'.$cat['name_'.$locale].'</a>';
            $child = $this->aDB->select("SELECT `id`, `name_".$locale."` FROM `armory_achievement_category` WHERE `parentCategory`=?", $cat['id']);
            if($child) {
                $achievementTree .= '<div class="cat_list">';
                foreach($child as $childcat) {
                    $achievementTree .= '<div class="nav-subcat"><a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, \''.$i.'\'); loadAchievements(\''.Characters::GetCharacterName($this->guid).'\', '.$childcat['id'].')">'.$childcat['name_'.$locale].'</a></div>';
                    $i++;
                }
                $achievementTree .= '</div>';
            }
            $achievementTree .= '</div>';
        }
        return $achievementTree;
    }
    
    /**
     * Returns basic achievement info (name, description, points). 
     * $achievementData must be in array format: array('achievement' => ACHIEVEMENT_ID, 'date' => TIMESTAMP_DATE)
     * @category Achievements class
     * @example Achievements::GetAchievementInfo(1263163814)
     * @return string
     **/
    public function GetAchievementInfo(&$achievementData) {
        if(!is_array($achievementData)) {
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $achievementinfo = $this->aDB->selectRow("SELECT `id`, `name_".$locale."` AS `name`, `description_".$locale."` AS `description`, `points` FROM `armory_achievement` WHERE `id`=? LIMIT 1", $achievementData['achievement']);
        if(!$achievementinfo) {
            return false;
        }
        $achievementinfo['date'] = $this->GetDateFormat($achievementData['date']);
        return $achievementinfo;
    }
    
    /**
     * Returns formatted date
     * @category Achievements class
     * @example Achievements::GetDateFormat(1263163814)
     * @return string
     **/
    public function GetDateFormat($timestamp) {
        return date('d/m/Y', $timestamp);
    }
    
    public function IsAchievementCompleted($achId) {
        if(!$this->guid || !$achId) {
            return false;
        }
        if($achId == 0 || $achId == '-1' || !$this->IsAchievementExists($achId)) {
            return true;
        }
        $date = $this->cDB->selectCell("SELECT `date` FROM `character_achievement` WHERE `guid`=? AND `achievement`=?", $this->guid, $achId);
        if($date) {
            return true;
        }
        return false;
    }
    
    public function IsAchievementExists($achId) {
        $data = $this->aDB->selectCell("SELECT `name_en_gb` FROM `armory_achievement` WHERE `id`=?", $achId);
        if($data) {
            return true;
        }
        return false;
    }
    /*
    public function MergeCompletedAchievements($check = false) {
        if(!$this->guid || !$this->achId) {
            return false;
        }
        if($check == true) {
            $tmp_data = $this->aDB->selectCell("SELECT `parentAchievement` FROM `armory_achievement` WHERE `id`=?", $achId);
            if($tmp_data) {
                if($this->IsAchievementCompleted($tmp_data)) {
                    return true;
                }
                return false;
            }
        }
        $loop = true;
        $achievementsArray = array();
        $i = 0;
        $achId = $this->achId;
        $macro = false;
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        while($loop == true) {
            $tmp_data = $this->aDB->selectCell("SELECT `parentAchievement` FROM `armory_achievement` WHERE `id`=?", $achId);
            if($tmp_data) {
                if($this->IsAchievementCompleted($tmp_data)) {
                    $achievementsArray[$i] = $this->cDB->selectRow("SELECT `id`, `name_".$locale."` AS `name`, `points` FROM `armory_achievement` WHERE `id`=?", $tmp_data);
                    $achId = $tmp_data;
                    $macro = true;
                }
            }
            else {
                $loop = false;
            }
            $i++;
        }
        if($macro == true) {
            $returnString = "<ul class='criteria c_list'>";
            $i = 0;
            foreach($achievementsArray as $achievement) {
                $returnString .= "<li class='c_list_col criteriamet' id='ach".$achievement['id']."'";
                if($i%2) {
                    $returnString .= ">";
                }
                else {
                    $returnString .= " style='float:left'>";
                }
                $returnString .= $achievement['name'].' ('.$achievement['points'].')'.'</li>';
                $i++;
            }
            $returnString .= '</ul>';
            return $achievementsArray;
        }
        return false;
    }
    */
}
?>