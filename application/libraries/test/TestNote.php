<?php

include '../src/openkm/OpenKM.php';

use openkm\OKMWebServicesFactory;
use openkm\OpenKM;
use openkm\bean\Note;

/**
 * Description of test
 *
 * @author sochoa
 */
class TestNote {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_DOC_TEXT = "/okm:root/text.txt";
    const TEST_DOC_PATH = "/okm:root/OpenKM/architecture.html";
    const TEST_DOC_UUID = 'a36ba707-122a-4a7f-9b63-2042a49bbf17';
    const TEST_NOTE = "be56afa8-a4fb-496a-805d-247ed8770cbb";
    const TEST_NOTE_UPDATE = "08a8c054-eb96-4a2c-a18f-ba75fd97cf5b";
    const TEST_NOTE_DELETE = "c5bbeac5-15d0-4e3d-a06e-bcc8aa5ece7a";

    private $ws;

    public function __construct() {
        $this->ws = OKMWebServicesFactory::build(self::USER, self::PASSWORD);
    }

    public function test() {
        //add Note
//        $note = $this->ws->addNote(self::TEST_DOC_UUID, "add note 4");
//        $this->printNote($note, 'addNote');

        //getNote
//        $note = $this->ws->getNote(self::TEST_NOTE);
//        $this->printNote($note, 'getNote');
        
        //setNote
        //$this->ws->setNote(self::TEST_NOTE_UPDATE, "add note 3");
        
        //delete
        //$this->ws->deleteNote(self::TEST_NOTE_DELETE);
        
        //listNotes
        $notes = $this->ws->listNotes(self::TEST_DOC_UUID);
        foreach ($notes as $note) {
            $this->printNote($note, 'listNotes');
        }
    }

    public function printNote(Note $note, $title) {
        echo '<h2>Note - ' . $title . '</h2>';
        echo '<div style="margin-left:30px">';
        echo '<p><strong>Author</strong>:' . $note->getAuthor() . '</p>';
        echo '<p><strong>Date</strong>:' . $note->getDate() . '</p>';
        echo '<p><strong>Path</strong>:' . $note->getPath() . '</p>';
        echo '<p><strong>text</strong>:' . $note->getText() . '</p>';
        echo '</div>';
    }

}

$openkm = new OpenKM();
$testNote = new TestNote();
$testNote->test();
?>