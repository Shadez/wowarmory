<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 30
 * @copyright (c) 2009 Shadez  
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
    
    public function _initTeam() {
        if(!$this->teamname) {
            return false;
        }
        $arenaInfo = $this->cDB->selectRow("SELECT * FROM `arena_team` WHERE `name`=? LIMIT 1", $this->teamname);
        $this->arenateamid = $arenaInfo['arenateamid'];
        $this->captainguid = $arenaInfo['captainguid'];
        $pattern = 'totalIcons=1&totalIcons=1&startPointX=4&initScale=100&overScale=100&largeIcon=1&iconColor1=%s&iconName1=images/icons/team/pvp-banner-emblem-%d.png&bgColor1=%s&borderColor1=%s&teamUrl1=';
        $this->teamlogostyle = sprintf($pattern, $arenaInfo['EmblemColor'], $arenaInfo['EmblemStyle'], $arenaInfo['BackgroundColor'], $arenaInfo['BorderColor']);
        $this->teamfaction = Characters::GetCharacterFaction($this->cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=? LIMIT 1", $this->captainguid));
        $this->teamtype = $arenaInfo['type'];
        $this->getTeamStats();
        $this->getTeamList();
        return true;
    }
    
    public function IsTeam($name) {
        if(!$this->cDB->selectCell("SELECT `arenateamid` FROM `arena_team` WHERE `name`=? LIMIT 1", $name)) {
            return false;
        }
        return true;
    }
    
    public function getTeamStats() {
        if(!$this->arenateamid) {
            return false;
        }
        $this->teamstats = $this->cDB->selectRow("SELECT * FROM `arena_team_stats` WHERE `arenateamid`=? LIMIT 1", $this->arenateamid);
        return true;
    }
    
    public function getTeamList() {
        $this->players = $this->cDB->select("
        SELECT
        `arena_team_member`.`played_season`,
        `arena_team_member`.`wons_season`,
        `arena_team_member`.`personal_rating`,
        `characters`.`guid`,
        `characters`.`name`,
        `characters`.`race`,
        `characters`.`class`,
        `characters`.`gender`
        FROM `arena_team_member` AS `arena_team_member`
        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team_member`.`guid`
        WHERE `arena_team_member`.`arenateamid`=?
        ", $this->arenateamid);
        return true;
    }
    
    public function exportMainData() {
        $data = array(
            'name' => $this->teamname,
            'type' => $this->teamtype,
            'faction' => $this->teamfaction,
            'logo' => $this->teamlogostyle
        );
        return $data;
    }
    
    public function exportStats() {
        $this->teamstats['percent_week'] = floor(Utils::GetPercent($this->teamstats['games'], $this->teamstats['wins']));
        $this->teamstats['percent_season'] = floor(Utils::GetPercent($this->teamstats['played'], $this->teamstats['wins2']));
        return $this->teamstats;
    }
    
    public function exportPlayersList() {
        $count = count($this->players);
        for($i=0;$i<$count;$i++) {
            if($this->players[$i]['guid'] == $this->captainguid) {
                $this->players[$i]['captain'] = true;
            }
            $this->players[$i]['guildid'] = Characters::GetDataField(PLAYER_GUILDID, $this->players[$i]['guid']);
            if($this->players[$i]['guildid'] > 0) {
                $this->players[$i]['guildname'] = $this->cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=?", $this->players[$i]['guildid']);
            }
            unset($this->players[$i]['guildid']);
            if($this->players[$i]['played_season'] > 0) {
                $this->players[$i]['percent_season'] = floor(Utils::GetPercent($this->players[$i]['played_season'], $this->players[$i]['wons_season']));
            }
            else {
                $this->players[$i]['percent_season'] = 0;
            }
        }
        return $this->players;
    }
    
    public function buildArenaLadderList($type, $num = false) {
        if($num == true) {
            $x = $this->cDB->selectPage($teamsnum, "SELECT `arenateamid` FROM `arena_team` WHERE `type`=?", $type);
            return $teamsnum;
        }
        $arenaTeamInfo = $this->cDB->select("
        SELECT
        `arena_team`.`name`,
        `arena_team_stats`.`rating`,
        `arena_team_stats`.`games`,
        `arena_team_stats`.`wins`,
        `arena_team_stats`.`rank`,
        `characters`.`race`
            FROM `arena_team` AS `arena_team`
                LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team_stats`.`arenateamid`=`arena_team`.`arenateamid`
                LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`arena_team`.`captainguid`
                    WHERE `type`=?
                        ORDER BY `arena_team_stats`.`rank`
        ", $type);
        $j=1;
        $count = count($arenaTeamInfo);
        for($i=0;$i<$count;$i++) {
            $arenaTeamInfo[$i]['num'] = $j;
            $j++;
        }
        return $arenaTeamInfo;
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
}
?>