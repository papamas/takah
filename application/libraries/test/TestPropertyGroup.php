<?php

include '../src/openkm/OpenKM.php';

use openkm\OKMWebServicesFactory;
use openkm\OpenKM;
use openkm\bean\SimplePropertyGroup;

/**
 * TestPropertyGroup
 *
 * @author sochoa
 */
class TestPropertyGroup {

    const HOST = "http://localhost:8080/OpenKM/";
    const USER = "okmAdmin";
    const PASSWORD = "admin";
    const TEST_FLD = "/okm:root/OpenKM";
    const TEST_DOC = "b07cf852-d5fe-4221-ae66-8d47bd1db8c6";
    const GROUP_JOOMLA = 'okg:joomla_publication';
    const GROUP_WORDPRESS = 'okg:wordpress_publication';

    private $ws;

    public function __construct() {
        $this->ws = OKMWebServicesFactory::build(self::HOST, self::USER, self::PASSWORD);
    }

    public function test() {
        //addGroup
        //$this->ws->addGroup(self::TEST_DOC, self::GROUP_WORDPRESS);
        
        //removeGroup        
        //$this->ws->removeGroup(self::TEST_DOC, self::GROUP_WORDPRESS);
        
        //getGroups from document or folder
        echo '<h2>getGroups from document or folder</h2>';
        $propertyGroups = $this->ws->getGroups(self::TEST_DOC);
        foreach ($propertyGroups as $propertyGroup) {
            echo '<p>' . $propertyGroup->toString() . '</p>';
        }

        // getAllGroups 
        echo '<h2>getAllGroups</h2>';
        $propertyGroups = $this->ws->getAllGroups();
        foreach ($propertyGroups as $propertyGroup) {
            echo '<p>' . $propertyGroup->toString() . '</p>';
        }

        //getPropertyGroupProperties
        echo '<h2>getPropertyGroupProperties -> ' . self::GROUP_JOOMLA . '<h2>';
        $formElementsComplex = $this->ws->getPropertyGroupProperties(self::TEST_DOC, self::GROUP_JOOMLA);
        foreach ($formElementsComplex as $formElementComplex) {
            echo '<p>' . $formElementComplex->toString() . '</p>';
        }

        //setPropertyGroupSimple
        echo '<h2>setPropertyGroupSimple</h2>';
        $properties = array();
        $simplePropertyGroupId = new SimplePropertyGroup();
        $simplePropertyGroupId->setName('okp:joomla_publication.article.id');
        $simplePropertyGroupId->setValue(1);
        $properties[] = $simplePropertyGroupId;

        $simplePropertyGroupTitle = new SimplePropertyGroup();
        $simplePropertyGroupTitle->setName('okp:joomla_publication.title');
        $simplePropertyGroupTitle->setValue('Articulo1');
        $properties[] = $simplePropertyGroupTitle;

        $this->ws->setPropertyGroupPropertiesSimple(self::TEST_DOC, self::GROUP_JOOMLA, $properties);

        //hasGroup
        echo '<h2>hasGroup</h2>';
        echo '<p>' . $this->ws->hasGroup(self::TEST_DOC, self::GROUP_JOOMLA) . '</p>';
    }

}

$openkm = new OpenKM();
$testPropertyGroup = new TestPropertyGroup();
$testPropertyGroup->test();
?>
