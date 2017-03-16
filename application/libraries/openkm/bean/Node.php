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
 * Node
 *
 * @author sochoa
 */
class Node {

    const AUTHOR = 'okm:author';
    const NAME = 'okm:name';

    protected $author;
    protected $created;
    protected $path;
    protected $permissions;
    protected $uuid;
    protected $subscribed;
    protected $categories = array();
    protected $subscriptors = array();
    protected $keywords = array();
    protected $notes = array();

    public function getAuthor() {
        return $this->author;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getPath() {
        return $this->path;
    }

    public function getPermissions() {
        return $this->permissions;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function getSubscribed() {
        return $this->subscribed;
    }

    public function getCategories() {
        return $this->categories;
    }

    public function getSubscriptors() {
        return $this->subscriptors;
    }

    public function getKeywords() {
        return $this->keywords;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function setPermissions($permissions) {
        $this->permissions = $permissions;
    }

    public function setUuid($uuid) {
        $this->uuid = $uuid;
    }

    public function setSubscribed($subscribed) {
        $this->subscribed = $subscribed;
    }

    public function setCategories($categories) {
        $this->categories = $categories;
    }

    public function setSubscriptors($subscriptors) {
        $this->subscriptors = $subscriptors;
    }

    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

}

?>
