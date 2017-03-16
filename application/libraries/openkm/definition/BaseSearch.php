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

use openkm\bean\QueryParams;

/**
 * BaseSearch
 *
 * @author sochoa
 */
interface BaseSearch {

    public function findByContent($content);

    public function findByName($name);

    public function findByKeywords($keywords = array());

    public function find(QueryParams $queryParams);

    public function findPaginated(QueryParams $queryParams, $offset, $limit);

    public function findSimpleQueryPaginated($statement, $offset, $limit);

    public function findMoreLikeThis($uuid, $max);

    public function getKeywordMap($filter = array());

    public function getCategorizedDocuments($categoryId);

    public function saveSearch(QueryParams $params);

    public function updateSearch(QueryParams $params);

    public function getSearch($qpId);

    public function getAllSearchs();

    public function deleteSearch($qpId);
}

?>
