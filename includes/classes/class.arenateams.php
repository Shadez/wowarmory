<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 493
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

Class Arenateams {

    public $arenateamid = 0;
    public $teamname = null;
    public $captainguid;
    public $teamfaction;
    public $teamlogostyle;
    public $teamtype;
    public $players;
    public $guid;
    private $gameid = false;
    private $m_server;
    
    public function Arenateams() {
        $this->m_server = Armory::$currentRealmInfo['type'];
    }
    
    /**
     * Builds team info
     * @category Arenateams class
     * @access   public
     * @return   bool
     **/
    public function InitTeam() {
        if(!$this->teamname && !$this->arenateamid) {
            Armory::Log()->writeError('%s : teamname and arenateamid are not defined', __METHOD__);
            return false;
        }
        if($this->teamname != null) {
            if($this->m_server == SERVER_MANGOS) {
                $arenaInfo = Armory::$cDB->selectRow("SELECT `arenateamid`, `captainguid`, `type`, `name` FROM `arena_team` WHERE `name` = '%s' LIMIT 1", $this->teamname);
            }
            else {
                $arenaInfo = Armory::$cDB->selectRow("SELECT `arenaTeamId` AS `arenateamid`, `captainGuid` AS `captainguid`, `type`, `name` FROM `arena_team` WHERE `name` = '%s' LIMIT 1", $this->teamname);
            }
        }
        elseif($this->arenateamid != 0) {
            if ($this->m_server == SERVER_MANGOS) {
                $arenaInfo = Armory::$cDB->selectRow("SELECT `arenateamid`, `captainguid`, `type`, `name` FROM `arena_team` WHERE `arenateamid` = %d LIMIT 1", $this->arenateamid);
            }
            else {
                $arenaInfo = Armory::$cDB->selectRow("SELECT `arenaTeamId` AS `arenateamid`, `captainGuid` AS `captainguid`, `type`, `name` FROM `arena_team` WHERE `arenaTeamId` = %d LIMIT 1", $this->arenateamid);
            }
        }
        if(!$arenaInfo || !isset($arenaInfo)) {
            Armory::Log()->writeError('%s : unable to find arenateam %s (id: %d)!', __METHOD__, $this->teamname, $this->arenateamid);
            return false;
        }
        $this->arenateamid   = $arenaInfo['arenateamid'];
        $this->captainguid   = $arenaInfo['captainguid'];
        $this->teamname      = $arenaInfo['name'];
        $this->teamlogostyle = self::GetArenaTeamEmblem($this->arenateamid);
        $this->teamfaction   = Utils::GetFactionId(Armory::$cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=%d LIMIT 1", $this->captainguid));
        $this->teamtype      = $arenaInfo['type'];
        self::GetTeamList();
    }
    
    /**
     * Returns array with team info, member list and stats
     * @category Arenateams class
     * @access   public
     * @return   array
     **/
    public function GetArenaTeamInfo() {
        if(!$this->arenateamid) {
            Armory::Log()->writeError('%s : arenateamid not defined', __METHOD__);
            return false;
        }
        $arenateaminfo = array();
        switch($this->m_server) {
            case SERVER_MANGOS:
                $arenateaminfo['data'] = Armory::$cDB->selectRow("
                SELECT
                `rating`,
                `games_week`   AS `gamesPlayed`,
                `wins_week`    AS `gamesWon`,
                `rank`         AS `ranking`,
                `games_season` AS `seasonGamesPlayed`,
                `wins_season`  AS `seasonGamesWon`
                 FROM `arena_team_stats`
                 WHERE `arenateamid`=%d", $this->arenateamid);
                break;
            case SERVER_TRINITY:
                $arenateaminfo['data'] = Armory::$cDB->selectRow("
                SELECT
                `rating`,
                `weekGames`   AS `gamesPlayed`,
                `weekWeens`   AS `gamesWon`,
                `rank`        AS `ranking`,
                `seasonGames` AS `seasonGamesPlayed`,
                `seasonWins`  AS `seasonGamesWon`
                 FROM `arena_team`
                 WHERE `arenateamid`=%d", $this->arenateamid);
                $sql = "";
                break;
        }
        if(!$arenateaminfo['data']) {
            Armory::Log()->writeError('%s : unable to get data from DB for arenateam %d (%s)', __METHOD__, $this->arenateamid, $this->teamname);
            return false;
        }
        $arenateaminfo['data']['battleGroup'] = Armory::$armoryconfig['defaultBGName'];
        $arenateaminfo['data']['lastSeasonRanking'] = 0;
        $arenateaminfo['data']['name'] = $this->teamname;
        $arenateaminfo['data']['realm'] = Armory::$currentRealmInfo['name'];
        $arenateaminfo['data']['realmName'] = sprintf(Armory::$currentRealmInfo['name']);
        $arenateaminfo['data']['realmUrl'] = sprintf('b=%s&r=%s&ts=%d', urlencode(Armory::$armoryconfig['defaultBGName']), urlencode(Armory::$currentRealmInfo['name']), $this->teamtype);
        $arenateaminfo['data']['relevance'] = 0;
        $arenateaminfo['data']['season'] = 0;
        $arenateaminfo['data']['size'] = $this->teamtype;
        $arenateaminfo['data']['teamSize'] = $this->teamtype;
        $arenateaminfo['data']['teamUrl'] = sprintf('r=%s&t=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($this->teamname));
        $arenateaminfo['data']['url'] = sprintf('r=%s&ts=%d&t=%s', urlencode(Armory::$currentRealmInfo['name']), $this->teamtype, urlencode($this->teamname));
        $arenateaminfo['emblem'] = self::GetArenaTeamEmblem();
        if(is_array($this->players)) {
            $arenateaminfo['members'] = $this->players;
        }
        else {
            $arenateaminfo['members'] = self::GetTeamList();
        }
        $arenateaminfo['data']['factionId'] = Utils::GetFactionId($arenateaminfo['members'][0]['raceId']);
        return $arenateaminfo;
    }
    
    /**
     * Checks is arena team exists
     * @category Arenateams class
     * @access   public
     * @return   bool
     **/
    public function IsTeam() {
        if(!$this->teamname && !$this->arenateamid) {
            Armory::Log()->writeError('%s : teamname and arenateamid are not defined', __METHOD__);
            return false;
        }
        if($this->teamname != null) {
            return Armory::$cDB->selectCell("SELECT 1 FROM `arena_team` WHERE `name`='%s' LIMIT 1", $this->teamname);
        }
        elseif($this->arenateamid != 0) {
            return Armory::$cDB->selectCell("SELECT 1 FROM `arena_team` WHERE `arenateamid`=%d LIMIT 1", $this->arenateamid);
        }
    }
    
    /**
     * Generates and returns info about character's (this->guid) arena teams.
     * @category Arenateams class
     * @access   public
     * @return   array
     **/
    public function GetCharacterArenaTeamInfo() {
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $team_names = Armory::$cDB->select("SELECT `name` FROM `arena_team` WHERE `arenateamid` IN (SELECT `arenateamid` FROM `arena_team_member` WHERE `guid`=%d)", $this->guid);
        if(!$team_names) {
            return false;
        }
        $count_teams = count($team_names);
        $teams_result = array();
        for($i=0;$i<$count_teams;$i++) {
            $this->teamname = $team_names[$i]['name'];
            self::InitTeam();
            $teams_result[$i] = self::GetArenaTeamInfo();
        }
        return $teams_result;
    }
    
    /**
     * Generates arena team member list
     * @category Arenateams class
     * @access   public
     * @return   bool
     **/
    public function GetTeamList() {
        if($this->m_server == SERVER_MANGOS) {
            $this->players = Armory::$cDB->select("
            SELECT
            `arena_team_member`.`played_season` AS `seasonGamesPlayed`,
            `arena_team_member`.`wons_season` AS `seasonGamesWon`,
            `arena_team_member`.`personal_rating` AS `contribution`,
            `characters`.`guid`,
            `characters`.`name`,
            `characters`.`race` AS `raceId`,
            `characters`.`class` AS `classId`,
            `characters`.`gender` AS `genderId`
            FROM `arena_team_member` AS `arena_team_member`
            LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team_member`.`guid`
            WHERE `arena_team_member`.`arenateamid`=%d", $this->arenateamid);
        }
        elseif($this->m_server == SERVER_TRINITY) {
            switch($this->teamtype) {
                case 2:
                default:
                    $slot = 0;
                    break;
                case 3:
                    $slot = 1;
                    break;
                case 5:
                    $slot = 2;
                    break;
            }
            $this->players = Armory::$cDB->select("
            SELECT
            `arena_team_member`.`seasonGames` AS `seasonGamesPlayed`,
            `arena_team_member`.`seasonWins` AS `seasonGamesWon`,
            `character_arena_stats`.`personalRating` AS `contribution`,
            `characters`.`guid`,
            `characters`.`name`,
            `characters`.`race` AS `raceId`,
            `characters`.`class` AS `classId`,
            `characters`.`gender` AS `genderId`
            FROM `arena_team_member` AS `arena_team_member`
            LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team_member`.`guid`
            LEFT JOIN `character_arena_stats` AS `character_arena_stats` ON `character_arena_stats`.`guid`=`arena_team_member`.`guid`
            WHERE `arena_team_member`.`arenateamid` = %d
            AND `character_arena_stats`.`slot` = %d", $this->arenateamid, $slot);
        }
        if(!$this->players) {
            Armory::Log()->writeLog('%s : unable to get player list for arena team %d (%s)', __METHOD__, $this->arenateamid, $this->teamname);
            return;
        }
        $count_players = count($this->players);
        for($i = 0; $i < $count_players; $i++) {
            if($this->players[$i]['guildId'] = Armory::$cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=%d", $this->players[$i]['guid'])) {
                $this->players[$i]['guild'] = Armory::$cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=%d", $this->players[$i]['guildId']);
                $this->players[$i]['guildUrl'] = sprintf('r=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($this->players[$i]['guild']));
            }
            $this->players[$i]['battleGroup'] = Armory::$armoryconfig['defaultBGName'];
            $this->players[$i]['charUrl'] = sprintf('r=%s&cn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($this->players[$i]['name']));
            unset($this->players[$i]['guid']);
        }
        return true;
    }
    
    /**
     * Builds arena ladder list
     * @category Arenateams class
     * @access   public
     * @param    int $type
     * @param    bool $num = false
     * @param    string $order = 'rating'
     * @param    string $sort = 'ASC'
     * @return   array
     **/
    public function BuildArenaLadderList($type, $page, $num = false, $order = 'rating', $sort = 'ASC') {
        if($num == true) {
            $summary = 0;
            foreach(Armory::$realmData as $realm_info) {
                $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters']);
                $current_count = $db->selectCell("SELECT COUNT(`arena_team`.`arenateamid`) FROM `arena_team` AS `arena_team` LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid` = `arena_team`.`arenateamid` WHERE `arena_team`.`type` = %d AND `arena_team_stats`.`rank` > 0", $type);
                $summary += $current_count;
            }
            return $summary;
        }
        $result_areanteams = array();
        $i = 0;
        foreach(Armory::$realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters']);
            if($order == 'lose') {
                // Special sorting
                switch($realm_info['type']) {
                    default:
                    case SERVER_MANGOS:
                        $realmArenaTeamInfo = $db->select("
                        SELECT
                        `arena_team`.`arenateamid`,
                        `arena_team`.`name`,
                        `arena_team_stats`.`rating`,
                        `arena_team_stats`.`games_week`  AS `gamesPlayed`,
                        `arena_team_stats`.`wins_week`   AS `gamesWon`,
                        `arena_team_stats`.`rank`   AS `ranking`,
                        `arena_team_stats`.`games_season` AS `seasonGamesPlayed`,
                        `arena_team_stats`.`wins_season`  AS `seasonGamesWon`,
                        `characters`.`race`,
                        `arena_team_stats`.`games_season`-`arena_team_stats`.`wins_season` AS `lose`
                        FROM `arena_team` AS `arena_team`
                        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenateamid`
                        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team`.`captainguid`
                        WHERE `arena_team`.`type`=%d AND `arena_team_stats`.`rank` > 0
                        ORDER BY `lose` %s LIMIT %d, 20", $type, $sort, $page);
                        break;
                    case SERVER_TRINITY:
                        $realmArenaTeamInfo = $db->select("
                        SELECT
                        `arena_team`.`arenaTeamId` AS `arenateamid`,
                        `arena_team`.`name`,
                        `arena_team_stats`.`rating`,
                        `arena_team_stats`.`weekGames`   AS `gamesPlayed`,
                        `arena_team_stats`.`weekWins`    AS `gamesWon`,
                        `arena_team_stats`.`rank`        AS `ranking`,
                        `arena_team_stats`.`seasonGames` AS `seasonGamesPlayed`,
                        `arena_team_stats`.`seasonWins`  AS `seasonGamesWon`,
                        `characters`.`race`,
                        `arena_team_stats`.`seasonGames`-`arena_team_stats`.`seasonWins` AS `lose`
                        FROM `arena_team` AS `arena_team`
                        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenateamid`
                        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team`.`captainguid`
                        WHERE `arena_team`.`type`=%d AND `arena_team_stats`.`rank` > 0
                        ORDER BY `lose` %s LIMIT %d, 20", $type, $sort, $page);
                        break;
                }
            }
            else {
                switch($realm_info['type']) {
                    default:
                    case SERVER_MANGOS:
                        $realmArenaTeamInfo = $db->select("
                        SELECT
                        `arena_team`.`arenateamid`,
                        `arena_team`.`name`,
                        `arena_team_stats`.`rating`,
                        `arena_team_stats`.`games_week`  AS `gamesPlayed`,
                        `arena_team_stats`.`wins_week`   AS `gamesWon`,
                        `arena_team_stats`.`rank`   AS `ranking`,
                        `arena_team_stats`.`games_season` AS `seasonGamesPlayed`,
                        `arena_team_stats`.`wins_season`  AS `seasonGamesWon`,
                        `characters`.`race`
                        FROM `arena_team` AS `arena_team`
                        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenaTeamId`
                        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team`.`captainGuid`
                        WHERE `arena_team`.`type`=%d AND `arena_team_stats`.`rank` > 0
                        ORDER BY %s %s LIMIT %d, 20", $type, $order, $sort, $page);
                        break;
                    case SERVER_TRINITY:
                        $realmArenaTeamInfo = $db->select("
                        SELECT
                        `arena_team`.`arenaTeamId` AS `arenateamid`,
                        `arena_team`.`name`,
                        `arena_team_stats`.`rating`,
                        `arena_team_stats`.`weekGames`   AS `gamesPlayed`,
                        `arena_team_stats`.`weekWins`    AS `gamesWon`,
                        `arena_team_stats`.`rank`        AS `ranking`,
                        `arena_team_stats`.`seasonGames` AS `seasonGamesPlayed`,
                        `arena_team_stats`.`seasonWins`  AS `seasonGamesWon`,
                        `characters`.`race`
                        FROM `arena_team` AS `arena_team`
                        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenaTeamId`
                        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team`.`captainGuid`
                        WHERE `arena_team`.`type`=%d AND `arena_team_stats`.`rank` > 0
                        ORDER BY %s %s LIMIT %d, 20", $type, $order, $sort, $page);
                        break;
                }
            }
            foreach($realmArenaTeamInfo as $team) {
                $result_areanteams[$i]['data'] = $team;
                $result_areanteams[$i]['data']['num'] = $i+1;
                $result_areanteams[$i]['data']['battleGroup'] = Armory::$armoryconfig['defaultBGName'];
                $result_areanteams[$i]['data']['faction'] = null;
                $result_areanteams[$i]['data']['factionId'] = Utils::GetFactionId($result_areanteams[$i]['data']['race']);
                $result_areanteams[$i]['data']['lastSeasonRanking'] = null;
                $result_areanteams[$i]['data']['realm'] = $realm_info['name'];
                $result_areanteams[$i]['data']['realmUrl'] = sprintf('b=%s&r=%s&ts=%d&select=%s', urlencode(Armory::$armoryconfig['defaultBGName']), urlencode($realm_info['name']), $type, urlencode($team['name']));
                $result_areanteams[$i]['data']['relevance'] = 0;
                $result_areanteams[$i]['data']['season'] = 0;
                $result_areanteams[$i]['data']['size'] = $type;
                $result_areanteams[$i]['data']['teamSize'] = $type;
                $result_areanteams[$i]['data']['teamUrl'] = sprintf('r=%s&ts=%d&t=%s', urlencode(Armory::$armoryconfig['defaultBGName']), urlencode($realm_info['name']), $type, urlencode($team['name']));
                $result_areanteams[$i]['emblem'] = self::GetArenaTeamEmblem($team['arenateamid'], $db);
                unset($result_areanteams[$i]['data']['arenateamid'], $result_areanteams[$i]['data']['captainguid']);
                $i++;
            }
        }
        if(!isset($result_areanteams[0]['data'])) {
            return false;
        }
        return $result_areanteams;
    }
    
    /**
     * Returns arena team emblem info.
     * @category Arenateams class
     * @access   public
     * @param    int $teamId = 0
     * @param    object $db = null
     * @return   array
     **/
    public function GetArenaTeamEmblem($teamId = 0, $db = null) {
        if($teamId == 0) {
            $teamId = $this->arenateamid;
        }
        if($db == null) {
            $arenaTeamEmblem = Armory::$cDB->selectRow("SELECT `BackgroundColor` AS `background`, `BorderColor` AS `borderColor`, `BorderStyle` AS `borderStyle`, `EmblemColor` AS `iconColor`, `EmblemStyle` AS `iconStyle` FROM `arena_team` WHERE `arenateamid`=%d", $teamId);
            
            // Displaying correct Team Emblem
            // We have DECIMAL value here in DB (4294106805 e.g.)
            // We need to reduce it to 255 (4294106550)
            // Then convert it to HEX (FFF2DDB6)
            // Remove 2 first symbols FF (F2DDB6)
            // And somehow add '0x' substring to our HEX value (0xF2DDB6).
            // If I'm doing it wrong (and I'm totally sure that I'm doing it in wrong way),
            // please report on GitHub.com/Shadez/wowarmory/issues/
            
            $arenaTeamEmblem['background'] = '0x' . substr(dechex($arenaTeamEmblem['background']-255), 2);
            $arenaTeamEmblem['borderColor'] = '0x' . substr(dechex($arenaTeamEmblem['borderColor']-255), 2);
            $arenaTeamEmblem['iconColor'] = '0x' . substr(dechex($arenaTeamEmblem['iconColor']-255), 2);
            return $arenaTeamEmblem;
        }
        elseif(is_object($db)) {
            $arenaTeamEmblem = $db->selectRow("SELECT `BackgroundColor` AS `background`, `BorderColor` AS `borderColor`, `BorderStyle` AS `borderStyle`, `EmblemColor` AS `iconColor`, `EmblemStyle` AS `iconStyle` FROM `arena_team` WHERE `arenateamid`=%d", $teamId);
            $arenaTeamEmblem['background'] = '0x' . substr(dechex($arenaTeamEmblem['background']-255), 2);
            $arenaTeamEmblem['borderColor'] = '0x' . substr(dechex($arenaTeamEmblem['borderColor']-255), 2);
            $arenaTeamEmblem['iconColor'] = '0x' . substr(dechex($arenaTeamEmblem['iconColor']-255), 2);
            return $arenaTeamEmblem;
        }
    }
    
    /**
     * Count all arena teams (by type) in all available realms.
     * @category Arenateams class
     * @access   public
     * @param    int $type
     * @return   int
     **/
    public function CountArenaTeams($type) {
        $summary = 0;
        foreach(Armory::$realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters']);
            $current_count = $db->selectCell("SELECT COUNT(`arenateamid`) FROM `arena_team` WHERE `type`=%d", $type);
            $summary += $current_count;
        }
        return $summary;
    }
    
    /**
     * Returns number of pages (arena ladder)
     * @category Arenateams class
     * @access   public
     * @param    int $type
     * @return   int
     **/
    public function CountPageNum($type) {
        return round(self::CountArenaTeams($type) / 20);
    }
    
    /**
     * Sets game id (arena chart)
     * @category Arenateams class
     * @access   public
     * @param    int $gameid
     * @return   bool
     **/
    public function SetGameID($gameid) {
        $this->gameid = $gameid;
        return true;
    }
    
    /**
     * Returns game id (arena ladder)
     * @category Arenateams class
     * @access   public
     * @return   int
     **/
    public function GetGameID() {
        return $this->gameid;
    }
    
    /**
     * Generates game info (by ID (this->gameid))
     * @category Arenateams class
     * @access   public
     * @return   array
     **/
    public function GetGameInfo() {
        if(!$this->gameid || $this->gameid === 0) {
            Armory::Log()->writeError('%s : gameid not provided', __METHOD__);
            return false;
        }
        $game_info = Armory::$cDB->select("
        SELECT
        `armory_game_chart`.`teamid`,
        `armory_game_chart`.`guid`,
        `armory_game_chart`.`changeType`,
        `armory_game_chart`.`ratingChange`,
        `armory_game_chart`.`teamRating`,
        `armory_game_chart`.`damageDone`,
        `armory_game_chart`.`deaths`,
        `armory_game_chart`.`healingDone`,
        `armory_game_chart`.`damageTaken`,
        `armory_game_chart`.`healingTaken`,
        `armory_game_chart`.`killingBlows`,
        `armory_game_chart`.`mapId`,
        `armory_game_chart`.`start`,
        `armory_game_chart`.`end`,
        `characters`.`race` AS `raceId`,
        `characters`.`class` AS `classId`,
        `characters`.`gender` AS `genderId`,
        `characters`.`name` AS `characterName`,
        `arena_team`.`BackgroundColor` AS `emblemBackground`,
        `arena_team`.`BorderColor` AS `emblemBorderColor`,
        `arena_team`.`BorderStyle` AS `emblemBorderStyle`,
        `arena_team`.`EmblemColor` AS `emblemIconColor`,
        `arena_team`.`EmblemStyle` AS `emblemIconStyle`,
        `arena_team`.`type`,
        `arena_team`.`name`
        FROM `armory_game_chart` AS `armory_game_chart`
        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`armory_game_chart`.`guid`
        LEFT JOIN `arena_team` AS `arena_team` ON `arena_team`.`arenateamid`=`armory_game_chart`.`teamid`
        WHERE `armory_game_chart`.`gameid`=%d", $this->gameid);
        if(!$game_info) {
            Armory::Log()->writeError('%s : unable to get data from characters DB for gameID %d', __METHOD__, $this->gameid);
            return false;
        }
        $chart_teams = array();
        $chart_teams['gameData'] = array(
            'battleGroup' => Armory::$armoryconfig['defaultBGName'],
            'id' => $this->gameid,
            'map' => Armory::$aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_maps` WHERE `id`=%d LIMIT 1", Armory::GetLocale(), $game_info[0]['mapId']),
            'matchLength' => $game_info[0]['end']-$game_info[0]['start'],
            'teamSize' => $game_info[0]['type']
        );
        foreach($game_info as $team_member) {
            $temp_id = $team_member['teamid'];
            if(!isset($chart_teams[$temp_id])) {
                $chart_teams[$temp_id] = array();
                $chart_teams[$temp_id]['teamData'] = array(
                    'deleted' => ($this->TeamExists($temp_id)) ? 'false' : 'true',
                    'emblemBackground' => $team_member['emblemBackground'],
                    'emblemBorderColor' => $team_member['emblemBorderColor'],
                    'emblemBorderStyle' => $team_member['emblemBorderStyle'],
                    'emblemIconColor' => $team_member['emblemIconColor'],
                    'emblemIconStyle' => $team_member['emblemIconStyle'],
                    'name' => $team_member['name'],
                    'ratingDelta' => ($team_member['changeType'] == 1) ? $team_member['ratingChange'] : '-' . $team_member['ratingChange'],
                    'ratingNew' => ($team_member['changeType'] == 1) ? $team_member['teamRating']+$team_member['ratingChange'] : $team_member['teamRating'] - $team_member['ratingChange'],
                    'realm' => Armory::$currentRealmInfo['name'],
                    'result' => ($team_member['changeType'] == 1) ? 'win' : 'loss',
                    'teamUrl' => sprintf('r=%s&ts=%d&t=%s', urlencode(Armory::$currentRealmInfo['name']), $team_member['type'], urlencode($team_member['name']))
                );
            }
            $chart_teams[$temp_id]['members'][] = array(
                'characterName' => $team_member['characterName'],
                'classId' => $team_member['classId'],
                'damageDone' => $team_member['damageDone'],
                'damageTaken' => $team_member['damageTaken'],
                'deleted' => 'false',
                'died' => ($team_member['deaths'] == 0) ? 'false' : 'true',
                'genderId' => $team_member['genderId'],
                'healingDone' => $team_member['healingDone'],
                'healingTaken' => $team_member['healingTaken'],
                'killingBlows' => $team_member['killingBlows'],
                'raceId' => $team_member['raceId'],
                'url' => sprintf('r=%s&cn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($team_member['characterName']))
            );
        }
        return $chart_teams;
    }
    
    /**
     * Checks is team exists
     * @category Arenateams class
     * @access   public
     * @param    int $teamId
     * @return   bool
     **/
    public function TeamExists($teamId) {
        return Armory::$cDB->selectCell("SELECT 1 FROM `arena_team` WHERE `arenateamid`=%d LIMIT 1", $teamId);
    }
    
    /**
     * Builds game list for current arena team
     * @category Arenateams class
     * @access   public
     * @return   array
     **/
    public function BuildGameChart() {
        if(!$this->arenateamid) {
            Armory::Log()->writeError('%s : arenateamid was not provided', __METHOD__);
            return false;
        }
        $game_ids = Armory::$cDB->select("SELECT DISTINCT `gameid` FROM `armory_game_chart` WHERE `teamid`=%d", $this->arenateamid);
        if(!$game_ids) {
            Armory::Log()->writeLog('%s : unable to find any game for teamId %d', __METHOD__, $this->arenateamid);
            return false;
        }
        if(count($game_ids) < 2) {
            Armory::Log()->writeLog('%s : arenateamid %d has less than 2 matches played. Showing results has been disabled to prevent browser crash.', __METHOD__, $this->arenateamid);
            return false;
        }
        $all_games = array();
        $counter = count($game_ids);
        foreach($game_ids as $game) {
            $all_games[] = $game['gameid'];
        }
        $game_chart = Armory::$cDB->select("
        SELECT
        `armory_game_chart`.`gameid`,
        `armory_game_chart`.`teamid`,
        `armory_game_chart`.`start`,
        `armory_game_chart`.`teamRating`,
        `armory_game_chart`.`changeType`,
        `armory_game_chart`.`ratingChange`,
        `armory_game_chart`.`guid`,
        `arena_team`.`name`,
        `arena_team`.`type`
        FROM `armory_game_chart` AS `armory_game_chart`
        LEFT JOIN `arena_team` AS `arena_team` ON `arena_team`.`arenateamid`=`armory_game_chart`.`teamid`
        WHERE `armory_game_chart`.`gameid` IN (%s) AND `armory_game_chart`.`teamid` <> %d", $all_games, $this->arenateamid);
        if(!$game_chart) {
            Armory::Log()->writeError('%s : game_ids were fetched from DB, but script was unable to get data for these matches from characters DB (arenateamid:%d)', __METHOD__, $this->arenateamid);
            return false;
        }
        $chart_data = array();
        foreach($game_chart as $team) {
            if(!isset($chart_data[$team['gameid']])) { // Do not add same games more than 1 time
                $chart_data[$team['gameid']] = array(
                    'deleted' => ($this->TeamExists($team['teamid'])) ? 'false' : 'true',
                    'id' => $team['gameid'],
                    'ot' => $team['name'],
                    'r' => ($team['changeType'] == 1) ? $team['teamRating'] + $team['ratingChange'] : $team['teamRating']-$team['ratingChange'],
                    'reamOffset' => 3600000, // hardcoded
                    'st' => $team['start'], // needs to be fixed (change to timestamp)
                    'teamUrl' => sprintf('r=%s&ts=%d&t=%s', urlencode(Armory::$currentRealmInfo['name']), $team['type'], urlencode($team['name']))
                );
            }
        }
        return $chart_data;
    }
    
    /**
     * Build opponents list for current arena team
     * @category Arenateams class
     * @access   public
     * @return   array
     **/
    public function BuildOpposingTeamList() {
        if(!$this->arenateamid) {
            Armory::Log()->writeError('%s : arenateamid not provided', __METHOD__);
            return false;
        }
        $game_ids = Armory::$cDB->select("SELECT DISTINCT `gameid` FROM `armory_game_chart` WHERE `teamid`=%d", $this->arenateamid);
        if(!$game_ids) {
            Armory::Log()->writeLog('%s : unable to find any game for teamId %d', __METHOD__, $this->arenateamid);
            return false;
        }
        $all_games = array();
        $counter = count($game_ids);
        foreach($game_ids as $game) {
            $all_games[] = $game['gameid'];
        }
        $game_chart = Armory::$cDB->select("
        SELECT
        `armory_game_chart`.`gameid`,
        `armory_game_chart`.`teamid`,
        `armory_game_chart`.`guid`,
        COUNT(`armory_game_chart`.`teamid`) AS `countTeam`,
        `arena_team`.`name`,
        `arena_team`.`type`
        FROM `armory_game_chart` AS `armory_game_chart`
        LEFT JOIN `arena_team` AS `arena_team` ON `arena_team`.`arenateamid`=`armory_game_chart`.`teamid`
        WHERE `armory_game_chart`.`gameid` IN (%s) AND `armory_game_chart`.`teamid` <> %d
        GROUP BY `armory_game_chart`.`gameid`", $all_games, $this->arenateamid);
        if(!$game_chart) {
            Armory::Log()->writeError('%s : game_ids were fetched from DB, but script was unable to get data for these matches from characters DB (arenateamid:%d)', __METHOD__, $this->arenateamid);
            return false;
        }
        $chart_data = array();
        foreach($game_chart as $team) {
            if(!isset($chart_data[$team['teamid']])) { // Do not add same teams more than 1 time
                $rating_change = Armory::$cDB->select("SELECT `gameid`, `changeType`, `ratingChange` FROM `armory_game_chart` WHERE `teamid`=%d AND `gameid` IN (%s)", $team['teamid'], $all_games);
                $rd = 0;
                if($rating_change) {
                    $exists = array();
                    foreach($rating_change as $rCh) {
                        if(!isset($exists[$rCh['gameid']])) {
                            if($rCh['changeType'] == 2) {
                                $rd += $rCh['ratingChange'];
                            }
                            else {
                                $rd -= $rCh['ratingChange'];
                            }
                            $exists[$rCh['gameid']] = true;
                        }
                    }
                }
                $losses = Armory::$cDB->selectCell("SELECT COUNT(`gameid`) FROM `armory_game_chart` WHERE `changeType`=1 AND `teamid`='%d' AND `gameid` IN (%s)", $team['teamid'], $all_games);
                $chart_data[$team['teamid']] = array(
                    'deleted'  => ($this->TeamExists($team['teamid'])) ? 'false' : 'true',
                    'games'    => $team['countTeam'],
                    'losses'   => $losses,
                    'rd'       => $rd,
                    'realm'    => Armory::$currentRealmInfo['name'],
                    'teamName' => $team['name'],
                    'teamUrl'  => sprintf("r=%s&ts=%d&t=%s", urlencode(Armory::$currentRealmInfo['name']), $team['type'], urlencode($team['name'])),
                    'wins'     => $team['countTeam']-$losses
                );
                $chart_data[$team['teamid']]['winPer'] = Utils::GetPercent($team['countTeam'], $chart_data[$team['teamid']]['wins']);
            }
        }
        return $chart_data;
    }
}
?>