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

namespace openkm\impl;

use openkm\definition\BaseProperty;
use openkm\util\UriHelper;
use Httpful\Request;

/**
 * PropertyImpl
 *
 * @author sochoa
 */
class PropertyImpl implements BaseProperty {

    private $host;
    private $user;
    private $password;

    /**
     * Construct
     */
    public function __construct($host, $user, $password) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * getClient
     */
    private function getClient(Request $client) {
        $client->sendsXml();
        $client->expectsXml();
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }       

    public function addCategory($nodeId, $catId) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_ADD_CATEGORY);
        $uri .= '?nodeId=' . $nodeId . '&catId=' . $catId;
        $client = Request::post($uri);
        $this->getClient($client);
    }

    public function removeCategory($nodeId, $catId) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_REMOVE_CATEGORY);
        $uri .= '?nodeId=' . $nodeId . '&catId=' . $catId;
        $client = Request::delete($uri);
        $this->getClient($client);
    }

    public function addKeyword($nodeId, $keyword) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_ADD_KEYWORD);
        $uri .= '?nodeId=' . $nodeId . '&keyword=' . $keyword;
        $client = Request::post($uri);
        $this->getClient($client);
    }

    public function removeKeyword($nodeId, $keyword) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_REMOVE_KEYWORD);
        $uri .= '?nodeId=' . $nodeId . '&keyword=' . $keyword;
        $client = Request::delete($uri);
        $this->getClient($client);
    }

    public function setEncryption($nodeId, $cipherName) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_SET_ENCRYPTION);
        $uri .= '?nodeId=' . $nodeId . '&cipherName=' . $cipherName;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function unsetEncryption($nodeId) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_UNSET_ENCRYPTION);
        $uri .= '?nodeId=' . $nodeId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function setSigned($nodeId, $signed) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_SET_SIGNED);
        $uri .= '?nodeId=' . $nodeId . '&signed=' . $signed;
        $client = Request::put($uri);
        $this->getClient($client);
    }

}

?>
