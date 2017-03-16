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
 * Input
 *
 * @author sochoa
 */
class Input extends FormElement {

    const TYPE_TEXT = 'text';
    const TYPE_DATE = 'date';
    const TYPE_LINK = 'link';
    const TYPE_FOLDER = 'folder';

    private $validators = array();
    private $type = self::TYPE_TEXT;
    private $value = "";
    private $data = "";
    private $readonly = false;

    function __construct() {
        
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getValidators() {
        return $this->validators;
    }

    public function setValidators($validators) {
        $this->validators = $validators;
    }

    public function isReadonly() {
        return $this->readonly;
    }

    public function setReadonly($readonly) {
        $this->readonly = $readonly;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function toString() {
        return
                "{label=" . $this->label . ", name=" . $this->name . ", value=" . $this->value . ", data=" . $this->data . ", width=" . $this->width . ", height=" . $this->height . ", readonly=" . $this->readonly . ", type=" . $this->type . ", validators=" . $this->validators . "}";
    }

}
?>

