<?php

include '../src/openkm/OpenKM.php';

use openkm\OKMWebServicesFactory;
use openkm\OpenKM;
use openkm\bean\Folder;
use openkm\bean\Document;
use openkm\bean\Version;
use openkm\bean\LockInfo;
use openkm\bean\QueryResult;
use openkm\bean\QueryParams;

/**
 * TestSearch
 *
 * @author sochoa
 */
class TestSearch {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_FLD_ROOT = "/okm:root/";
    const TEST_FLD_PATH = "/okm:root/OpenKM/img";
    const TEST_DOC_TEXT = "/okm:root/text.txt";
    const TEST_DOC_PATH = "/okm:root/OpenKM/architecture.html";
    const TEST_DOC_UUID = 'b07cf852-d5fe-4221-ae66-8d47bd1db8c6';
    const TEST_DOC = "9c88f911-e53f-4682-8dcc-7100fab27d76";
    const TEST_CATEGORY = "02e3fd64-73f5-4c9a-9b95-218fd4580013";

    private $ws;

    public function __construct() {
        $this->ws = OKMWebServicesFactory::build(self::HOST, self::USER, self::PASSWORD);
    }

    public function test() {
 //findByContent
        //$queryResults = $this->ws->findByContent('basic');
        //foreach ($queryResults as $queryResult) {
        //    $this->printQueryResult($queryResult, 'findByContent');
        //}
        
        //findByName
        //$queryResults = $this->ws->findByName('text');
        //foreach ($queryResults as $queryResult) {
        //    $this->printQueryResult($queryResult, 'findByName');
        //}
       
        //findByKeywords
        //$keywords = array();
        //$keywords[] = 'text';
        //$queryResults = $this->ws->findByKeywords($keywords);
        //foreach ($queryResults as $queryResult) {
        //    $this->printQueryResult($queryResult, 'findByKeywords');
        //}
        
        //find
//        $keywords = array();
//        $keywords[] = 'text';
//        $queryParams = new QueryParams();
//        $queryParams->setDomain(QueryParams::DOCUMENT + QueryParams::FOLDER);
//        $queryParams->setKeywords($keywords);
//        $queryResults = $this->ws->find($queryParams);
//        foreach ($queryResults as $queryResult) {
//            $this->printQueryResult($queryResult, 'find');
//        }

        //findPaginated
        //echo '<h2>findPaginated</h2>';
        //$queryParams = new QueryParams();        
        //$resultSet = $this->ws->findPaginated($queryParams,0,10);
        //echo '<p><strong>Total:</strong>' . $resultSet->getTotal() .'</p>';
        //foreach ($resultSet->getResults() as $queryResult) {
        //    $this->printQueryResult($queryResult, 'findPaginated');
        //}
        
        //findSimpleQueryPaginated
//        echo '<h2>findSimpleQueryPaginated</h2>';         
//        $resultSet = $this->ws->findSimpleQueryPaginated('programacion',0,10);
//        echo '<p><strong>Total:</strong>' . $resultSet->getTotal() .'</p>';
//        foreach ($resultSet->getResults() as $queryResult) {
//            $this->printQueryResult($queryResult, 'findSimpleQueryPaginated');
//        }

        //findMoreLikeThis
//        echo '<h2>findMoreLikeThis</h2>';         
//        $resultSet = $this->ws->findMoreLikeThis(self::TEST_DOC_UUID,100);
//        echo '<p><strong>Total:</strong>' . $resultSet->getTotal() .'</p>';
//        foreach ($resultSet->getResults() as $queryResult) {
//            $this->printQueryResult($queryResult, 'findMoreLikeThis');
//        }

        //getKeywordMap
//        echo '<h2>getkeywordMap</h2>';
//        $filter = array();
//        $filter[0] = 'test';
//        echo '<div style="margin-left:30px">';
//        $keywordMaps = $this->ws->getKeywordMap($filter);
//        foreach ($keywordMaps as $keywordMap) {
//            echo '<h2>keywordMap</h2>';
//            echo '<p><strong>keyword:</strong>' . $keywordMap->getKeyword() . '</p>';
//            echo '<p><strong>occurs:</strong>' . $keywordMap->getOccurs() . '</p>';
//        }
//        echo '</div>';

        //getCategorizedDocuments
        //$documents = $this->ws->getCategorizedDocuments(self::TEST_CATEGORY);
        //foreach ($documents as $document) {            
        //   $this->printDocument($document, 'getCategorizedDocuments');
        //}  
        
        //getSearch
        //echo '<h2>getSearch</h2>';
        //$queryParams = new QueryParams();
        //$queryParams = $this->ws->getSearch(1);
        //$this->printQueryParams($queryParams);
        
        //saveSearch
        //echo '<h2>saveSearch</h2>';
        //$queryParams->setId('');        
        //$queryParams->setQueryName('test3');
        //$keywords = array();
        //$keywords[] = 'okm';
        //$queryParams->setKeywords($keywords);
        //echo '<p><strong>Id:</strong>'.$this->ws->saveSearch($queryParams).'</p>';
        
        //updateSearch
        //echo '<h2>updateSearch</h2>';        
        //$queryParams->setQueryName('test_3');
        //$keywords = array();
        //$keywords[] = 'openkm';
        //$queryParams->setKeywords($keywords);
        //echo '<p><strong>Id:</strong>'.$this->ws->saveSearch($queryParams).'</p>'; 
               
        //getAllSearchs
        echo '<h2>getAllSearchs</h2>';
        $queriesParams = $this->ws->getAllSearchs();
        foreach ($queriesParams as $queryParams) {
            $this->printQueryParams($queryParams);
        }
        
        //deleteSearch
        //$this->ws->deleteSearch(1);
    }

    public function printQueryResult(QueryResult $queryResult, $title) {
        echo '<h2>QueryResult - ' . $title . '</h2>';
        echo '<div style="margin-left:30px">';
        echo '<p><strong>Excerpt</strong>:' . $queryResult->getExcerpt() . '</p>';
        echo '<p><strong>Score</strong>:' . $queryResult->getScore() . '</p>';
        if ($queryResult->getDocument()!= null) {
            $this->printDocument($queryResult->getDocument(), $title);
        }
        if ($queryResult->getFolder() != null) {
            $this->printFolder($queryResult->getFolder(), $title);
        }
        echo '</div>';
    }

    public function printDocument(Document $document, $title) {
        echo '<h2>Document - ' . $title . '</h2>';
        echo '<div style="margin-left:30px">';
        echo '<p><strong>Author</strong>:' . $document->getAuthor() . '</p>';
        echo '<p><strong>Created</strong>:' . $document->getCreated() . '</p>';
        echo '<p><strong>Path</strong>:' . $document->getPath() . '</p>';
        echo '<p><strong>Permissions</strong>:' . $document->getPermissions() . '</p>';
        echo '<p><strong>Subscribed</strong>:' . $document->isSubscribed() . '</p>';
        echo '<p><strong>Uuid</strong>:' . $document->getUuid() . '</p>';
        echo '<p><strong>CheckedOut</strong>:' . $document->isCheckedOut() . '</p>';
        echo '<p><strong>ConvertibleDxf</strong>:' . $document->isConvertibleToDxf() . '</p>';
        echo '<p><strong>ConvertiblePdf</strong>:' . $document->isConvertibleToPdf() . '</p>';
        echo '<p><strong>ConvertibleSwf</strong>:' . $document->isConvertibleToSwf() . '</p>';
        echo '<p><strong>Description</strong>:' . $document->getDescription() . '</p>';
        echo '<p><strong>Language</strong>:' . $document->getLanguage() . '</p>';
        echo '<p><strong>LastModified</strong>:' . $document->getLastModified() . '</p>';
        echo '<p><strong>Locked</strong>:' . $document->isLocked() . '</p>';
        echo '<p><strong>MineType</strong>:' . $document->getMimeType() . '</p>';
        echo '<p><strong>Signed</strong>:' . $document->isSigned() . '</p>';
        echo '<p><strong>Title</strong>:' . $document->getTitle() . '</p>';

        $this->printVersion($document->getActualVersion());

        $this->printLockInfo($document->getLockInfo());

        foreach ($document->getCategories() as $category) {
            echo '<h3>Categories</h3>';
            echo '<p><strong>Author</strong>:' . $category->getAuthor() . '</p>';
            echo '<p><strong>Created</strong>:' . $category->getCreated() . '</p>';
            echo '<p><strong>Path</strong>:' . $category->getPath() . '</p>';
            echo '<p><strong>Permissions</strong>:' . $category->getPermissions() . '</p>';
            echo '<p><strong>Subscribed</strong>:' . $category->isSubscribed() . '</p>';
            echo '<p><strong>Uuid</strong>:' . $category->getUuid() . '</p>';
            echo '<p><strong>HasChildrend</strong>:' . $category->isHasChildren() . '</p>';
        }
        foreach ($document->getKeywords() as $keyword) {
            echo '<h3>Keywords: ' . $keyword . '</h3>';
        }

        foreach ($document->getNotes() as $note) {
            echo '<h3>Notes</h3>';
            echo '<p><strong>Author</strong>:' . $note->getAuthor() . '</p>';
            echo '<p><strong>Date</strong>:' . $note->getDate() . '</p>';
            echo '<p><strong>Path</strong>:' . $note->getPath() . '</p>';
            echo '<p><strong>text</strong>:' . $note->getText() . '</p>';
        }
        foreach ($document->getSubscriptors() as $subscriptor) {
            echo '<h3>Subscriptors: ' . $subscriptor . '</h3>';
        }
        echo '</div>';
    }

    public function printVersion(Version $version) {
        echo '<h2>Version</h2>';
        echo '<p><strong>Actual</strong>:' . $version->getActual() . '</p>';
        echo '<p><strong>Author</strong>:' . $version->getAuthor() . '</p>';
        echo '<p><strong>Checksum</strong>:' . $version->getChecksum() . '</p>';
        echo '<p><strong>Created</strong>:' . $version->getCreated() . '</p>';
        echo '<p><strong>Name</strong>:' . $version->getName() . '</p>';
        echo '<p><strong>Size</strong>:' . $version->getSize() . '</p>';
    }

    public function printLockInfo(LockInfo $lockInfo) {
        echo '<h2>LockInfo</h2>';
        echo '<p><strong>NodePath</strong>:' . $lockInfo->getNodePath() . '</p>';
        echo '<p><strong>Owner</strong>:' . $lockInfo->getOwner() . '</p>';
        echo '<p><strong>Token</strong>:' . $lockInfo->getToken() . '</p>';
    }

    public function printFolder(Folder $folder, $title) {
        echo '<h2>Folder - ' . $title . '</h2>';
        echo '<div style="margin-left:30px">';
        echo '<p><strong>Author</strong>:' . $folder->getAuthor() . '</p>';
        echo '<p><strong>Created</strong>:' . $folder->getCreated() . '</p>';
        echo '<p><strong>Path</strong>:' . $folder->getPath() . '</p>';
        echo '<p><strong>Permissions</strong>:' . $folder->getPermissions() . '</p>';
        echo '<p><strong>Subscribed</strong>:' . $folder->isSubscribed() . '</p>';
        echo '<p><strong>Uuid</strong>:' . $folder->getUuid() . '</p>';
        echo '<p><strong>HasChildrend</strong>:' . $folder->isHasChildren() . '</p>';
        foreach ($folder->getCategories() as $category) {
            echo '<h3>Categories</h3>';
            echo '<p><strong>Author</strong>:' . $category->getAuthor() . '</p>';
            echo '<p><strong>Created</strong>:' . $category->getCreated() . '</p>';
            echo '<p><strong>Path</strong>:' . $category->getPath() . '</p>';
            echo '<p><strong>Permissions</strong>:' . $category->getPermissions() . '</p>';
            echo '<p><strong>Subscribed</strong>:' . $category->isSubscribed() . '</p>';
            echo '<p><strong>Uuid</strong>:' . $category->getUuid() . '</p>';
            echo '<p><strong>HasChildrend</strong>:' . $category->isHasChildren() . '</p>';
        }
        foreach ($folder->getKeywords() as $keyword) {
            echo '<h3>Keywords: ' . $keyword . '</h3>';
        }

        foreach ($folder->getNotes() as $note) {
            echo '<h3>Notes</h3>';
            echo '<p><strong>Author</strong>:' . $note->getAuthor() . '</p>';
            echo '<p><strong>Date</strong>:' . $note->getDate() . '</p>';
            echo '<p><strong>Path</strong>:' . $note->getPath() . '</p>';
            echo '<p><strong>text</strong>:' . $note->getText() . '</p>';
        }
        foreach ($folder->getSubscriptors() as $subscriptor) {
            echo '<h3>Subscriptors: ' . $subscriptor . '</h3>';
        }
        echo '</div>';
    }

    public function printQueryParams(QueryParams $queryParams) {
        echo '<h2>QueryParams</h2>';
        echo '<div style="margin-left:30px">';
        echo '<p><strong>Id</strong>:' . $queryParams->getId() . '</p>';
        echo '<p><strong>Author</strong>:' . $queryParams->getAuthor() . '</p>';
        echo '<p><strong>Content</strong>:' . $queryParams->getContent() . '</p>';
        echo '<p><strong>Dashboard</strong>:' . $queryParams->isDashboard() . '</p>';
        echo '<p><strong>Domain</strong>:' . $queryParams->getDomain() . '</p>';
        echo '<p><strong>LastModifiedFrom</strong>:' . $queryParams->getLastModifiedFrom() . '</p>';
        echo '<p><strong>LastModifiedTo</strong>:' . $queryParams->getLastModifiedTo() . '</p>';
        echo '<p><strong>MailFrom</strong>:' . $queryParams->getMailFrom() . '</p>';
        echo '<p><strong>MailSubject</strong>:' . $queryParams->getMailSubject() . '</p>';
        echo '<p><strong>MailTo</strong>:' . $queryParams->getMailTo() . '</p>';
        echo '<p><strong>MimeType</strong>:' . $queryParams->getMimeType() . '</p>';
        echo '<p><strong>Name</strong>:' . $queryParams->getName() . '</p>';
        echo '<p><strong>Operator</strong>:' . $queryParams->getOperator() . '</p>';
        echo '<p><strong>Path</strong>:' . $queryParams->getPath() . '</p>';
        echo '<p><strong>QueryName</strong>:' . $queryParams->getQueryName() . '</p>';
        echo '<p><strong>User</strong>:' . $queryParams->getUser() . '</p>';

        foreach ($queryParams->getCategories() as $categories) {
            echo '<h3>Categories: ' . $categories . '</h3>';
        }

        foreach ($queryParams->getKeywords() as $keyword) {
            echo '<h3>Keywords: ' . $keyword . '</h3>';
        }

        echo '<h2>Properties</h2>';
        foreach ($queryParams->getProperties() as $entry) {
            echo '<p><strong>' . $entry->getKey() . ':</strong>' . $entry->getValue() . '</p>';
        }

        echo '</div>';
    }

}

$openkm = new OpenKM();
$testSearch = new TestSearch();
$testSearch->test();
?>
