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

namespace openkm\bean\form;

/**
 * Option
 *
 * @author pherrera
 */
class Option {

    private $label = "";
    private $value = "";
    private $selected = false;

    function __construct() {
        
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function isSelected() {
        return $this->selected;
    }

    public function setSelected($selected) {
        $this->selected = $selected;
    }

    public function toString() {
        return "{label=" . $this->label . ", value=" . $this->value . ", selected=" . $this->selected . "}";
    }

}
?>

