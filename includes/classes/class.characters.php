<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 484
 * @copyright (c) 2009-2011 Shadez
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

Class Characters {
    
    /**
     * Player guid
     * @category Characters class
     * @access   private
     **/
    private $guid = false;
    
    /**
     * Player name
     * @category Characters class
     * @access   private
     **/
    private $name = false;
    
    /**
     * Player race id
     * @category Characters class
     * @access   private
     **/
    private $race = false;
    
    /**
     * Player class id
     * @category Characters class
     * @access   private
     **/
    private $class = false;
    
    /**
     * Player gender
     * (0 - male, 1 - female)
     * @category Characters class
     * @access   private
     **/
    private $gender = false;
    
    /**
     * Player level
     * @category Characters class
     * @access   private
     **/
    private $level = false;
    
    /**
     * Player money amount
     **/
    private $money;
    
    /**
     * Player model display info
     * @category Characters class
     * @access   private
     **/
    private $playerBytes = false;
    private $playerBytes2 = false;
    private $playerFlags = false;
    
    /**
     * Player title ID
     * @category Characters class
     * @access   private
     **/
    private $chosenTitle = false;
    
    /**
     * Player health value
     * @category Characters class
     * @access   private
     **/
    private $health = false;
    
    /**
     * Player powers values
     * @category Characters class
     * @access   private
     **/
    private $power1 = false;
    private $power2 = false;
    private $power3 = false;
    
    /**
     * Account ID
     * (currently not used)
     * @category Characters class
     * @access   private
     **/
    private $account = false;
    
    /**
     * Talent specs count
     * @category Characters class
     * @access   private
     **/
    private $specCount = false;
    
    /**
     * Active talent spec ID
     * (0 or 1)
     * @category Characters class
     * @access   private
     **/
    private $activeSpec = false;

    /**
     * Player faction
     * (1 - Horde, 0 - Alliance)
     * @category Characters class
     * @access   private
     **/
    private $faction = false;
    
    /**
     * Array with player stats constants
     * (depends on character level)
     * @category Characters class
     * @access   private
     **/
    private $rating = false;
     
    /**
     * Player title data
     * (prefix, suffix, titleId)
     * @category Characters class
     * @access   private
     **/
    private $character_title = array('prefix' => null, 'suffix' => null, 'titleId' => null);
    
    /**
     * Player guild ID
     * @category Characters class
     * @access   private
     **/
    private $guild_id = false;
    
    /**
     * Player guild name
     * @category Characters class
     * @access   private
     **/
    private $guild_name = false;
    
    /**
     * Player guild rank ID
     * @category Characters class
     * @access   private
     **/
    private $guild_rank_id = false;
    
    /**
     * Player guild rank name
     * @category Characters class
     * @access   private
     **/
    private $guild_rank_name = false;
    
    /**
     * $this->class text
     * @category Characters class
     * @access   private
     **/
    private $classText = false;
    
    /**
     * $this->race text
     * @category Characters class
     * @access   private
     **/
    private $raceText = false;
    
    /**
     * Equipped item IDs
     * @category Characters class
     * @access   private
     **/
    private $equipmentCache = false;
    
    /**
     * Database handler
     * @category Characters class
     * @access   private
     **/
    private $db = null;
    
    /**
     * Character realm name
     * @category Characters class
     * @access   private
     **/
    private $realmName = false;
    
    /**
     * Character realm ID
     * @category Characters class
     * @access   private
     **/
    private $realmID = false;
    
    /**
     * Achievement MGR
     * @category Characters class
     * @access   private
     **/
    private $m_achievementMgr = null;
    
    /**
     * Equipped items storage
     * @category Characters class
     * @access   private
     **/
    private $m_items;
    
    /**
     * Server type (SERVER_MANGOS or SERVER_TRINITY)
     * @category Characters class
     * @access   private
     **/
    private $m_server = null;
    
    /**
     * Character feed data
     **/
    private $feed_data = array();
    
    /**
     * Character data
     **/
    private $char_data = array();
    
    /**
     * 
     **/
    private $load_options = array();
    
    public function Characters() {
        // Reset load options
        $this->load_options = array(
            'load_achievements' => true,    // Achievement Manager
            'load_inventory'    => false,   // Inventory
            'load_feeds'        => false,   // Character Feed
            'load_data'         => false,   // Data field
            'load_info'         => true     // Class, race info
        );
        return true;
    }
    
    public function SetOptions($options) {
        if(!is_array($options)) {
            switch($options) {
                case LOAD_ALL:
                default:
                    foreach($this->load_options as $opt_key => $opt_value) {
                        $this->load_options[$opt_key] = true;
                    }
                    return true;
                    break;
                case LOAD_NOTHING:
                    foreach($this->load_options as $opt_key => $opt_value) {
                        $this->load_options[$opt_key] = false;
                    }
                    return true;
                    break;
            }
        }
        foreach($options as $op_key => $op_value) {
            if(isset($this->load_options[$op_key])) {
                $this->load_options[$op_key] = $op_value;
            }
        }
        return true;
    }
    
    private function IsCharacterFitsRequirements(&$player_data) {
        $gmLevel = 0;
        // Disable next SQL error
        Armory::$rDB->SkipNextError();
        if($this->m_server == SERVER_TRINITY) {
            $gmLevel = Armory::$rDB->selectCell("SELECT `gmlevel` FROM `account_access` WHERE `id`=%d AND `RealmID` IN (-1, %d)", $player_data['account'], Armory::$connectionData['id']);
        }
        elseif($this->m_server == SERVER_MANGOS) {
            $gmLevel = Armory::$rDB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id`=%d LIMIT 1", $player_data['account']);
        }
        $allowed = ($gmLevel <= Armory::$armoryconfig['minGmLevelToShow']) ? true : false;
        if(!$allowed) {
            Armory::Log()->writeLog('%s : unable to display character %s (GUID: %d): GM level restriction!', __METHOD__, $player_data['name'], $player_data['guid']);
            return false;
        }
        if($player_data['level'] < Armory::$armoryconfig['minlevel']) {
            Armory::Log()->writeLog('%s : unable to load character %s (GUID: %d): level restriction.', __METHOD__, $player_data['name'], $player_data['guid']);
            return false;
        }
        if(Armory::$armoryconfig['skipBanned'] && Armory::$rDB->selectCell("SELECT 1 FROM `account_banned` WHERE `id` = %d AND `active` = 1", $player_data['account'])) {
            Armory::Log()->writeLog('%s : unable to load character %s (GUID: %d) from banned account %d.', __METHOD__, $player_data['name'], $player_data['guid'], $player_data['account']);
            return false;
        }
        // Class/race/faction checks
        if($player_data['class'] >= MAX_CLASSES) {
            // Unknown class
            Armory::Log()->writeError('%s : character %s (GUID: %d) has wrong data in DB: classID %d was not found. Unable to continue.', __METHOD__, $player_data['name'], $player_data['guid'], $player_data['class']);
            return false;
        }
        elseif($player_data['race'] >= MAX_RACES) {
            // Unknown race
            Armory::Log()->writeError('%s : character %s (GUID: %d) has wrong data in DB: raceID %d was not found. Unable to continue.', __METHOD__, $player_data['name'], $player_data['guid'], $player_data['race']);
            return false;
        }
        $this->faction = Utils::GetFactionId($player_data['race']);
        if($this->faction === false) {
            // Unknown faction
            Armory::Log()->writeError('%s : character %s (GUID: %d) has wrong data in DB: factionID %d was not found (raceID: %d).', __METHOD__, $player_data['name'], $player_data['guid'], $this->faction, $player_data['race']);
            return false;
        }
        return true;
    }
    
    /**
     * Init character, load data from DB, checks for requirements, etc.
     * @category Characters class
     * @access   public
     * @param    string $name
     * @param    int $realmId = 1
     * @param    bool $full = true
     * @param    bool $initialBuild = false
     * @param    int  $loadType
     * @return   bool
     **/
    public function BuildCharacter($name, $realmId = 1, $full = true, $initialBuild = false, $loadType = 0) {
        if(!is_string($name)) {
            Armory::Log()->writeLog('%s : name must be a string!', __METHOD__);
            return false;
        }
        if($realmId == false) {
            Armory::Log()->writeLog('%s : realmId not provided!', __METHOD__);
            return false;
        }
        if(!isset(Armory::$realmData[$realmId])) {
            Armory::Log()->writeError('%s : unable to find data for realmId %d', __METHOD__, $realmId);
            return false;
        }
        $realm_info = Armory::$realmData[$realmId];
        $this->db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters']);
        if(!$this->db || !$this->db->TestLink()) {
            Armory::Log()->writeError('%s : unable to connect to MySQL server (error: %s; realmId: %d). Check your configs.', __METHOD__, mysql_error(), $realmId);
            return false;
        }
        // Set server type (SERVER_MANGOS or SERVER_TRINITY)
        $this->m_server = $realm_info['type'];
        if($this->m_server == UNK_SERVER) {
            Armory::Log()->writeError('%s : unknown server type! Unable to initialize characters class (character name: %s, realmId: %d)', __METHOD__, $name, $realmId);
            return false;
        }
        $name = ucfirst($name); // Because BINARY is used in SQL query.
        if($full == true) {
            $player_data = $this->db->selectRow("
            SELECT
            `characters`.`guid`,
            `characters`.`account`,
            `characters`.`name`,
            `characters`.`race`,
            `characters`.`class`,
            `characters`.`gender`,
            `characters`.`level`,
            `characters`.`money`,
            `characters`.`playerBytes`,
            `characters`.`playerBytes2`,
            `characters`.`playerFlags`,
            `characters`.`specCount`,
            `characters`.`activeSpec`,
            `characters`.`chosenTitle`,
            `characters`.`health`,
            `characters`.`power1`,
            `characters`.`power2`,
            `characters`.`power3`,
            `characters`.`equipmentCache`,
            `guild_member`.`guildid` AS `guild_id`,
            `guild`.`name` AS `guild_name`
            FROM `characters` AS `characters`
            LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
            LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildid`
            WHERE BINARY `characters`.`name`='%s' LIMIT 1", $name);
        }
        else {
            $player_data = $this->db->selectRow("
            SELECT
            `characters`.`guid`,
            `characters`.`account`,
            `characters`.`name`,
            `characters`.`race`,
            `characters`.`class`,
            `characters`.`gender`,
            `characters`.`level`,
            `characters`.`equipmentCache`,
            `guild_member`.`guildid` AS `guild_id`,
            `guild`.`name` AS `guild_name`
            FROM `characters` AS `characters`
            LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
            LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildid`
            WHERE BINARY `characters`.`name`='%s' LIMIT 1", $name);
        }
        if($player_data == false || !is_array($player_data)) {
            Armory::Log()->writeError('%s: unable to get data from characters DB for player %s (realmId: %d, expected realmName: %s, currentRealmName: %s)', __METHOD__, $name, $realmId, (isset($_GET['r'])) ? $_GET['r'] : 'none', $realm_info['name']);
            return false;
        }
        if($this->load_options['load_data'] == true) {
            // Character data required for character-sheet.xml page only.
            $this->char_data = $this->db->selectCell("SELECT `data` FROM `armory_character_stats` WHERE `guid` = %d LIMIT 1", $player_data['guid']);
            if(!$this->char_data) {
                Armory::Log()->writeError('%s : player %d (%s) has no data in `armory_character_stats` table (SQL update to Characters DB was not applied? / Character was not saved in game? / Server core was not patched?)', __METHOD__, $player_data['guid'], $player_data['name']);
                unset($player_data);
                return false;
            }
            $this->HandleCharacterData();
        }
        // Can we display this character?
        if(!$this->IsCharacterFitsRequirements($player_data)) {
            return false;
            // Debug message will be added from Characters::IsCharacterFitsRequirements()
        }
        foreach($player_data as $pData_key => $pData_value) {
            if(is_string($pData_key)) {
                $this->{$pData_key} = $pData_value;
            }
        }
        $this->HandleEquipmentCacheData();
        if($this->load_options['load_info'] == true) {
            // Get race and class strings
            $race_class = Armory::$aDB->selectRow("
            SELECT
            `ARMORYDBPREFIX_races`.`name_%s` AS `race`,
            `ARMORYDBPREFIX_classes`.`name_%s` AS `class`
            FROM `ARMORYDBPREFIX_races` AS `ARMORYDBPREFIX_races`
            LEFT JOIN `ARMORYDBPREFIX_classes` AS `ARMORYDBPREFIX_classes` ON `ARMORYDBPREFIX_classes`.`id`=%d
            WHERE `ARMORYDBPREFIX_races`.`id`=%d", Armory::GetLocale(), Armory::GetLocale(), $player_data['class'], $player_data['race']);
            if(!$race_class) {
                Armory::Log()->writeError('%s : unable to find class/race text strings for player %d (name: %s, raceID: %d, classID: %d)', __METHOD__, $player_data['guid'], $player_data['name'], $player_data['race'], $player_data['class']);
                unset($player_data);
                return false;
            }
            $this->classText = $race_class['class'];
            $this->raceText = $race_class['race'];
            // Get title info
            if($this->chosenTitle > 0) {
                $this->HandleChosenTitleInfo();
            }
        }
        if($this->load_options['load_inventory'] == true) {
            // Load items
            $this->LoadInventory();
        }
        $this->realmName = $realm_info['name'];
        $this->realmID   = $realm_info['id'];
        if($this->load_options['load_achievements']) {
            // Initialize achievement manager
            $this->m_achievementMgr = new Achievements;
            $this->m_achievementMgr->InitAchievements($this->guid, $this->db, true);
        }
        if($this->load_options['load_feeds']) {
            // Load Feed data
            $this->LoadFeedData();
        }
        // Everything correct
        if($initialBuild == true) {
            Armory::Log()->writeLog('%s : all correct, player %s (GUID: %d, raceID: %d, classID: %d, level: %d) loaded, class has been initialized.', __METHOD__, $name, $this->guid, $this->race, $this->class, $this->level);
            if($this->GetLevel() > GT_MAX_LEVEL) {
                Armory::Log()->writeLog('%s : WARNING: %s\'s (GUID: %d) level is more than GT_MAX_LEVEL (%d) - %d. This may cause some errors at data generation.', __METHOD__, $this->GetName(), $this->GetGUID(), GT_MAX_LEVEL, $this->GetLevel());
            }
        }
        unset($realm_info);
        return true;
    }
    
    /**
     * Converts $this->equipmentCache from string to array
     * @category Characters class
     * @access   private
     * @return   bool
     **/
    private function HandleEquipmentCacheData() {
        if(!$this->equipmentCache) {
            Armory::Log()->writeError('%s : %s::$equipmentCache has NULL value, unable to generate array. Character items would not be shown.', __METHOD__, __METHOD__);
            return false;
        }
        $itemscache = explode(' ', $this->equipmentCache);
        if(!$itemscache) {
            Armory::Log()->writeError('%s : unable to convert %s::$equipmentCache from string to array (function.explode). Character items would not be shown.', __METHOD__, __METHOD__);
            return false;
        }
        $this->equipmentCache = $itemscache;
        $cacheCount = count($this->equipmentCache);
        if($cacheCount < 37) {
            for($i = $cacheCount; $i < 38; $i++) {
                $this->equipmentCache[$i] = null;
            }
        }
        return true;
    }
    
    /**
     * Constructs character title info
     * @category Characters class
     * @access   private
     * @return   bool
     **/
    private function HandleChosenTitleInfo() {
        $title_data = Armory::$aDB->selectRow("SELECT `title_F_%s` AS `titleF`, `title_M_%s` AS `titleM`, `place` FROM `ARMORYDBPREFIX_titles` WHERE `id`=%d", Armory::GetLocale(), Armory::GetLocale(), $this->chosenTitle);
        if(!$title_data) {
            Armory::Log()->writeError('%s: player %d (%s) has wrong chosenTitle id (%d) or there is no data for %s locale (locId: %d)', __METHOD__, $this->guid, $this->name, $this->chosenTitle, Armory::GetLocale(), Armory::GetLoc());
            return false;
        }
        switch($this->gender) {
            case 0:
                if($title_data['place'] == 'prefix') {
                    $this->character_title['prefix'] = $title_data['titleM'];
                }
                elseif($title_data['place'] == 'suffix') {
                    $this->character_title['suffix'] = $title_data['titleM'];
                }
                break;
            case 1:
                if($title_data['place'] == 'prefix') {
                    $this->character_title['prefix'] = $title_data['titleF'];
                }
                elseif($title_data['place'] == 'suffix') {
                    $this->character_title['suffix'] = $title_data['titleF'];
                }
                break;
        }
        $this->character_title['titleId'] = $this->chosenTitle;
        return true;
    }
    
    private function HandleCharacterData() {
        if(!$this->char_data) {
            return false;
        }
        if(is_array($this->char_data)) {
            // Already converted.
            return true;
        }
        $this->char_data = explode(' ', $this->char_data);
        if(!is_array($this->char_data) || !isset($this->char_data[1])) {
            Armory::Log()->writeError('%s : unable to convert $this->char_data from string to array!', __METHOD__);
        }
        return true;
    }
    
    /**
     * Checks current player (loaded or not).
     * @category Characters class
     * @access   public
     * @return   bool
     **/
    public function CheckPlayer() {
        if(!$this->guid || !$this->name) {
            return false;
        }
        return true;
    }
    
    /**
     * Returns player GUID
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetGUID() {
        return $this->guid;
    }
    
    /**
     * Returns player name
     * @category Characters class
     * @access   public
     * @return   string
     **/
    public function GetName() {
        return $this->name;
    }
    
    /**
     * Returns player class
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetClass() {
        return $this->class;
    }
    
    /**
     * Returns player race
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetRace() {
        return $this->race;
    }
    
    /**
     * Returns player level
     * @category Characters class
     * @access   public
     * @return   int
     **/    
    public function GetLevel() {
        return $this->level;
    }
    
    /**
     * Returns player gender
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetGender() {
        return $this->gender;
    }
    
    /**
     * Returns player faction
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetFaction() {
        return $this->faction;
    }
    
    /**
     * Returns player account ID
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetAccountID() {
        return $this->account;
    }
    
    /**
     * Returns active talent spec ID
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetActiveSpec() {
        return $this->activeSpec;
    }
    
    /**
     * Returns talent specs count
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetSpecCount() {
        return $this->specCount;
    }
    
    /**
     * Returns array with player model info
     * @category Characters class
     * @access   public
     * @return   array
     **/
    public function GetPlayerBytes() {
        return array('playerBytes' => $this->playerBytes, 'playerBytes2' => $this->playerBytes2, 'playerFlags' => $this->playerFlags);
    }
    
    /**
     * Returns player guild name
     * @category Characters class
     * @access   public
     * @return   string
     **/
    public function GetGuildName() {
        return $this->guild_name;
    }
    
    /**
     * Returns player guild ID
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetGuildID() {
        return $this->guild_id;
    }
    
    /**
     * Returns array with chosen title info
     * @category Characters class
     * @access   public
     * @return   array
     **/
    public function GetChosenTitleInfo() {
        return $this->character_title;
    }
    
    /**
     * Returns text string for $this->class ID
     * @category Characters class
     * @access   public
     * @return   string
     **/
    public function GetClassText() {
        return $this->classText;
    }
    
    /**
     * Returns text string for $this->race ID
     * @category Characters class
     * @access   public
     * @return   string
     **/
    public function GetRaceText() {
        return $this->raceText;
    }
    
    /**
     * Returns character URL string (r=realmName&cn=CharName&gn=GuildName)
     * @category Characters class
     * @access   public
     * @return   string
     **/
    public function GetUrlString() {
        $url = sprintf('r=%s&cn=%s', urlencode($this->realmName), urlencode($this->name));
        if($this->guild_id > 0) {
            $url .= sprintf('&gn=%s', urlencode($this->guild_name));
        }
        return $url;
    }
    
    /**
     * Returns character realm name
     * @category Characters class
     * @access   public
     * @return   string
     **/
    public function GetRealmName() {
        return $this->realmName;
    }
    
    /**
     * Returns character realm ID
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetRealmID() {
        return $this->realmID;
    }
    
    /**
     * Returns server type
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetServerType() {
        return $this->m_server;
    }
    
    /**
     * Returns money amount
     * @category Characters class
     * @access   public
     * @return   int
     **/
    public function GetMoney() {
        return $this->money;
    }
    
    public function GetAchievementMgr() {
        if(!is_object($this->m_achievementMgr)) {
            $this->m_achievementMgr = new Achievements();
            $this->m_achievementMgr->InitAchievements($this->GetGUID(), $this->db, true);
        }
        return $this->m_achievementMgr;
    }
    
    /**
     * Generates character header (for XML output)
     * @category Characters class
     * @access   public
     * @return   array 
     **/
    public function GetHeader() {
        $header = array(
            'battleGroup'  => Armory::$armoryconfig['defaultBGName'],
            'charUrl'      => $this->GetUrlString(),
            'class'        => $this->classText,
            'classId'      => $this->class,
            'classUrl'     => sprintf("c=%s", urlencode($this->classText)),
            'faction'      => null,
            'factionId'    => $this->faction,
            'gender'       => null,
            'genderId'     => $this->gender,
            'guildName'    => ($this->guild_id > 0) ? $this->guild_name : null,
            'guildUrl'     => ($this->guild_id > 0) ? sprintf('r=%s&gn=%s', urlencode($this->GetRealmName()), urlencode($this->guild_name)) : null,
            'lastModified' => null,
            'level'        => $this->level,
            'name'         => $this->name,
            'points'       => $this->GetAchievementMgr()->GetAchievementPoints(),
            'prefix'       => $this->character_title['prefix'],
            'race'         => $this->raceText,
            'raceId'       => $this->race,
            'realm'        => $this->GetRealmName(),
            'suffix'       => $this->character_title['suffix'],
            'titleId'      => $this->character_title['titleId'],
        );
        if(Utils::IsWriteRaw()) {
            $header['guildUrl'] = ($this->guild_id > 0) ? sprintf('r=%s&amp;gn=%s', urlencode($this->GetRealmName()), urlencode($this->guild_name)) : null;
        }
        return $header;
    }
    
    /**
     * Returns array with additional energy bar data (mana for paladins, mages, warlocks & hunters, etc.)
     * @category Characters class
     * @access   public
     * @return   array
     **/
    public function GetSecondBar() {
        if(!$this->class) {
            return false;
        }        
        $mana   = 'm';
        $rage   = 'r';
        $energy = 'e';
        $runic  = 'p';
        
        $switch = array(
            '1' => $rage,
            '2' => $mana,
            '3' => $mana,
            '4' => $energy,
            '5' => $mana,
            '6' => $runic,
            '7' => $mana,
            '8' => $mana,
            '9' => $mana,
            '11'=> $mana
        );
        switch($this->class) {
            case 2:
            case 3:
            case 5:
            case 7:
            case 8:
            case 9:
            case 11:
                $data['casting']    = 0;
                $data['notCasting'] = '22';
                $data['effective']  = $this->GetMaxMana();
                $data['type']       = $switch[$this->class];
                break;
            case 1:
                $data['casting']    = '-1';
                $data['effective']  = $this->GetMaxRage();
                $data['notCasting'] = '-1';
                $data['perFive']    = '-1';
                $data['type']       = $switch[$this->class];
                break;
            case 4:
                $data['casting']   = '-1';
                $data['effective'] = $this->GetMaxEnergy();
                $data['type']      = $switch[$this->class];
                break;
            case 6:
                $data['casting']   = '-1';
                $data['effective'] = $this->GetMaxEnergy();
                $data['type']      = $switch[$this->class];
                break;
        }
        return $data;
    }
    
    /**
     * Returns item ID from $slot (head, neck, shoulder, etc.). Requires $this->guid!
     * @category Character class
     * @param    string $slot
     * @return   int
     **/
    public function GetCharacterEquip($slot) {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not defined', __METHOD__);
            return 0;
        }
        if(!is_array($this->equipmentCache)) {
            Armory::Log()->writeError('%s : equipmentCache must have array type!', __METHOD__);
            return 0;
        }
        switch($slot) {
            case 'head':
                return $this->equipmentCache[0];
                break;
            case 'neck':
				return $this->equipmentCache[2];
				break;
			case 'shoulder':
				return $this->equipmentCache[4];
				break;
			case 'shirt':
				return $this->equipmentCache[6];
				break;
			case 'chest':
				return $this->equipmentCache[8];
				break;
			case 'wrist':
				return $this->equipmentCache[16];
				break;
			case 'legs':
				return $this->equipmentCache[12];
				break;
			case 'boots':
				return $this->equipmentCache[14];
				break;
			case 'belt':
				return $this->equipmentCache[10];
				break;
			case 'gloves':
				return $this->equipmentCache[18];
				break;
			case 'ring1':
				return $this->equipmentCache[20];
				break;
			case 'ring2':
				return $this->equipmentCache[22];
				break;
			case 'trinket1':
				return $this->equipmentCache[24];
				break;
            case 'trinket2':
				return $this->equipmentCache[26];
				break;
			case 'back':
				return $this->equipmentCache[28];
				break;
			case 'mainhand':
				return $this->equipmentCache[30];
				break;
			case 'offhand':
				return $this->equipmentCache[32];
			    break;
			case 'relic':
				return $this->equipmentCache[34];
				break;
			case 'tabard':
				return $this->equipmentCache[36];
				break;
			default:
                Armory::Log()->writeError('%s : wrong item slot: %s', __METHOD__, $slot);
				return 0;
				break;
        }
    }
    
    /**
     * Returns enchantment id of item contained in $slot slot. If $guid not provided, function will use $this->guid.
     * @category Character class
     * @access   public
     * @param    string $slot
     * @return   int
     **/
    public function GetCharacterEnchant($slot) {
        if(!is_array($this->equipmentCache)) {
            Armory::Log()->writeError('%s : equipmentCache must have array type!', __METHOD__);
            return 0;
        }
        switch($slot) {
            case 'head':
                return $this->equipmentCache[1];
                break;
            case 'neck':
                return $this->equipmentCache[3];
                break;
            case 'shoulder':
                return $this->equipmentCache[5];
                break;
            case 'shirt':
                return $this->equipmentCache[7];
                break;
            case 'chest':
                return $this->equipmentCache[9];
                break;
            case 'wrist':
                return $this->equipmentCache[17];
                break;
            case 'legs':
                return $this->equipmentCache[13];
                break;
            case 'boots':
                return $this->equipmentCache[15];
                break;
            case 'belt':
                return $this->equipmentCache[11];
                break;
            case 'gloves':
                return $this->equipmentCache[19];
                break;
            case 'ring1':
                return $this->equipmentCache[21];
                break;
            case 'ring2':
                return $this->equipmentCache[23];
                break;
            case 'trinket1':
                return $this->equipmentCache[25];
                break;
            case 'trinket2':
                return $this->equipmentCache[27];
                break;
            case 'back':
                return $this->equipmentCache[29];
                break;
            case 'mainhand':
            case 'stave':
                return $this->equipmentCache[31];
                break;
            case 'offhand':
                return $this->equipmentCache[33];
                break;
            case 'relic':
            case 'sigil':
            case 'gun':
                return $this->equipmentCache[35];
                break;
            case 'tabard':
                return $this->equipmentCache[37];
                break;
            default:
                Armory::Log()->writeLog('%s : wrong item slot: %s', __METHOD__, $slot);
                return 0;
                break;
        }
    }
    
    /**
     * Returns array with TalentTab IDs for current classID ($this->class)
     * @category Characters class
     * @access   public
     * @param    int $tab_count = -1
     * @return   array
     **/
    public function GetTalentTab($tab_count = -1) {
        if(!$this->class) {
            Armory::Log()->writeError('%s : player class not defined', __METHOD__);
            return false;
        }
        $talentTabId = array(
            1  => array(161, 164, 163), // Warior
            2  => array(382, 383, 381), // Paladin
            3  => array(361, 363, 362), // Hunter
            4  => array(182, 181, 183), // Rogue
            5  => array(201, 202, 203), // Priest
            6  => array(398, 399, 400), // Death Knight
            7  => array(261, 263, 262), // Shaman
            8  => array( 81,  41,  61), // Mage
            9  => array(302, 303, 301), // Warlock
            11 => array(283, 281, 282), // Druid
        );
        if(!isset($talentTabId[$this->class])) {
            return false;
        }
        $tab_class = $talentTabId[$this->class];
        if($tab_count >= 0) {
            $values = array_values($tab_class);
            return $values[$tab_count];
        }
        return $tab_class;
    }
    
    /**
     * Calculates and returns array with character talent specs. !Required $this->guid and $this->class!
     * Depends on $this->m_server value (SERVER_MANGOS or SERVER_TRINITY)
     * @category Character class
     * @access   public
     * @return   array
     **/
    public function CalculateCharacterTalents() {
        if(!$this->class || !$this->guid) {
            Armory::Log()->writeError('%s : player class or guid not defined', __METHOD__);
            return false;
        }
        $talentTree = array();
        $tab_class = self::GetTalentTab();
        if(!is_array($tab_class)) {
            Armory::Log()->writeError('%s : unable to find tab_class for class %d (player: %s (GUID: %d))', __METHOD__, $this->GetClass(), $this->GetName(), $this->GetGUID());
            return false;
        }
        $character_talents = $this->db->select("SELECT * FROM `character_talent` WHERE `guid`=%d", $this->guid);
        if(!$character_talents) {
            Armory::Log()->writeError('%s : unable to get data from DB for player %d (%s)', __METHOD__, $this->guid, $this->name);
            return false;
        }
        $class_talents = Armory::$aDB->select("SELECT * FROM `ARMORYDBPREFIX_talents` WHERE `TalentTab` IN (%s) ORDER BY `TalentTab`, `Row`, `Col`", $tab_class);
        if(!$class_talents) {
            Armory::Log()->writeError('%s : unable to find talents for class %d (tabs are: %d, %d, %d)', __METHOD__, $this->GetClass(), $tab_class[0], $tab_class[1], $tab_class[2]);
            return false;
        }
        $talent_build = array();
        $talent_build[0] = null;
        $talent_build[1] = null;
        $talent_points = array();
        foreach($tab_class as $tab_val) {
            $talent_points[0][$tab_val] = 0;
            $talent_points[1][$tab_val] = 0;
        }
        $num_tabs = array();
        $i = 0;
        foreach($tab_class as $tab_key => $tab_value) {
            $num_tabs[$tab_key] = $i;
            $i++;
        }
        foreach($class_talents as $class_talent) {
            $current_found = false;
            $last_spec = 0;
            foreach($character_talents as $char_talent) {
                switch($this->m_server) {
                    case SERVER_MANGOS:
                        if($char_talent['talent_id'] == $class_talent['TalentID']) {
                            $talent_ranks = $char_talent['current_rank']+1;
                            $talent_build[$char_talent['spec']] .= $talent_ranks; // not 0-4, is 1-5
                            $current_found = true;
                            $talent_points[$char_talent['spec']][$class_talent['TalentTab']] += $talent_ranks;
                        }
                        $last_spec = $char_talent['spec'];
                        break;
                    case SERVER_TRINITY:
                        for($k = 1; $k < 6; $k++) {
                            if($char_talent['spell'] == $class_talent['Rank_' . $k]) {
                                $talent_build[$char_talent['spec']] .= $k;
                                $current_found = true;
                                $talent_points[$char_talent['spec']][$class_talent['TalentTab']] += $k;
                            }
                        }
                        $last_spec = $char_talent['spec'];
                        break;
                    default:
                        Armory::Log()->writeError('%s : unknown server type');
                        return false;
                        break;
                }
            }
            if(!$current_found) {
                $talent_build[$last_spec] .= 0;
            }
        }
        $talent_data = array('points' => $talent_points);
        return $talent_data;
    }
    
    /**
     * Returns character talent build for all specs (2 if character has dual talent specialization)
     * @category Character class
     * @access   public
     * @return   array
     **/
    public function CalculateCharacterTalentBuild() {
        if(!$this->guid || !$this->class) {
            Armory::Log()->writeError('%s : player class or guid not defined', __METHOD__);
            return false;
        }
        $build_tree = array(1 => null, 2 => null);
        $tab_class = self::GetTalentTab();
        $specs_talents = array();
        $character_talents = $this->db->select("SELECT * FROM `character_talent` WHERE `guid`=%d", $this->guid);
        $talent_data = array(0 => null, 1 => null); // Talent build
        if(!$character_talents) {
            Armory::Log()->writeError('%s : unable to get data from DB for player %d (%s)', __METHOD__, $this->guid, $this->name);
            return false;
        }
        foreach($character_talents as $_tal) {
            if($this->m_server == SERVER_MANGOS) {
                $specs_talents[$_tal['spec']][$_tal['talent_id']] = $_tal['current_rank']+1;
            }
            elseif($this->m_server == SERVER_TRINITY) {
                $specs_talents[$_tal['spec']][$_tal['spell']] = true;
            }
        }
        if($this->m_server == SERVER_TRINITY) {
            for($i = 0; $i < 3; $i++) {
                $current_tab = Armory::$aDB->select("SELECT * FROM `ARMORYDBPREFIX_talents` WHERE `TalentTab`=%d ORDER BY `TalentTab`, `Row`, `Col`", $tab_class[$i]);
                if(!$current_tab) {
                    continue;
                }
                foreach($current_tab as $tab) {
                    for($j = 0; $j < 2; $j++) {
                        if(isset($specs_talents[$j][$tab['Rank_5']])) {
                            $talent_data[$j] .= 5;
                        }
                        elseif(isset($specs_talents[$j][$tab['Rank_4']])) {
                            $talent_data[$j] .= 4;
                        }
                        elseif(isset($specs_talents[$j][$tab['Rank_3']])) {
                            $talent_data[$j] .= 3;
                        }
                        elseif(isset($specs_talents[$j][$tab['Rank_2']])) {
                            $talent_data[$j] .= 2;
                        }
                        elseif(isset($specs_talents[$j][$tab['Rank_1']])) {
                            $talent_data[$j] .= 1;
                        }
                        else {
                            $talent_data[$j] .= 0;
                        }
                    }
                }
            }
        }
        elseif($this->m_server == SERVER_MANGOS) {
            for($i = 0; $i < 3; $i++) {
                if(!isset($tab_class[$i])) {
                    continue;
                }
                $current_tab = Armory::$aDB->select("SELECT `TalentID`, `TalentTab`, `Row`, `Col` FROM `ARMORYDBPREFIX_talents` WHERE `TalentTab`=%d ORDER BY `TalentTab`, `Row`, `Col`", $tab_class[$i]);
                if(!$current_tab) {
                    continue;
                }
                foreach($current_tab as $tab) {
                    for($j = 0; $j < 2; $j++) {
                        if(isset($specs_talents[$j][$tab['TalentID']])) {
                            $talent_data[$j] .= $specs_talents[$j][$tab['TalentID']];
                        }
                        else {
                            $talent_data[$j] .= 0;
                        }
                    }
                }
            }
        }
        return $talent_data;
    }
    
    /**
     * Returns array with glyph data for all specs
     * @category Character class
     * @access   public
     * @param    int $spec = -1
     * @return   array
     **/
    public function GetCharacterGlyphs($spec = -1) {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        switch($this->m_server) {
            case SERVER_MANGOS:
                if($spec >= 0) {
                    $glyphs_data = $this->db->select("SELECT * FROM `character_glyphs` WHERE `guid`=%d AND `spec`=%d ORDER BY `slot`", $this->guid, $spec);
                }
                else {
                    $glyphs_data = $this->db->select("SELECT * FROM `character_glyphs` WHERE `guid`=%d ORDER BY `spec`, `slot`", $this->guid);
                }
                break;
            case SERVER_TRINITY:
                if($spec >= 0) {
                    $glyphs_data = $this->db->select("SELECT * FROM `character_glyphs` WHERE `guid`=%d AND `spec`=%d", $this->guid, $spec);
                }
                else {
                    $glyphs_data = $this->db->select("SELECT * FROM `character_glyphs` WHERE `guid`=%d ORDER BY `spec`", $this->guid);
                }
                break;
        }
        if(!$glyphs_data) {
            return false;
        }
        $data = array(0 => array(), 1 => array());
        $i = 0;
        foreach($glyphs_data as $glyph) {
            switch($this->m_server) {
                case SERVER_MANGOS:
                    if(in_array(Armory::GetLocale(), array('ru_ru', 'en_gb'))) {
                        $current_glyph = Armory::$aDB->selectRow("SELECT `name_%s` AS `name`, `description_%s` AS `effect`, `type` FROM `ARMORYDBPREFIX_glyphproperties` WHERE `id`=%d", Armory::GetLocale(), Armory::GetLocale(), $glyph['glyph']);
                    }
                    else {
                        $current_glyph = Armory::$aDB->selectRow("SELECT `name_en_gb` AS `name`, `description_en_gb` AS `effect`, `type` FROM `ARMORYDBPREFIX_glyphproperties` WHERE `id`=%d", $glyph['glyph']);
                    }
                    $data[$glyph['spec']][$i] = array(
                        'effect' => str_replace('"', '&quot;', $current_glyph['effect']),
                        'id'     => $glyph['glyph'],
                        'name'   => str_replace('"', '&quot;', $current_glyph['name'])
                    );
                    if($current_glyph['type'] == 0) {
                        $data[$glyph['spec']][$i]['type'] = 'major';
                    }
                    else {
                        $data[$glyph['spec']][$i]['type'] = 'minor';
                    }
                    $i++;
                    break;
                case SERVER_TRINITY:
                    for($j = 1; $j < 7; $j++) {
                        $current_glyph = Armory::$aDB->selectRow("SELECT `name_%s` AS `name`, `description_%s` AS `effect`, `type` FROM `ARMORYDBPREFIX_glyphproperties` WHERE `id`=%d", Armory::GetLocale(), Armory::GetLocale(), $glyph['glyph' . $j]);
                        if(!$current_glyph) {
                            continue;
                        }
                        $data[$glyph['spec']][$i] = array(
                            'effect' => str_replace('"', '&quot;', $current_glyph['effect']),
                            'id'     => $glyph['glyph' . $j],
                            'name'   => str_replace('"', '&quot;', $current_glyph['name'])
                        );
                        if($current_glyph['type'] == 0) {
                            $data[$glyph['spec']][$i]['type'] = 'major';
                        }
                        else {
                            $data[$glyph['spec']][$i]['type'] = 'minor';
                        }
                        $i++;
                    }
                    break;
            }
        }
        return $data;
    }
    
    /**
     * Returns talent tree name for selected class
     * @category Character class
     * @access   public
     * @param    int $spec
     * @return   string
     **/
    public function ReturnTalentTreesNames($spec) {
        if(!$this->class) {
            Armory::Log()->writeError('%s : class not provided', __METHOD__);
            return false;
        }
		return Armory::$aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_talent_icons` WHERE `class`=%d AND `spec`=%d", Armory::GetLocale(), $this->class, $spec);
	}
    
    /**
     * Returns icon name for selected class & talent tree
     * @category Character class
     * @access   public
     * @param    int $tree
     * @return   string
     * @todo     Move this function to Utils class
     **/
    public function ReturnTalentTreeIcon($tree) {
        if(!$this->class) {
            Armory::Log()->writeError('%s : class not provided', __METHOD__);
            return false;
        }
        return Armory::$aDB->selectCell("SELECT `icon` FROM `ARMORYDBPREFIX_talent_icons` WHERE `class`=%d AND `spec`=%d LIMIT 1", $this->class, $tree);
    }
    
    /**
     * Returns array with character professions (name, icon & current skill value)
     * @category Character class
     * @access   public
     * @return   array
     **/
    public function GetCharacterProfessions() {
        $skills_professions = array(164, 165, 171, 182, 186, 197, 202, 333, 393, 755, 773);
        $professions = $this->db->select("SELECT * FROM `character_skills` WHERE `skill` IN (%s) AND `guid`=%d LIMIT 2", $skills_professions, $this->guid);
        if(!$professions) {
            return false;
        }
        $p = array();
        $i = 0;
        foreach($professions as $prof) {
            $p[$i] = Armory::$aDB->selectRow("SELECT `id`, `name_%s` AS `name`, `icon` FROM `ARMORYDBPREFIX_professions` WHERE `id`=%d LIMIT 1", Armory::GetLocale(), $prof['skill']);
            $p[$i]['value'] = $prof['value'];
            $p[$i]['key'] = str_replace('-sm', '', (isset($p[$i]['icon'])) ? $p[$i]['icon'] : '' );
            $p[$i]['max'] = 450;
            unset($p[$i]['icon']);
            $i++;
        }
        return $p;
    }
    
    /**
     * Returns array with character reputation (faction name, description, value)
     * @category Character class
     * @access   public
     * @todo     Make parent sections
     * @return   array
     **/
    public function GetCharacterReputation() {
        if(!$this->guid) {
            return false;
        }
        /*
        // Default categories
        $categories = array(
            // World of Warcraft (Classic)
            1118 => array(
                // Horde
                67 => array(
                    'order' => 1,
                    'side'  => 1
                ),
                // Horde Forces
                892 => array(
                    'order' => 2,
                    'side'  => 1
                ),
                // Alliance
                469 => array(
                    'order' => 1,
                    'side'  => 2
                ),
                // Alliance Forces
                891 => array(
                    'order' => 2,
                    'side'  => 2
                ),
                // Steamwheedle Cartel
                169 => array(
                    'order' => 3,
                    'side'  => -1
                )
            ),
            // The Burning Crusade
            980 => array(
                // Shattrath
                936 => array(
                    'order' => 1,
                    'side'  => -1
                )
            ),
            // Wrath of the Lich King
            1097 => array(
                // Sholazar Basin
                1117 => array(
                    'order' => 1,
                    'side'  => -1
                ),
                // Horde Expedition
                1052 => array(
                    'order' => 2,
                    'side'  => 1
                ),
                // Alliance Vanguard
                1037 => array(
                    'order' => 2,
                    'side'  => 2
                ),
            ),
            // Other
            0 => array(
                // Wintersaber trainers
                589 => array(
                    'order' => 1,
                    'side'  => 2
                ),
                // Syndicat
                70 => array(
                    'order' => 2,
                    'side'  => -1
                )
            )
        );
        */
        $repData = $this->db->select("SELECT `faction`, `standing`, `flags` FROM `character_reputation` WHERE `guid`=%d", $this->guid); 
        if(!$repData) {
            return false;
        }
        $i = 0;
        foreach($repData as $faction) {
            if(!($faction['flags']&FACTION_FLAG_VISIBLE) || $faction['flags'] & (FACTION_FLAG_HIDDEN | FACTION_FLAG_INVISIBLE_FORCED)) {
                continue;
            }
            $factionReputation[$i] = Armory::$aDB->selectRow("SELECT `id`, `category`, `name_%s` AS `name`, `key` FROM `ARMORYDBPREFIX_faction` WHERE `id`=%d", Armory::GetLocale(), $faction['faction']);
            if($faction['standing'] > 42999) {
                $factionReputation[$i]['reputation'] = 42999;
            }
            else {
                $factionReputation[$i]['reputation'] = $faction['standing'];
            }
            $i++;
        }
        return $factionReputation;
    }
    
    private function GetFactionCategories($faction) {
        $path = array();
        $in_process = true;
        $id = $faction;
        while($in_process) {
            $id = Armory::$aDB->selectCell("SELECT `category` FROM `ARMORYDBPREFIX_faction` WHERE `id` = %d", $id);
            if($id > 0) {
                $path[] = $id;
            }
            else {
                $in_process = false;
            }
        }
        return $path;
    }
    
    /**
     * Returns value of $fieldNum field. Requires $this->guid or int $guid as second parameter!
     * @category Characters class
     * @access   public
     * @param    int $fieldNum
     * @param    int $guid = null
     * @return   int
     **/
    public function GetDataField($fieldNum, $guid = null) {
        if($guid == null && $this->guid > 0) {
            $guid = $this->guid;
        }
        if(!$guid) {
            Armory::Log()->writeError('%s : guid not provided', __METHOD__);
            return false;
        }
        return (isset($this->char_data[$fieldNum])) ? $this->char_data[$fieldNum] : 0;
    }
    
    /**
     * Returns current health value
     * @category Character class
     * @access   public
     * @return   int
     **/
    public function GetMaxHealth() {
        return $this->health;
    }
    
    /**
     * Returns current mana value
     * @category Character class
     * @access   public
     * @return   int
     **/
    public function GetMaxMana() {
        return $this->power1;
    }
    
    /**
     * Returns current rage value
     * @category Character class
     * @access   public
     * @return   int
     **/
    public function GetMaxRage() {
        return 100;
    }
    
    /**
     * Returns current energy (for Rogues) or Runic power (for Death Knight) value
     * @category Character class
     * @access   public
     * @return   int
     **/
    public function GetMaxEnergy() {
        $maxPower = 100;
        if($this->class == CLASS_DK) {
            // Check for 50147, 49455 spells (Runic power mastery) in current talent spec
            $tRank = $this->HasTalent(2020);
            if($tRank === 0) {
                // Runic power mastery (Rank 1)
                $maxPower = 115;
            }
            elseif($tRank == 1) {
                // Runic power mastery (Rank 2)
                $maxPower = 130;
            }
        }
        elseif($this->class == CLASS_ROGUE) {
            // Check for 14983 spell (Vigor) in current talent spec
            $tRank = $this->HasTalent(382);
            if($tRank) {
                $maxPower = 110;
            }
            // Also, check for Glyph of Vigor (id 408)
            switch($this->m_server) {
                case SERVER_MANGOS:
                    $isGlyphed = $this->db->selectCell("SELECT 1 FROM `character_glyphs` WHERE `guid`=%d AND `glyph`=408 AND `spec`=%d", $this->guid, $this->activeSpec);
                    if($isGlyphed) {
                        $maxPower = 120;
                    }
                    break;
                case SERVER_TRINITY:
                    $isGlyphed = $this->db->selectCell("SELECT 1 FROM `character_glyphs` WHERE `guid`=%d AND (`glyph1`=408 OR `glyph2`=408 OR `glyph3`=408 OR `glyph4`=408 OR `glyph5`=408 OR `glyph6`=408) AND `spec`=%d", $this->guid, $this->activeSpec);
                    if($isGlyphed) {
                        $maxPower = 120;
                    }
                    break;
                default:
                    break;
            }
        }
        return $maxPower;
    }
    
    /**
     * Assigns $this->rating variable (or returns it if it was already assigned)
     * @category Character class
     * @access   public
     * @return   array
     **/
    public function SetRating() {
        if(is_array($this->rating)) {
            return $this->rating;
        }
        else {
            $this->rating = Utils::GetRating($this->level);
            return $this->rating;
        }
    }
    
    /**
     * Calls internal function to calculate character stat
     * @category Character class
     * @access   public
     * @param    string $stat_string
     * @param    int $type
     * @return   int
     **/
    public function GetCharacterStat($stat_string, $type = false) {
        switch($stat_string) {
            case 'strength':
                return $this->GetCharacterStrength();
                break;
            case 'agility':
                return $this->GetCharacterAgility();
                break;
            case 'stamina':
                return $this->GetCharacterStamina();
                break;
            case 'intellect':
                return $this->GetCharacterIntellect();
                break;
            case 'spirit':
                return $this->GetCharacterSpirit();
                break;
            case 'armor':
                return $this->GetCharacterArmor();
                break;                
            case 'mainHandDamage':
                return $this->GetCharacterMainHandMeleeDamage();
                break;
            case 'offHandDamage':
                return $this->GetCharacterOffHandMeleeDamage();
                break;
            case 'mainHandSpeed':
                return $this->GetCharacterMainHandMeleeHaste();
                break;
            case 'offHandSpeed':
                return $this->GetCharacterOffHandMeleeHaste();
                break;
            case 'power':
                if($type === false) {
                    return $this->GetCharacterAttackPower();
                }
                elseif($type == 1) {
                    return $this->GetCharacterRangedAttackPower();
                }
                break;
            case 'hitRating':
                if(!$type) {
                    return $this->GetCharacterMeleeHitRating();
                }
                elseif($type == 1) {
                    return $this->GetCharacterRangedHitRating();
                }
                elseif($type == 2) {
                    return $this->GetCharacterSpellHitRating();
                }
                break;
            case 'critChance':
                if(!$type) {
                    return $this->GetCharacterMeleeCritChance();
                }
                elseif($type == 1) {
                    return $this->GetCharacterRangedCritChance();
                }
                elseif($type == 2) {
                    return $this->GetCharacterSpellCritChance();
                }
                break;
            case 'expertise':
                return $this->GetCharacterMainHandMeleeSkill();
                break;
            case 'damage':
                return $this->GetCharacterRangedDamage();
                break;
            case 'speed':
                return $this->GetCharacterRangedHaste();
                break;
            case 'weaponSkill':
                return $this->GetCharacterRangedWeaponSkill();
                break;
            case 'bonusDamage':
                return $this->GetCharacterSpellBonusDamage();
                break;
            case 'bonusHealing':
                return $this->GetCharacterSpellBonusHeal();
                break;
            case 'hasteRating':
                return $this->GetCharacterSpellHaste();
                break;
            case 'penetration':
                return $this->GetCharacterSpellPenetration();
                break;
            case 'manaRegen':
                return $this->GetCharacterSpellManaRegen();
                break;
            case 'defense':
                return $this->GetCharacterDefense();
                break;
            case 'dodge':
                return $this->GetCharacterDodge();
                break;
            case 'parry':
                return $this->GetCharacterParry();
                break;
            case 'block':
                return $this->GetCharacterBlock();
                break;
            case 'resilience':
                return $this->GetCharacterResilence();
                break;
            default:
                return false;
                break;
        }
    }
    
    /**
     * Returns array with Strength value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterStrength() {
        $tmp_stats = array();
        $tmp_stats['bonus_strenght'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT0), 0);
        $tmp_stats['negative_strenght'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT0), 0);        
        $tmp_stats['effective'] = $this->GetDataField(UNIT_FIELD_STAT0);
        $tmp_stats['attack'] = Utils::GetAttackPowerForStat(STAT_STRENGTH, $tmp_stats['effective'], $this->class);
        $tmp_stats['base'] = $tmp_stats['effective']-$tmp_stats['bonus_strenght'] - $tmp_stats['negative_strenght'];
        if(in_array($this->class, array(CLASS_WARRIOR, CLASS_PALADIN, CLASS_SHAMAN))) {
            $tmp_stats['block'] = max(0, $tmp_stats['effective'] * BLOCK_PER_STRENGTH - 10);
        }
        else {
            $tmp_stats['block'] = -1;
        }
        $player_stats = array(
            'attack'    => $tmp_stats['attack'],
            'base'      => $tmp_stats['base'],
            'block'     => $tmp_stats['block'],
            'effective' => $tmp_stats['effective']
        );
        unset($tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Agility value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterAgility() {
        $tmp_stats    = array();
        $rating       = $this->SetRating();
        $tmp_stats['effective'] = $this->GetDataField(UNIT_FIELD_STAT1);
        $tmp_stats['bonus_agility'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT1), 0);
        $tmp_stats['negative_agility'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT1), 0);
        $tmp_stats['base'] = $tmp_stats['effective'] - $tmp_stats['bonus_agility'] - $tmp_stats['negative_agility'];
        $tmp_stats['critHitPercent'] = floor(Utils::GetCritChanceFromAgility($rating, $this->class, $tmp_stats['effective']));
        $tmp_stats['attack'] = Utils::GetAttackPowerForStat(STAT_AGILITY, $tmp_stats['effective'], $this->class);
        $tmp_stats['armor'] = $tmp_stats['effective'] * ARMOR_PER_AGILITY;
        if($tmp_stats['attack'] == 0) {
            $tmp_stats['attack'] = -1;
        }
        $player_stats = array(
            'armor'          => $tmp_stats['armor'],
            'attack'         => $tmp_stats['attack'],
            'base'           => $tmp_stats['base'],
            'critHitPercent' => $tmp_stats['critHitPercent'],
            'effective'      => $tmp_stats['effective']
        );
        unset($rating, $tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Stamina value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterStamina() {
        $tmp_stats = array();
        $tmp_stats['effective'] = $this->GetDataField(UNIT_FIELD_STAT2);
        $tmp_stats['bonus_stamina'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT2), 0);
        $tmp_stats['negative_stamina'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT2), 0);
        $tmp_stats['base'] = $tmp_stats['effective'] - $tmp_stats['bonus_stamina'] - $tmp_stats['negative_stamina'];
        $tmp_stats['base_stamina'] = min(20, $tmp_stats['effective']);
        $tmp_stats['more_stamina'] = $tmp_stats['effective'] - $tmp_stats['base_stamina'];
        $tmp_stats['health'] = $tmp_stats['base_stamina'] + ($tmp_stats['more_stamina'] * HEALTH_PER_STAMINA);
        $tmp_stats['petBonus'] = Utils::ComputePetBonus(2, $tmp_stats['effective'], $this->class);
        if($tmp_stats['petBonus'] == 0) {
            $tmp_stats['petBonus'] = -1;
        }
        $player_stats = array(
            'base'      => $tmp_stats['base'],
            'effective' => $tmp_stats['effective'],
            'health'    => $tmp_stats['health'],
            'petBonus'  => $tmp_stats['petBonus']
        );
        unset($tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Intellect value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterIntellect() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $tmp_stats['effective'] =$this->GetDataField(UNIT_FIELD_STAT3);
        $tmp_stats['bonus_intellect'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT3), 0);
        $tmp_stats['negative_intellect'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT3), 0);
        $tmp_stats['base'] = $tmp_stats['effective']-$tmp_stats['bonus_intellect']-$tmp_stats['negative_intellect'];
        if($this->IsManaUser()) {
            $tmp_stats['base_intellect'] = min(20, $tmp_stats['effective']);
            $tmp_stats['more_intellect'] = $tmp_stats['effective'] - $tmp_stats['base_intellect'];
            $tmp_stats['mana'] = $tmp_stats['base_intellect'] + $tmp_stats['more_intellect'] * MANA_PER_INTELLECT;
            $tmp_stats['critHitPercent'] = round(Utils::GetSpellCritChanceFromIntellect($rating, $this->class, $tmp_stats['effective']), 2);
        }
        else {
            $tmp_stats['base_intellect'] = -1;
            $tmp_stats['more_intellect'] = -1;
            $tmp_stats['mana'] = -1;
            $tmp_stats['critHitPercent'] = -1;
        }
        $tmp_stats['petBonus'] = Utils::ComputePetBonus(7, $tmp_stats['effective'], $this->class);
        if($tmp_stats['petBonus'] == 0) {
            $tmp_stats['petBonus'] = -1;
        }
        $player_stats = array(
            'base' => $tmp_stats['base'],
            'critHitPercent' => $tmp_stats['critHitPercent'],
            'effective'      => $tmp_stats['effective'],
            'mana'           => $tmp_stats['mana'],
            'petBonus'       => $tmp_stats['petBonus']
        );
        unset($rating, $tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Spirit value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterSpirit() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $tmp_stats['effective'] =$this->GetDataField(UNIT_FIELD_STAT4);
        $tmp_stats['bonus_spirit'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT4), 0);
        $tmp_stats['negative_spirit'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT4), 0);
        $tmp_stats['base'] = $tmp_stats['effective']-$tmp_stats['bonus_spirit']-$tmp_stats['negative_spirit'];
        $baseRatio = array(0, 0.625, 0.2631, 0.2, 0.3571, 0.1923, 0.625, 0.1724, 0.1212, 0.1282, 1, 0.1389);
        $tmp_stats['base_spirit'] = $tmp_stats['effective'];
        if($tmp_stats['base_spirit'] > 50) {
            $tmp_stats['base_spirit'] = 50;
        }
        $tmp_stats['more_spirit'] = $tmp_stats['effective'] - $tmp_stats['base_spirit'];
        $tmp_stats['healthRegen'] = floor($tmp_stats['base_spirit'] * $baseRatio[$this->class] + $tmp_stats['more_spirit'] * Utils::GetHRCoefficient($rating, $this->class));
        
        if($this->IsManaUser()) {
            $intellect_tmp = $this->GetCharacterIntellect();
            $tmp_stats['manaRegen'] = sqrt($intellect_tmp['effective']) * $tmp_stats['effective'] * Utils::GetMRCoefficient($rating, $this->class);
            $tmp_stats['manaRegen'] = floor($tmp_stats['manaRegen'] * 5);
        }
        else {
            $tmp_stats['manaRegen'] = -1;
        }
        $player_stats = array(
            'base'        => $tmp_stats['base'],
            'effective'   => $tmp_stats['effective'],
            'healthRegen' => $tmp_stats['healthRegen'],
            'manaRegen'   => $tmp_stats['manaRegen']
        );
        unset($rating, $tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Armor value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterArmor() {
        $tmp_stats = array();
        $levelModifier = 0;        
        $tmp_stats['effective'] = $this->GetDataField(UNIT_FIELD_RESISTANCES);
        $tmp_stats['bonus_armor'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_RESISTANCEBUFFMODSPOSITIVE), 0);
        $tmp_stats['negative_armor'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_RESISTANCEBUFFMODSNEGATIVE), 0);
        $tmp_stats['base'] = $tmp_stats['effective']-$tmp_stats['bonus_armor']-$tmp_stats['negative_armor'];
        if($this->level > 59 ) {
            $levelModifier = $this->level + (4.5 * ($this->level-59));
        }
        $tmp_stats['reductionPercent'] = 0.1*$tmp_stats['effective']/(8.5*$levelModifier + 40);
    	$tmp_stats['reductionPercent'] = round($tmp_stats['reductionPercent']/(1+$tmp_stats['reductionPercent'])*100, 2);
    	if($tmp_stats['reductionPercent'] > 75) {
    	   $tmp_stats['reductionPercent'] = 75;
    	}
    	if($tmp_stats['reductionPercent'] <  0) {
    	   $tmp_stats['reductionPercent'] = 0;
    	}
        $tmp_stats['petBonus'] = Utils::ComputePetBonus(4, $tmp_stats['effective'], $this->class);
        if($tmp_stats['petBonus'] == 0) {
            $tmp_stats['petBonus'] = '-1';
        }
        $player_stats = array(
            'base'      => $tmp_stats['base'],
            'effective' => $tmp_stats['effective'],
            'percent'   => $tmp_stats['reductionPercent'],
            'petBonus'  => $tmp_stats['petBonus']
        );
        unset($tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Expertise (MH melee) value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterMainHandMeleeSkill() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $character_data = $this->db->selectCell("SELECT `data` FROM `armory_character_stats` WHERE `guid`=%d", $this->guid);
        $tmp_stats['melee_skill_id'] = Utils::GetSkillIDFromItemID($this->GetCharacterEquip('mainhand'));
        $tmp_stats['melee_skill'] = Utils::GetSkillInfo($tmp_stats['melee_skill_id'], $character_data);
        $tmp_stats['rating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1+20);
        $tmp_stats['additional'] = $tmp_stats['rating']/Utils::GetRatingCoefficient($rating, 2);
        $buff = $tmp_stats['melee_skill'][4]+$tmp_stats['melee_skill'][5]+intval($tmp_stats['additional']);
        $tmp_stats['value'] = $tmp_stats['melee_skill'][2]+$buff;
        $player_stats = array(
            'value'      => $tmp_stats['value'],
            'rating'     => $tmp_stats['rating'],
            'additional' => $tmp_stats['additional'],
            'percent'    => '0.00'
        );
        unset($tmp_stats, $rating);
        return $player_stats;
    }
    
    /**
     * Returns array with Expertise (OH melee) value
     * @category Character class
     * @access   private
     * @return   array
     * @todo     correctly handle this stat
     **/
    private function GetCharacterOffHandMeleeSkill() {
        return array('value' => null, 'rating' => null);
    }
    
    /**
     * Returns array with Main hand melee damage value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterMainHandMeleeDamage() {
        $tmp_stats = array();
        $tmp_stats['min'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_MINDAMAGE), 0);
        $tmp_stats['max'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_MAXDAMAGE), 0);
        $tmp_stats['speed'] = round(Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_BASEATTACKTIME), 2) / 1000, 2);
        $tmp_stats['melee_dmg'] = ($tmp_stats['min'] + $tmp_stats['max']) * 0.5;
        $tmp_stats['dps'] = round((max($tmp_stats['melee_dmg'], 1) / $tmp_stats['speed']), 1);
        if($tmp_stats['speed'] < 0.1) {
            $tmp_stats['speed'] = 0.1;
        }
        $player_stats = array(
            'dps'     => $tmp_stats['dps'],
            'max'     => $tmp_stats['max'],
            'min'     => $tmp_stats['min'],
            'percent' => 0,
            'speed'   => $tmp_stats['speed']
        );
        unset($tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Off hand melee damage value
     * @category Character class
     * @access   private
     * @return   array
     * @todo     correctly handle this stat
     **/
    private function GetCharacterOffHandMeleeDamage() {
        return array('speed' => 0, 'min' => 0, 'max'  => 0, 'percent' => 0, 'dps' => '0.0');
    }
    
    /**
     * Returns array with Main hand melee haste value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterMainHandMeleeHaste() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $tmp_stats['value'] = round(Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_BASEATTACKTIME), 2)/1000, 2);
        $tmp_stats['hasteRating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 17);
        $tmp_stats['hastePercent'] = round($tmp_stats['hasteRating'] / Utils::GetRatingCoefficient($rating, 19), 2);
        unset($rating);
        return $tmp_stats;
    }
    
    /**
     * Returns array with Off hand melee haste value
     * @category Character class
     * @access   private
     * @return   array
     * @todo     correctly handle this stat
     **/
    private function GetCharacterOffHandMeleeHaste() {
        return array('hastePercent' => 0, 'hasteRating' => 0, 'value' => 0);
    }
    
    /**
     * Returns array with Attack power value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterAttackPower() {
        $tmp_stats = array();
        $tmp_stats['multipler_melee_ap'] = Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_ATTACK_POWER_MULTIPLIER), 8);
        if($tmp_stats['multipler_melee_ap'] < 0) {
            $tmp_stats['multipler_melee_ap'] = 0;
        }
        else {
            $tmp_stats['multipler_melee_ap']+=1;
        }
        $tmp_stats['base'] = $this->GetDataField(UNIT_FIELD_ATTACK_POWER) * $tmp_stats['multipler_melee_ap'];
        $tmp_stats['bonus_melee_ap'] = $this->GetDataField(UNIT_FIELD_ATTACK_POWER_MODS) * $tmp_stats['multipler_melee_ap'];
        $tmp_stats['effective'] = $tmp_stats['base'] + $tmp_stats['bonus_melee_ap'];
        $tmp_stats['increasedDps'] = floor(max($tmp_stats['effective'], 0) / 14);
        $player_stats = array(
            'base'         => round($tmp_stats['base']),
            'effective'    => round($tmp_stats['effective']),
            'increasedDps' => round($tmp_stats['increasedDps'])
        );
        unset($tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns array with Hit rating (melee) value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterMeleeHitRating() {
        $player_stats = array();
        $rating       = $this->SetRating();
        $player_stats['value'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1+5);
        $player_stats['increasedHitPercent'] = floor($player_stats['value'] / Utils::GetRatingCoefficient($rating, 6));
        $player_stats['armorPenetration'] = $this->GetDataField(PLAYER_FIELD_MOD_TARGET_PHYSICAL_RESISTANCE);
        $player_stats['reducedArmorPercent'] = '0.00';
        unset($rating);
        return $player_stats;
    }
    
    /**
     * Returns array with Melee crit value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterMeleeCritChance() {
        $rating = $this->SetRating();
        $player_stats = array();
        $player_stats['percent'] = Utils::GetFloatValue($this->GetDataField(PLAYER_CRIT_PERCENTAGE), 2);
        $player_stats['rating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1+8);
        $player_stats['plusPercent'] = floor($player_stats['rating'] / Utils::GetRatingCoefficient($rating, 9));
        unset($rating);
        return $player_stats;
    }
    
    /**
     * Returns array with Ranged Expertise value
     * @category Character class
     * @access   private
     * @return   array
     * @todo     correctly handle this stat
     **/
    private function GetCharacterRangedWeaponSkill() {
        return array('value' => -1, 'rating' => -1);
    }
    
    /**
     * Returns array with Ranged weapon damage value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterRangedDamage() {
        $tmp_stats     = array();
        $rangedSkillID = Mangos::GetSkillIDFromItemID($this->GetDataField(PLAYER_VISIBLE_ITEM_18_ENTRYID));
        if($rangedSkillID == SKILL_UNARMED) {
            $tmp_stats['min'] = 0;
            $tmp_stats['max'] = 0;
            $tmp_stats['speed'] = 0;
            $tmp_stats['dps'] = 0;
        }
        else {
            $tmp_stats['min'] =  Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_MINRANGEDDAMAGE), 0);
            $tmp_stats['max'] =  Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_MAXRANGEDDAMAGE), 0);
            $tmp_stats['speed'] = round( Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_RANGEDATTACKTIME), 2)/1000, 2);
            $tmp_stats['ranged_dps'] = ($tmp_stats['min'] + $tmp_stats['max']) * 0.5;
            if($tmp_stats['speed'] < 0.1) {
                $tmp_stats['speed'] = 0.1;
            }
            $tmp_stats['dps'] = round((max($tmp_stats['ranged_dps'], 1) / $tmp_stats['speed']));
        }
        $player_stats = array(
            'speed'   => $tmp_stats['speed'],
            'min'     => $tmp_stats['min'],
            'max'     => $tmp_stats['max'],
            'dps'     => $tmp_stats['dps'],
            'percent' => '0.00'
        );
        unset($tmp_stats, $rangedSkillID);
        return $player_stats;
    }
    
    /**
     * Returns array with Ranged weapon haste value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterRangedHaste() {
        $player_stats  = array();
        $rating        = $this->SetRating();
        $rangedSkillID = Mangos::GetSkillIDFromItemID($this->GetDataField(PLAYER_VISIBLE_ITEM_18_ENTRYID));
        if($rangedSkillID == SKILL_UNARMED) {
            $player_stats['value'] = 0;
            $player_stats['hasteRating'] = 0;
            $player_stats['hastePercent'] = 0;
        }
        else {
            $player_stats['value'] = round(Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_RANGEDATTACKTIME),2)/1000, 2);
            $player_stats['hasteRating'] = round($this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1+18));
            $player_stats['hastePercent'] = round($player_stats['hasteRating']/ Utils::GetRatingCoefficient($rating, 19), 2);
        }
        unset($rating, $rangedSkillID);
        return $player_stats;
    }
    
    /**
     * Returns array with Ranged Attack Power value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterRangedAttackPower() {
        $player_stats = array();
        $multipler =  Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER_MULTIPLIER), 8);        
        if($multipler < 0) {
            $multipler = 0;
        }
        else {
            $multipler += 1;
        }
        $effectiveStat = $this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER) * $multipler;
        $buff = $this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER_MODS) * $multipler;
        $multiple =  Utils::GetFloatValue($this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER_MULTIPLIER), 2);
        $posBuff = 0;
        $negBuff = 0;
        if($buff > 0) {
            $posBuff = $buff;
        }
        elseif($buff < 0) {
            $negBuff = $buff;
        }
        $stat = $effectiveStat+$buff;
        $player_stats['base'] = floor($effectiveStat);
        $player_stats['effective'] = floor($stat);
        $player_stats['increasedDps'] = floor(max($stat, 0) / 14);
        $player_stats['petAttack'] = floor(Utils::ComputePetBonus(0, $stat, $this->class));
        $player_stats['petSpell'] = floor(Utils::ComputePetBonus(1, $stat, $this->class));
        return $player_stats;
    }
    
    /**
     * Returns array with Ranged Hit Rating value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterRangedHitRating() {
        $player_stats = array();
        $rating       = $this->SetRating();
        $player_stats['value'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 6);
        $player_stats['increasedHitPercent'] = floor($player_stats['value'] / Utils::GetRatingCoefficient($rating, 7));
        $player_stats['reducedArmorPercent'] = $this->GetDataField(PLAYER_FIELD_MOD_TARGET_PHYSICAL_RESISTANCE);
        $player_stats['penetration'] = 0;
        unset($rating);
        return $player_stats;
    }
    
    /**
     * Returns array with Ranged Crit value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterRangedCritChance() {
        $player_stats = array();
        $rating       = $this->SetRating();        
        $player_stats['percent'] =  Utils::GetFloatValue($this->GetDataField(PLAYER_RANGED_CRIT_PERCENTAGE), 2);
        $player_stats['rating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 9);
        $player_stats['plusPercent'] = floor($player_stats['rating']/ Utils::GetRatingCoefficient($rating, 10));
        unset($rating);
        return $player_stats;
    }
    
    /**
     * Returns array with Spell Power (damage) value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterSpellBonusDamage() {
        $tmp_stats  = array();
        $holySchool = SPELL_SCHOOL_HOLY;
        $minModifier = Utils::GetSpellBonusDamage($holySchool, $this->guid, $this->db);
        for ($i = 1; $i < 7; $i++) {
            $bonusDamage[$i] = Utils::GetSpellBonusDamage($i, $this->guid, $this->db);
            $minModifier = min($minModifier, $bonusDamage);
        }
        $tmp_stats['holy']   = round($bonusDamage[1]);
        $tmp_stats['fire']   = round($bonusDamage[2]);
        $tmp_stats['nature'] = round($bonusDamage[3]);
        $tmp_stats['frost']  = round($bonusDamage[4]);
        $tmp_stats['shadow'] = round($bonusDamage[5]);
        $tmp_stats['arcane'] = round($bonusDamage[6]);
        $tmp_stats['attack'] = -1;
        $tmp_stats['damage'] = -1;
        if($this->class == CLASS_HUNTER || $this->class == CLASS_WARLOCK) {
            $shadow = Utils::GetSpellBonusDamage(5, $this->guid, $this->db);
            $fire   = Utils::GetSpellBonusDamage(2, $this->guid, $this->db);
            $tmp_stats['attack'] = Utils::ComputePetBonus(6, max($shadow, $fire), $this->class);
            $tmp_stats['damage'] = Utils::ComputePetBonus(5, max($shadow, $fire), $this->class);
        }
        $tmp_stats['fromType'] = 0;
        return $tmp_stats;
    }
    
    /**
     * Returns array with Spell Crit value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterSpellCritChance() {
        $player_stats = array();
        $spellCrit    = array();
        $rating       = $this->SetRating();
        $player_stats['rating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 10);
        $player_stats['spell_crit_pct'] = $player_stats['rating'] / Utils::GetRatingCoefficient($rating, 11);
        $minCrit = $this->GetDataField(PLAYER_SPELL_CRIT_PERCENTAGE1 + 1);
        for($i = 1; $i < 7; $i++) {
            $scfield = PLAYER_SPELL_CRIT_PERCENTAGE1 + $i;
            $s_crit_value = $this->GetDataField($scfield);
            $spellCrit[$i] =  Utils::GetFloatValue($s_crit_value, 2);
            $minCrit = min($minCrit, $spellCrit[$i]);
        }
        $player_stats['holy']   = $spellCrit[1];
        $player_stats['fire']   = $spellCrit[2];
        $player_stats['nature'] = $spellCrit[3]; 
        $player_stats['frost']  = $spellCrit[4];
        $player_stats['arcane'] = $spellCrit[5];       
        $player_stats['shadow'] = $spellCrit[6];
        unset($rating, $spellCrit, $player_stats['spell_crit_pct']);
        return $player_stats;
    }
    
    /**
     * Returns array with Spell Hit value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterSpellHitRating() {
        $player_stats = array();
        $rating       = $this->SetRating();
        $player_stats['value'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 7);
        $player_stats['increasedHitPercent'] = floor($player_stats['value'] / Utils::GetRatingCoefficient($rating, 8));
        $player_stats['penetration'] = $this->GetDataField(PLAYER_FIELD_MOD_TARGET_RESISTANCE);
        $player_stats['reducedResist'] = 0;
        unset($rating);
        return $player_stats;
    }
    
    /**
     * Returns array with Spell Power (heal) value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterSpellBonusHeal() {
        return array('value' => $this->GetDataField(PLAYER_FIELD_MOD_HEALING_DONE_POS));
    }
    
    /**
     * Returns array with Spell Haste value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterSpellHaste() {
        $player_stats = array();
        $rating       = $this->SetRating();
        $player_stats['hasteRating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 19);
        $player_stats['hastePercent'] = round($player_stats['hasteRating']/ Utils::GetRatingCoefficient($rating, 20), 2);
        unset($rating);
        return $player_stats;
    }
    
    /**
     * Returns array with Spell Penetration value
     * @category Character class
     * @access   private
     * @return   array
     * @todo     correctly handle this stat
     **/
    private function GetCharacterSpellPenetration() {
        return array('value' => 0);
    }
    
    /**
     * Returns array with Mana Regeneration value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterSpellManaRegen() {
        $player_stats = array();
        $player_stats['notCasting'] = $this->GetDataField(UNIT_FIELD_POWER_REGEN_FLAT_MODIFIER);
        $player_stats['casting'] = $this->GetDataField(UNIT_FIELD_POWER_REGEN_INTERRUPTED_FLAT_MODIFIER);
        $player_stats['notCasting'] =  floor(Utils::GetFloatValue($player_stats['notCasting'], 2) * 5);
        $player_stats['casting'] =  round(Utils::GetFloatValue($player_stats['casting'], 2) * 5, 2);
        return $player_stats;
    }
    
    /**
     * Returns array with Defense value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterDefense() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $gskill    = $this->db->selectRow("SELECT * FROM `character_skills` WHERE `guid`=%d AND `skill`=95", $this->guid);
        $tmp_value = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 1);
        $tmp_stats['defense_rating_skill'] = $gskill['value'];
        $tmp_stats['plusDefense'] = round($tmp_value / Utils::GetRatingCoefficient($rating, 2));
        $tmp_stats['value'] = $gskill['value'];
        $tmp_stats['rating'] = $tmp_value;
        $tmp_stats['increasePercent'] = DODGE_PARRY_BLOCK_PERCENT_PER_DEFENSE * ($tmp_stats['rating'] - $this->level * 5);
        $tmp_stats['decreasePercent'] = $tmp_stats['increasePercent'];
        if($tmp_stats['increasePercent'] < 0) {
            $tmp_stats['increasePercent'] = 0;
        }
        if($tmp_stats['decreasePercent'] < 0) {
            $tmp_stats['decreasePercent'] = 0;
        }
        unset($rating, $gskill, $tmp_stats['defense_rating_skill']);
        return $tmp_stats;
    }
    
    /**
     * Returns array with Dodge value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterDodge() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $tmp_stats['percent'] = Utils::GetFloatValue($this->GetDataField(PLAYER_DODGE_PERCENTAGE), 2);
        $tmp_stats['rating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 2);
        $tmp_stats['increasePercent'] = floor($tmp_stats['rating']/Utils::GetRatingCoefficient($rating, 3));
        unset($rating);
        return $tmp_stats;
    }
    
    /**
     * Returns array with Parry value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterParry() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $tmp_stats['percent'] = Utils::GetFloatValue($this->GetDataField(PLAYER_PARRY_PERCENTAGE), 2);
        $tmp_stats['rating'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 3);
        $tmp_stats['increasePercent'] = floor($tmp_stats['rating']/Utils::GetRatingCoefficient($rating, 4));
        unset($rating);
        return $tmp_stats;
    }
    
    /**
     * Returns array with Block value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterBlock() {
        $tmp_stats = array();
        $blockvalue = $this->GetDataField(PLAYER_BLOCK_PERCENTAGE);
        $tmp_stats['percent'] =  Utils::GetFloatValue($blockvalue, 2);
        $tmp_stats['increasePercent'] = $this->GetDataField(PLAYER_FIELD_COMBAT_RATING_1 + 4);
        $tmp_stats['rating'] = $this->GetDataField(PLAYER_SHIELD_BLOCK);
        return $tmp_stats;
    }
    
    /**
     * Returns array with Resilence value
     * @category Character class
     * @access   private
     * @return   array
     **/
    private function GetCharacterResilence() {
        $tmp_stats = array();
        $rating    = $this->SetRating();
        $tmp_stats['melee_resilence'] = $this->GetDataField(PLAYER_FIELD_CRIT_TAKEN_MELEE_RATING);
        $tmp_stats['ranged_resilence'] = $this->GetDataField(PLAYER_FIELD_CRIT_TAKEN_RANGED_RATING);
        $tmp_stats['spell_resilence'] = $this->GetDataField(PLAYER_FIELD_CRIT_TAKEN_SPELL_RATING);        
        $tmp_stats['value'] = min($tmp_stats['melee_resilence'], $tmp_stats['ranged_resilence'], $tmp_stats['spell_resilence']);
        $tmp_stats['damagePercent'] = $tmp_stats['melee_resilence']/Utils::GetRatingCoefficient($rating, 15);
        $tmp_stats['ranged_resilence_pct'] = $tmp_stats['ranged_resilence']/Utils::GetRatingCoefficient($rating, 16);
        $tmp_stats['hitPercent'] = $tmp_stats['spell_resilence']/Utils::GetRatingCoefficient($rating, 17);
        $player_stats = array(
            'value'         => $tmp_stats['value'],
            'hitPercent'    => round($tmp_stats['hitPercent'], 2),
            'damagePercent' => round($tmp_stats['damagePercent'], 2)
        );
        unset($rating, $tmp_stats);
        return $player_stats;
    }
    
    /**
     * Returns skill info for $skill. If $guid not provided, function will use $this->guid. Not used now.
     * @category Character class
     * @access   public
     * @param    int $skill
     * @param    int $guid = 0
     * @return   array
     **/
    public function GetCharacterSkill($skill, $guid = 0) {
        if($guid == 0 && $this->guid > 0) {
            $guid = $this->guid;
        }
        if($guid == 0) {
            Armory::Log()->writeError('%s : guid not provided', __METHOD__);
            return false;
        }
        return $this->db->selectRow("SELECT * FROM `character_skill` WHERE `guid`=%d AND `skill`=%d", $guid, $skill);
    }
    
    /**
     * Returns data for 2x2, 3x3 and 5x5 character arena teams (if exists).
     * If $check == true, function will return boolean type.
     * Used by character-*.php to check show or not 'Arena' button
     * @category Character class
     * @access   public
     * @param    bool $check = false
     * @return   array
     **/
    public function GetCharacterArenaTeamInfo($check = false) {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $arenaTeamInfo = array();
        $tmp_info = $this->db->select(
        "SELECT 
        `arena_team_member`.`arenateamid`,
        `arena_team_member`.`guid`,
        `arena_team_member`.`personal_rating`,
        `arena_team`.`name`,
        `arena_team`.`type`,
        `arena_team_stats`.`rating`,
        `arena_team_stats`.`rank`
        FROM `arena_team_member` AS `arena_team_member`
        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team_member`.`arenateamid`
        LEFT JOIN `arena_team` AS `arena_team` ON `arena_team`.`arenateamid`=`arena_team_member`.`arenateamid`
        WHERE `arena_team_member`.`guid`=%d", $this->guid);
        if(!$tmp_info) {
            return false;
        }
        if($check == true && is_array($tmp_info)) {
            return true;
        }
        for($i = 0; $i < 3; $i++) {
            switch($tmp_info[$i]['type']) {
                case 2:
                    $arenaTeamInfo['2x2'] = array(
                        'name' => $tmp_info[$i]['name'],
                        'rank' => $tmp_info[$i]['rank'],
                        'rating' => $tmp_info[$i]['rating'],
                        'personalrating' => $tmp_info[$i]['personal_rating']
                    );
                    break;
                case 3:
                    $arenaTeamInfo['3x3'] = array(
                        'name' => $tmp_info[$i]['name'],
                        'rank' => $tmp_info[$i]['rank'],
                        'rating' => $tmp_info[$i]['rating'],
                        'personalrating' => $tmp_info[$i]['personal_rating']
                    );
                    break;
                case 5:
                    $arenaTeamInfo['5x5'] = array(
                        'name' => $tmp_info[$i]['name'],
                        'rank' => $tmp_info[$i]['rank'],
                        'rating' => $tmp_info[$i]['rating'],
                        'personalrating' => $tmp_info[$i]['personal_rating']
                    );
                    break;
                default:
                    return false;
                    break;
            }
            return $arenaTeamInfo;
        }
    }
    
    /**
     * Loads character feed data from DB
     * @category Characters class
     * @access   private
     * @return   bool
     **/
    private function LoadFeedData() {
        if($this->feed_data) {
            return true;
        }
        $this->feed_data = $this->db->select("SELECT * FROM `character_feed_log` WHERE `guid` = %d AND `date` > 0 ORDER BY `date` DESC", $this->GetGUID());
        if(!$this->feed_data) {
            Armory::Log()->writeLog('%s : unable to load feed data for character %s (GUID: %d).', __METHOD__, $this->GetName(), $this->GetGUID());
            return false;
        }
        $count = count($this->feed_data);
        for($i = 0; $i < $count; $i++) {
            if($this->feed_data[$i]['type'] == TYPE_ACHIEVEMENT_FEED) {
                $this->feed_data[$i]['date'] = $this->GetAchievementMgr()->GetAchievementDate($this->feed_data[$i]['data'], true);
            }
        }
        return true;
    }
    
    /**
     * Returns info about last character activity. Requires MaNGOS/Trinity core patch (tools/character_feed)!
     * bool $full used only in character-feed.php
     * @category Characters class
     * @access   public
     * @param    bool $full = false
     * @return   array
     * @todo     Some bosses kills/achievement gains are not shown or shown with wrong date
     **/
    public function GetCharacterFeed($full = false) {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        if(!$this->feed_data) {
            // Must be loaded from Character::BuildCharacter()
            return false;
        }
        $limit = ($full == true) ? 50 : 10;
        $currently_added = 0;
        $i = 0;
        $key = 0;
        $feed_data = array();
        // Strings
        $feed_strings = Armory::$aDB->select("SELECT `id`, `string_%s` AS `string` FROM `ARMORYDBPREFIX_string` WHERE `id` IN (13, 14, 15, 16, 17, 18)", Armory::GetLocale());
        if(!$feed_strings) {
            Armory::Log()->writeError('%s : unable to load strings from armory_string (current locale: %s; locId: %d)', __METHOD__, Armory::GetLocale(), Armory::GetLoc());
            return false;
        }
        $_strings = array();
        foreach($feed_strings as $str) {
            $_strings[$str['id']] = $str['string'];
        }
        foreach($this->feed_data as $event) {
            if($currently_added == $limit) {
                break;
            }
            $event_date = $event['date'];
            $event_type = $event['type'];
            $event_data = $event['data'];
            $date_string = date('d.m.Y', $event_date);
            $feed_data[$i]['hard_date'] = $event_date;
            $feed_data[$i]['hard_data'] = $event_data;
            if(date('d.m.Y') == $date_string) {
                $sort = 'today';
                $diff = time() - $event_date;
                if(Armory::GetLocale() == 'ru_ru') {
                    $periods = array('сек.', 'мин.', 'ч.');
                    $ago_str = 'назад';
                }
                else {
                    $periods = array('seconds', 'minutes', 'hours');
                    $ago_str = 'ago';
                }
                $lengths = array(60, 60, 24);
                for($j = 0; $diff >= $lengths[$j]; $j++) {
                    $diff /= $lengths[$j];
                }
                $diff = round($diff);
                $date_string = sprintf('%s %s %s', $diff, $periods[$j], $ago_str);
            }
            elseif(date('d.m.Y', strtotime('yesterday')) == $date_string) {
                $sort = 'yesterday';
            }
            else {
                $sort = 'earlier';
            }
            switch($event_type) {
                case TYPE_ACHIEVEMENT_FEED:
                    $send_data = array('achievement' => $event_data, 'date' => $event_date);
                    $achievement_info = $this->GetAchievementMgr()->GetAchievementInfo($send_data);
                    if(!$achievement_info || !isset($achievement_info['title']) || !$achievement_info['title'] || empty($achievement_info['title'])) {
                        // Wrong achievement ID or achievement not found in DB.
                        continue;
                    }
                    if(date('d/m/Y', $event_date) != $this->GetAchievementMgr()->GetAchievementDate($event['data'])) {
                        // Wrong achievement date, skip. Related to Vasago's issue.
                        continue;
                    }
                    if(!isset($achievement_info['points'])) {
                        $achievement_info['points'] = 0; // Feat of Strength has no points.
                    }
                    $feed_data[$i]['event'] = array(
                        'type'   => 'achievement',
                        'date'   => $date_string,
                        'time'   => date('H:i:s', $event_date),
                        'id'     => $event_data,
                        'points' => $achievement_info['points'],
                        'sort'   => $sort
                    );
                    $achievement_info['desc'] = str_replace("'", "\'", $achievement_info['desc']);
                    $achievement_info['title'] = str_replace("'", "\'", $achievement_info['title']);
                    $tooltip = sprintf('&lt;div class=\&quot;myTable\&quot;\&gt;&lt;img src=\&quot;wow-icons/_images/51x51/%s.jpg\&quot; align=\&quot;left\&quot; class=\&quot;ach_tooltip\&quot; /\&gt;&lt;strong style=\&quot;color: #fff;\&quot;\&gt;%s (%d)&lt;/strong\&gt;&lt;br /\&gt;%s', $achievement_info['icon'], $achievement_info['title'], $achievement_info['points'], $achievement_info['desc']);
                    if($achievement_info['categoryId'] == 81) {
                        // Feats of strenght
                        $feed_data[$i]['title'] = sprintf('%s [%s].', $_strings[14], $achievement_info['title']);
                        $feed_data[$i]['desc'] = sprintf('%s [<a class="achievement staticTip" href="character-achievements.xml?r=%s&amp;cn=%s" onMouseOver="setTipText(\'%s\')">%s</a>]', $_strings[14], urlencode($this->GetRealmName()), urlencode($this->name), $tooltip, $achievement_info['title']);
                    }
                    else {
                        $points_string = sprintf($_strings[18], $achievement_info['points']);
                        $feed_data[$i]['title'] = sprintf('%s [%s].', $_strings[13], $achievement_info['title']);
                        $feed_data[$i]['desc'] = sprintf('%s [<a class="achievement staticTip" href="character-achievements.xml?r=%s&amp;cn=%s" onMouseOver="setTipText(\'%s\')">%s</a>] %s.', $_strings[13], urlencode($this->GetRealmName()), urlencode($this->name), $tooltip, $achievement_info['title'], $points_string);
                    }
                    $feed_data[$i]['tooltip'] = $tooltip;
                    break;
                case TYPE_ITEM_FEED:
                    $item = Armory::$wDB->selectRow("SELECT `displayid`, `InventoryType`, `name`, `Quality` FROM `item_template` WHERE `entry`=%d LIMIT 1", $event_data);
                    if(!$item) {
                        continue;
                    }
                    $item_icon = Armory::$aDB->selectCell("SELECT `icon` FROM `ARMORYDBPREFIX_icons` WHERE `displayid`=%d", $item['displayid']);
                    // Is item equipped?
                    if($this->IsItemEquipped($event_data)) {
                        $item_slot = $item['InventoryType'];
                    }
                    else {
                        $item_slot = -1;
                    }
                    $feed_data[$i]['event'] = array(
                        'type' => 'loot',
                        'date' => $date_string,
                        'time' => date('H:i:s', $event_date),
                        'icon' => $item_icon,
                        'id'   => $event_data,
                        'slot' => $item_slot,
                        'sort' => $sort,
                    );
                    if(Armory::GetLocale() != 'en_gb' && Armory::GetLocale() != 'en_us') {
                        $item['name'] = Items::GetItemName($event_data);
                    }
                    $feed_data[$i]['title'] = sprintf('%s [%s].', $_strings[15], $item['name']);
                    $feed_data[$i]['desc'] = sprintf('%s <a class="staticTip itemToolTip" id="i=%d" href="item-info.xml?i=%d"><span class="stats_rarity%d">[%s]</span></a>.', $_strings[15], $event_data, $event_data, $item['Quality'], $item['name']);
                    $feed_data[$i]['tooltip'] = $feed_data[$i]['desc'];
                    break;
                case TYPE_BOSS_FEED:
                    // Get criterias
                    $achievement_ids = array();
                    $dungeonDifficulty = $event['difficulty'];
                    if($dungeonDifficulty <= 0) {
                        $DifficultyEntry = $event_data;
                    }
                    else {
                        // Search for difficulty_entry_X
                        $DifficultyEntry = Armory::$wDB->selectCell("SELECT `entry` FROM `creature_template` WHERE `difficulty_entry_%d` = %d", $event['difficulty'], $event_data);
                        if(!$DifficultyEntry || $DifficultyEntry == 0) {
                            $DifficultyEntry = $event['data'];
                        }
                    }
                    $criterias = Armory::$aDB->select("SELECT `referredAchievement` FROM `ARMORYDBPREFIX_achievement_criteria` WHERE `data` = %d", $DifficultyEntry);
                    if(!$criterias || !is_array($criterias)) {
                        continue;
                    }
                    foreach($criterias as $crit) {
                        $achievement_ids[] = $crit['referredAchievement'];
                    }
                    if(!$achievement_ids || !is_array($achievement_ids)) {
                        continue;
                    }
                    $achievement = Armory::$aDB->selectRow("SELECT `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_achievement` WHERE `id` IN (%s) AND `flags`=1 AND `dungeonDifficulty`=%d", Armory::GetLocale(), $achievement_ids, $dungeonDifficulty);
                    if(!$achievement || !is_array($achievement)) {
                        continue;
                    }
                    $feed_data[$i]['event'] = array(
                        'type' => 'bosskill',
                        'date'   => $date_string,
                        'time'   => date('H:i:s', $event_date),
                        'id'     => $event_data,
                        'points' => 0,                        
                        'sort'   => $sort
                    );
                    $feed_data[$i]['title'] = sprintf('%s [%s] %d %s', $_strings[16], $achievement['name'], $event['counter'], $_strings[17]);
                    $feed_data[$i]['desc'] = sprintf('%d %s.', $event['counter'], $achievement['name']);
                    $feed_data[$i]['tooltip'] = $feed_data[$i]['desc'];
                    break;
                default:
                    continue;
                    break;
            }
            $i++;
            $currently_added++;
        }
        return $feed_data;
    }
    
    /**
     * Returns array with data for item placed in $slot['slot']
     * @category Character class
     * @access   public
     * @param    array $slot
     * @return   array
     **/
    public function GetCharacterItemInfo($slot) {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not provided', __METHOD__);
            return false;
        }
        if(!isset($this->m_items[$slot['slotid']])) {
            Armory::Log()->writeError('%s : slot %d is empty (nothing equipped?)', __METHOD__, $slot['slotid']);
            return false;
        }
        $item = $this->m_items[$slot['slotid']];
        $gems = array(
            'g0' => $item->GetSocketInfo(1),
            'g1' => $item->GetSocketInfo(2),
            'g2' => $item->GetSocketInfo(3)
        );
        $durability = $item->GetItemDurability();
        $item_data = Armory::$wDB->selectRow("SELECT `name`, `displayid`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry`=%d", $item->GetEntry());
        $enchantment = $item->GetEnchantmentId();
        $originalSpell = 0;
        $enchItemData = array();
        $enchItemDisplayId = 0;
        if($enchantment > 0) {
            $originalSpell = Armory::$aDB->selectCell("SELECT `id` FROM `ARMORYDBPREFIX_spellenchantment` WHERE `Value`=%d", $enchantment);
            if($originalSpell > 0) {
                $enchItemData = Armory::$wDB->selectRow("SELECT `entry`, `displayid` FROM `item_template` WHERE `spellid_1`=%d LIMIT 1", $originalSpell);
                if($enchItemData) {
                    // Item
                    $enchItemDisplayId = Armory::$aDB->selectCell("SELECT `icon` FROM `ARMORYDBPREFIX_icons` WHERE `displayid`=%d", $enchItemData['displayid']);
                }
                else {
                    // Spell
                    $spellEnchData = Items::GenerateEnchantmentSpellData($originalSpell);
                }
            }
        }
        $item_info = array(
            'displayInfoId'          => $item_data['displayid'],
            'durability'             => $durability['current'],
            'icon'                   => Items::GetItemIcon($item->GetEntry(), $item_data['displayid']),
            'id'                     => $item->GetEntry(),
            'level'                  => $item_data['ItemLevel'],
            'maxDurability'          => $durability['max'],
            'name'                   => (Armory::GetLocale() == 'en_gb' || Armory::GetLocale() == 'en_us') ? $item_data['name'] : Items::GetItemName($item->GetEntry()),
            'permanentenchant'       => $enchantment,
            'pickUp'                 => 'PickUpLargeChain',
            'putDown'                => 'PutDownLArgeChain',
            'randomPropertiesId'     => 0,
            'rarity'                 => $item_data['Quality'],
            'seed'                   => $item->GetGUID(),
            'slot'                   => $slot['slotid']
        );
        if(is_array($gems)) {
            for($i = 0; $i < 3; $i++) {
                if($gems['g' . $i]['item'] > 0) {
                    $item_info['gem' . $i . 'Id'] = $gems['g' . $i]['item'];
                    $item_info['gemIcon' . $i ] = $gems['g' . $i]['icon'];
                }
            }
        }
        if(is_array($enchItemData) && isset($enchItemData['entry'])) {
            $item_info['permanentEnchantIcon'] = $enchItemDisplayId;
            $item_info['permanentEnchantItemId'] = $enchItemData['entry'];
        }
        elseif(isset($spellEnchData) && is_array($spellEnchData) && isset($spellEnchData['name'])) {
            $item_info['permanentEnchantIcon'] = 'trade_engraving';
            $item_info['permanentEnchantSpellName'] = $spellEnchData['name'];
            $item_info['permanentEnchantSpellDesc'] = $spellEnchData['desc'];
        }
        return $item_info;
    }
    
    /**
     * Checks is item with entry $itemID currently equipped on character.
     * @category Character class
     * @access   public
     * @param    int $itemID
     * @return   bool
     **/
    public function IsItemEquipped($itemID) {
        if(!is_array($this->equipmentCache)) {
            return false;
        }
        if(in_array($itemID, $this->equipmentCache)) {
            return true;
        }
        return false;
    }
    
    /**
     * Returns currently equipped item's GUID (depends on $slot_id)
     * @category Character class
     * @access   public
     * @param    string $slot_id
     * @return   int
     **/
    public function GetEquippedItemGuidBySlot($slot_id) {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not provided', __METHOD__);
            return 0;
        }
        switch($slot_id) {
            case 'head':
                return $this->GetDataField(PLAYER_SLOT_ITEM_HEAD);
                break;
            case 'neck':
                return $this->GetDataField(PLAYER_SLOT_ITEM_NECK);
                break;
            case 'shoulder':
                return $this->GetDataField(PLAYER_SLOT_ITEM_SHOULDER);
                break;
            case 'shirt':
                return $this->GetDataField(PLAYER_SLOT_ITEM_SHIRT);
                break;
            case 'chest':
                return $this->GetDataField(PLAYER_SLOT_ITEM_CHEST);
                break;
            case 'belt':
                return $this->GetDataField(PLAYER_SLOT_ITEM_BELT);
                break;
            case 'legs':
                return $this->GetDataField(PLAYER_SLOT_ITEM_LEGS);
                break;
            case 'wrist':
                return $this->GetDataField(PLAYER_SLOT_ITEM_WRIST);
                break;
            case 'boots':
                return $this->GetDataField(PLAYER_SLOT_ITEM_FEET);
                break;
            case 'gloves':
                return $this->GetDataField(PLAYER_SLOT_ITEM_GLOVES);
                break;
            case 'ring1':
                return $this->GetDataField(PLAYER_SLOT_ITEM_FINGER1);
                break;
            case 'ring2':
                return $this->GetDataField(PLAYER_SLOT_ITEM_FINGER2);
                break;
            case 'trinket1':
                return $this->GetDataField(PLAYER_SLOT_ITEM_TRINKET1);
                break;
            case 'trinket2':
                return $this->GetDataField(PLAYER_SLOT_ITEM_TRINKET2);
                break;
            case 'back':
                return $this->GetDataField(PLAYER_SLOT_ITEM_BACK);
                break;
            case 'stave':
            case 'mainhand':
                return $this->GetDataField(PLAYER_SLOT_ITEM_MAIN_HAND);
                break;
            case 'offhand':
                return $this->GetDataField(PLAYER_SLOT_ITEM_OFF_HAND);
                break;
            case 'gun':
            case 'relic':
                return $this->GetDataField(PLAYER_SLOT_ITEM_RANGED);
                break;
            case 'tabard':
                return $this->GetDataField(PLAYER_SLOT_ITEM_TABARD);
                break;
            default:
                Armory::Log()->writeLog('%s : wrong item_slot: %s', __METHOD__, $slot_id);
                return 0;
                break;
        }
    }
    
    /**
     * Returns database handler instance
     * @category Characters class
     * @access   public
     * @return   object
     **/
    public function GetDB() {
        return $this->db;
    }
    
    /**
     * Returns array with player model scales according with player race
     * @category Characters class
     * @access   public
     * @return   array
     **/
    public function GetModelData() {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not provided', __METHOD__);
            return false;
        }
        switch($this->race) {
            case RACE_HUMAN:
                if($this->gender == 1) {
                    return array('baseY' => 1.05, 'facedY' => 1.625, 'scale' => 1.65);
                }
                return array('baseY' => 1.05, 'facedY' => 1.5, 'scale' => 1.65);
                break;
            case RACE_ORC:
                if($this->gender == 1) {
                    return array('baseY' => 1.05, 'facedY' => 1.7, 'scale' => 1.7);
                }
                return array('baseY' => 1.25, 'facedY' => 1.7, 'scale' => 1.3);
                break;
            case RACE_DWARF:
                return array('baseY' => 0.75, 'facedY' => 1.45, 'scale' => 1.75);
                break;
            case RACE_NIGHTELF:
                if($this->gender == 1) {
                    return array('baseY' => 1.15, 'facedY' => 2.0, 'scale' => 1.5);
                }
                return array('baseY' => 1.25, 'facedY' => 2.0, 'scale' => 1.4);
                break;
            case RACE_UNDEAD:
                return array('baseY' => 0.95, 'facedY' => 1.5, 'scale' => 1.8);
                break;
            case RACE_TAUREN:
                return array('baseY' => 1.05, 'facedY' => 1.7, 'scale' => 1.55);
                break;
            case RACE_GNOME:
                return array('baseY' => 0.55, 'facedY' => 0.7, 'scale' => 2.7);
                break;
            case RACE_TROLL:
                return array('baseY' => 1.2, 'facedY' => 1.9, 'scale' => 1.45);
                break;
            case RACE_BLOODELF:
                if($this->gender == 1) {
                    return array('baseY' => 0.97, 'facedY' => 1.6, 'scale' => 1.7);
                }
                return array('baseY' => 1.05, 'facedY' => 1.75, 'scale' => 1.7);
                break;
            case RACE_DRAENEI:
                return array('baseY' => 1.275, 'facedY' => 1.9, 'scale' => 1.375);
                break;
            default:
                Armory::Log()->writeError('%s : wrong character raceId: %d (player: %s, realm: %s)', __METHOD__, $this->race, $this->name, $this->realmName);
                return false;
                break;
        }
    }
    
    /**
     * Checks for spell ID in character's spellbook
     * @category Characters class
     * @access   public
     * @param    int $spell_id
     * @return   bool
     **/
    public function HasSpell($spell_id) {
        return (bool) $this->db->selectCell("SELECT 1 FROM `character_spell` WHERE `spell`=%d AND `guid`=%d AND `active`=1 AND `disabled`=0 LIMIT 1", $spell_id, $this->guid);;
    }
    
    /**
     * Checks for talent ID in active or all specs
     * @category Characters class
     * @access   public
     * @param    int $talent_id
     * @param    bool $active_spec = true
     * @param    int $rank = -1
     * @return   bool
     **/
    public function HasTalent($talent_id, $active_spec = true, $rank = -1) {
        switch($this->GetServerType()) {
            case SERVER_MANGOS:
                $sql_data = array(
                    'activeSpec' => array(
                        sprintf('SELECT `current_rank` + 1 FROM `character_talent` WHERE `talent_id`=%d AND `guid`=%%d AND `spec`=%%d', $talent_id),
                        sprintf('SELECT 1 FROM `character_talent` WHERE `talent_id`=%d AND `guid`=%%d AND `spec`=%%d AND `current_rank`=%d', $talent_id, $rank)
                    ),
                    'spec' => array(
                        sprintf('SELECT `current_rank` + 1 FROM `character_talent` WHERE `talent_id`=%d AND `guid`=%%d', $talent_id),
                        sprintf('SELECT 1 FROM `character_talent` WHERE `talent_id`=%d AND `guid`=%%d AND `current_rank`=%d', $talent_id, $rank)
                    )
                );
                break;
            case SERVER_TRINITY:
                $talent_spells = Armory::$aDB->selectRow("SELECT `Rank_1`, `Rank_2`, `Rank_3`, `Rank_4`, `Rank_5` FROM `ARMORYDBPREFIX_talents` WHERE `TalentID` = %d LIMIT 1", $talent_id);
                if(!$talent_spells || !is_array($talent_spells) || ($rank >= 0 && !isset($talent_spells['Rank_' . $rank + 1]))) {
                    Armory::Log()->writeError('%s : talent ranks for talent %d was not found in DB!', __METHOD__, $talent_id);
                    return false;
                }
                $sql_data = array(
                    'activeSpec' => array(
                        sprintf('SELECT `spell` FROM `character_talent` WHERE `spell` IN (%s) AND `guid`=%%d AND `spec`=%%d LIMIT 1', $talent_spells['Rank_1'] . ', ' . $talent_spells['Rank_2'] . ', ' . $talent_spells['Rank_3'] . ', ' . $talent_spells['Rank_4'] . ', ' . $talent_spells['Rank_5']),
                        sprintf('SELECT 1 FROM `character_talent` WHERE `spell`=%d AND `guid`=%%d AND `spec`=%%d', $rank == -1 ? $talent_spells['Rank_1'] : $talent_spells['Rank_' . ($rank + 1)])
                    ),
                    'spec' => array(
                        sprintf('SELECT `spell` FROM `character_talent` WHERE `spell` IN (%s) AND `guid`=%%d LIMIT 1', $talent_spells['Rank_1'] . ', ' . $talent_spells['Rank_2'] . ', ' . $talent_spells['Rank_3'] . ', ' . $talent_spells['Rank_4'] . ', ' . $talent_spells['Rank_5']),
                        sprintf('SELECT 1 FROM `character_talent` WHERE `spell`=%d AND `guid`=%%d', $rank == -1 ? $talent_spells['Rank_1'] : $talent_spells['Rank_' . ($rank + 1)])
                    )
                );
                break;
            default:
                Armory::Log()->writeError('%s : unknown server type %d!', __METHOD__, $this->GetServerType());
                return false;
                break;
        }
        
        if($active_spec) {
            if($rank == -1) {
                $has = $this->db->selectCell($sql_data['activeSpec'][0], $this->guid, $this->activeSpec);
            }
            elseif($rank >= 0) {
                $has = $this->db->selectCell($sql_data['activeSpec'][1], $this->guid, $this->activeSpec);
            }
        }
        else {
            if($rank == -1) {
                $has = $this->db->selectCell($sql_data['spec'][0], $this->guid);
            }
            elseif($rank >= 0) {
                $has = $this->db->selectCell($sql_data['spec'][1], $this->guid);
            }
        }
        if($this->GetServerType() == SERVER_TRINITY && $rank == -1 && $has != false) {
            for($i = 0; $i < 5; $i++) {
                if(isset($talent_spells['Rank_' . ($i + 1)]) && $talent_spells['Rank_' . ($i + 1)] == $has) {
                    return $i;
                }
            }
        }
        if($this->GetServerType() == SERVER_MANGOS && $has) {
            return $has - 1;
        }
        return $has;
    }
    
    /**
     * Returns talent rank by talent ID (if player has this talent)
     * @category Characters class
     * @access   public
     * @param    int $talent_id
     * @param    bool $active_spec = true
     * @return   int
     **/
    public function GetTalentRankByID($talent_id, $active_spec = true) {
        return $this->HasTalent($talent_id, $active_spec);
    }
    
    /**
     * Returns skill value by skill ID (if player has this skill)
     * @category Characters class
     * @access   public
     * @param    int $skill
     * @return   int
     **/
    public function GetSkillValue($skill) {
        return $this->db->selectCell("SELECT `value` FROM `character_skills` WHERE `guid`=%d AND `skill`=%d", $this->guid, $skill);
    }
    
    /**
     * Returns reputation value with selected faction. If $returnAsRank == true, function will return reputation rank ID.
     * @category Characters class
     * @access   public
     * @param    int $faction_id
     * @param    bool $returnAsRank = false
     * @return   int
     **/
    public function GetReputationWith($faction_id, $returnAsRank = false) {
        $standing = $this->db->selectCell("SELECT `standing` FROM `character_reputation` WHERE `faction`=%d AND `guid`=%d", $faction_id, $this->guid);
        if($returnAsRank == true) {
            $PointsInRank = array(36000, 3000, 3000, 3000, 6000, 12000, 21000, 1000);
            $RepRanks  = array(REP_HATED, REP_HOSTILE, REP_UNFRIENDLY, REP_NEUTRAL, REP_FRIENDLY, REP_HONORED, REP_REVERED, REP_EXALTED);
            $limit = 43000;
            for($i = 7; $i >= 0; $i--) {
                $limit -= $PointsInRank[$i];
                if($standing >= $limit) {
                    return $RepRanks[$i];
                }
            }
        }
        return $standing;
    }
    
    /**
     * Load character inventory (equipped items only). Must be called from Characters::BuildCharacter() only!
     * @category Characters class
     * @access   private
     * @return   bool
     **/
    private function LoadInventory() {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid is not defined.', __METHOD__);
            return false;
        }
        switch($this->m_server) {
            case SERVER_MANGOS:
                $inv = $this->db->select("SELECT `item`, `slot`, `item_template`, `bag` FROM `character_inventory` WHERE `bag` = 0 AND `slot` < %d AND `guid` = %d", INV_MAX, $this->guid);
                break;
            case SERVER_TRINITY:
                $inv = $this->db->select("SELECT `item`, `slot`, `bag` FROM `character_inventory` WHERE `bag` = 0 AND `slot` < %d AND `guid` = %d", INV_MAX, $this->guid);
        }
        if(!$inv) {
            return false;
        }
        foreach($inv as $item) {
            $item['enchants'] = $this->GetCharacterEnchant(Utils::GetItemSlotTextBySlotId($item['slot']));
            $this->m_items[$item['slot']] = new Item($this->m_server);
            $this->m_items[$item['slot']]->LoadFromDB($item, $this->guid, $this->db);
            // Do not load itemproto from here!
        }
        return true;
    }
    
    /**
     * Load equipped item from character_inventory (by SLOT ID)
     * @category Characters class
     * @access   public
     * @param    int $slotID
     * @param    bool $addToInventoryStorage = true
     * @return   mixed
     **/
    private function LoadItemFromDBBySlotID($slotID, $addToInventoryStorage = true) {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid is not defined.', __METHOD__);
            return false;
        }
        switch($this->m_server) {
            case SERVER_MANGOS:
                $inv = $this->db->selectRow("SELECT `item`, `slot`, `item_template`, `bag` FROM `character_inventory` WHERE `bag` = 0 AND `slot` = %d AND `guid` = %d LIMIT 1", $slotID, $this->guid);
                break;
            case SERVER_TRINITY:
                $inv = $this->db->selectRow("SELECT `item`, `slot`, `bag` FROM `character_inventory` WHERE `bag` = 0 AND `slot` = %d AND `guid` = %d LIMIT 1", $slotID, $this->guid);;
                break;
        }
        if(!$inv) {
            return false;
        }
        if($addToInventoryStorage == true) {
            $inv['enchants'] = $this->GetCharacterEnchant(Utils::GetItemSlotTextBySlotId($item['slot']));
            $this->m_items[$inv['slot']] = new Item($this->m_server);
            $this->m_items[$inv['slot']]->LoadFromDB($inv, $this->guid, $this->GetDB());
            // Do not load itemproto from here!
        }
        return $inv;
    }
    
    /**
     * Return Item by SlotID
     * Note: m_items must be initialized in Characters::BuildCharacter()!
     * @category Characters class
     * @access   public
     * @param    int $slot
     * @return   object
     **/
    public function GetItemBySlot($slot) {
        if(!isset($this->m_items[$slot])) {
            Armory::Log()->writeError('%s : slot %d is empty (character: %s, GUID: %d).', __METHOD__, $slot, $this->name, $this->guid);
            return null;
        }
        elseif(!is_object($this->m_items[$slot])) {
            // Try to reload item
            $item_temporary = $this->LoadItemFromDBBySlotID($slot, true);
            if($item_temporary->IsCorrect()) {
                return $item_temporary;
            }
            Armory::Log()->writeError('%s : slot %d is not an object (character: %s, GUID: %d).', __METHOD__, $slot, $this->name, $this->guid);
            return null;
        }
        elseif(!$this->m_items[$slot]->IsCorrect()) {
            Armory::Log()->writeError('%s : item in slot %d has wrong data (Item::IsCorrect() fail)', __METHOD__, $slot);
            return null;
        }
        return $this->m_items[$slot];
    }
    
    /**
     * Return item handler by item entry (from item storage)
     * Note: m_items must be initialized in Characters::BuildCharacter()!
     * @category Characters class
     * @access   public
     * @param    int $entry
     * @return   object
     **/
    public function GetItemByEntry($entry) {
        if(!is_array($this->m_items)) {
            Armory::Log()->writeError('%s : m_items must be an array!', __METHOD__);
            return false;
        }
        foreach($this->m_items as $mItem) {
            if($mItem->GetEntry() == $entry) {
                return $mItem;
            }
        }
        return false;
    }
    
    /**** DEVELOPMENT SECTION ****/
    
    /**
     * Checks if player has any active pet
     * @category Characters class
     * @access   public
     * @return   bool
     **/
    public function IsHaveAnyPet() {
        if(!$this->IsCanHavePet()) {
            return false;
        }
        return $this->db->selectCell("SELECT 1 FROM `character_pet` WHERE `owner` = %d AND `PetType` = 1", $this->GetGUID());
    }
    
    /**
     * Checks if player mana user
     * @category Characters class
     * @access   private
     * @return   bool
     **/
    private function IsManaUser() {
        if(!in_array($this->class, array(CLASS_DK, CLASS_ROGUE, CLASS_WARRIOR/*, CLASS_HUNTER*/))) {
            return true;
        }
        return false;
    }
    
    /**
     * Checks if player can has pet.
     * Note: self::CalculatePetTalents() must has internal check (CLASS_HUNTER)
     * @category Characters class
     * @access   private
     * @return   bool
     **/
    private function IsCanHavePet() {
        if(in_array($this->class, array(CLASS_DK, CLASS_HUNTER, CLASS_WARLOCK))) {
            return true;
        }
        return false;
    }
}
?>