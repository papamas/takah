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
 * Validator
 *
 * @author sochoa
 */
class Validator {

    const TYPE_REQUIRED = "req";
    const TYPE_ALPHABETIC = "alpha";
    const TYPE_DECIMAL = "dec";
    const TYPE_NUMERIC = "num";
    const TYPE_EMAIL = "email";
    const TYPE_URL = "url";
    const TYPE_MAXLENGTH = "maxlen";
    const TYPE_MINLENGTH = "minlen";
    const TYPE_LESSTHAN = "lt";
    const TYPE_GREATERTHAN = "gt";
    const TYPE_MINIMUN = "min";
    const TYPE_MAXIMUN = "max";
    const TYPE_REGEXP = "regexp";

    private $type = '';
    private $parameter = '';

    function __construct() {
        
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getParameter() {
        return $this->parameter;
    }

    public function setParameter($parameter) {
        $this->parameter = $parameter;
    }

    public function toString() {
        return "{type=" . $this->type . ", parameter=" . $this->parameter . "}";
    }

}
?>

