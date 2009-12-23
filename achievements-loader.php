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

define('__ARMORY__', true);
define('load_characters_class', true);
define('load_achievements_class', true);

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}

$characters->name = Utils::escape($_GET['cn']);
$achievementsCategory = (int) $_GET['c'];
$characters->_structCharacter();
$faction = ($characters->faction==1) ? 0 : 1;    
if(empty($characters->name) || empty($achievementsCategory)) {
    die('{"js":{"achievements":"' . $armory->tpl->get_config_vars('armory_character_achievements_unable_to_load') . '"},"text":""}');
}
$query = $armory->aDB->select("
    SELECT `id`, `parentAchievement`, `name_".$_locale."`, `description_".$_locale."`, `points`, `iconname`, `titleReward_".$_locale."`
        FROM `achievements`
            WHERE `categoryId`=? AND `factionFlag` IN (?, '-1')", $achievementsCategory, $faction);           
$cc = $armory->aDB->selectPage($totalCount, 
    "SELECT `id`
        FROM `achievements`
        WHERE `categoryId`=? AND `factionFlag` IN (?, '-1')", $achievementsCategory, $faction);
$total = 0;
$string = '';
$uncompleted = '';
$prestring = '';
$achievements->guid = $characters->guid;
foreach($query as $ach) {
    $achievements->achId = $ach['id'];
    $completed = $achievements->GetAchievementDate();
    if(!empty($completed)) {
        $string .= "<div class='achievement' id='ach".$ach['id']."' onclick='Armory.Achievements.select(this, true)'>";
        if($achievementsCategory!=81) {
            $string .= "<div class='pointshield'><div>".$ach['points']."</div></div>";
        }
        $string .= "<div class='firsts_icon' style='background-image:url(&quot;/wow-icons/_images/51x51/".$ach['iconname'].".jpg&quot;)'><img class='p' src='images/achievements/fst_iconframe.png'/></div><div class='achv_title'>".$ach['name_'.$_locale]."</div><div class='achv_desc'>".$ach['description_'.$_locale]."</div>";
        $string .= "<div class='achv_date'>".$completed."</div>";
        $string .= $achievements->AchievementProgress();
        if(!empty($ach['titleReward_'.$_locale])) {
            $string .= "<br clear='all' /><div class='achv_reward_bg'>".$ach['titleReward_'.$_locale]."</div>";
        }
        $string .= "<br clear='all'/></div>";
        $total++;
    }
    else {
        if($achievementsCategory!=81) {
            $uncompleted .= "<div class='achievement locked' id='ach".$ach['id']."' onclick='Armory.Achievements.select(this, true)'><div class='pointshield'><div>".$ach['points']."</div></div><div class='firsts_icon' style='background-image:url(&quot;/wow-icons/_images/51x51/".$ach['iconname'].".jpg&quot;)'><img class='p' src='images/achievements/fst_iconframe.png'/></div><div class='achv_title'>".$ach['name_'.$_locale]."</div><div class='achv_desc'>".$ach['description_'.$_locale]."</div>";
            $uncompleted .= $achievements->AchievementProgress();
            if(!empty($ach['titleReward_'.$_locale])) {
                $uncompleted .="<br clear='all' /><div class='achv_reward_bg'>".$ach['titleReward_'.$_locale]."</div>";
            }
            $uncompleted .= "<br clear='all'/></div>";
        }
     }
}
if($achievementsCategory!=81) {
    $prestring = "<div><div><div><div class='prog_bar '><div class='progress_cap'><!----></div><div class='progress_cap_r' style='background-position:bottom'><!----></div><div class='progress_int'><div class='progress_fill' style='width:".$achievements->CountAchievementPercent($total, 1)."%'><!----></div><div class='prog_int_text'>".$total." / ".$totalCount."</div></div></div></div>";
}
echo '{"js":{"achievements":"'.$prestring.$string;
if($achievementsCategory != 94442) {
    // temporary hack
    echo $uncompleted;
}
echo '"},"text":""}';
exit();
?>