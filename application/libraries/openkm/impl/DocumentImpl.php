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
use openkm\bean\Document;
use openkm\bean\Note;
use openkm\bean\Version;
use openkm\bean\LockInfo;
use openkm\definition\BaseDocument;
use openkm\util\UriHelper;
use Httpful\Request;

/**
 * DocumentImpl
 *
 * @author sochoa
 */
class DocumentImpl implements BaseDocument {

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

    public function createDocument(Document $okmDocument, $is) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_CREATE);
        $uri .= '?content=' . $is;
        $client = Request::post($uri);
        $documentXML = new \SimpleXMLElement('<document></document>');
        $documentXML->addChild('author', $okmDocument->getAuthor());
        $documentXML->addChild('created', $okmDocument->getCreated());
        $documentXML->addChild('path', $okmDocument->getPath());
        $documentXML->addChild('permissions', $okmDocument->getPermissions());
        $documentXML->addChild('subscribed', $okmDocument->isSubscribed());
        $documentXML->addChild('uuid', $okmDocument->getUuid());
        //version
        $versionXML = $documentXML->addChild('actualVersion');
        $versionXML->addChild('actual', $okmDocument->getActualVersion()->getActual());
        $versionXML->addChild('author', $okmDocument->getActualVersion()->getAuthor());
        $versionXML->addChild('checksum', $okmDocument->getActualVersion()->getChecksum());
        $versionXML->addChild('created', $okmDocument->getActualVersion()->getCreated());
        $versionXML->addChild('name', $okmDocument->getActualVersion()->getName());
        $versionXML->addChild('size', $okmDocument->getActualVersion()->getSize());

        $documentXML->addChild('checkedOut', $okmDocument->isCheckedOut());
        $documentXML->addChild('convertibleToDxf', $okmDocument->isConvertibleToDxf());
        $documentXML->addChild('convertibleToPdf', $okmDocument->isConvertibleToPdf());
        $documentXML->addChild('convertibleToSwf', $okmDocument->isConvertibleToSwf());
        $documentXML->addChild('description', $okmDocument->getDescription());
        $documentXML->addChild('language', $okmDocument->getLanguage());
        $documentXML->addChild('lastModified', $okmDocument->getLastModified());
        //LockInfo
        $documentXML->addChild('nodePath', $okmDocument->getLockInfo()->getNodePath());
        $documentXML->addChild('owner', $okmDocument->getLockInfo()->getOwner());
        $documentXML->addChild('token', $okmDocument->getLockInfo()->getToken());

        $documentXML->addChild('locked', $okmDocument->isLocked());
        $documentXML->addChild('mimeType', $okmDocument->getMimeType());
        $documentXML->addChild('signed', $okmDocument->isSigned());
        $documentXML->addChild('title', $okmDocument->getTitle());

        foreach ($okmDocument->getCategories() as $category) {
            $categoryXML = $documentXML->addChild('categories');
            $categoryXML->addChild('author', $category->getAuthor());
            $categoryXML->addChild('created', $category->getCreated());
            $categoryXML->addChild('path', $category->getPath());
            $categoryXML->addChild('permissions', $category->getPermissions());
            $categoryXML->addChild('subscribed', $category->isSubscribed());
            $categoryXML->addChild('uuid', $category->getUuid());
            $categoryXML->addChild('hasChildren', $category->isHasChildren());
        }
        foreach ($okmDocument->getKeywords() as $keyword) {
            $documentXML->addChild('keywords', $keyword);
        }

        foreach ($okmDocument->getNotes() as $note) {
            $noteXML = $documentXML->addChild('notes');
            $noteXML->addChild('author', $note->getAuthor());
            $noteXML->addChild('date', $note->getDate());
            $noteXML->addChild('path', $note->getPath());
            $noteXML->addChild('text', $note->getText());
        }
        foreach ($okmDocument->getSubscriptors() as $subscriptor) {
            $documentXML->addChild('subscriptors', $subscriptor);
        }
        $client->body($documentXML->asXML());
        $response = $this->getClient($client);
        return $this->phpDocument($response->body);
    }

    public function createDocumentSimple($docPath, $is) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_CREATE_SIMPLE);
        $uri .= '?docPath=' . $docPath . '&content=' . $is;
        $client = Request::post($uri);
        $response = $this->getClient($client);
        return $this->phpDocument($response->body);
    }

    public function deleteDocument($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_DELETE);
        $uri .= '?docId=' . $docId;
        $client = Request::delete($uri);
        $this->getClient($client);
    }

    /**
     * getDocumentProperties     
     */
    public function getDocumentProperties($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_PROPERTIES);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpDocument($response->body);
    }

    /**
     * getContent     
     */
    public function getContent($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_CONTENT);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $response->body;
    }

    public function getContentByVersion($docId, $versionId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_CONTENT_BY_VERSION);
        $uri .= '?docId=' . $docId . '&versionId=' . $versionId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $response->body;
    }

    /**
     * getDocumentChildren     
     */
    public function getDocumentChildren($fldId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_CHILDREN);
        $uri .= '?fldId=' . $fldId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $documents = array();
        foreach ($response->body->document as $documentXML) {
            $documents[] = $this->phpDocument($documentXML);
        }
        return $documents;
    }

    public function renameDocument($docId, $newName) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_RENAME);
        $uri .= '?docId=' . $docId . '&newName=' . $newName;
        $client = Request::put($uri);
        $response = $this->getClient($client);
        return $this->phpDocument($response->body);
    }

    public function setProperties(Document $okmDocument) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_SET_PROPERTIES);
        $client = Request::put($uri);
        $documentXML = new \SimpleXMLElement('<document></document>');
        $documentXML->addChild('author', $okmDocument->getAuthor());
        $documentXML->addChild('created', $okmDocument->getCreated());
        $documentXML->addChild('path', $okmDocument->getPath());
        $documentXML->addChild('permissions', $okmDocument->getPermissions());
        $documentXML->addChild('subscribed', $okmDocument->isSubscribed());
        $documentXML->addChild('uuid', $okmDocument->getUuid());
        //version
        $versionXML = $documentXML->addChild('actualVersion');
        $versionXML->addChild('actual', $okmDocument->getActualVersion()->getActual());
        $versionXML->addChild('author', $okmDocument->getActualVersion()->getAuthor());
        $versionXML->addChild('checksum', $okmDocument->getActualVersion()->getChecksum());
        $versionXML->addChild('created', $okmDocument->getActualVersion()->getCreated());
        $versionXML->addChild('name', $okmDocument->getActualVersion()->getName());
        $versionXML->addChild('size', $okmDocument->getActualVersion()->getSize());

        $documentXML->addChild('checkedOut', $okmDocument->isCheckedOut());
        $documentXML->addChild('convertibleToDxf', $okmDocument->isConvertibleToDxf());
        $documentXML->addChild('convertibleToPdf', $okmDocument->isConvertibleToPdf());
        $documentXML->addChild('convertibleToSwf', $okmDocument->isConvertibleToSwf());
        $documentXML->addChild('description', $okmDocument->getDescription());
        $documentXML->addChild('language', $okmDocument->getLanguage());
        $documentXML->addChild('lastModified', $okmDocument->getLastModified());
        //LockInfo
        $documentXML->addChild('nodePath', $okmDocument->getLockInfo()->getNodePath());
        $documentXML->addChild('owner', $okmDocument->getLockInfo()->getOwner());
        $documentXML->addChild('token', $okmDocument->getLockInfo()->getToken());

        $documentXML->addChild('locked', $okmDocument->isLocked());
        $documentXML->addChild('mimeType', $okmDocument->getMimeType());
        $documentXML->addChild('signed', $okmDocument->isSigned());
        $documentXML->addChild('title', $okmDocument->getTitle());

        foreach ($okmDocument->getCategories() as $category) {
            $categoryXML = $documentXML->addChild('categories');
            $categoryXML->addChild('author', $category->getAuthor());
            $categoryXML->addChild('created', $category->getCreated());
            $categoryXML->addChild('path', $category->getPath());
            $categoryXML->addChild('permissions', $category->getPermissions());
            $categoryXML->addChild('subscribed', $category->isSubscribed());
            $categoryXML->addChild('uuid', $category->getUuid());
            $categoryXML->addChild('hasChildren', $category->isHasChildren());
        }
        foreach ($okmDocument->getKeywords() as $keyword) {
            $documentXML->addChild('keywords', $keyword);
        }

        foreach ($okmDocument->getNotes() as $note) {
            $noteXML = $documentXML->addChild('notes');
            $noteXML->addChild('author', $note->getAuthor());
            $noteXML->addChild('date', $note->getDate());
            $noteXML->addChild('path', $note->getPath());
            $noteXML->addChild('text', $note->getText());
        }
        foreach ($okmDocument->getSubscriptors() as $subscriptor) {
            $documentXML->addChild('subscriptors', $subscriptor);
        }
        $client->body($documentXML->asXML());
        $this->getClient($client);
    }
    
    public function checkout($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_CHECKOUT);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $this->getClient($client);
    }

    public function cancelCheckout($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_CANCEL_CHECKOUT);
        $uri .= '?docId=' . $docId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function forceCancelCheckout($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_FORCE_CANCEL_CHECKOUT);
        $uri .= '?docId=' . $docId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function isCheckedOut($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_IS_CHECKOUT);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string) $response->body;
    }

    public function checkin($docId, $is, $comment) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_CHECKIN);
        $uri .= '?docId=' . $docId . '&content=' . $is . '&comment=' . $comment;
        $client = Request::post($uri);
        $response = $this->getClient($client);
        return $this->phpVersion($response->body);
    }

    public function getVersionHistory($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_VERSION_HISTORY);
        $uri .='?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $versions = array();
        foreach ($response->body->version as $versionXML) {
            $versions[] = $this->phpVersion($versionXML);
        }
        return $versions;
    }

    public function lock($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_LOCK);
        $uri .= '?docId=' . $docId;
        $client = Request::put($uri);
        $response = $this->getClient($client);
        return $this->phpLockInfo($response->body);
    }

    public function unlock($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_UNLOCK);
        $uri .= '?docId=' . $docId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function forceUnlock($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_FORCE_UNLOCK);
        $uri .= '?docId=' . $docId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function isLocked($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_IS_LOCKED);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string) $response->body;
    }

    public function getLockInfo($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_LOCKINFO);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        return $this->phpLockInfo($response->body);
    }

    public function purgeDocument($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_PURGE);
        $uri .= '?docId=' . $docId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function moveDocument($docId, $dstId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_MOVE);
        $uri .= '?docId=' . $docId . '&dstId=' . $dstId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function copyDocument($docId, $dstId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_COPY);
        $uri .= '?docId=' . $docId . '&dstId=' . $dstId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function restoreVersion($docId, $versionId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_RESTORE_VERSION);
        $uri .= '?docId=' . $docId . '&versionId=' . $versionId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function purgeVersionHistory($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_PURGE_VERSION_HISTORY);
        $uri .= '?docId=' . $docId;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function getVersionHistorySize($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_VERSION_HISTORY_SIZE);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (int) $response->body;
    }

    public function isValidDocument($docId) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_IS_VALID);
        $uri .= '?docId=' . $docId;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string) $response->body;
    }

    public function getDocumentPath($uuid) {
        $uri = UriHelper::getUri($this->host, UriHelper::DOCUMENT_GET_PATH);
        $uri .= '?uuid=' . $uuid;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string) $response->body;
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
