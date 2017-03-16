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
 * Select
 *
 * @author pherrera
 */
class Select extends FormElement {

    const TYPE_SIMPLE = "simple";
    const TYPE_MULTIPLE = "multiple";

    private $validators = array();
    private $options = array();
    private $type = 'TYPE_SIMPLE';
    private $value = '';
    private $data = '';
    private $optionsData = '';
    private $table = '';
    private $optionsQuery = '';
    private $suggestion = '';
    private $readonly = false;

    function __construct() {
        $this->width = '150px';
    }

    public function getOptions() {
        return $this->options;
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

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getOptionsData() {
        return $this->optionsData;
    }

    public function setOptionsData($optionsData) {
        $this->optionsData = $optionsData;
    }

    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function getOptionsQuery() {
        return $this->optionsQuery;
    }

    public function setOptionsQuery($optionsQuery) {
        $this->optionsQuery = $optionsQuery;
    }

    public function getSuggestion() {
        return $this->suggestion;
    }

    public function setSuggestion($suggestion) {
        $this->suggestion = $suggestion;
    }

    public function isReadonly() {
        return $this->readonly;
    }

    public function setReadonly($readonly) {
        $this->readonly = $readonly;
    }

    public function toString() {
        return "{label=" . $this->label . ", name=" . $this->name . ", width=" . $this->width . ", height=" . $this->height . ", readonly=" . $this->readonly . ", type=" . $this->type . ", value=" . $this->value . ", data=" . $this->data . ", optionsData=" . $this->optionsData . ", options=" . $this->options . ", validators=" . $this->validators . ", table=" . $this->table . ", optionsQuery=" . $this->optionsQuery . ", suggestion=" . $this->suggestion . "}";
    }

}
?>

