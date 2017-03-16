<?php

include '../src/openkm/OpenKM.php';

use openkm\OKMWebServicesFactory;
use openkm\OpenKM;

/**
 * TestProperty
 *
 * @author sochoa
 */
class TestProperty {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_FLD = "/okm:root/OpenKM";
    const TEST_CATEGORY = "02e3fd64-73f5-4c9a-9b95-218fd4580013";
    const TEST_DOC_PATH = "/okm:root/OpenKM/architecture.html";
    const TEST_DOC_UUID = 'e0856a93-3b25-4726-88fc-632dec7c6ab0';
    const VERSION = OKMWebServicesFactory::WEBSERVICES_1_0;

    private $ws;

    public function __construct() {
        $this->ws = OKMWebServicesFactory::build(self::HOST, self::USER, self::PASSWORD);
    }

    public function test() {
        //add Category        
        //$this->ws->addCategory(self::TEST_DOC_UUID,  self::TEST_CATEGORY); 
        //remove category
        //$this->ws->removeCategory(self::TEST_DOC_UUID, self::TEST_CATEGORY);
        //add keyword
        //$this->ws->addKeyword(self::TEST_DOC_UUID, 'okm');
        //remove Keyword
        //$this->ws->removeKeyword(self::TEST_DOC_UUID, 'okm');
        //setEncrypteion
        $this->ws->setEncryption(self::TEST_DOC_UUID, 'test');

        //unsetEncryption
        $this->ws->unsetEncryption(self::TEST_DOC_UUID);
        
        //setSigned
        $this->ws->setSigned(self::TEST_DOC_UUID, 'test');
    }

}

$openkm = new OpenKM();
$testProperty = new TestProperty();
$testProperty->test();
?>