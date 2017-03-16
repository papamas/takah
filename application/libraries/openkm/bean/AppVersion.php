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
 * AppVersion 
 *
 * @author sochoa
 */
class AppVersion {

    const EXTENSION_PRO = "Professional";
    const EXTENSION_COM = "Community";

    private $major = "0";
    private $minor = "0";
    private $maintenance = "0";
    private $build = "0";
    private $extension;

    function __construct() {
        $this->extension = self::EXTENSION_PRO;
    }

    public function getMajor() {
        return $this->major;
    }

    public function setMajor($major) {
        $this->major = $major;
    }

    public function getMinor() {
        return $this->minor;
    }

    public function setMinor($minor) {
        $this->minor = $minor;
    }

    public function getMaintenance() {
        return $this->maintenance;
    }

    public function setMaintenance($maintenance) {
        $this->maintenance = $maintenance;
    }

    public function getBuild() {
        return $this->build;
    }

    public function setBuild($build) {
        $this->build = $build;
    }

    public function getExtension() {
        return $this->extension;
    }

    public function setExtension($extension) {
        $this->extension = $extension;
    }

    public function getVersion() {
        return $this->major . "." . $this->minor . "." . $this->maintenance;
    }

    public function toString() {
        return $this->major . "." . $this->minor . "." . $this->maintenance . " (build: " . $this->build . ")";
    }

}
?>


