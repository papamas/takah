<?php

include '../src/openkm/OpenKM.php';

use openkm\OKMWebServicesFactory;
use openkm\OpenKM;
use openkm\bean\Folder;

/**
 * TestFolder
 *
 * @author sochoa
 */
class TestFolder {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_FLD_ROOT = "/okm:root/";
    const TEST_FLD_DESIGN = "/okm:root/design";
    const TEST_FLD_PATH = "/okm:root/PROVINSI GORONTALO";
    const TEST_FLD_UUID = '105be14b-63b8-4658-a225-6694e7ce5cb4';

    private $ws;

    public function __construct() {
        $this->ws = OKMWebServicesFactory::build(self::HOST, self::USER, self::PASSWORD);
    }

    public function test() {
        //createFolderSimple
        $folder = new Folder();
//        $folder = $this->ws->createFolderSimple(self::TEST_FLD_DESIGN);
//        $this->printFolder($folder,'createFolderSimple');
        //getFolderProperties
//        $folder = $this->ws->getFolderProperties(self::TEST_FLD_UUID);
//        $this->printFolder($folder, 'getFolderProperties');
        //deleteFolder
        //$this->ws->deleteFolder(self::TEST_FLD_DESIGN);  
        //renameFolder
//        $folder = $this->ws->renameFolder(self::TEST_FLD_DESIGN, 'designweb');
//        $this->printFolder($folder,'renameFolder');        
//        
        //moveFolder
//        $this->ws->moveFolder(self::TEST_FLD_DESIGN, self::TEST_FLD_PATH);
//        
        //getFolderChildren
        $folders = $this->ws->getFolderChildren(self::TEST_FLD_UUID);
        foreach ($folders as $folder) {
            $this->printFolder($folder, 'getFolderChildren');
        }

        //isValidFolder
        echo '<h2>isValid</h2>';
        echo '<p>' . $this->ws->isValidFolder(self::TEST_FLD_PATH) . '</p>';

        //getFolderPath
        echo '<h2>getFolderPath</h2>';
        echo '<p>' . $this->ws->getFolderPath(self::TEST_FLD_UUID) . '</p>';
    }

    public function printFolder(Folder $folder, $title) {
        echo '<h2>Folder - ' . $title . '</h2>';
        echo '<div style="margin-left:30px">';
        echo '<p><strong>Author</strong>:' . $folder->getAuthor() . '</p>';
        echo '<p><strong>Created</strong>:' . $folder->getCreated() . '</p>';
        echo '<p><strong>Path</strong>:' . $folder->getPath() . '</p>';
        echo '<p><strong>Permissions</strong>:' . $folder->getPermissions() . '</p>';
        //echo '<p><strong>Subscribed</strong>:' . $folder->isSubscribed() . '</p>';
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
$testFolder = new TestFolder();
$testFolder->test();
?>