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

namespace openkm\util;

/**
 * UriHelper
 *
 * @author sochoa
 */
class UriHelper {
    // Auth

    const AUTH_GET_GRANTED_ROLES = "services/rest/auth/getGrantedRoles";
    const AUTH_GET_GRANTED_USERS = "services/rest/auth/getGrantedUsers";
    const AUTH_GET_MAIL = "services/rest/auth/getMail";
    const AUTH_GET_NAME = "services/rest/auth/getName";
    const AUTH_GET_ROLES = "services/rest/auth/getRoles";
    const AUTH_GET_ROLES_BY_USER = "services/rest/auth/getRolesByUser";
    const AUTH_GET_USERS = "services/rest/auth/getUsers";
    const AUTH_GET_USERS_BY_ROLE = "services/rest/auth/getUsersByRole";
    const AUTH_REVOKE_ROLE = "services/rest/auth/revokeRole";
    const AUTH_REVOKE_USER = "services/rest/auth/revokeUser";
    const AUTH_GRANT_ROLE = "services/rest/auth/grantRole";
    const AUTH_GRANT_USER = "services/rest/auth/grantUser";

    // Document
    const DOCUMENT_CREATE = "services/rest/document/create";
    const DOCUMENT_CREATE_SIMPLE = "services/rest/document/createSimple";
    const DOCUMENT_DELETE = "services/rest/document/delete";
    const DOCUMENT_GET_PROPERTIES = "services/rest/document/getProperties";
    const DOCUMENT_GET_CONTENT = "services/rest/document/getContent";
    const DOCUMENT_GET_CONTENT_BY_VERSION = "services/rest/document/getContentByVersion";
    const DOCUMENT_GET_CHILDREN = "services/rest/document/getChildren";
    const DOCUMENT_RENAME = "services/rest/document/rename";
    const DOCUMENT_SET_PROPERTIES = "services/rest/document/setProperties";
    const DOCUMENT_SET_LANGUAGE = "services/rest/document/setLanguage";
    const DOCUMENT_SET_TITLE = "services/rest/document/setTitle";
    const DOCUMENT_CHECKOUT = "services/rest/document/checkout";
    const DOCUMENT_CANCEL_CHECKOUT = "services/rest/document/cancelCheckout";
    const DOCUMENT_FORCE_CANCEL_CHECKOUT = "services/rest/document/forceCancelCheckout";
    const DOCUMENT_IS_CHECKOUT = "services/rest/document/isCheckedOut";
    const DOCUMENT_CHECKIN = "services/rest/document/checkin";
    const DOCUMENT_GET_VERSION_HISTORY = "services/rest/document/getVersionHistory";
    const DOCUMENT_LOCK = "services/rest/document/lock";
    const DOCUMENT_UNLOCK = "services/rest/document/unlock";
    const DOCUMENT_FORCE_UNLOCK = "services/rest/document/forceUnlock";
    const DOCUMENT_IS_LOCKED = "services/rest/document/isLocked";
    const DOCUMENT_GET_LOCKINFO = "services/rest/document/getLockInfo";
    const DOCUMENT_PURGE = "services/rest/document/purge";
    const DOCUMENT_COPY = "services/rest/document/copy";
    const DOCUMENT_MOVE = "services/rest/document/move";
    const DOCUMENT_RESTORE_VERSION = "services/rest/document/restoreVersion";
    const DOCUMENT_PURGE_VERSION_HISTORY = "services/rest/document/purgeVersionHistory";
    const DOCUMENT_GET_VERSION_HISTORY_SIZE = "services/rest/document/getVersionHistorySize";
    const DOCUMENT_IS_VALID = "services/rest/document/isValid";
    const DOCUMENT_GET_PATH = "services/rest/document/getPath";
    const DOCUMENT_GET_DETECTED_LANGUAGES = "services/rest/document/getDetectedLanguages";

    // Folder
    const FOLDER_CREATE = "services/rest/folder/create";
    const FOLDER_CREATE_SIMPLE = "services/rest/folder/createSimple";
    const FOLDER_GET_PROPERTIES = "services/rest/folder/getProperties";
    const FOLDER_DELETE = "services/rest/folder/delete";
    const FOLDER_RENAME = "services/rest/folder/rename";
    const FOLDER_MOVE = "services/rest/folder/move";
    const FOLDER_GET_CHILDREN = "services/rest/folder/getChildren";
    const FOLDER_IS_VALID = "services/rest/folder/isValid";
    const FOLDER_GET_PATH = "services/rest/folder/getPath";

    // Note
    const NOTE_ADD = "services/rest/note/add";
    const NOTE_GET = "services/rest/note/get";
    const NOTE_DELETE = "services/rest/note/delete";
    const NOTE_SET = "services/rest/note/set";
    const NOTE_LIST = "services/rest/note/list";

    // PropertyGroup
    const PROPERTY_GROUP_ADD_GROUP = "services/rest/propertyGroup/addGroup";
    const PROPERTY_GROUP_REMOVE_GROUP = "services/rest/propertyGroup/removeGroup";
    const PROPERTY_GROUP_GET_GROUPS = "services/rest/propertyGroup/getGroups";
    const PROPERTY_GROUP_GET_ALL_GROUPS = "services/rest/propertyGroup/getAllGroups";
    const PROPERTY_GROUP_GET_PROPERTIES = "services/rest/propertyGroup/getProperties";
    const PROPERTY_GROUP_GET_PROPERTY_GROUP_FORM = "services/rest/propertyGroup/getPropertyGroupForm";
    const PROPERTY_GROUP_SET_PROPERTIES = "services/rest/propertyGroup/setProperties";    
    const PROPERTY_GROUP_SET_PROPERTIES_SIMPLE = "services/rest/propertyGroup/setPropertiesSimple";
    const PROPERTY_GROUP_HAS_GROUP = "services/rest/propertyGroup/hasGroup";

    // Repository
    const REPOSITORY_GET_ROOT_FOLDER = "services/rest/repository/getRootFolder";
    const REPOSITORY_GET_ROOT_TRASH = "services/rest/repository/getTrashFolder";
    const REPOSITORY_GET_ROOT_TEMPLATES = "services/rest/repository/getTemplatesFolder";
    const REPOSITORY_GET_ROOT_PERSONAL = "services/rest/repository/getPersonalFolder";
    const REPOSITORY_GET_ROOT_MAIL = "services/rest/repository/getMailFolder";
    const REPOSITORY_GET_ROOT_THESAURUS = "services/rest/repository/getThesaurusFolder";
    const REPOSITORY_GET_ROOT_CATEGORIES = "services/rest/repository/getCategoriesFolder";
    const REPOSITORY_PURGE_TRASH = "services/rest/repository/purgeTrash";
    const REPOSITORY_GET_UPDATE_MESSAGE = "services/rest/repository/getUpdateMessage";
    const REPOSITORY_GET_RESPOSITORY_UUID = "services/rest/repository/getRepositoryUuid";
    const REPOSITORY_HAS_NODE = "services/rest/repository/hasNode";
    const REPOSITORY_GET_NODE_PATH = "services/rest/repository/getNodePath";
    const REPOSITORY_GET_NODE_UUID = "services/rest/repository/getNodeUuid";
    const REPOSITORY_GET_APP_VERSION = "services/rest/repository/getAppVersion";

    // Search
    const REPOSITORY_FIND_BY_CONTENT = "services/rest/search/findByContent";
    const REPOSITORY_FIND_BY_NAME = "services/rest/search/findByName";
    const REPOSITORY_FIND_BY_KEYWORDS = "services/rest/search/findByKeywords";
    const REPOSITORY_FIND = "services/rest/search/find";
    const REPOSITORY_FIND_PAGINATED = "services/rest/search/findPaginated";
    const REPOSITORY_FIND_SIMPLE_QUERY_PAGINATED = "services/rest/search/findSimpleQueryPaginated";
    const REPOSITORY_FIND_MORE_LIKE_THIS = "services/rest/search/findMoreLikeThis";
    const REPOSITORY_GET_KEYWORD_MAP = "services/rest/search/getKeywordMap";
    const REPOSITORY_GET_CATEGORIZED_DOCUMENTS = "services/rest/search/getCategorizedDocuments";
    const REPOSITORY_SAVE_SEARCH = "services/rest/search/saveSearch";
    const REPOSITORY_UPDATE_SEARCH = "services/rest/search/updateSearch";
    const REPOSITORY_GET_SEARCH = "services/rest/search/getSearch";
    const REPOSITORY_GET_ALL_SEARCH = "services/rest/search/getAllSearchs";
    const REPOSITORY_DELETE_SEARCH = "services/rest/search/deleteSearch";

    // Property
    const PROPERTY_ADD_CATEGORY = "services/rest/property/addCategory";
    const PROPERTY_REMOVE_CATEGORY = "services/rest/property/removeCategory";
    const PROPERTY_ADD_KEYWORD = "services/rest/property/addKeyword";
    const PROPERTY_REMOVE_KEYWORD = "services/rest/property/removeKeyword";
    const PROPERTY_SET_ENCRYPTION = "services/rest/property/setEncryption";
    const PROPERTY_UNSET_ENCRYPTION = "services/rest/property/unsetEncryption";
    const PROPERTY_SET_SIGNED = "services/rest/property/setSigned";

    /**
     * getUri
     */
    public static function getUri($host, $serviceUrl) {
        if (substr($host, strlen($host) - 1, strlen($host)) == '/') {
            return $host . $serviceUrl;
        } else {
            return $host . "/" . $serviceUrl;
        }
    }

}

?>
