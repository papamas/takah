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

use openkm\bean\Document;

/**
 * BaseDocument
 *
 * @author sochoa
 */
interface BaseDocument {

    public function createDocument(Document $okmDocument, $is);

    public function createDocumentSimple($docPath, $is);

    public function deleteDocument($docId);

    public function getDocumentProperties($docId);

    public function getContent($docId);

    public function getContentByVersion($docId, $versionId);

    public function getDocumentChildren($fldId);

    public function renameDocument($docId, $newName);

    public function setProperties(Document $okmDocument);

    public function checkout($docId);

    public function cancelCheckout($docId);

    public function forceCancelCheckout($docId);

    public function isCheckedOut($docId);

    public function checkin($docId, $is, $comment);

    public function getVersionHistory($docId);

    public function lock($docId);

    public function unlock($docId);

    public function forceUnlock($docId);

    public function isLocked($docId);

    public function getLockInfo($docId);

    public function purgeDocument($docId);

    public function moveDocument($docId, $dstId);

    public function copyDocument($docId, $dstId);

    public function restoreVersion($docId, $versionId);

    public function purgeVersionHistory($docId);

    public function getVersionHistorySize($docId);

    public function isValidDocument($docId);

    public function getDocumentPath($uuid);
    
}

?>
