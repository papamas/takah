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
 * FormElementComplex
 *
 * @author pherrera
 */
class FormElementComplex {

    private $objClass;
    private $label;
    private $name;
    private $width;
    private $height;
    private $type;
    private $value;
    private $transition = "";
    private $readonly;
    private $options = array();
    private $validators = array();

    function __construct() {
        
    }

    public function getObjClass() {
        return $this->objClass;
    }

    public function setObjClass($objClass) {
        $this->objClass = $objClass;
    }

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

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
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

    public function getTransition() {
        return $this->transition;
    }

    public function setTransition($transition) {
        $this->transition = $transition;
    }

    public function isReadonly() {
        return $this->readonly;
    }

    public function setReadonly($readonly) {
        $this->readonly = $readonly;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    public function getValidators() {
        return $this->validators;
    }

    public function setValidators($validators) {
        $this->validators = $validators;
    }

    public function toString() {
        return "{" . "label=" . $this->label . ", name=" . $this->name . ", width=" . $this->width . ", height=" . $this->height . ", objClass=" . $this->objClass . ", type=" . $this->type . ", value=" . $this->value . ", readonly=" . $this->readonly . ", options=" . $this->options . ", validators=" . $this->validators . "}";
    }

}
