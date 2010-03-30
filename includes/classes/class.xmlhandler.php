<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 122
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

Class XMLHandler {
    public $writer = null;
    public $region = 'eu';
    public $locale = 'ru_ru';
    
    public function XMLHandler($locale = null, $region = null) {
        $this->writer = new XMLWriter;
        $this->writer->openMemory();
        if($region) {
            $this->region = $region;
        }
        if($locale) {
            $this->locale = $locale;
        }
        return true;
    }
    
    public function XMLWriter() {
        if($this->writer) {
            return $this->writer;
        }
        else {
            $this->writer = new XMLWriter;
            return $this->writer;
        }
    }
    
    /**
     * Create new XML document
     * Return: bool
     **/
    public function StartXML() {
        $this->writer->startDocument('1.0', 'UTF-8');
    }
    
    /**
     * Load XSLT sheet
     * Return: bool
     **/
    public function LoadXSLT($xslt_link) {
        $this->writer->writePI('xml-stylesheet', sprintf('type="text/xsl" href="_layout/%s"', $xslt_link));
    }
    
    /**
     * End current document and flush memory buffer
     * Return: bool
     **/
    public function EndXML() {
        $this->writer->endDocument();
        $this->writer->flush();
    }
    
    /**
     * End current document, send memory buffer to caller and flush it
     * Return: bool
     **/
    public function StopXML() {
        $this->writer->endDocument();
        $xml_output = $this->writer->outputMemory(true);
        $this->writer->flush();
        return $xml_output;
    }
    
    /**
     * Flush memory buffer
     * Return: bool
     **/
    public function FlushXML() {
        $this->writer->flush();
    }
}

?>