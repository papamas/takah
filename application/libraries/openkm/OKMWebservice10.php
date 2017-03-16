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

namespace openkm;

use openkm\bean\Document;
use openkm\bean\Folder;
use openkm\bean\QueryParams;
use openkm\impl\AuthImpl;
use openkm\impl\DocumentImpl;
use openkm\impl\FolderImpl;
use openkm\impl\NoteImpl;
use openkm\impl\PropertyGroupImpl;
use openkm\impl\PropertyImpl;
use openkm\impl\RepositoryImpl;
use openkm\impl\SearchImpl;

/**
 * OKMWebservice10
 *
 * @author sochoa
 */
class OKMWebservice10 implements OKMWebservices {

    private $authImpl;
    private $docImpl;
    private $fldImpl;
    private $noteImpl;
    private $propertyGroupImpl;
    private $respositoryImpl;
    private $searchImpl;
    private $propertyImpl;

    public function __construct($host, $user, $password) {
        $this->authImpl = new AuthImpl($host, $user, $password);
        $this->docImpl = new DocumentImpl($host, $user, $password);
        $this->fldImpl = new FolderImpl($host, $user, $password);
        $this->noteImpl = new NoteImpl($host, $user, $password);
        $this->propertyGroupImpl = new PropertyGroupImpl($host, $user, $password);
        $this->propertyImpl = new PropertyImpl($host, $user, $password);
        $this->respositoryImpl = new RepositoryImpl($host, $user, $password);
        $this->searchImpl = new SearchImpl($host, $user, $password);
    }

    /**
     * getGrantedRoles
     */
    public function getGrantedRoles($nodeId) {
        return $this->authImpl->getGrantedRoles($nodeId);
    }

    /**
     * getGrantedUsers
     */
    public function getGrantedUsers($nodeId) {
        return $this->authImpl->getGrantedUsers($nodeId);
    }

    /**
     * getMail
     */
    public function getMail($user) {
        return $this->authImpl->getMail($user);
    }

    /**
     * getName
     */
    public function getName($user) {
        return $this->authImpl->getName($user);
    }

    /**
     * getRoles
     */
    public function getRoles() {
        return $this->authImpl->getRoles();
    }

    /**
     * getRolesByUser
     */
    public function getRolesByUser($user) {
        return $this->authImpl->getRolesByUser($user);
    }

    /**
     * getUsers
     */
    public function getUsers() {
        return $this->authImpl->getUsers();
    }

    /**
     * getUsersByRole
     */
    public function getUsersByRole($role) {
        return $this->authImpl->getUsersByRole($role);
    }

    /**
     * revokeRole
     */
    public function revokeRole($nodeId, $role, $permissions, $recursive) {
        return $this->authImpl->revokeRole($nodeId, $role, $permissions, $recursive);
    }

    /**
     * revokeUser
     */
    public function revokeUser($nodeId, $user, $permissions, $recursive) {
        return $this->authImpl->revokeUser($nodeId, $user, $permissions, $recursive);
    }

    /**
     * grantRole
     */
    public function grantRole($nodeId, $role, $permissions, $recursive) {
        return $this->authImpl->grantRole($nodeId, $role, $permissions, $recursive);
    }

    /**
     * grantUser
     */
    public function grantUser($nodeId, $user, $permissions, $recursive) {
        return $this->authImpl->grantUser($nodeId, $user, $permissions, $recursive);
    }

    /**
     * create
     */
    public function createDocument(Document $okmDocument, $is) {
        return $this->docImpl->createDocument($okmDocument, $is);
    }

    /**
     * createSimple
     */
    public function createDocumentSimple($docPath, $is) {
        return $this->docImpl->createDocumentSimple($docPath, $is);
    }

    /**
     * delete
     */
    public function deleteDocument($docId) {
        return $this->docImpl->deleteDocument($docId);
    }

    /**
     * getProperties
     */
    public function getDocumentProperties($docId) {
        return $this->docImpl->getDocumentProperties($docId);
    }

    /**
     * getContent
     */
    public function getContent($docId) {
        return $this->docImpl->getContent($docId);
    }

    /**
     * getContentByVersion
     */
    public function getContentByVersion($docId, $versionId) {
        return $this->docImpl->getContentByVersion($docId, $versionId);
    }

    /**
     * getChildren
     */
    public function getDocumentChildren($fldId) {
        return $this->docImpl->getDocumentChildren($fldId);
    }

    /**
     * rename
     */
    public function renameDocument($docId, $newName) {
        return $this->docImpl->renameDocument($docId, $newName);
    }

    /**
     * setProperties
     */
    public function setProperties(Document $okmDocument) {
        return $this->docImpl->setProperties($okmDocument);
    }

    /**
     * checkout
     */
    public function checkout($docId) {
        return $this->docImpl->checkout($docId);
    }

    /**
     * cancelCheckout
     */
    public function cancelCheckout($docId) {
        return $this->docImpl->cancelCheckout($docId);
    }

    /**
     * forceCancelCheckout
     */
    public function forceCancelCheckout($docId) {
        return $this->docImpl->forceCancelCheckout($docId);
    }

    /**
     * isCheckedOut
     */
    public function isCheckedOut($docId) {
        return $this->docImpl->isCheckedOut($docId);
    }

    /**
     * checkin
     */
    public function checkin($docId, $is, $comment) {
        return $this->docImpl->checkin($docId, $is, $comment);
    }

    /**
     * getVersionHistory
     */
    public function getVersionHistory($docId) {
        return $this->docImpl->getVersionHistory($docId);
    }

    /**
     * lock
     */
    public function lock($docId) {
        return $this->docImpl->lock($docId);
    }

    /**
     * unlock
     */
    public function unlock($docId) {
        return $this->docImpl->unlock($docId);
    }

    /**
     * forceUnlock
     */
    public function forceUnlock($docId) {
        return $this->docImpl->forceUnlock($docId);
    }

    /**
     * isLocked
     */
    public function isLocked($docId) {
        return $this->docImpl->isLocked($docId);
    }

    /**
     * getLockInfo
     */
    public function getLockInfo($docId) {
        return $this->docImpl->getLockInfo($docId);
    }

    /**
     * purge
     */
    public function purgeDocument($docId) {
        return $this->docImpl->purgeDocument($docId);
    }

    /**
     * move
     */
    public function moveDocument($docId, $dstId) {
        return $this->docImpl->moveDocument($docId, $dstId);
    }

    /**
     * copy
     */
    public function copyDocument($docId, $dstId) {
        return $this->docImpl->copyDocument($docId, $dstId);
    }

    /**
     * restoreVersion
     */
    public function restoreVersion($docId, $versionId) {
        return $this->docImpl->restoreVersion($docId, $versionId);
    }

    /**
     * purgeVersionHistory
     */
    public function purgeVersionHistory($docId) {
        return $this->docImpl->purgeVersionHistory($docId);
    }

    /**
     * getVersionHistorySize
     */
    public function getVersionHistorySize($docId) {
        return $this->docImpl->getVersionHistorySize($docId);
    }

    /**
     * isValid
     */
    public function isValidDocument($docId) {
        return $this->docImpl->isValidDocument($docId);
    }

    /**
     * getPath
     */
    public function getDocumentPath($uuid) {
        return $this->docImpl->getDocumentPath($uuid);
    }

    /**
     * createFolder
     */
    public function createFolder(Folder $okmFolder) {
        return $this->fldImpl->createFolder($okmFolder);
    }

    /**
     * createFolderSimple
     */
    public function createFolderSimple($fldPath) {
        return $this->fldImpl->createFolderSimple($fldPath);
    }

    /**
     * getFolderProperties
     */
    public function getFolderProperties($fldId) {
        return $this->fldImpl->getFolderProperties($fldId);
    }

    /**
     * deleteFolder
     */
    public function deleteFolder($fldId) {
        return $this->fldImpl->deleteFolder($fldId);
    }

    /**
     * renameFolder
     */
    public function renameFolder($fldId, $newName) {
        return $this->fldImpl->renameFolder($fldId, $newName);
    }

    /**
     * moveFolder
     */
    public function moveFolder($fldId, $dstId) {
        return $this->fldImpl->moveFolder($fldId, $dstId);
    }

    /**
     * getFolderChildren
     */
    public function getFolderChildren($fldId) {
        return $this->fldImpl->getFolderChildren($fldId);
    }

    /**
     * isValidFolder
     */
    public function isValidFolder($fldId) {
        return $this->fldImpl->isValidFolder($fldId);
    }

    /**
     * getFolderPath
     */
    public function getFolderPath($uuid) {
        return $this->fldImpl->getFolderPath($uuid);
    }

    /**
     * addNote
     */
    public function addNote($nodeId, $text) {
        return $this->noteImpl->addNote($nodeId, $text);
    }

    /**
     * getNote
     */
    public function getNote($noteId) {
        return $this->noteImpl->getNote($noteId);
    }

    /**
     * deteleNote
     */
    public function deleteNote($noteId) {
        return $this->noteImpl->deleteNote($noteId);
    }

    /**
     * setNote
     */
    public function setNote($noteId, $text) {
        return $this->noteImpl->setNote($noteId, $text);
    }

    /**
     * listNotes
     */
    public function listNotes($nodeId) {
        return $this->noteImpl->listNotes($nodeId);
    }

    /**
     * addGroup
     */
    public function addGroup($nodeId, $grpName) {
        return $this->propertyGroupImpl->addGroup($nodeId, $grpName);
    }

    /**
     * removeGroup
     */
    public function removeGroup($nodeId, $grpName) {
        return $this->propertyGroupImpl->removeGroup($nodeId, $grpName);
    }

    /**
     * getGroups
     */
    public function getGroups($nodeId) {
        return $this->propertyGroupImpl->getGroups($nodeId);
    }

    /**
     * getAllGroups
     */
    public function getAllGroups() {
        return $this->propertyGroupImpl->getAllGroups();
    }

    /**
     * getPropertyGroupProperties
     */
    public function getPropertyGroupProperties($nodeId, $grpName) {
        return $this->propertyGroupImpl->getPropertyGroupProperties($nodeId, $grpName);
    }

    /**
     * getPropertyGroupForm
     */
    public function getPropertyGroupForm($grpName) {
        return $this->propertyGroupImpl->getPropertyGroupForm($grpName);
    }

    /**
     * setPropetyGroupProperties
     */
    public function setPropetyGroupProperties($nodeId, $grpName, $formElementList = array()) {
        return $this->propertyGroupImpl->setPropetyGroupProperties($nodeId, $grpName, $formElementList);
    }

    /**
     * setPropertyGroupPropertiesSimple
     * 
     * @param string $nodeId
     * @param string $grpName
     * @param array $properties Object @see \openkm\bean\SimplePropertyGroup
     */
    public function setPropertyGroupPropertiesSimple($nodeId, $grpName, $properties = array()) {
        return $this->propertyGroupImpl->setPropertyGroupPropertiesSimple($nodeId, $grpName, $properties);
    }

    /**
     * hasGroup
     */
    public function hasGroup($nodeId, $grpName) {
        return $this->propertyGroupImpl->hasGroup($nodeId, $grpName);
    }

    /**
     * getRootFolder
     */
    public function getRootFolder() {
        return $this->respositoryImpl->getRootFolder();
    }

    /**
     * getTrashFolder
     */
    public function getTrashFolder() {
        return $this->respositoryImpl->getTrashFolder();
    }

    /**
     * getTemplatesFolder
     */
    public function getTemplatesFolder() {
        return $this->respositoryImpl->getTemplatesFolder();
    }

    /**
     * getPersonalFolder
     */
    public function getPersonalFolder() {
        return $this->respositoryImpl->getPersonalFolder();
    }

    /**
     * getMailFolder
     */
    public function getMailFolder() {
        return $this->respositoryImpl->getMailFolder();
    }

    /**
     * getThesaurusFolder
     */
    public function getThesaurusFolder() {
        return $this->respositoryImpl->getThesaurusFolder();
    }

    /**
     * getCategoriesFolder
     */
    public function getCategoriesFolder() {
        return $this->respositoryImpl->getCategoriesFolder();
    }

    /**
     * purgeTrash
     */
    public function purgeTrash() {
        return $this->respositoryImpl->purgeTrash();
    }

    /**
     * getUpdateMessage
     */
    public function getUpdateMessage() {
        return $this->respositoryImpl->getUpdateMessage();
    }

    /**
     * getRepositoryUuid
     */
    public function getRepositoryUuid() {
        return $this->respositoryImpl->getRepositoryUuid();
    }

    /**
     * hasNode
     */
    public function hasNode($nodeId) {
        return $this->respositoryImpl->hasNode($nodeId);
    }

    /**
     * getNodePath
     */
    public function getNodePath($uuid) {
        return $this->respositoryImpl->getNodePath($uuid);
    }

    /**
     * getNodeUuid
     */
    public function getNodeUuid($nodePath) {
        return $this->respositoryImpl->getNodeUuid($nodePath);
    }

    /**
     * getAppVersion
     */
    public function getAppVersion() {
        return $this->respositoryImpl->getAppVersion();
    }

    /**
     * findByContent
     */
    public function findByContent($content) {
        return $this->searchImpl->findByContent($content);
    }

    /**
     * findByName
     */
    public function findByName($name) {
        return $this->searchImpl->findByName($name);
    }

    /**
     * findByKeywords
     */
    public function findByKeywords($keywords = array()) {
        return $this->searchImpl->findByKeywords($keywords);
    }

    /**
     * find
     */
    public function find(QueryParams $queryParams) {
        return $this->searchImpl->find($queryParams);
    }

    /**
     * findPaginated
     */
    public function findPaginated(QueryParams $queryParams, $offset, $limit) {
        return $this->searchImpl->findPaginated($queryParams, $offset, $limit);
    }

    /**
     * findSimpleQueryPaginated
     */
    public function findSimpleQueryPaginated($statement, $offset, $limit) {
        return $this->searchImpl->findSimpleQueryPaginated($statement, $offset, $limit);
    }

    /**
     * findMoreLikeThis
     */
    public function findMoreLikeThis($uuid, $max) {
        return $this->searchImpl->findMoreLikeThis($uuid, $max);
    }

    /**
     * getKeywordMap
     */
    public function getKeywordMap($filter = array()) {
        return $this->searchImpl->getKeywordMap($filter);
    }

    /**
     * getCategorizedDocuments
     */
    public function getCategorizedDocuments($categoryId) {
        return $this->searchImpl->getCategorizedDocuments($categoryId);
    }

    /**
     * saveSearch
     */
    public function saveSearch(QueryParams $params) {
        return $this->searchImpl->saveSearch($params);
    }

    /**
     * updateSearch
     */
    public function updateSearch(QueryParams $params) {
        return $this->searchImpl->updateSearch($params);
    }

    /**
     * getSearch
     */
    public function getSearch($qpId) {
        return $this->searchImpl->getSearch($qpId);
    }

    /**
     * getAllSearchs
     */
    public function getAllSearchs() {
        return $this->searchImpl->getAllSearchs();
    }

    /**
     * deleteSearch
     */
    public function deleteSearch($qpId) {
        return $this->searchImpl->deleteSearch($qpId);
    }

    /**
     * addCategory
     */
    public function addCategory($nodeId, $catId) {
        return $this->propertyImpl->addCategory($nodeId, $catId);
    }

    /**
     * removeCategory
     */
    public function removeCategory($nodeId, $catId) {
        return $this->propertyImpl->removeCategory($nodeId, $catId);
    }

    /**
     * addKeyword
     */
    public function addKeyword($nodeId, $keyword) {
        return $this->propertyImpl->addKeyword($nodeId, $keyword);
    }

    /**
     * removeKeyword
     */
    public function removeKeyword($nodeId, $keyword) {
        return $this->propertyImpl->removeKeyword($nodeId, $keyword);
    }

    /**
     * setEncryption
     */
    public function setEncryption($nodeId, $cipherName) {
        return $this->propertyImpl->setEncryption($nodeId, $cipherName);
    }

    /**
     * unsetEncryption
     */
    public function unsetEncryption($nodeId) {
        return $this->propertyImpl->unsetEncryption($nodeId);
    }

    /**
     * setSigned
     */
    public function setSigned($nodeId, $signed) {
        return $this->propertyImpl->setSigned($nodeId, $signed);
    }

}

?>
