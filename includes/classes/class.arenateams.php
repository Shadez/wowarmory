<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 324
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

Class Arenateams extends Connector {
    public $arenateamid;
    public $teamname;
    public $captainguid;
    public $teamfaction;
    public $teamlogostyle;
    public $teamtype;
    public $teamstats;
    public $players;
    public $guid;
    private $gameid = false;
    
    public function _initTeam() {
        if(!$this->teamname) {
            $this->Log()->writeError('%s : teamname not defined', __METHOD__);
            return false;
        }
        $arenaInfo           = $this->cDB->selectRow("SELECT `arenateamid`, `captainguid`, `type` FROM `arena_team` WHERE `name`='%s' LIMIT 1", $this->teamname);
        $this->arenateamid   = $arenaInfo['arenateamid'];
        $this->captainguid   = $arenaInfo['captainguid'];
        $this->teamlogostyle = self::GetArenaTeamEmblem($this->arenateamid);
        $this->teamfaction   = Utils::GetFactionId($this->cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=%d LIMIT 1", $this->captainguid));
        $this->teamfaction   = 1;
        $this->teamtype      = $arenaInfo['type'];
        self::GetTeamList();
    }
    
    public function GetArenaTeamInfo() {
        if(!$this->arenateamid) {
            $this->Log()->writeError('%s : arenateamid not defined', __METHOD__);
            return false;
        }
        $arenateaminfo = array();
        $arenateaminfo['data'] = $this->cDB->selectRow("
        SELECT
        `rating`,
        `games`  AS `gamesPlayed`,
        `wins`   AS `gamesWon`,
        `rank`   AS `ranking`,
        `played` AS `seasonGamesPlayed`,
        `wins2`  AS `seasonGamesWon`
        FROM `arena_team_stats` WHERE `arenateamid`=%d", $this->arenateamid);
        if(!$arenateaminfo) {
            $this->Log()->writeError('%s : unable to get data from DB for arenateam %d (%s)', __METHOD__, $this->arenateamid, $this->teamname);
            return false;
        }
        $arenateaminfo['data']['battleGroup'] = $this->armoryconfig['defaultBGName'];
        $arenateaminfo['data']['lastSeasonRanking'] = 0;
        $arenateaminfo['data']['name'] = $this->teamname;
        $arenateaminfo['data']['realm'] = $this->currentRealmInfo['name'];
        $arenateaminfo['data']['realmName'] = sprintf($this->currentRealmInfo['name']);
        $arenateaminfo['data']['realmUrl'] = sprintf('b=%s&r=%s&ts=%d', urlencode($this->armoryconfig['defaultBGName']), urlencode($this->currentRealmInfo['name']), $this->teamtype);
        $arenateaminfo['data']['relevance'] = 0;
        $arenateaminfo['data']['season'] = 0;
        $arenateaminfo['data']['size'] = $this->teamtype;
        $arenateaminfo['data']['teamSize'] = $this->teamtype;
        $arenateaminfo['data']['teamUrl'] = sprintf('r=%s&t=%s', urlencode($this->currentRealmInfo['name']), urlencode($this->teamname));
        $arenateaminfo['data']['url'] = sprintf('r=%s&ts=%d&t=%s', urlencode($this->currentRealmInfo['name']), $this->teamtype, urlencode($this->teamname));
        $arenateaminfo['emblem'] = self::GetArenaTeamEmblem();
        if(is_array($this->players)) {
            $arenateaminfo['members'] = $this->players;
        }
        else {
            $arenateaminfo['members'] = self::GetTeamList();
        }
        return $arenateaminfo;
    }
    
    public function IsTeam() {
        if(!$this->teamname) {
            $this->Log()->writeError('%s : teamname not defined', __METHOD__);
            return false;
        }
        if(!$this->cDB->selectCell("SELECT 1 FROM `arena_team` WHERE `name`='%s' LIMIT 1", $this->teamname)) {
            return false;
        }
        return true;
    }
    
    public function GetCharacterArenaTeamInfo() {
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $team_names = $this->cDB->select("SELECT `name` FROM `arena_team` WHERE `arenateamid` IN (SELECT `arenateamid` FROM `arena_team_member` WHERE `guid`=%d)", $this->guid);
        if(!$team_names) {
            $this->Log()->writeLog('%s : player %d does not have any arena teams', __METHOD__, $this->guid);
            return false;
        }
        $count_teams = count($team_names);
        $teams_result = array();
        for($i=0;$i<$count_teams;$i++) {
            $this->teamname = $team_names[$i]['name'];
            self::_initTeam();
            $teams_result[$i] = self::GetArenaTeamInfo();
        }
        return $teams_result;
    }
    
    public function getTeamStats() {
        if(!$this->arenateamid) {
            $this->Log()->writeError('%s : arenateamid not defined', __METHOD__);
            return false;
        }
        $this->teamstats = $this->cDB->selectRow("SELECT * FROM `arena_team_stats` WHERE `arenateamid`=%d LIMIT 1", $this->arenateamid);
        return true;
    }
    
    public function GetTeamList() {
        $this->players = $this->cDB->select("
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
        WHERE `arena_team_member`.`arenateamid`=%d
        ", $this->arenateamid);
        if(!$this->players) {
            $this->Log()->writeLog('%s : unable to get player list for arena team %d (%s)', __METHOD__, $this->arenateamid, $this->teamname);
            return;
        }
        $count_players = count($this->players);
        for($i=0;$i<$count_players;$i++) {
            if($this->players[$i]['guildId'] = $this->cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=%d", $this->players[$i]['guid'])) {
                $this->players[$i]['guild'] = $this->cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=%d", $this->players[$i]['guildId']);
                $this->players[$i]['guildUrl'] = sprintf('r=%s&gn=%s', urlencode($this->currentRealmInfo['name']), urlencode($this->players[$i]['guild']));
            }
            $this->players[$i]['battleGroup'] = $this->armoryconfig['defaultBGName'];
            $this->players[$i]['charUrl'] = sprintf('r=%s&cn=%s', urlencode($this->currentRealmInfo['name']), urlencode($this->players[$i]['name']));
            unset($this->players[$i]['guid']);
        }
    }
    
    public function BuildArenaLadderList($type, $page, $num = false, $order = 'rating', $sort = 'ASC') {
        if($num == true) {
            $summary = 0;
            foreach($this->realmData as $realm_info) {
                $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
                $current_count = $db->selectCell("
                SELECT
                COUNT(`arena_team`.`arenateamid`) 
                    FROM `arena_team` AS `arena_team` 
                        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid` = `arena_team`.`arenateamid` 
                        WHERE `arena_team`.`type` = %d AND `arena_team_stats`.`rank` > 0", $type);
                $summary = $current_count+$summary;
            }
            return $summary;
        }
        $result_areanteams = array();
        $i = 0;
        foreach($this->realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
            if($order == 'lose') {
                // Special sorting
                $realmArenaTeamInfo = $db->select("
                SELECT
                `arena_team`.`arenateamid`,
                `arena_team`.`name`,
                `arena_team_stats`.`rating`,
                `arena_team_stats`.`games`  AS `gamesPlayed`,
                `arena_team_stats`.`wins`   AS `gamesWon`,
                `arena_team_stats`.`rank`   AS `ranking`,
                `arena_team_stats`.`played` AS `seasonGamesPlayed`,
                `arena_team_stats`.`wins2`  AS `seasonGamesWon`,
                `characters`.`race`,
                `arena_team_stats`.`played`-`arena_team_stats`.`wins2` AS `lose`
                    FROM `arena_team` AS `arena_team`
                        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenateamid`
                        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team`.`captainguid`
                            WHERE `arena_team`.`type`=%d AND `arena_team_stats`.`rank` > 0
                                ORDER BY `lose` %s LIMIT %d, 20
                ", $type, $sort, $page);
            }
            else {
                $realmArenaTeamInfo = $db->select("
                SELECT
                `arena_team`.`arenateamid`,
                `arena_team`.`name`,
                `arena_team_stats`.`rating`,
                `arena_team_stats`.`games`  AS `gamesPlayed`,
                `arena_team_stats`.`wins`   AS `gamesWon`,
                `arena_team_stats`.`rank`   AS `ranking`,
                `arena_team_stats`.`played` AS `seasonGamesPlayed`,
                `arena_team_stats`.`wins2`  AS `seasonGamesWon`,
                `characters`.`race`
                    FROM `arena_team` AS `arena_team`
                        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenateamid`
                        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team`.`captainguid`
                            WHERE `arena_team`.`type`=%d AND `arena_team_stats`.`rank` > 0
                                ORDER BY %s %s LIMIT %d, 20
                ", $type, $order, $sort, $page);
            }
            if(!$realmArenaTeamInfo) {
                $this->Log()->writeLog('%s : loop finished, no arena teams found (order: %s, type: %d, page: %d, sort: %s, db_name: %s).', __METHOD__, $order, $type, $page, $sort, $realm_info['name_characters']);
                continue;
            }
            foreach($realmArenaTeamInfo as $team) {
                $result_areanteams[$i]['data'] = $team;
                $result_areanteams[$i]['data']['num'] = $i+1;
                $result_areanteams[$i]['data']['battleGroup'] = $this->armoryconfig['defaultBGName'];
                $result_areanteams[$i]['data']['faction'] = null;
                $result_areanteams[$i]['data']['factionId'] = Utils::GetFactionId($result_areanteams[$i]['data']['race']);
                $result_areanteams[$i]['data']['lastSeasonRanking'] = null;
                $result_areanteams[$i]['data']['realm'] = $realm_info['name'];
                $result_areanteams[$i]['data']['realmUrl'] = sprintf('b=%s&r=%s&ts=%d&select=%s', urlencode($this->armoryconfig['defaultBGName']), urlencode($realm_info['name']), $type, urlencode($team['name']));
                $result_areanteams[$i]['data']['relevance'] = 0;
                $result_areanteams[$i]['data']['season'] = 0;
                $result_areanteams[$i]['data']['size'] = $type;
                $result_areanteams[$i]['data']['teamSize'] = $type;
                $result_areanteams[$i]['data']['teamUrl'] = sprintf('r=%s&ts=%d&t=%s', urlencode($this->armoryconfig['defaultBGName']), urlencode($realm_info['name']), $type, urlencode($team['name']));
                $result_areanteams[$i]['emblem'] = self::GetArenaTeamEmblem($team['arenateamid'], $db);
                unset($result_areanteams[$i]['data']['arenateamid'], $result_areanteams[$i]['data']['captainguid']);
                $i++;
            }
        }
        if(!isset($result_areanteams[0]['data'])) {
            $this->Log()->writeLog('%s : unable to find any arena teams', __METHOD__);
            return false;
        }
        return $result_areanteams;
    }
    
    public function GetArenaTeamEmblem($teamId = null, $db = false) {
        if($teamId == null) {
            $teamId = $this->arenateamid;
        }
        if($db == false) {
            $arenaTeamEmblem = $this->cDB->selectRow("
            SELECT `BackgroundColor` AS `background`, `BorderColor` AS `borderColor`, `BorderStyle` AS `borderStyle`, `EmblemColor` AS `iconColor`, `EmblemStyle` AS `iconStyle`
                FROM `arena_team`
                    WHERE `arenateamid`=%d", $teamId);
            $arenaTeamEmblem['background'] = dechex($arenaTeamEmblem['background']);
            $arenaTeamEmblem['borderColor'] = dechex($arenaTeamEmblem['borderColor']);
            $arenaTeamEmblem['iconColor'] = dechex($arenaTeamEmblem['iconColor']);
            return $arenaTeamEmblem;
        }
        elseif(is_object($db)) {
            $arenaTeamEmblem = $db->selectRow("
            SELECT `BackgroundColor` AS `background`, `BorderColor` AS `borderColor`, `BorderStyle` AS `borderStyle`, `EmblemColor` AS `iconColor`, `EmblemStyle` AS `iconStyle`
                FROM `arena_team`
                    WHERE `arenateamid`=%d", $teamId);
            $arenaTeamEmblem['background'] = dechex($arenaTeamEmblem['background']);
            $arenaTeamEmblem['borderColor'] = dechex($arenaTeamEmblem['borderColor']);
            $arenaTeamEmblem['iconColor'] = dechex($arenaTeamEmblem['iconColor']);
            return $arenaTeamEmblem;
        }
    }
    
    public function buildArenaIconsList($type) {
        $arenaTeamInfo = $this->cDB->select("
        SELECT
        `arena_team`.`BackgroundColor`,
        `arena_team`.`EmblemStyle`,
        `arena_team`.`EmblemColor`,
        `arena_team`.`BorderStyle`,
        `arena_team`.`BorderColor`,
        `arena_team_stats`.`rank`
        FROM `arena_team` AS `arena_team`
        LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenateamid`
        WHERE `type`=%d
        ORDER BY `arena_team_stats`.`rank`", $type);
        $j = 1;
        $count = count($arenaTeamInfo);
        for($i=0;$i<$count;$i++) {
            $arenaTeamInfo[$i]['num'] = $j;
            $arenaTeamInfo[$i]['EmblemColor'] = dechex($arenaTeamInfo[$i]['EmblemColor']);
            $arenaTeamInfo[$i]['BorderColor'] = dechex($arenaTeamInfo[$i]['BorderColor']);
            $j++;
        }
        return $arenaTeamInfo;
    }
    
    public function CountArenaTeams($type) {
        $summary = 0;
        foreach($this->realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
            $current_count = $db->selectCell("SELECT COUNT(`arenateamid`) FROM `arena_team` WHERE `type`=%d", $type);
            $summary = $summary+$current_count;
        }
        return $summary;
    }
    
    public function CountPageNum($type) {
        $all_teams = self::CountArenaTeams($type);
        $result = round($all_teams/20);
        return $result;
    }
    
    public function SetGameID($gameid) {
        if($gameid > 0) {
            $this->gameid = $gameid;
        }
        return true;
    }
    
    public function GetGameID() {
        return $this->gameid;
    }
    
    public function GetGameInfo() {
        if(!$this->gameid || $this->gameid === 0) {
            $this->Log()->writeError('%s : gameid not provided', __METHOD__);
            return false;
        }
        $game_info = $this->cDB->select("
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
            $this->Log()->writeError('%s : unable to get data from characters DB for gameID %d', __METHOD__, $this->gameid);
            return false;
        }
        $chart_teams = array();
        $chart_teams['gameData'] = array(
            'battleGroup' => $this->armoryconfig['defaultBGName'],
            'id' => $this->gameid,
            'map' => $this->aDB->selectCell("SELECT `name_%s` FROM `armory_maps` WHERE `id`=%d LIMIT 1", $this->_locale, $game_info[0]['mapId']),
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
                    'ratingDelta' => ($team_member['changeType'] == 1) ? $team_member['ratingChange'] : '-'.$team_member['ratingChange'],
                    'ratingNew' => ($team_member['changeType'] == 1) ? $team_member['teamRating']+$team_member['ratingChange'] : $team_member['teamRating']-$team_member['ratingChange'],
                    'realm' => $this->currentRealmInfo['name'],
                    'result' => ($team_member['changeType'] == 1) ? 'win' : 'loss',
                    'teamUrl' => sprintf('r=%s&ts=%d&t=%s', urlencode($this->currentRealmInfo['name']), $team_member['type'], urlencode($team_member['name']))
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
                'url' => sprintf('r=%s&cn=%s', urlencode($this->currentRealmInfo['name']), urlencode($team_member['characterName']))
            );
        }
        return $chart_teams;
    }
    
    public function TeamExists($teamId) {
        return $this->cDB->selectCell("SELECT 1 FROM `arena_team` WHERE `arenateamid`=%d LIMIT 1", $teamId);
    }
    
    public function BuildGameChart() {
        if(!$this->arenateamid) {
            $this->Log()->writeError('%s : arenateamid not provided', __METHOD__);
            return false;
        }
        $game_ids = $this->cDB->select("SELECT DISTINCT `gameid` FROM `armory_game_chart` WHERE `teamid`=%d", $this->arenateamid);
        if(!$game_ids) {
            $this->Log()->writeLog('%s : unable to find any game for teamId %d', __METHOD__, $this->arenateamid);
            return false;
        }
        if(count($game_ids) < 2) {
            $this->Log()->writeLog('%s : arenateamid %d have less than 2 matches played. Showing results has been disabled to prevent browser crash.', __METHOD__, $this->arenateamid);
            return false;
        }
        $game_ids_str = null;
        $counter = count($game_ids);
        for($i = 0; $i < $counter; $i++) {
            if($i) {
                $game_ids_str .= ', ' . $game_ids[$i]['gameid'];
            }
            else {
                $game_ids_str .= $game_ids[$i]['gameid'];
            }
        }
        $game_chart = $this->cDB->select("
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
        WHERE `armory_game_chart`.`gameid` IN (%s) AND `armory_game_chart`.`teamid` <> %d", $game_ids_str, $this->arenateamid);
        if(!$game_chart) {
            $this->Log()->writeError('%s : game_ids were fetched from DB, but script was unable to get data for these matches (%s) from characters DB (arenateamid:%d)', __METHOD__, $game_ids_str, $this->arenateamid);
            return false;
        }
        $chart_data = array();
        foreach($game_chart as $team) {
            if(!isset($chart_data[$team['gameid']])) { // Do not add same games more then 1 time
                $chart_data[$team['gameid']] = array(
                    'deleted' => ($this->TeamExists($team['teamid'])) ? 'false' : 'true',
                    'id' => $team['gameid'],
                    'ot' => $team['name'],
                    'r' => ($team['changeType'] == 1) ? $team['teamRating']+$team['ratingChange'] : $team['teamRating']-$team['ratingChange'],
                    'reamOffset' => 3600000, // hardcode
                    'st' => $team['start'], // need to be fixed (change to timestamp)
                    'teamUrl' => sprintf('r=%s&ts=%d&t=%s', urlencode($this->currentRealmInfo['name']), $team['type'], urlencode($team['name']))
                );
            }
        }
        return $chart_data;
    }
    
    public function BuildOpposingTeamList() {
        if(!$this->arenateamid) {
            $this->Log()->writeError('%s : arenateamid not provided', __METHOD__);
            return false;
        }
        $game_ids = $this->cDB->select("SELECT DISTINCT `gameid` FROM `armory_game_chart` WHERE `teamid`=%d", $this->arenateamid);
        if(!$game_ids) {
            $this->Log()->writeLog('%s : unable to find any game for teamId %d', __METHOD__, $this->arenateamid);
            return false;
        }
        $game_ids_str = null;
        $counter = count($game_ids);
        for($i = 0 ; $i < $counter; $i++) {
            if($i) {
                $game_ids_str .= ', ' . $game_ids[$i]['gameid'];
            }
            else {
                $game_ids_str .= $game_ids[$i]['gameid'];
            }
        }
        $game_chart = $this->cDB->select("
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
        GROUP BY `armory_game_chart`.`gameid`", $game_ids_str, $this->arenateamid);
        if(!$game_chart) {
            $this->Log()->writeError('%s : game_ids were fetched from DB, but script was unable to get data for these matches (%s) from characters DB (arenateamid:%d)', __METHOD__, $game_ids_str, $this->arenateamid);
            return false;
        }
        $chart_data = array();
        foreach($game_chart as $team) {
            if(!isset($chart_data[$team['teamid']])) { // Add 1 team in 1 time
                $rating_change = $this->cDB->select("SELECT `gameid`, `changeType`, `ratingChange` FROM `armory_game_chart` WHERE `teamid`=%d AND `gameid` IN (%s)", $team['teamid'], $game_ids_str);
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
                $losses = $this->cDB->selectCell("SELECT COUNT(`gameid`) FROM `armory_game_chart` WHERE `changeType`=1 AND `teamid`='%d' AND `gameid` IN (%s)", $team['teamid'], $game_ids_str);
                $chart_data[$team['teamid']] = array(
                    'deleted'  => ($this->TeamExists($team['teamid'])) ? 'false' : 'true',
                    'games'    => $team['countTeam'],
                    'losses'   => $losses,
                    'rd'       => $rd,
                    'realm'    => $this->currentRealmInfo['name'],
                    'teamName' => $team['name'],
                    'teamUrl'  => sprintf("r=%s&ts=%d&t=%s", urlencode($this->currentRealmInfo['name']), $team['type'], urlencode($team['name'])),
                    'wins'     => $team['countTeam']-$losses
                );
                $chart_data[$team['teamid']]['winPer'] = Utils::getPercent($team['countTeam'], $chart_data[$team['teamid']]['wins']);
            }
        }
        return $chart_data;
    }
}
?>