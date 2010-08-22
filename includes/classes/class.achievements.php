<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 369
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

Class Achievements extends Armory {
    
    /**
     * Character guid
     * @category Achievements class
     * @access   public
     **/
    public $guid;
    
    /**
     * Character achievement points
     * @category Achievements class
     * @access   public
     **/
    public $pts;
    
    /**
     * Achievement ID
     * @category Achievements class
     * @access   public
     **/
    public $achId;
    
    /**
     * Characters database handler
     * @category Achievements class
     * @access   private
     **/
    private $db;
    
    /**
     * Character achievements count
     * @category Achievements class
     * @access   private
     **/
    private $m_count;
    
    /**
     * Creates Achievement class instance
     * @category Achievements class
     * @access   public
     * @param    int $player_guid
     * @param    ArmoryDatabaseHandler $db
     * @param    bool $check = true
     * @return   bool
     **/
    public function InitAchievements($player_guid, ArmoryDatabaseHandler $db, $check = true) {
        // Clear values before recalculation
        $this->guid    = 0;
        $this->db      = null;
        $this->achId   = 0;
        $this->m_count = 0;
        $this->pts     = 0;
        if(!is_object($db)) {
            $this->Log()->writeError('%s : $db must be object, %s given!', __METHOD__, gettype($db));
            return false;
        }
        if(!$db->TestLink()) {
            $this->Log()->writeError('%s : wrong database handler!', __METHOD__);
            unset($db, $player_guid);
            return false;
        }
        if($check == true && !$db->selectCell("SELECT 1 FROM `characters` WHERE `guid`=%d LIMIT 1", $player_guid)) {
            $this->Log()->writeError('%s : player with guid %d was not found in `characters` table!', __METHOD__, $player_guid);
            unset($db, $player_guid);
            return false;
        }
        $this->guid = $player_guid;
        $this->db   = $db;
        self::CalculateAchievementPoints();
        self::CountCharacterAchievements();
        return true;
    }
    
    /**
     * Returns achievement points for current character
     * @category Achievements class
     * @access   public
     * @return   int
     **/
    public function GetAchievementPoints() {
        return $this->pts;
    }
    
    /**
     * Returns completed achievements count
     * @category Achievements class
     * @access   public
     * @return   int
     **/
    public function GetAchievementsCount() {
        return $this->m_count;
    }
    
    /**
     * Calculate total character achievement points
     * @category Achievements class
     * @access   public
     * @return   int
     **/
    public function CalculateAchievementPoints() {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $achievement_ids = $this->db->select("SELECT `achievement` FROM `character_achievement` WHERE `guid`=%d", $this->guid);
        if(!$achievement_ids) {
            $this->Log()->writeError('%s : unable to find any completed achievement for player %d', __METHOD__, $this->guid);
            return false;
        }
        $ids = array();
        foreach($achievement_ids as $_tmp) {
            $ids[] = $_tmp['achievement'];
        }
        $this->pts = $this->aDB->selectCell("SELECT SUM(`points`) FROM `ARMORYDBPREFIX_achievement` WHERE `id` IN (%s)", $ids);
        return $this->pts;
    }
    
    /**
     * Returns number of character completed achievements.
     * @category Achievements class
     * @access   public
     * @return   int
     **/
    public function CountCharacterAchievements() {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $this->m_count = $this->db->selectCell("SELECT COUNT(`achievement`) FROM `character_achievement` WHERE `guid`=%d", $this->guid);
        return $this->m_count;
    }
    
    /**
     * Returns summary data for completed achievements in selected category.
     * @category Achievements class
     * @access   public
     * @param    int $category
     * @return   array
     **/
    public function GetSummaryAchievementData($category) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $achievement_data = array('categoryId' => $category);
        $categories = 0;
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
                $categories = 0;
                $achievement_data['total'] = ACHIEVEMENTS_COUNT_SUMMARY;
                $achievement_data['totalPoints'] = ACHIEVEMENT_POINTS_SUMMARY;
                break;
        }
        if($categories != 0) {
            $id_in_category = $this->aDB->select("SELECT `id` FROM `ARMORYDBPREFIX_achievement` WHERE `categoryId` IN (%s)", $categories);
            if(!$id_in_category) {
                $this->Log()->writeError('%s : unable to find any achievements in %s category', __METHOD__, $categories);
            }
            $a_ids = array();
            if(is_array($id_in_category)) {
                foreach($id_in_category as $_tId) {
                    $a_ids[] = $_tId['id'];
                }
            }
            $achievement_ids = $this->db->select("SELECT `achievement` FROM `character_achievement` WHERE `guid`=%d AND `achievement` IN (%s)", $this->guid, $a_ids);
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
            $achievement_data['points'] = $this->aDB->selectCell("SELECT SUM(`points`) FROM `ARMORYDBPREFIX_achievement` WHERE `id` IN (%s)", $ids);
            if(!$achievement_data['earned']) {
                $achievement_data['earned'] = 0;
            }
            if(!$achievement_data['points']) {
                $achievement_data['points'] = 0;
            }
        }
        else {
            $achievement_data['earned'] = self::GetAchievementsCount();
            $achievement_data['points'] = self::GetAchievementPoints();
        }
        return $achievement_data;
    }
        
    /**
     * Returns array with 5 latest completed achievements. Requires $this->guid!
     * @category Achievements class
     * @access   public
     * @return   array
     **/
    public function GetLastAchievements() {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $achievements = $this->db->select("SELECT `achievement`, `date` FROM `character_achievement` WHERE `guid`=%d ORDER BY `date` DESC LIMIT 5", $this->guid);
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
     * Returns achievement date.
     * @category Achievements class
     * @access   public
     * @param    int $achId = 0
     * @return   string
     **/
    public function GetAchievementDate($achId = 0) {
        if($achId == 0) {
            $achId = $this->achId;
        }
        if(!$this->guid || !$achId) {
            $this->Log()->writeError('%s : not enough data for calculation (guid: %d, achId: %d).', __METHOD__, $this->guid, $achId);
            return false;
        }
        $achievement_date = $this->cDB->selectCell("SELECT `date` FROM `character_achievement` WHERE `achievement`=%d AND `guid`=%d LIMIT 1", $achId, $this->guid);
        if(!$achievement_date) {
            $this->Log()->writeError('%s : unable to find completion date for achievement %d, player %d', __METHOD__, $achId, $this->guid);
            return false;
        }
        return date('d/m/Y', $achievement_date); // Hack (Can't find the reason why achievement date is not displaying. Working on it.)
    }
    
    /**
     * Generates achievements categories tree
     * @category Achievements class
     * @access   public
     * @return   string
     **/
    public function BuildCategoriesTree() {
        $categoryIds = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_achievement_category` WHERE `parentCategory`=-1 AND `id` <> 1", $this->GetLocale());
        if(!$categoryIds) {
            $this->Log()->writeError('%s : unable to get categories names (current locale: %s, locId: %d)', __METHOD__, $this->GetLocale(), $this->GetLoc());
            return false;
        }
        $root_tree = array();
        $i = 0;
        foreach($categoryIds as $cat) {
            $child_categories = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_achievement_category` WHERE `parentCategory`=%d", $this->GetLocale(), $cat['id']);
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
     * Generates statistics categories tree
     * @category Achievements class
     * @access   public
     * @return   array
     **/
    public function BuildStatisticsCategoriesTree() {
        $categoryIds = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_achievement_category` WHERE `parentCategory`=1", $this->GetLocale());
        $root_tree = array();
        $i = 0;
        foreach($categoryIds as $cat) {
            $child_categories = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_achievement_category` WHERE `parentCategory`=%d", $this->GetLocale(), $cat['id']);
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
     * @access   public
     * @param    array $achievementData
     * @return   string
     **/
    public function GetAchievementInfo($achievementData) {
        if(!is_array($achievementData)) {
            $this->Log()->writeError('%s : achievementData must be an array!', __METHOD__);
            return false;
        }
        $achievementinfo = $this->aDB->selectRow("SELECT `id`, `name_%s` AS `title`, `description_%s` AS `desc`, `points`, `categoryId`, `iconname` AS `icon` FROM `ARMORYDBPREFIX_achievement` WHERE `id`=%d LIMIT 1", $this->GetLocale(), $this->GetLocale(), $achievementData['achievement']);
        if(!$achievementinfo) {
            $this->Log()->writeError('%s : unable to get data for achievement %d (current locale: %s; locId: %d)', __METHOD__, $achievementData['achievement'], $this->GetLocale(), $this->GetLoc());
            return false;
        }
        if($achievementinfo['points'] == 0) {
            unset($achievementinfo['points']);
        }
        $achievementinfo['dateCompleted'] = date('Y-m-d\TH:i:s:+01:00', $achievementData['date']);
        return $achievementinfo;
    }
    
    /**
     * Checks is achievement with $achId ID completed by current player
     * @category Achievements class
     * @access   public
     * @param    int $achId
     * @return   bool
     **/
    public function IsAchievementCompleted($achId) {
        if(!$this->guid || !$achId) {
            $this->Log()->writeError('%s : player guid or achievement id not provided (guid: %d, achId: %d)', __METHOD__, $this->guid, $achId);
            return false;
        }
        if($achId == 0 || $achId == -1 || !self::IsAchievementExists($achId)) {
            $this->Log()->writeError('%s : achievement %d not exists', __METHOD__, $achId);
            return false;
        }
        return $this->db->selectCell("SELECT 1 FROM `character_achievement` WHERE `guid`=%d AND `achievement`=%d", $this->guid, $achId);
    }
    
    /**
     * Checks is achievement $achId exists in DB
     * @category Achievements class
     * @access   public
     * @param    int $achId
     * @return   bool
     **/
    public function IsAchievementExists($achId) {
        return $this->aDB->selectCell("SELECT 1 FROM `ARMORYDBPREFIX_achievement` WHERE `id`=%d LIMIT 1", $achId);
    }
    
    /**
     * Generates achievement page
     * @category Achievements class
     * @access   public
     * @param    int $page_id
     * @param    int $faction
     * @return   array
     **/
    public function LoadAchievementPage($page_id, $faction) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not provided', __METHOD__);
            return false;
        }
        $achievements_data = $this->aDB->select(
        "SELECT `id`, `name_%s` AS `title`, `description_%s` AS `desc`, `iconname` AS `icon`, `points`, `categoryId`, `titleReward_%s` AS `titleReward`
            FROM `ARMORYDBPREFIX_achievement`
                WHERE `categoryId`=%d AND `factionFlag` IN (%d, -1) ORDER BY `OrderInCategory`", $this->GetLocale(), $this->GetLocale(), $this->GetLocale(), $page_id, $faction);
        if(!$achievements_data) {
            $this->Log()->writeError('%s : unable to get data (page_id: %u, faction: %u, locale: %s, locId: %d)', __METHOD__, $page_id, $faction, $this->GetLocale(), $this->GetLoc());
            return false;
        }
        $return_data = array();
        $i = 0;
        $hide_id = array();
        foreach($achievements_data as $achievement) {
            $this->achId = $achievement['id'];
            $completed = self::IsAchievementCompleted($this->achId);
            $parentId = $this->aDB->selectCell("SELECT `parentAchievement` FROM `ARMORYDBPREFIX_achievement` WHERE `id`=%d", $this->achId);
            if($completed) {
                $return_data['completed'][$this->achId]['data'] = $achievement;
                $return_data['completed'][$this->achId]['data']['categoryId'] = $page_id;
                if($return_data['completed'][$this->achId]['data']['titleReward'] != null) {
                    $return_data['completed'][$this->achId]['data']['reward'] = $return_data['completed'][$this->achId]['data']['titleReward'];
                    unset($return_data['completed'][$this->achId]['data']['titleReward']);
                }
                if($page_id == 81) {
                    // Feats of Strength does not have points
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
                                FROM `ARMORYDBPREFIX_achievement`
                                    WHERE `id`=%d", $this->GetLocale(), $this->GetLocale(), $parentId);
                            $return_data['completed'][$this->achId]['achievement_tree'][$j]['dateCompleted'] = self::GetAchievementDate($parentId);
                            $cPoints = $return_data['completed'][$this->achId]['achievement_tree'][$j]['points'];
                            $fullPoints = $fullPoints+$cPoints;
                            $return_data['completed'][$this->achId]['data']['points'] = $return_data['completed'][$this->achId]['achievement_tree'][$j]['points']+$fullPoints;
                            $parentId = $this->aDB->selectCell("SELECT `parentAchievement` FROM `ARMORYDBPREFIX_achievement` WHERE `id`=%d", $parentId);
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
    
    /**
     * Builds criterias table for current (this->achId) achievement
     * @category Achievements class
     * @access   private
     * @return   array
     **/
    private function BuildAchievementCriteriaTable() {
        if($this->GetLocale() == 'es_es' || $this->GetLocale() == 'es_mx') {
            $locale = 'en_gb';
        }
        else {
            $locale = $this->GetLocale();
        }
        if(!$this->guid || !$this->achId) {
            $this->Log()->writeError('%s : player guid or achievement id not defiend (guid: %s, achId: %d)', __METHOD__, $this->guid, $this->achId);
            return false;
        }
        $data = $this->aDB->select("SELECT * FROM `ARMORYDBPREFIX_achievement_criteria` WHERE `referredAchievement`=%d ORDER BY `showOrder`", $this->achId);
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
            $m_data = self::GetCriteriaData($criteria['id']);
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
                    $money = Mangos::GetMoney($m_data['counter']);
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
    
    /**
     * Returns criteria ($criteria_id) data
     * @category Achievements class
     * @access   private
     * @param    int $criteria_id
     * @return   array
     **/
    private function GetCriteriaData($criteria_id) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        return $this->db->selectRow("SELECT * FROM `character_achievement_progress` WHERE `guid`=%d AND `criteria`=%d", $this->guid, $criteria_id);
    }
    
    /**
     * Generates statistics page
     * @category Achievements class
     * @access   public
     * @param    int $page_id
     * @param    int $faction
     * @return   array
     **/
    public function LoadStatisticsPage($page_id, $faction) {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $achievements_data = $this->aDB->select(
        "SELECT `id`, `name_%s` AS `name`, `description_%s` AS `desc`, `categoryId`
            FROM `ARMORYDBPREFIX_achievement`
                WHERE `categoryId`=%d AND `factionFlag` IN (%d, -1)", $this->GetLocale(), $this->GetLocale(), $page_id, $faction);
        if(!$achievements_data) {
            $this->Log()->writeError('%s : unable to get data for page_id %d, faction %d (current locale: %s, locId: %d)', __METHOD__, $page_id, $faction, $this->GetLocale(), $this->GetLoc());
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
    
    /**
     * Returns criteria value for current achievement (this->achId)
     * @category Achievements class
     * @access   private
     * @return   int
     **/
    private function GetCriteriaValue() {
        if(!$this->guid || !$this->achId) {
            $this->Log()->writeError('%s : player guid or achievement id not defined', __METHOD__);
            return false;
        }
        $criteria_ids = $this->aDB->select("SELECT `id` FROM `ARMORYDBPREFIX_achievement_criteria` WHERE `referredAchievement`=%d", $this->achId);
        if(!$criteria_ids) {
            return false;
        }
        $tmp_criteria_value = 0;
        foreach($criteria_ids as $criteria) {
            $tmp_criteria_value = $this->db->selectCell("SELECT `counter` FROM `character_achievement_progress` WHERE `guid`=%d AND `criteria`=%d LIMIT 1", $this->guid, $criteria['id']);
            if(!$tmp_criteria_value) {
                continue;
            }
            else {
                return $tmp_criteria_value;
            }
        }
        if(!$tmp_criteria_value) {
            return 0;
        }
        return $tmp_criteria_value;
    }
    
    /**
     * Generates Feats of Strength list for achievements comparison.
     * @category Achievements class
     * @access   public
     * @param    array $pages
     * @return   array
     **/
    public function BuildFoSListForComparison($pages) {
        if(!is_array($pages)) {
            return false;
        }
        foreach($pages as $char) {
            foreach($char['completed'] as $achList) {
                if(!isset($pages[0]['completed'][$achList['data']['id']])) {
                    $pages[0]['completed'][$achList['data']['id']] = $achList;
                    $pages[0]['completed'][$achList['data']['id']]['data']['dateCompleted'] = null;
                }
            }
        }
        return $pages;
    }
}
?>