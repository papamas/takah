<?php
include '../src/openkm/OpenKM.php';

use openkm\OKMWebServicesFactory;
use openkm\OpenKM;
use openkm\bean\Document;
use openkm\bean\Version;
use openkm\bean\LockInfo;

/**
 * TestDocument
 *
 * @author sochoa
 */
class TestDocument {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_FLD_ROOT = "/okm:root/";
    const TEST_FLD_PATH = "/okm:root/OpenKM/img/";
    const TEST_DOC_TEXT = "/okm:root/text.txt";
    const TEST_DOC_PATH_1 = "/okm:root/architecture.html";
    const TEST_DOC_PATH = "/okm:root/OpenKM/architecture.html";
    const TEST_DOC_UUID = 'e0856a93-3b25-4726-88fc-632dec7c6ab0';

    private $ws;

    public function __construct() {
        $this->ws = OKMWebServicesFactory::build(self::HOST, self::USER, self::PASSWORD);
    }

    public function test() {

        //deleteDocument
        //$this->ws->deleteDocument(self::TEST_DOC_TEXT);
        
        
        //getDocumentProperties
//        $document = new Document();
//        $document = $this->ws->getDocumentProperties(self::TEST_DOC_UUID);
//        $this->printDocument($document, 'getDocumentProperties');

        
        //content
        //$content = $this->ws->getContent(self::TEST_DOC_UUID);
        /**
         * first method
         */
        //$file = fopen(dirname(__FILE__) . '/files/' . $this->getNamePath($document->getPath()), 'w+');
        //fwrite($file, $content);
        //fclose($file);
        /**
         * second method
         */
        //$this->download($document, $content);
        
        
        //getDocumentChildren
//        $documents = $this->ws->getDocumentChildren(self::TEST_FLD_PATH);        
//        foreach ($documents as $document) {
//            $this->printDocument($document, 'getDocumentChildren');
//        }

        //renameDocument
        //$document = $this->ws->renameDocument(self::TEST_DOC_TEXT, 'text1.txt');
        //$this->printDocument($document, 'renameDocument');
        
        //setProperties}
//        $subscriptors = array();
//        $subscriptors[] = 'okmAdmin';
//        $document->setSubscribed(true);
//        $document->setSubscriptors($subscriptors);
//        $document->setTitle('okm');
//        $this->ws->setProperties($document);  
             
        //checkout
        //echo '<h2>checkout</h2>';
        //$this->ws->checkout(self::TEST_DOC_TEXT);
        //echo '<h3>' . $this->ws->isCheckedOut(self::TEST_DOC_TEXT). '</h3>';    
            
        //cancelCheckOut
        //echo '<h2>cancelCheckout</h2>';
        //$this->ws->cancelCheckout(self::TEST_DOC_TEXT);
        //echo '<h3>' . $this->ws->isCheckedOut(self::TEST_DOC_TEXT). '</h3>';
        
        //cancelCheckOut
        //echo '<h2>forgeCancelCheckout</h2>';
        //$this->ws->forceCancelCheckout(self::TEST_DOC_TEXT);
        //echo '<h3>' . $this->ws->isCheckedOut(self::TEST_DOC_TEXT). '</h3>';
        
        //version
        $versions = $this->ws->getVersionHistory(self::TEST_DOC_TEXT);
        foreach ($versions as $version) {
            $this->printVersion($version);
        }

        //if($this->ws->isLocked(self::TEST_DOC_TEXT)== 'false'){
        //lock
        //    echo '<h2>lock</h2>';
        //    $lockInfo =  $this->ws->lock(self::TEST_DOC_TEXT);
        //    $this->printLockInfo($lockInfo);
        //} else {        
        //unlock
        //    echo '<h2>unlock</h2>';
        //    $this->ws->unlock(self::TEST_DOC_TEXT);        
        //}
        
        //forceUnlock
        //echo '<h2>forceUnlock</h2>';
        //$this->ws->forceUnlock(self::TEST_DOC_TEXT);  
              
        //isLock
        //echo '<h2>islock</h2>';
        //echo $this->ws->isLocked(self::TEST_DOC_TEXT);
        
        //getLockInfo
//        echo '<h2>getLockInfo</h2>';               
//        $lockInfo = $this->ws->getLockInfo(self::TEST_DOC_TEXT);
//        $this->printLockInfo($lockInfo);

        //purgeDocument
        //$this->ws->purgeDocument(self::TEST_DOC_TEXT);
        
        //moveDocument
        //$this->ws->moveDocument(self::TEST_DOC_TEXT, self::TEST_FLD_PATH);
        
        //copyDocument
        //echo '<h2>copyDocument</h2>';
        //$this->ws->copyDocument(self::TEST_DOC_TEXT, self::TEST_FLD_PATH);
        
        //restoreVersion
        //$this->ws->restoreVersion(self::TEST_DOC_TEXT, '1.1');
        
        //purgeVersionHistory
        //$this->ws->purgeVersionHistory(self::TEST_DOC_TEXT);
        
        //getVersionHistorySize
        //echo '<h2>getVersionHistorySize</h2>';
        //echo '<p>' . $this->ws->getVersionHistorySize(self::TEST_DOC_TEXT) . '</p>';
        
        //isValidDocument
        //echo '<h2>isValidDocument</h2>';
        //echo '<p>' . $this->ws->isValidDocument(self::TEST_DOC_PATH) . '</p>';
        
        //getDocumentPath
        //echo '<h2>getDocumentPath</h2>';
        //echo '<p>' . $this->ws->getDocumentPath(self::TEST_DOC_UUID) . '</p>';
        
        $fileName = dirname(__FILE__) . '/files/architecture.html';
        $docPath = '/okm:root/arq.html';
        $this->ws->createDocumentSimple($docPath, file_get_contents($fileName));
    }

    public function getNamePath($path) {
        return substr($path, strrpos($path, '/') + 1);
    }

    public function download(Document $document, $content) {
        header('Expires', 'Sat, 6 May 1971 12:00:00 GMT');
        header('Cache-Control', 'max-age=0, must-revalidate');
        header('Cache-Control', 'post-check=0, pre-check=0');
        header('Pragma', 'no-cache');
        header('Content-Type: ' . $document->getMimeType());
        header('Content-Disposition: attachment; filename="' . $this->getNamePath($document->getPath()) . '"');
        echo $content;
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

}

$openkm = new OpenKM();
$testDocument = new TestDocument();
$testDocument->test();
?>
