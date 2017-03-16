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
 * Document
 *
 * @author sochoa
 */
class Document extends Node {

    const TYPE = 'okm:document';
    const CONTENT = 'okm:content';
    const CONTENT_TYPE = 'okm:resource';
    const SIZE = 'okm:size';
    const LANGUAGE = 'okm:language';
    const VERSION_COMMENT = 'okm:versionComment';
    const NAME = 'okm:name';
    const TEXT = 'okm:text';
    const TITLE = 'okm:title';
    const DESCRIPTION = 'okm:description';

    private $title = "";
    private $description = "";
    private $language = "";
    private $lastModified;
    private $mimeType;
    private $locked;
    private $checkedOut;
    private $actualVersion;
    private $lockInfo;
    private $signed;
    private $convertibleToPdf;
    private $convertibleToSwf;
    private $convertibleToDxf;
    private $cipherName;

    function __construct() {
        
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function getLastModified() {
        return $this->lastModified;
    }

    public function setLastModified($lastModified) {
        $this->lastModified = $lastModified;
    }

    public function getMimeType() {
        return $this->mimeType;
    }

    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
    }

    public function isLocked() {
        return $this->locked;
    }

    public function setLocked($locked) {
        $this->locked = $locked;
    }

    public function isCheckedOut() {
        return $this->checkedOut;
    }

    public function setCheckedOut($checkedOut) {
        $this->checkedOut = $checkedOut;
    }

    public function getLockInfo() {
        return $this->lockInfo;
    }

    public function setLockInfo(LockInfo $lockInfo) {
        $this->lockInfo = $lockInfo;
    }

    public function isSigned() {
        return $this->signed;
    }

    public function setSigned($signed) {
        $this->signed = $signed;
    }

    public function isConvertibleToPdf() {
        return $this->convertibleToPdf;
    }

    public function setConvertibleToPdf($convertibleToPdf) {
        $this->convertibleToPdf = $convertibleToPdf;
    }

    public function isConvertibleToSwf() {
        return $this->convertibleToSwf;
    }

    public function setConvertibleToSwf($convertibleToSwf) {
        $this->convertibleToSwf = $convertibleToSwf;
    }

    public function isConvertibleToDxf() {
        return $this->convertibleToDxf;
    }

    public function setConvertibleToDxf($convertibleToDxf) {
        $this->convertibleToDxf = $convertibleToDxf;
    }

    public function getCipherName() {
        return $this->cipherName;
    }

    public function setCipherName($cipherName) {
        $this->cipherName = $cipherName;
    }

    public function getActualVersion() {
        return $this->actualVersion;
    }

    public function setActualVersion(Version $actualVersion) {
        $this->actualVersion = $actualVersion;
    }

}

?>
