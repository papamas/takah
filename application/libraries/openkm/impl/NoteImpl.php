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

use openkm\definition\BaseNote;
use openkm\bean\Note;
use openkm\util\UriHelper;
use Httpful\Request;

/**
 * NoteImpl
 *
 * @author sochoa
 */
class NoteImpl implements BaseNote {

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
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }

    public function addNote($nodeId, $text) {
        $uri = UriHelper::getUri($this->host, UriHelper::NOTE_ADD);
        $uri .= '?nodeId=' . $nodeId;
        $client = Request::post($uri);
        $client->body($text);
        $response = $this->getClient($client);
        return $this->phpNote($response->body);
    }

    public function getNote($noteId) {
        $uri = UriHelper::getUri($this->host, UriHelper::NOTE_GET);
        $uri .= '?noteId=' . $noteId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpNote($response->body);
    }
    
    public function deleteNote($noteId) {
        $uri = UriHelper::getUri($this->host, UriHelper::NOTE_DELETE);
        $uri .= '?noteId=' . $noteId;
        $client = Request::delete($uri);
        $this->getClient($client);
    }
    
    public function setNote($noteId, $text) {
        $uri = UriHelper::getUri($this->host, UriHelper::NOTE_SET);
        $uri .= '?noteId=' . $noteId;
        $client = Request::put($uri);
        $client->body($text);
        $this->getClient($client);
    }
    
    /**
     * listNotes
     * @param type $nodeId
     * @return type array \openkm\bean\Note
     */
    public function listNotes($nodeId) {
        $uri = UriHelper::getUri($this->host, UriHelper::NOTE_LIST);
        $uri .= '?nodeId=' . $nodeId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $notes = array();
        foreach ($response->body->note as $noteXML) {
            $notes[] = $this->phpNote($noteXML);
        }
        return $notes;
    }   

    public function phpNote($noteXML) {
        $note = new Note();
        $note->setAuthor((string)$noteXML->author);
        $note->setDate((string)$noteXML->date);
        $note->setPath((string)$noteXML->path);
        $note->setText((string)$noteXML->text);
        return $note;
    }

}

?>
