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

namespace openkm\definition;

/**
 * BaseAuth
 * 
 * @author sochoa
 */
interface BaseAuth {

    public function getGrantedRoles($nodeId);

    public function getGrantedUsers($nodeId);

    public function getRoles();

    public function getUsers();

    public function grantRole($nodeId, $role, $permissions, $recursive);

    public function grantUser($nodeId, $user, $permissions, $recursive);

    public function revokeRole($nodeId, $role, $permissions, $recursive);

    public function revokeUser($nodeId, $user, $permissions, $recursive);

    public function getUsersByRole($role);

    public function getRolesByUser($user);

    public function getMail($user);

    public function getName($user);
}

?>
