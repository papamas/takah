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
 * ProposedQueryReceived
 *
 * @author sochoa
 */
class ProposedQueryReceived {

    const serialVersionUID = '1L';

    private $id;
    private $from;
    private $to;
    private $user;
    private $comment;
    private $accepted;
    private $seenDate;
    private $sentDate;

    public function getId() {
        return id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFrom() {
        return $this->from;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function getTo() {
        return $this->to;
    }

    public function setTo($to) {
        $this->to = $to;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function isAccepted() {
        return $this->accepted;
    }

    public function setAccepted($accepted) {
        $this->accepted = $accepted;
    }

    public function getSeenDate() {
        return $this->seenDate;
    }

    public function setSeenDate($seenDate) {
        $this->seenDate = $seenDate;
    }

    public function getSentDate() {
        return $this->sentDate;
    }

    public function setSentDate($sentDate) {
        $this->sentDate = $sentDate;
    }

    public function toString() {
        return "{id=" . $this->id . ", from=" . $this->from . ", to=" . $this->to . ", user=" . $this->user . ", accepted=" . $this->accepted . ", seenDate=" . $this->seenDate == null ? null : $this->seenDate->getTime() . ", sentDate=" . $this->sentDate == null ? null : $this->sentDate->getTime() . "}";
    }

}
?>

