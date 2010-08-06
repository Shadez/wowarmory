<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 345
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

define('__ARMORY__', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'newsfeed.xml');
$armory_news = $utils->GetArmoryNews();
if($armory_news && is_array($armory_news)) {
    foreach($armory_news as $news) {
        $xml->XMLWriter()->startElement('news');
        $xml->XMLWriter()->writeAttribute('icon', 'news');
        $xml->XMLWriter()->writeAttribute('posted', $news['posted']);
        $xml->XMLWriter()->startElement('story');
        $xml->XMLWriter()->writeAttribute('permalink', null);
        $xml->XMLWriter()->writeAttribute('title', $news['title']);
        $xml->XMLWriter()->text($news['text']);
        $xml->XMLWriter()->endElement();  //story
        $xml->XMLWriter()->endElement(); //news
    }
}
$xml->XMLWriter()->endElement(); //page
echo htmlspecialchars_decode($xml->StopXML()); // htmlspecialchars_decode used to enable HTML tags
exit;
?>