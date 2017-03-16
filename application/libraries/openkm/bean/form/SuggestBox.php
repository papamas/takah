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
 * SuggestBox
 *
 * @author pherrera
 */
class SuggestBox extends FormElement {

    private $validators = array();
    private $value = '';
    private $data = '';
    private $readonly = false;
    private $table = '';
    private $dialogTitle = '';
    private $filterQuery = '';
    private $valueQuery = '';
    private $filterMinLen = 0;

    function __construct() {
        
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

    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function getFilterQuery() {
        return $this->filterQuery;
    }

    public function setFilterQuery($filterQuery) {
        $this->filterQuery = $filterQuery;
    }

    public function getValueQuery() {
        return $this->valueQuery;
    }

    public function setValueQuery($valueQuery) {
        $this->valueQuery = $valueQuery;
    }

    public function getDialogTitle() {
        return $this->dialogTitle;
    }

    public function setDialogTitle($dialogTitle) {
        $this->dialogTitle = $dialogTitle;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getFilterMinLen() {
        return $this->filterMinLen;
    }

    public function setFilterMinLen($filterMinLen) {
        $this->filterMinLen = $filterMinLen;
    }

    public function toString() {
        return "{label=" . $this->label . ", name=" . $this->name . ", value=" . $this->value . ", data=" . $this->data . ", width=" . $this->width . ", height=" . $this->height . ", readonly=" . $this->readonly . ", table=" . $this->table . ", filterQuery=" . $this->filterQuery . ", valueQuery=" . $this->valueQuery . ", dialogTitle=" . $this->dialogTitle . ", filterMinLen=" . $this->filterMinLen . ", validators=" . $this->validators . "}";
    }

}
?>

