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

use openkm\bean\GrantedRole;
use openkm\bean\GrantedUser;
use openkm\definition\BaseAuth;
use openkm\util\UriHelper;
use Httpful\Request;

/**
 * AuthImpl
 *
 * @author sochoa
 */
class AuthImpl implements BaseAuth {

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
        $client->expectesXml();
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }
    
    /**
     * getClientWithHTMLResponse     
     */
    private function getClientWithHTMLResponse(Request $client) {
        $client->sendsXml();
        $client->expectsHtml();
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }

    public function getGrantedRoles($nodeId) {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_GRANTED_ROLES);
        $uri .= '?nodeId=' . $nodeId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $grantedRoles = array();
        foreach ($response->body->grantedRole as $grantedRoleXML) {
            $grantedRole = new GrantedRole();
            $grantedRole->setPermissions((int)$grantedRoleXML->permissions);
            $grantedRole->setRole((string)$grantedRoleXML->role);
            $grantedRoles[] = $grantedRole;
        }
        return $grantedRoles;
    }

    public function getGrantedUsers($nodeId) {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_GRANTED_USERS);
        $uri .= '?nodeId=' . $nodeId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $grantedUsers = array();
        foreach ($response->body->grantedUser as $grantedUserXML) {
            $grantedUser = new GrantedUser();
            $grantedUser->setPermissions((int)$grantedUserXML->permissions);
            $grantedUser->setUser((string)$grantedUserXML->user);
            $grantedUsers[] = $grantedUser;
        }
        return $grantedUsers;
    }

    public function getRoles() {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_ROLES);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $roles = array();
        foreach ($response->body->role as $roleXML) {
            $roles[] = (string)$roleXML;
        }
        return $roles;
    }

    public function getUsers() {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_USERS);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $users = array();
        foreach ($response->body->user as $userXML) {
            $users[] = (string)$userXML;
        }
        return $users;
    }

    public function grantRole($nodeId, $role, $permissions, $recursive) {       
    }

    public function grantUser($nodeId, $user, $permissions, $recursive) {
        
    }

    public function revokeRole($nodeId, $role, $permissions, $recursive) {
        
    }

    public function revokeUser($nodeId, $user, $permissions, $recursive) {
        
    }

    public function getUsersByRole($role) {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_USERS_BY_ROLE);
        $uri .= '/' . $role;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $users = array();
        foreach ($response->body->user as $userXML) {
            $users[] = (string)$userXML;
        }
        return $users;
    }

    public function getRolesByUser($user) {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_ROLES_BY_USER);
        $uri .= '/' . $user;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $roles = array();
        foreach ($response->body->role as $roleXML) {
            $roles[] = (string)$roleXML;
        }
        return $roles;
    }

    public function getMail($user) {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_MAIL);
        $uri .= '/' . $user;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string)$response->body;
    }

    public function getName($user) {
        $uri = UriHelper::getUri($this->host, UriHelper::AUTH_GET_NAME);
        $uri .= '/' . $user;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string)$response->body;
    }

}

?>
