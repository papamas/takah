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

use openkm\bean\AppVersion;
use openkm\bean\Folder;
use openkm\bean\Note;
use openkm\definition\BaseRepository;
use openkm\util\UriHelper;
use Httpful\Request;

/**
 * RepositoryImpl
 *
 * @author sochoa
 */
class RepositoryImpl implements BaseRepository {

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

    public function getRootFolder() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ROOT_FOLDER);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function getTrashFolder() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ROOT_TRASH);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function getTemplatesFolder() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ROOT_TEMPLATES);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function getPersonalFolder() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ROOT_PERSONAL);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function getMailFolder() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ROOT_MAIL);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function getThesaurusFolder() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ROOT_THESAURUS);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function getCategoriesFolder() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ROOT_CATEGORIES);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpFolderComplete($response->body);
    }

    public function purgeTrash() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_PURGE_TRASH);
        $client = Request::delete($uri);
        $this->getClient($client);
    }

    public function getUpdateMessage() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_UPDATE_MESSAGE);
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return $response->body;
    }

    public function getRepositoryUuid() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_RESPOSITORY_UUID);
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return $response->body;
    }

    public function hasNode($nodeId) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_HAS_NODE);
        $uri .= '?nodeId=' . $nodeId;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return $response->body;
    }

    public function getNodePath($uuid) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_NODE_PATH);
        $uri .= '?uuid=' . $uuid;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return $response->body;
    }

    public function getNodeUuid($nodePath) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_NODE_UUID);
        $uri .= '?nodePath=' . $nodePath;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string)$response->body;
    }

    /**
     * getAppVersion
     * @return \openkm\bean\AppVersion
     */
    public function getAppVersion() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_APP_VERSION);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $appVersionXML = $response->body;
        $appVersion = new AppVersion();
        $appVersion->setBuild((string) $appVersionXML->build);
        $appVersion->setExtension((string) $appVersionXML->estension);
        $appVersion->setMaintenance((string) $appVersionXML->maintenance);
        $appVersion->setMajor((string) $appVersionXML->major);
        $appVersion->setMinor((string) $appVersionXML->minor);
        return $appVersion;
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
