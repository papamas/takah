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
 * QueryParams
 *
 * @author sochoa
 */
class QueryParams {

    const DOCUMENT = 1;
    const FOLDER = 2;
    const MAIL = 4;
    const RECORD = 8;
    const _AND = 'and';
    const _OR = 'or';

    private $id;
    private $queryName;
    private $user;
    private $name;
    private $title;
    private $keywords = array();
    private $categories = array();
    private $content;
    private $mimeType;
    private $language;
    private $author;
    private $folder;
    private $folderRecursive;
    private $lastModifiedFrom;
    private $lastModifiedTo;
    private $mailSubject;
    private $mailFrom;
    private $mailTo;
    private $notes;
    private $statementQuery;
    private $statementType;
    private $dashboard;
    private $domain;
    private $operator;
    private $properties = array();
    private $shared = array();
    private $proposedSent = array();
    private $proposedReceived = array();

    function __construct() {
        $this->domain = self::DOCUMENT;
        $this->operator = self::_AND;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getQueryName() {
        return $this->queryName;
    }

    public function setQueryName($queryName) {
        $this->queryName = $queryName;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getKeywords() {
        return $this->keywords;
    }

    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    public function getCategories() {
        return $this->categories;
    }

    public function setCategories($categories) {
        $this->categories = $categories;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getMimeType() {
        return $this->mimeType;
    }

    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getLastModifiedFrom() {
        return $this->lastModifiedFrom;
    }

    public function setLastModifiedFrom($lastModifiedFrom) {
        $this->lastModifiedFrom = $lastModifiedFrom;
    }

    public function getLastModifiedTo() {
        return $this->lastModifiedTo;
    }

    public function setLastModifiedTo($lastModifiedTo) {
        $this->lastModifiedTo = $lastModifiedTo;
    }

    public function getMailSubject() {
        return $this->mailSubject;
    }

    public function setMailSubject($mailSubject) {
        $this->mailSubject = $mailSubject;
    }

    public function getMailFrom() {
        return $this->mailFrom;
    }

    public function setMailFrom($mailFrom) {
        $this->mailFrom = $mailFrom;
    }

    public function getMailTo() {
        return $this->mailTo;
    }

    public function setMailTo($mailTo) {
        $this->mailTo = $mailTo;
    }

    public function getStatementQuery() {
        return $this->statementQuery;
    }

    public function setStatementQuery($statementQuery) {
        $this->statementQuery = $statementQuery;
    }

    public function getStatementType() {
        return $this->statementType;
    }

    public function setStatementType($statementType) {
        $this->statementType = $statementType;
    }

    public function isDashboard() {
        return $this->dashboard;
    }

    public function setDashboard($dashboard) {
        $this->dashboard = $dashboard;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function setDomain($domain) {
        $this->domain = $domain;
    }

    public function getOperator() {
        return $this->operator;
    }

    public function setOperator($operator) {
        $this->operator = $operator;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function setProperties($properties) {
        $this->properties = $properties;
    }

    public function getShared() {
        return $this->shared;
    }

    public function setShared($shared) {
        $this->shared = $shared;
    }

    public function getProposedSent() {
        return $this->proposedSent;
    }

    public function setProposedSent($proposedSent) {
        $this->proposedSent = $proposedSent;
    }

    public function getProposedReceived() {
        return $this->proposedReceived;
    }

    public function setProposedReceived($proposedReceived) {
        $this->proposedReceived = $proposedReceived;
    }

    public function toString() {
        return "{id=" . $this->id . ", queryName=" . $this->queryName . ", user=" . $this->user . ", name=" . $this->name . ", title=" . $this->title . ", keywords=" . $this->keywords . ", categories=" . $this->categories . ", content=" . $this->content . ", mimeType=" . $this->mimeType . ", language=" . $this->language . ", author=" . $this->author . ", path=" . $this->path . ", dashboard=" . $this->dashboard . ", domain=" . $this->domain . ", operator=" . $this->operator . ", shared=" . $this->shared . ", proposedSent=" . $this->proposedSent . ", proposedReceived=" . $this->proposedReceived . ", statementQuery=" . $this->statementQuery . ", statementType=" . $this->statementType . ", lastModifiedFrom=" . $this->lastModifiedFrom == null ? null : $this->lastModifiedFrom->getTime() . ", lastModifiedTo=" . $this->lastModifiedTo == null ? null : $this->lastModifiedTo->getTime() . "}";
    }

}
?>

