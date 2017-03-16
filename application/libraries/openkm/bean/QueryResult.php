<?php

/**
 * OpenKM, Open Document Management System (http://www.openkm.com)
 * Copyright (c) 2006-2014 Paco Avila & Josep Llort
 * 
 * No bytes were intentionally harmed during the development of this application.
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace openkm\bean;

/**
 * QueryResult
 *
 * @author sochoa
 */
class QueryResult {

    private $document;
    private $folder;
    private $excerpt;
    private $score;

    function __construct() {
        
    }

    public function getDocument() {
        return $this->document;
    }

    public function getFolder() {
        return $this->folder;
    }

    public function setDocument($document) {
        $this->document = $document;
    }

    public function setFolder($folder) {
        $this->folder = $folder;
    }

    public function getExcerpt() {
        return $this->excerpt;
    }

    public function setExcerpt($excerpt) {
        $this->excerpt = $excerpt;
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($score) {
        $this->score = $score;
    }

    public function toString() {
        return "{node=" . $this->node . ", attachment=" . $this->attachment . ", excerpt=" . $this->excerpt . ", score=" . $this->score . "}";
    }

}

?>