<?php

include '../src/openkm/OpenKM.php';

use openkm\bean\Folder;
use openkm\bean\AppVersion;
use openkm\OKMWebServicesFactory;
use openkm\OpenKM;

/**
 * TestRepository
 *
 * @author sochoa
 */
class TestRepository {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_FLD = "/okm:root/OpenKM";
    const TEST_CATEGORY = "02e3fd64-73f5-4c9a-9b95-218fd4580013";
    const TEST_DOC_TEXT = "/okm:root/text.txt";
    const TEST_DOC_PATH = "/okm:root/OpenKM/architecture.html";
    const TEST_DOC_UUID = 'e0856a93-3b25-4726-88fc-632dec7c6ab0';    

    private $ws;

    public function __construct() {
        $this->ws = OKMWebServicesFactory::build(self::HOST, self::USER, self::PASSWORD);
    }

    public function test() {
        
        //getRootFolder
        $folder = $this->ws->getRootFolder();
        $this->printFolder($folder, 'getRootFolder');
        
        //getTrashFolder
        $folder = $this->ws->getTrashFolder();
        $this->printFolder($folder, 'getTrashFolder');
        
        //getCategoriesFolder
        $folder = $this->ws->getCategoriesFolder();
        $this->printFolder($folder, 'getCategoriesFolder');

        //getUpdateMessage
        echo '<h2>getUpdateMessage</h2>';
        echo '<p>' . $this->ws->getUpdateMessage() . '</p>';
        
        //getRepositoryUuid
        echo '<h2>getRepositoryUuid</h2>';
        echo '<p>' . $this->ws->getRepositoryUuid() . '</p>';
        
        //hasNode
        echo '<h2>hasNode</h2>';
        echo '<p>' . $this->ws->hasNode(self::TEST_DOC_UUID) . '</p>';
        
        //getNodePath
        echo '<h2>getNodePath</h2>';
        echo '<p>' . $this->ws->getNodePath(self::TEST_DOC_UUID) . '</p>';
        
        //getNodeUuid
        echo '<h2>getNodeUuid</h2>';
        echo '<p>' . $this->ws->getNodeUuid(self::TEST_DOC_PATH) . '</p>';
        
        //getAppVersion
        echo '<h2>getAppVersion</h2>';
        $appVersion = new AppVersion();
        $appVersion = $this->ws->getAppVersion();
        echo '<div style="margin-left:30px">';
        echo '<p><strong>Build</strong>:' . $appVersion->getBuild() . '</p>';
        echo '<p><strong>Extension</strong>:' . $appVersion->getExtension() . '</p>';
        echo '<p><strong>Maintenance</strong>:' . $appVersion->getMaintenance() . '</p>';
        echo '<p><strong>Major</strong>:' . $appVersion->getMajor() . '</p>';
        echo '<p><strong>Minor</strong>:' . $appVersion->getMinor() . '</p>';        
        echo '</div>';
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

}

$openkm = new OpenKM();
$testRepository = new TestRepository();
$testRepository->test();
?>