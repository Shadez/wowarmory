<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 196
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
    
    public function _initTeam() {
        if(!$this->teamname) {
            return false;
        }
        $arenaInfo           = $this->cDB->selectRow("SELECT `arenateamid`, `captainguid`, `type` FROM `arena_team` WHERE `name`=? LIMIT 1", $this->teamname);
        $this->arenateamid   = $arenaInfo['arenateamid'];
        $this->captainguid   = $arenaInfo['captainguid'];
        $this->teamlogostyle = self::GetArenaTeamEmblem($this->arenateamid);
        $this->teamfaction   = Utils::GetFactionId($this->cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=? LIMIT 1", $this->captainguid));
        $this->teamfaction   = 1;
        $this->teamtype      = $arenaInfo['type'];
        self::GetTeamList();
    }
    
    public function GetArenaTeamInfo() {
        if(!$this->arenateamid) {
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
            FROM `arena_team_stats` WHERE `arenateamid`=?", $this->arenateamid);
        if(!$arenateaminfo) {
            return false;
        }
        $arenateaminfo['data']['battleGroup'] = $this->armoryconfig['defaultBGName'];
        $arenateaminfo['data']['lastSeasonRanking'] = 0;
        $arenateaminfo['data']['name'] = $this->teamname;
        $arenateaminfo['data']['realm'] = $this->currentRealmInfo['name'];
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
            return false;
        }
        if(!$this->cDB->selectCell("SELECT 1 FROM `arena_team` WHERE `name`=? LIMIT 1", $this->teamname)) {
            return false;
        }
        return true;
    }
    
    public function GetCharacterArenaTeamInfo() {
        if(!$this->guid) {
            return false;
        }
        $team_names = $this->cDB->select("SELECT `name` FROM `arena_team` WHERE `arenateamid` IN (SELECT `arenateamid` FROM `arena_team_member` WHERE `guid`=?)", $this->guid);
        if(!$team_names) {
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
            return false;
        }
        $this->teamstats = $this->cDB->selectRow("SELECT * FROM `arena_team_stats` WHERE `arenateamid`=? LIMIT 1", $this->arenateamid);
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
        WHERE `arena_team_member`.`arenateamid`=?
        ", $this->arenateamid);
        if(!$this->players) {
            return;
        }
        $count_players = count($this->players);
        for($i=0;$i<$count_players;$i++) {
            if($this->players[$i]['guildId'] = $this->cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=?", $this->players[$i]['guid'])) {
                $this->players[$i]['guild'] = $this->cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=?", $this->players[$i]['guildId']);
                $this->players[$i]['guildUrl'] = sprintf('r=%s&gn=%s', urlencode($this->currentRealmInfo['name']), urlencode($this->players[$i]['guild']));
            }
            $this->players[$i]['battleGroup'] = $this->armoryconfig['defaultBGName'];
            $this->players[$i]['charUrl'] = sprintf('r=%s&cn=%s', urlencode($this->currentRealmInfo['name']), urlencode($this->players[$i]['name']));
            unset($this->players[$i]['guid']);
        }
    }
    
    public function BuildArenaLadderList($type, $page, $num = false, $order = 'rank', $type = 'DESC') {
        if($num == true) {
            return $this->cDB->selectCell("SELECT COUNT(`arenateamid`) FROM `arena_team` WHERE `type`=?", $type);
        }
        $arenaTeamInfo = $this->cDB->select("
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
                    WHERE `type`=?
                        ORDER BY `arena_team_stats`.`".$order."` ".$type." LIMIT ".$page.", 20
        ", $type);
        if(!$arenaTeamInfo) {
            return false;
        }
        $result_areanteams = array();
        $i = 0;
        foreach($arenaTeamInfo as $team) {
            $result_areanteams[$i]['data'] = $team;
            $result_areanteams[$i]['data']['num'] = $i+1;
            $result_areanteams[$i]['data']['battleGroup'] = $this->armoryconfig['defaultBGName'];
            $result_areanteams[$i]['data']['faction'] = '';
            $result_areanteams[$i]['data']['factionId'] = Utils::GetFactionId($result_areanteams[$i]['data']['race']);
            //$result_areanteams[$i]['data']['factionId'] = 1;
            $result_areanteams[$i]['data']['lastSeasonRanking'] = '';
            $result_areanteams[$i]['data']['realm'] = $this->currentRealmInfo['name'];
            $result_areanteams[$i]['data']['realmUrl'] = sprintf('b=%s&r=%s&ts=%d&select=%s', urlencode($this->armoryconfig['defaultBGName']), urlencode($this->currentRealmInfo['name']), $type, urlencode($team['name']));
            $result_areanteams[$i]['data']['relevance'] = 0;
            $result_areanteams[$i]['data']['season'] = 0;
            $result_areanteams[$i]['data']['size'] = $type;
            $result_areanteams[$i]['data']['teamSize'] = $type;
            $result_areanteams[$i]['data']['teamUrl'] = sprintf('r=%s&ts=%d&t=%s', urlencode($this->armoryconfig['defaultBGName']), urlencode($this->currentRealmInfo['name']), $type, urlencode($team['name']));
            $result_areanteams[$i]['emblem'] = self::GetArenaTeamEmblem($team['arenateamid']);
            unset($result_areanteams[$i]['data']['arenateamid']);
            unset($result_areanteams[$i]['data']['captainguid']);
            $i++;
        }
        return $result_areanteams;
    }
    
    public function GetArenaTeamEmblem($teamId=null) {
        if($teamId == null) {
            $teamId = $this->arenateamid;
        }
        return $this->cDB->selectRow("
        SELECT `BackgroundColor` AS `background`, `BorderColor` AS `borderColor`, `BorderStyle` AS `borderStyle`, `EmblemColor` AS `iconColor`, `EmblemStyle` AS `iconStyle`
            FROM `arena_team`
                WHERE `arenateamid`=?", $teamId);
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
                WHERE `type`=?
                        ORDER BY `arena_team_stats`.`rank`
        ", $type);
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
        return $this->cDB->selectCell("SELECT COUNT(`arenateamid`) FROM `arena_team` WHERE `type`=?", $type);
    }
    
    public function CountPageNum($type) {
        $all_teams = self::CountArenaTeams($type);
        return round($all_teams/20);        
    }
}
?>