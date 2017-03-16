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

use openkm\definition\BaseSearch;
use openkm\bean\QueryParams;
use openkm\bean\Note;
use openkm\bean\Document;
use openkm\bean\LockInfo;
use openkm\bean\Version;
use openkm\bean\Folder;
use openkm\bean\ResultSet;
use openkm\bean\QueryResult;
use openkm\bean\Entry;
use openkm\util\UriHelper;
use Httpful\Request;
use openkm\bean\KeywordMap;

/**
 * SearchImpl
 *
 * @author sochoa
 */
class SearchImpl implements BaseSearch {

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

    /**
     * getClientWithHTMLResponse
     */
    private function getClientWithHTMLResponse(Request $client) {
        $client->sendsXml();
        $client->expectsHtml();
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }

    public function findByContent($content) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_FIND_BY_CONTENT);
        $uri .= '?content=' . $content;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $queryResults = array();
        foreach ($response->body->queryResult as $queryResultXML) {
            $queryResults[] = $this->phpQueryResult($queryResultXML);
        }
        return $queryResults;
    }

    public function findByName($name) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_FIND_BY_NAME);
        $uri .= '?name=' . $name;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $queryResults = array();
        foreach ($response->body->queryResult as $queryResultXML) {
            $queryResults[] = $this->phpQueryResult($queryResultXML);
        }
        return $queryResults;
    }

    public function findByKeywords($keywords = array()) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_FIND_BY_KEYWORDS);
        for ($i = 0; $i < count($keywords); $i++) {
            if ($i == 0) {
                $uri .= '?keyword=' . $keywords[$i];
            } else {
                $uri .= '&keyword=' . $keywords[$i];
            }
        }
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $queryResults = array();
        foreach ($response->body->queryResult as $queryResultXML) {
            $queryResults[] = $this->phpQueryResult($queryResultXML);
        }
        return $queryResults;
    }

    public function find(QueryParams $queryParams) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_FIND);
        $uri = $this->makeUri($queryParams, $uri);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $queryResults = array();
        foreach ($response->body->queryResult as $queryResultXML) {
            $queryResults[] = $this->phpQueryResult($queryResultXML);
        }
        return $queryResults;
    }

    public function findPaginated(QueryParams $queryParams, $offset, $limit) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_FIND_PAGINATED);
        $uri = $this->makeUri($queryParams, $uri);
        $uri .= '&offset=' . $offset . '&limit=' . $limit;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $resulSetXML = $response->body;
        $resultSet = new ResultSet();
        $resultSet->setTotal($resulSetXML->total);
        $results = array();
        foreach ($resulSetXML->results as $queryResultXML) {
            $results[] = $this->phpQueryResult($queryResultXML);
        }
        $resultSet->setResults($results);
        return $resultSet;
    }

    public function findSimpleQueryPaginated($statement, $offset, $limit) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_FIND_SIMPLE_QUERY_PAGINATED);
        $uri .= '?statement=' . $statement . '&offset=' . $offset . '&limit=' . $limit;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $resulSetXML = $response->body;
        $resultSet = new ResultSet();
        $resultSet->setTotal($resulSetXML->total);
        $results = array();
        foreach ($resulSetXML->results as $queryResultXML) {
            $results[] = $this->phpQueryResult($queryResultXML);
        }
        $resultSet->setResults($results);
        return $resultSet;
    }

    public function findMoreLikeThis($uuid, $max) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_FIND_SIMPLE_QUERY_PAGINATED);
        $uri .= '/' . $uuid . '/' . $max;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $resulSetXML = $response->body;
        $resultSet = new ResultSet();
        $resultSet->setTotal($resulSetXML->total);

        $results = array();
        foreach ($resulSetXML->results as $queryResultXML) {
            $results[] = $this->phpQueryResult($queryResultXML);
        }
        $resultSet->setResults($results);
        return $resultSet;
    }

    public function getKeywordMap($filter = array()) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_KEYWORD_MAP);
        for ($i = 0; $i < count($filter); $i++) {
            if ($i == 0) {
                $uri .= '?filter=' . $filter[$i];
            } else {
                $uri .= '&filter=' . $filter[$i];
            }
        }
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $keywordMaps = array();
        foreach ($response->body->keywordMap as $keywordMapXML) {
            $keywordMap = new KeywordMap();
            $keywordMap->setKeyword($keywordMapXML->keyword);
            $keywordMap->setOccurs($keywordMapXML->occurs);
            $keywordMaps[] = $keywordMap;
        }
        return $keywordMaps;
    }

    public function getCategorizedDocuments($categoryId) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_CATEGORIZED_DOCUMENTS);
        $uri .= '/' . $categoryId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $documents = array();
        foreach ($response->body->document as $documentXML) {
            $documents[] = $this->phpDocument($documentXML);
        }
        return $documents;
    }

    public function saveSearch(QueryParams $params) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_SAVE_SEARCH);
        $client = Request::post($uri);
        $queryParamsXML = new \SimpleXMLElement('<queryParams></queryParams>');
        $queryParamsXML->addChild('author', $params->getAuthor());
        $queryParamsXML->addChild('content', $params->getContent());
        $queryParamsXML->addChild('dashboard', $params->isDashboard());
        $queryParamsXML->addChild('domain', $params->getDomain());
        $queryParamsXML->addChild('id', $params->getId());
        $queryParamsXML->addChild('lastModifiedFrom', $params->getLastModifiedFrom());
        $queryParamsXML->addChild('lastModifiedTo', $params->getLastModifiedTo());
        $queryParamsXML->addChild('mailFrom', $params->getMailFrom());
        $queryParamsXML->addChild('mailSubject', $params->getMailSubject());
        $queryParamsXML->addChild('mailTo', $params->getMailTo());
        $queryParamsXML->addChild('mimeType', $params->getMimeType());
        $queryParamsXML->addChild('name', $params->getName());
        $queryParamsXML->addChild('operator', $params->getOperator());
        $queryParamsXML->addChild('path', $params->getPath());
        $queryParamsXML->addChild('queryName', $params->getQueryName());
        $queryParamsXML->addChild('user', $params->getUser());
        foreach ($params->getCategories() as $category) {
            $queryParamsXML->addChild('categories', $category);
        }
        foreach ($params->getKeywords() as $keyword) {
            $queryParamsXML->addChild('keywords', $keyword);
        }
        $propertiesXML = $queryParamsXML->addChild('properties');
        foreach ($params->getProperties() as $entry) {
            $entryXML = $propertiesXML->addChild('entry');
            $entryXML->addChild('key', $entry->getKey());
            $entryXML->addChild('value', $entry->getValue());
        }
        $client->body($queryParamsXML->asXML());
        $response = $this->getClientWithHTMLResponse($client);
        return (int) $response->body;
    }

    public function updateSearch(QueryParams $params) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_UPDATE_SEARCH);
        $client = Request::put($uri);
        $queryParamsXML = new \SimpleXMLElement('<queryParams></queryParams>');
        $queryParamsXML->addChild('author', $params->getAuthor());
        $queryParamsXML->addChild('content', $params->getContent());
        $queryParamsXML->addChild('dashboard', $params->isDashboard());
        $queryParamsXML->addChild('domain', $params->getDomain());
        $queryParamsXML->addChild('id', $params->getId());
        $queryParamsXML->addChild('lastModifiedFrom', $params->getLastModifiedFrom());
        $queryParamsXML->addChild('lastModifiedTo', $params->getLastModifiedTo());
        $queryParamsXML->addChild('mailFrom', $params->getMailFrom());
        $queryParamsXML->addChild('mailSubject', $params->getMailSubject());
        $queryParamsXML->addChild('mailTo', $params->getMailTo());
        $queryParamsXML->addChild('mimeType', $params->getMimeType());
        $queryParamsXML->addChild('name', $params->getName());
        $queryParamsXML->addChild('operator', $params->getOperator());
        $queryParamsXML->addChild('path', $params->getPath());
        $queryParamsXML->addChild('queryName', $params->getQueryName());
        $queryParamsXML->addChild('user', $params->getUser());
        foreach ($params->getCategories() as $category) {
            $queryParamsXML->addChild('categories', $category);
        }
        foreach ($params->getKeywords() as $keyword) {
            $queryParamsXML->addChild('keywords', $keyword);
        }
        $propertiesXML = $queryParamsXML->addChild('properties');
        foreach ($params->getProperties() as $entry) {
            $entryXML = $propertiesXML->addChild('entry');
            $entryXML->addChild('key', $entry->getKey());
            $entryXML->addChild('value', $entry->getValue());
        }
        $client->body($queryParamsXML->asXML());
        $this->getClien($client);
    }

    public function getSearch($qpId) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_SEARCH);
        $uri .= '/' . $qpId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpQueryParams($response->body);
    }

    public function getAllSearchs() {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_GET_ALL_SEARCH);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $queriesParams = array();
        foreach ($response->body->queryParams as $queryParamsXML) {
            $queriesParams[] = $this->phpQueryParams($queryParamsXML);
        }
        return $queriesParams;
    }

    public function deleteSearch($qpId) {
        $uri = UriHelper::getUri($this->host, UriHelper::REPOSITORY_DELETE_SEARCH);
        $uri .= '/' . $qpId;
        $client = Request::delete($uri);
        $this->getClient($client);
    }

    public function makeUri(QueryParams $queryParams, $uri) {
        $uri .= '?domain=' . $queryParams->getDomain();
        if ($queryParams->getContent() != "") {
            $uri .= '&content=' . $queryParams->getContent();
        }
        if ($queryParams->getName() != '') {
            $uri .= '&name=' . $queryParams->getName();
        }
        foreach ($queryParams->getKeywords() as $keyword) {
            if ($keyword != '') {
                $uri .= '&keyword=' . $keyword;
            }
        }
        foreach ($queryParams->getCategories() as $category) {
            if($category != ''){
             $uri .= '&category=' . $category;   
            }            
        }
        foreach ($queryParams->getProperties() as $entry) {
            $uri .= '&property=' . $entry->getKey() . '=' . $entry->getValue();
        }
        if ($queryParams->getAuthor() != '') {
            $uri .= '&author=' . $queryParams->getAuthor();
        }
        if ($queryParams->getMimeType() != '') {
            $uri .= '&mimeType=' . $queryParams->getMimeType();
        }
        if ($queryParams->getLastModifiedFrom() != '') {
            $uri .= '&lastModifiedFrom=' . $queryParams->getLastModifiedFrom();
        }
        if ($queryParams->getLastModifiedTo() != '') {
            $uri .= '&lastModifiedTo=' . $queryParams->getLastModifiedTo();
        }
        if ($queryParams->getMailSubject() != '') {
            $uri .= '&mailSubject=' . $queryParams->getMailSubject();
        }
        if ($queryParams->getMailFrom() != '') {
            $uri .= '&mailFrom=' . $queryParams->getMailFrom();
        }
        if ($queryParams->getMailTo() != '') {
            $uri .= '&mailTo=' . $queryParams->getMailTo();
        }
        return $uri;
    }

    public function phpQueryResult($queryResultXML) {
        $queryResult = new QueryResult();
        $queryResult->setExcerpt((string) $queryResultXML->excerpt);
        if (!empty($queryResultXML->document)) {
            $queryResult->setDocument($this->phpDocument($queryResultXML->document));
        }
        if (!empty($queryResultXML->folder)) {
            $queryResult->setFolder($this->phpFolderComplete($queryResultXML->folder));
        }
        $queryResult->setScore((int) $queryResultXML->score);
        return $queryResult;
    }

    public function phpDocument($documentXML) {
        $document = new Document();
        $document->setAuthor((string) $documentXML->author);
        $document->setCreated((string) $documentXML->created);
        $document->setPath((string) $documentXML->path);
        $document->setPermissions((int) $documentXML->permissions);
        $document->setSubscribed((string) $documentXML->subscribed);
        $document->setUuid((string) $documentXML->uuid);

        //Version        
        $document->setActualVersion($this->phpVersion($documentXML->actualVersion));

        $document->setCheckedOut((string) $documentXML->checkedOut);
        $document->setConvertibleToDxf((string) $documentXML->convertibleToDxf);
        $document->setConvertibleToPdf((string) $documentXML->convertibleToPdf);
        $document->setConvertibleToSwf((string) $documentXML->convertibleToSwf);
        $document->setDescription((string) $documentXML->description);
        $document->setLanguage((string) $documentXML->language);
        $document->setLastModified((string) $documentXML->lastModified);

        //LockInfo        
        $document->setLockInfo($this->phpLockInfo($documentXML->lockInfo));

        $document->setLocked((string) $documentXML->locked);
        $document->setMimeType((string) $documentXML->mimeType);
        $document->setSigned((string) $documentXML->signed);
        $document->setTitle((string) $documentXML->title);

        //categories
        $categories = array();
        foreach ($documentXML->categories as $categoryXML) {
            $categories[] = $this->phpFolder($categoryXML);
        }
        $document->setCategories($categories);
        //keywords
        $keywords = array();
        foreach ($documentXML->keywords as $keywordXML) {
            $keywords[] = (string) $keywordXML;
        }
        $document->setKeywords($keywords);
        //notes
        $notes = array();
        foreach ($documentXML->notes as $noteXML) {
            $note = new Note();
            $note->setAuthor((string) $noteXML->author);
            $note->setDate((string) $noteXML->date);
            $note->setPath((string) $noteXML->path);
            $note->setText((string) $noteXML->text);
            $notes[] = $note;
        }
        $document->setNotes($notes);
        $subscriptors = array();
        foreach ($documentXML->subscriptors as $subscriptor) {
            $subscriptors[] = $subscriptor;
        }
        $document->setSubscriptors($subscriptors);
        return $document;
    }

    public function phpVersion($versionXML) {
        $version = new Version();
        $version->setActual((string) $versionXML->actual);
        $version->setAuthor((string) $versionXML->author);
        $version->setChecksum((string) $versionXML->checksum);
        $version->setCreated((string) $versionXML->created);
        $version->setName((string) $versionXML->name);
        $version->setSize((string) $versionXML->size);
        return $version;
    }

    public function phpLockInfo($lockInfoXML) {
        $lockInfo = new LockInfo();
        $lockInfo->setNodePath((string) $lockInfoXML->nodePath);
        $lockInfo->setOwner((string) $lockInfoXML->owner);
        $lockInfo->setToken((string) $lockInfoXML->token);
        return $lockInfo;
    }

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

    public function phpQueryParams($queryParamsXML) {
        $queryParams = new QueryParams();
        $queryParams->setAuthor((string) $queryParamsXML->author);
        $queryParams->setContent((string) $queryParamsXML->content);
        $queryParams->setDashboard((string) $queryParamsXML->dashboard);
        $queryParams->setDomain((int) $queryParamsXML->domain);
        $queryParams->setId((int) $queryParamsXML->id);
        $queryParams->setLastModifiedFrom((string) $queryParamsXML->lastModifiedFrom);
        $queryParams->setLastModifiedTo((string) $queryParamsXML->lastModifiedTo);
        $queryParams->setMailFrom((string) $queryParamsXML->mailFrom);
        $queryParams->setMailSubject((string) $queryParamsXML->mailSubject);
        $queryParams->setMailTo((string) $queryParamsXML->mailTo);
        $queryParams->setMimeType((string) $queryParamsXML->mimeType);
        $queryParams->setName((string) $queryParamsXML->name);
        $queryParams->setOperator((string) $queryParamsXML->operator);
        $queryParams->setPath((string) $queryParamsXML->path);
        $queryParams->setQueryName((string) $queryParamsXML->queryName);
        $queryParams->setUser((string) $queryParamsXML->user);
        $categories = array();
        foreach ($queryParamsXML->categories as $category) {
            $categories[] = (string) $category;
        }
        $queryParams->setCategories($categories);
        $keywords = array();
        foreach ($queryParamsXML->keywords as $keyword) {
            $keywords[] = (string) $keyword;
        }
        $queryParams->setKeywords($keywords);
        $properties = array();
        foreach ($queryParamsXML->properties->entry as $entryXML) {
            $entry = new Entry();
            $entry->setKey((string) $entryXML->key);
            $entry->setValue((string) $entryXML->value);
            $properties[] = $entry;
        }
        $queryParams->setProperties($properties);
        return $queryParams;
    }

}

?>
