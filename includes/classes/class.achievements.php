<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 321
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
    public function CalculateAchievementPoints($guid = null) {
        if($guid == null) {
            $guid = $this->guid;
        }
        if(!$guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $pts = $this->aDB->selectCell("
        SELECT SUM(`points`)
            FROM `armory_achievement`
                WHERE `id` IN 
                (
                    SELECT `achievement` 
                    FROM `%s`.`character_achievement`
                    WHERE `guid`=%d
                )
                ", $this->connectionData['name_characters'], $guid);
        $this->pts = $pts;
        return $this->pts;
    }
    
    /**
     * Returns % (0-100) for achievement progress bar width.
     * @category Achievements class
     * @example Achievements::getAchievementProgressBar(150)
     * @todo Check ACH_MAX_COUNT_GAME
     * @return int
     **/
    public function getAchievementProgressBar($sum) {
        $percent = ACHIEVEMENTS_COUNT_SUMMARY / 100;
        $progressPercent = $sum / $percent;
        return $progressPercent;
    }
    
    /**
     * Returns number of character completed achievements.
     * @category Achievements class
     * @example Achievements::countCharacterAchievements()
     * @return int
     **/
    public function CountCharacterAchievements() {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        return $this->cDB->selectCell("SELECT COUNT(`achievement`) FROM `character_achievement` WHERE `guid`=%d", $this->guid);
    }
    
    public function GetSummaryAchievementData($category) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $achievement_data = array('categoryId' => $category);
        $categories = null;
        // 3.3.5a
        switch($category) {
            case 92:
                $categories = '92';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_GENERAL;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_GENERAL;
                break;
            case 96:
                $categories = '14861, 14862, 14863';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_QUESTS;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_QUESTS;
                break;
            case 97:
                $categories = '14777, 14778, 14779, 14780';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_EXPLORATION;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_EXPLORATION;
                break;
            case 95:
                $categories = '165, 14801, 14802, 14803, 14804, 14881, 14901, 15003';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_PVP;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_PVP;
                break;
            case 168:
                $categories = '14808, 14805, 14806, 14921, 14922, 14923, 14961, 14962, 15001, 15002, 15041, 15042';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_DUNGEONS;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_DUNGEONS;
                break;
            case 169:
                $categories = '170, 171, 172';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_PROFESSIONS;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_PROFESSIONS;
                break;
            case 201:
                $categories = '14864, 14865, 14866';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_REPUTATION;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_REPUTATION;
                break;
            case 155:
                $categories = '160, 187, 159, 163, 161, 162, 158, 14981, 156, 14941';
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_EVENTS;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_EVENTS;
                break;
            case 81:
                $categories = '81';
                break;
            default: // Summary
                $categories = null;
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_SUMMARY;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_SUMMARY;
                break;
        }
        if($categories != null) {
            $achievement_ids = $this->aDB->select("
            SELECT `achievement`
                FROM `%s`.`character_achievement`
                WHERE `achievement` IN 
                (
                    SELECT `id` 
                    FROM `%s`.`armory_achievement` 
                    WHERE `categoryId` IN (%s)
                )
                AND `guid`=%d", $this->connectionData['name_characters'], $this->mysqlconfig['name_armory'], $categories, $this->guid);
            if(!$achievement_ids) {
                $achievement_data['earned'] = 0;
                $achievement_data['points'] = 0;
                return $achievement_data;
            }
            $ids = array();
            foreach($achievement_ids as $ach) {
                $ids[] = $ach['achievement'];
            }
            $achievement_data['earned'] = count($ids);
            $achievement_data['points'] = $this->aDB->selectCell("SELECT SUM(`points`) FROM `armory_achievement` WHERE `id` IN (%s)", $ids);
            if(!$achievement_data['earned']) {
                $achievement_data['earned'] = 0;
            }
            if(!$achievement_data['points']) {
                $achievement_data['points'] = 0;
            }
        }
        else {
            $achievement_data['earned'] = self::CountCharacterAchievements();
            $achievement_data['points'] = self::CalculateAchievementPoints();
        }
        return $achievement_data;
    }
        
    /**
     * Returns array with 5 latest completed achievements. Requires $this->guid!
     * @category Achievements class
     * @example Achievements::GetLastAchievements()
     * @return array
     **/
    public function GetLastAchievements() {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $achievements = $this->cDB->select("SELECT `achievement`, `date` FROM `character_achievement` WHERE `guid`=%d ORDER BY `date` DESC LIMIT 5", $this->guid);
        if(!$achievements) {
            $this->Log()->writeError('%s : unable to get data from character_achievement (player %d does not have achievements?)', __METHOD__, $this->guid);
            return false;
        }
        $aCount = count($achievements);
        for($i=0;$i<$aCount;$i++) {
            $achievements[$i] = self::GetAchievementInfo($achievements[$i]);
        }
        return $achievements;
    }
    
    /**
     * Returns achievement date. If $guid not provided, function will use $this->guid.
     * @category Achievements class
     * @example Achievements::GetAchievementDate(17, false)
     * @return string
     **/
    public function GetAchievementDate($guid = null, $achId = null) {
        if($guid == null) {
            $guid = $this->guid;
        }
        if($achId == null) {
            $achId = $this->achId;
        }
        $achievement_date = $this->cDB->selectCell("SELECT `date` FROM `character_achievement` WHERE `achievement`=%d AND `guid`=%d LIMIT 1", $achId, $guid);
        if(!$achievement_date) {
            $this->Log()->writeError('%s : unable to find completion date for achievement %d, player %d', __METHOD__, $achId, $guid);
            return false;
        }
        return date('Y-m-d\TH:i:s+02:00', $achievement_date);
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
     * @example Achievements::BuildCategoriesTree()
     * @return string
     **/
    public function BuildCategoriesTree() {
        $categoryIds = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `armory_achievement_category` WHERE `parentCategory`=-1 AND `id` <> 1", $this->_locale);
        if(!$categoryIds) {
            $this->Log()->writeError('%s : unable to get categories names (current locale: %s, locId: %d)', __METHOD__, $this->_locale, $this->_loc);
            return false;
        }
        $root_tree = array();
        $i = 0;
        foreach($categoryIds as $cat) {
            $child_categories = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `armory_achievement_category` WHERE `parentCategory`=%d", $this->_locale, $cat['id']);
            if($child_categories) {
                $root_tree[$i]['child'] = array();
                $child_count = count($child_categories);
                for($j=0;$j<$child_count;$j++) {
                    $root_tree[$i]['child'][$j] = array('name' => $child_categories[$j]['name'], 'id' => $child_categories[$j]['id']);
                }
            }
            $root_tree[$i]['name'] = $cat['name'];
            $root_tree[$i]['id'] = $cat['id'];
            $i++;
        }
        return $root_tree;
    }
    
    public function BuildStatisticsCategoriesTree() {
        $categoryIds = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `armory_achievement_category` WHERE `parentCategory`=1", $this->_locale);
        $root_tree = array();
        $i = 0;
        foreach($categoryIds as $cat) {
            $child_categories = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `armory_achievement_category` WHERE `parentCategory`=%d", $this->_locale, $cat['id']);
            if($child_categories) {
                $root_tree[$i]['child'] = array();
                $child_count = count($child_categories);
                for($j=0;$j<$child_count;$j++) {
                    $root_tree[$i]['child'][$j] = array('name' => $child_categories[$j]['name'], 'id' => $child_categories[$j]['id']);
                }
            }
            $root_tree[$i]['name'] = $cat['name'];
            $root_tree[$i]['id'] = $cat['id'];
            $i++;
        }
        return $root_tree;
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
            $this->Log()->writeError('%s : achievementData must be an array!', __METHOD__);
            return false;
        }
        $achievementinfo = $this->aDB->selectRow("SELECT `id`, `name_%s` AS `title`, `description_%s` AS `desc`, `points`, `categoryId`, `iconname` AS `icon` FROM `armory_achievement` WHERE `id`=%d LIMIT 1", $this->_locale, $this->_locale, $achievementData['achievement']);
        if(!$achievementinfo) {
            $this->Log()->writeError('%s : unable to get data for achievement %d (current locale: %s; locId: %d)', __METHOD__, $achievementData['achievement'], $this->_locale, $this->_loc);
            return false;
        }
        if($achievementinfo['points'] == 0) {
            unset($achievementinfo['points']);
        }
        $achievementinfo['dateCompleted'] = date('Y-m-d\TH:i:s:+01:00', $achievementData['date']);
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
            $this->Log()->writeError('%s : player guid or achievement id not provided', __METHOD__);
            return false;
        }
        if($achId == 0 || $achId == -1 || !$this->IsAchievementExists($achId)) {
            $this->Log()->writeError('%s : achievement %u not exists', __METHOD__, $achId);
            return false;
        }
        $date = $this->cDB->selectCell("SELECT `date` FROM `character_achievement` WHERE `guid`=%d AND `achievement`=%d", $this->guid, $achId);
        if($date) {
            return true;
        }
        return false;
    }
    
    public function IsAchievementExists($achId) {
        $data = $this->aDB->selectCell("SELECT 1 FROM `armory_achievement` WHERE `id`=%d LIMIT 1", $achId);
        if($data) {
            return true;
        }
        return false;
    }
    
    public function LoadAchievementPage($page_id, $faction) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not provided', __METHOD__);
            return false;
        }
        $achievements_data = $this->aDB->select(
        "SELECT `id`, `name_%s` AS `title`, `description_%s` AS `desc`, `iconname` AS `icon`, `points`, `categoryId`, `titleReward_%s` AS `titleReward`
            FROM `armory_achievement`
                WHERE `categoryId`=%d AND `factionFlag` IN (%d, -1) ORDER BY `OrderInCategory`", $this->_locale, $this->_locale, $this->_locale, $page_id, $faction);
        if(!$achievements_data) {
            $this->Log()->writeError('%s : unable to get data (page_id: %u, faction: %u, locale: %s, locId: %d)', __METHOD__, $page_id, $faction, $this->_locale, $this->_loc);
            return false;
        }
        $return_data = array();
        $i=0;
        $hide_id = array();
        foreach($achievements_data as $achievement) {
            $this->achId = $achievement['id'];
            $completed = self::IsAchievementCompleted($this->achId);
            $parentId = $this->aDB->selectCell("SELECT `parentAchievement` FROM `armory_achievement` WHERE `id`=%d", $this->achId);
            if($completed) {
                $return_data['completed'][$this->achId]['data'] = $achievement;
                $return_data['completed'][$this->achId]['data']['categoryId'] = $page_id;
                if($return_data['completed'][$this->achId]['data']['titleReward'] != null) {
                    $return_data['completed'][$this->achId]['data']['reward'] = $return_data['completed'][$this->achId]['data']['titleReward'];
                    unset($return_data['completed'][$this->achId]['data']['titleReward']);
                }
                if($page_id == 81) {
                    unset($return_data['completed'][$this->achId]['data']['points']);
                }
                $return_data['completed'][$this->achId]['data']['dateCompleted'] = self::GetAchievementDate();
                $return_data['completed'][$this->achId]['display'] = 1;
                $parent_used = false;
                if($parentId > 0 && self::IsAchievementCompleted($parentId)) {
                    $j=0;
                    $fullPoints = 0;
                    $return_data['completed'][$this->achId]['achievement_tree'] = array();
                    while($parentId != 0) {
                        if(!self::IsAchievementCompleted($parentId)) {
                            $hide_id[$i] = $parentId;
                            $parentId = 0;
                            if(count($return_data['completed'][$this->achId]['achievement_tree']) == 0) {
                                $parent_used = false;
                                unset($return_data['completed'][$this->achId]['achievement_tree']);
                            }
                        }
                        else {
                            $return_data['completed'][$parentId]['display'] = 0;
                            $parent_used = true;
                            $return_data['completed'][$this->achId]['achievement_tree'][$j] = $this->aDB->selectRow("
                            SELECT `id`, `name_%s` AS `title`, `description_%s` AS `desc`, `iconname` AS `icon`, `points`, `categoryId`
                                FROM `armory_achievement`
                                    WHERE `id`=%d", $this->_locale, $this->_locale, $parentId);
                            $return_data['completed'][$this->achId]['achievement_tree'][$j]['dateCompleted'] = self::GetAchievementDate($this->guid, $parentId);
                            $cPoints = $return_data['completed'][$this->achId]['achievement_tree'][$j]['points'];
                            $fullPoints = $fullPoints+$cPoints;
                            $return_data['completed'][$this->achId]['data']['points'] = $return_data['completed'][$this->achId]['achievement_tree'][$j]['points']+$fullPoints;
                            $parentId = $this->aDB->selectCell("SELECT `parentAchievement` FROM `armory_achievement` WHERE `id`=%d", $parentId);
                            $j++;
                        }
                    }
                }
                if(!$parent_used) {
                    $return_data['completed'][$this->achId]['criteria'] = self::BuildAchievementCriteriaTable();
                }
            }
            elseif($page_id != 81) { // Do not display incompleted achievements in `Feats of Strenght` category.
                $return_data['incompleted'][$this->achId]['data'] = $achievement;
                $return_data['incompleted'][$this->achId]['data']['categoryId'] = $page_id;
                $return_data['incompleted'][$this->achId]['display'] = 1;
                if(isset($return_data['incompleted'][$this->achId]['data']['titleReward']) && $return_data['incompleted'][$this->achId]['data']['titleReward'] != '') {
                    $return_data['incompleted'][$this->achId]['data']['reward'] = $return_data['incompleted'][$this->achId]['data']['titleReward'];
                    unset($return_data['incompleted'][$this->achId]['data']['titleReward']);
                }
                $return_data['incompleted'][$this->achId]['criteria'] = self::BuildAchievementCriteriaTable();
            }
            $i++;
        }
        return $return_data;
    }
    
    public function BuildAchievementCriteriaTable() {
        if($this->_locale == 'es_es' || $this->_locale == 'es_mx') {
            $locale = 'en_gb';
        }
        else {
            $locale = $this->_locale;
        }
        if(!$this->guid || !$this->achId) {
            $this->Log()->writeError('%s : player guid or achievement id not defiend', __METHOD__);
            return false;
        }
        $data = $this->aDB->select("SELECT * FROM `armory_achievement_criteria` WHERE `referredAchievement`=%d ORDER BY `showOrder`", $this->achId);
        if(!$data) {
            $this->Log()->writeError('%s : achievement criteria for achievement #%d not found', __METHOD__, $this->achId);
            return false;
        }
        $i = 0;
        $achievement_criteria = array();
        foreach($data as $criteria) {
            if($criteria['completionFlag']&ACHIEVEMENT_CRITERIA_FLAG_HIDE_CRITERIA) {
                continue;
            }
            $m_data = $this->GetCriteriaData($criteria['id']);
            if(!isset($m_data['counter']) || !$m_data['counter']) {
                $m_data['counter'] = 0;
            }
            $achievement_criteria[$i]['id']   = $criteria['id'];
            if(isset($m_data['date']) && $m_data['date'] > 0) {
                $achievement_criteria[$i]['date'] = date('Y-m-d\TH:i:s\+01:00', $m_data['date']);
            }
            $achievement_criteria[$i]['name'] = $criteria['name_'.$locale];
            if($criteria['completionFlag']&ACHIEVEMENT_CRITERIA_FLAG_SHOW_PROGRESS_BAR || $criteria['completionFlag']&ACHIEVEMENT_FLAG_COUNTER) {
                if($criteria['completionFlag']&ACHIEVEMENT_CRITERIA_FLAG_MONEY_COUNTER) {
                    $achievement_criteria[$i]['maxQuantityGold'] = $criteria['value'];
                    $money = Mangos::getMoney($m_data['counter']);
                    $achievement_criteria[$i]['quantityGold'] = $money['gold'];
                    $achievement_criteria[$i]['quantitySilver'] = $money['silver'];
                    $achievement_criteria[$i]['quantityCopper'] = $money['copper'];
                }
                else {
                    $achievement_criteria[$i]['maxQuantity'] = $criteria['value'];
                    $achievement_criteria[$i]['quantity'] = $m_data['counter'];
                }
            }
            $i++;
        }
        return $achievement_criteria;
    }
    
    public function GetCriteriaData($criteria_id) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $criteria_data = $this->cDB->selectRow("SELECT * FROM `character_achievement_progress` WHERE `guid`=%d AND `criteria`=%d", $this->guid, $criteria_id);
        if($criteria_data) {
            return $criteria_data;
        }
        return false;
    }
    
    public function LoadStatisticsPage($page_id, $faction) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $achievements_data = $this->aDB->select(
        "SELECT `id`, `name_%s` AS `name`, `description_%s` AS `desc`, `categoryId`
            FROM `armory_achievement`
                WHERE `categoryId`=%d AND `factionFlag` IN (%d, -1)", $this->_locale, $this->_locale, $page_id, $faction);
        if(!$achievements_data) {
            $this->Log()->writeError('%s : unable to get data for page_id %d, faction %d (current locale: %s, locId: %d)', __METHOD__, $page_id, $faction, $this->_locale, $this->_loc);
            return false;
        }
        $return_data = array();
        $i=0;
        $hide_id = array();
        foreach($achievements_data as $achievement) {
            $this->achId = $achievement['id'];
            $return_data[$i] = $achievement;
            $return_data[$i]['quantity'] = self::GetCriteriaValue();
            $i++;
        }
        return $return_data;
    }
    
    public function GetCriteriaValue() {
        if(!$this->guid || !$this->achId) {
            $this->Log()->writeError('%s : player guid or achievement id not defined', __METHOD__);
            return false;
        }
        $criteria_ids = $this->aDB->select("SELECT `id` FROM `armory_achievement_criteria` WHERE `referredAchievement`=%d", $this->achId);
        if(!$criteria_ids) {
            $this->Log()->writeError('%s : unable to get criterias for achievement %d', __METHOD__, $this->achId);
            return false;
        }
        $tmp_criteria_value = 0;
        foreach($criteria_ids as $criteria) {
            $tmp_criteria_value = $this->cDB->selectCell("SELECT `counter` FROM `character_achievement_progress` WHERE `guid`=%d AND `criteria`=%d LIMIT 1", $this->guid, $criteria['id']);
            if(!$tmp_criteria_value) {
                continue;
            }
            else {
                return $tmp_criteria_value;
            }
        }
        if(!$tmp_criteria_value) {
            $this->Log()->writeError('%s : criteria value not found (id: %d)', __METHOD__, $this->achId);
            return 0;
        }
        return $tmp_criteria_value;
    }
}
?>