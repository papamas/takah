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

use openkm\bean\Folder;
use openkm\bean\Note;
use openkm\definition\BaseFolder;
use openkm\util\UriHelper;
use Httpful\Request;

/**
 * FolderImpl
 *
 * @author sochoa
 */
class FolderImpl implements BaseFolder {

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

    /**
     * getClientWithHTMLResponse
     */
    private function getClientWithHTMLResponse(Request $client) {
        $client->sendsXml();
        $client->expectsHtml();
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }

    /**
     * 
     * @param \openkm\bean\Folder $okmFolder
     * @return type \openkm\bean\Folder
     */              
    public function createFolder(Folder $okmFolder) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_CREATE);
        $client = Request::post($uri);
        $folderXML = new \SimpleXMLElement('<folder></folder>');
        $folderXML->addChild('author', $okmFolder->getAuthor());
        $folderXML->addChild('created', $okmFolder->getCreated());
        $folderXML->addChild('path', $okmFolder->getPath());
        $folderXML->addChild('permissions', $okmFolder->getPermissions());
        $folderXML->addChild('subscribed', $okmFolder->isSubscribed());
        $folderXML->addChild('uuid', $okmFolder->getUuid());
        $folderXML->addChild('hasChildren', $okmFolder->isHasChildren());
        foreach ($okmFolder->getCategories() as $category) {
            $categoryXML = $folderXML->addChild('categories');
            $categoryXML->addChild('author', $category->getAuthor());
            $categoryXML->addChild('created', $category->getCreated());
            $categoryXML->addChild('path', $category->getPath());
            $categoryXML->addChild('permissions', $category->getPermissions());
            $categoryXML->addChild('subscribed', $category->isSubscribed());
            $categoryXML->addChild('uuid', $category->getUuid());
            $categoryXML->addChild('hasChildren', $category->isHasChildren());
        }
        foreach ($okmFolder->getKeywords() as $keyword) {
            $folderXML->addChild('keywords', $keyword);
        }

        foreach ($okmFolder->getNotes() as $note) {
            $noteXML = $folderXML->addChild('notes');
            $noteXML->addChild('author', $note->getAuthor());
            $noteXML->addChild('date', $note->getDate());
            $noteXML->addChild('path', $note->getPath());
            $noteXML->addChild('text', $note->getText());
        }
        foreach ($okmFolder->getSubscriptors() as $subscriptor) {
            $folderXML->addChild('subscriptors', $subscriptor);
        }
        $client->body($folderXML->asXML());
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function createFolderSimple($fldPath) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_CREATE_SIMPLE);
        $client = Request::post($uri);
        $client->body($fldPath);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function getFolderProperties($fldId) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_GET_PROPERTIES);
        $uri .= '?fldId=' . $fldId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function deleteFolder($fldId) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_DELETE);
        $uri .= '?fldId=' . $fldId;
        $client = Request::delete($uri);
        $response = $this->getClient($client);
    }

    public function renameFolder($fldId, $newName) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_RENAME);
        $uri .= '?fldId=' . $fldId . '&newName=' . $newName;
        $client = Request::put($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function moveFolder($fldId, $dstId) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_MOVE);
        $uri .= '?fldId=' . $fldId . '&dstId=' . $dstId;
        $client = Request::put($uri);
        $response = $this->getClient($client);        
    }

    public function getFolderChildren($fldId) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_GET_CHILDREN);
        $uri .= '?fldId=' . $fldId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $folders = array();
        foreach ($response->body->folder as $folderXML) {
            $folders[] = $this->phpFolderComplete($folderXML);
        }
        return $folders;
    }

    public function isValidFolder($fldId) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_IS_VALID);
        $uri .= '?fldId=' . $fldId;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string) $response->body;
    }

    public function getFolderPath($uuid) {
        $uri = UriHelper::getUri($this->host, UriHelper::FOLDER_GET_PATH);
        $uri .= '?uuid=' . $uuid;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string) $response->body;
    }

    /**
     * phpFolderComplete
     * @param type $folderXML
     * @return type \openkm\bean\Folder
     */
    public function phpFolderComplete($folderXML) {        
        $folder = $this->phpFolder($folderXML);
        $categories = array();
        foreach ($folderXML->categories as $categoryXML) {
            $categories[] = $this->phpFolder($categoryXML);
        }
        $folder->setCategories($categories);
        $keywords = array();
        foreach ($folderXML->keywords as $keywordXML) {
            $keywords[] = (string) $keywordXML;
        }
        $folder->setKeywords($keywords);
        $notes = array();
        foreach ($folderXML->notes as $noteXML) {
            $note = new Note();
            $note->setAuthor((string) $noteXML->author);
            $note->setDate((string) $noteXML->date);
            $note->setPath((string) $noteXML->path);
            $note->setText((string) $noteXML->text);
            $notes[] = $note;
        }
        $folder->setNotes($notes);
        $subscriptors = array();
        foreach ($folderXML->subscriptors as $subscriptor) {
            $subscriptors[] = $subscriptor;
        }
        $folder->setSubscriptors($subscriptors);
        return $folder;
    }

    public function phpFolder($folderXML) {
        $folder = new Folder();
        $folder->setAuthor((string) $folderXML->author);
        $folder->setCreated((string) $folderXML->created);
        $folder->setPath((string) $folderXML->path);
        $folder->setPermissions((int) $folderXML->permissions);
        $folder->setSubscribed((string) $folderXML->subscribed);
        $folder->setUuid((string) $folderXML->uuid);
        $folder->setHasChildren((string) $folderXML->hasChildren);
        return $folder;
    }

}

?>
