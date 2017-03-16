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
 * PropertyGroup
 *
 * @author sochoa
 */
class PropertyGroup {

    const GROUP = 'okg';
    const GROUP_URI = 'http://www.openkm.org/group/1.0';
    const GROUP_PROPERTY = 'okp';
    const GROUP_PROPERTY_URI = 'http://www.openkm.org/group/property/1.0';

    private $label = "";
    private $name = "";
    private $visible = true;
    private $readonly = false;

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function isVisible() {
        return $this->visible;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }

    public function isReadonly() {
        return $this->readonly;
    }

    public function setReadonly($readonly) {
        $this->readonly = $readonly;
    }

    public function toString() {
        return "{label=" . $this->label . ", name=" . $this->name . ", visible=" . $this->visible . ", readonly=" . $this->readonly . "}";
    }

}
?>

