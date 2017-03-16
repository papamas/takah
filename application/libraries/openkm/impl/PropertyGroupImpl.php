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

namespace openkm\impl;

use openkm\bean\PropertyGroup;
use openkm\bean\FormElementComplex;
use openkm\bean\form\Option;
use openkm\bean\form\Validator;
use openkm\bean\SimplePropertyGroup;
use openkm\definition\BasePropertyGroup;
use openkm\util\UriHelper;
use Httpful\Request;

/**
 * PropertyGroupImpl
 *
 * @author sochoa
 */
class PropertyGroupImpl implements BasePropertyGroup {

    private $host;
    private $user;
    private $password;

    /**
     * Construct
     */
    public function __construct($host, $user, $password) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * getClient
     */
    private function getClient(Request $client) {
        $client->sendsXml();
        $client->expectsXml();
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }

    /**
     * getClientWithHTMLResponse     
     */
    private function getClientWithHTMLResponse(Request $client) {
        $client->sendsXml();
        $client->expectsHtml();
        $client->authenticateWith($this->user, $this->password);
        return $client->send();
    }

    public function addGroup($nodeId, $grpName) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_ADD_GROUP);
        $uri .= '?nodeId=' . $nodeId . '&grpName=' . $grpName;
        $client = Request::put($uri);
        $this->getClient($client);
    }

    public function removeGroup($nodeId, $grpName) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_REMOVE_GROUP);
        $uri .= '?nodeId=' . $nodeId . '&grpName=' . $grpName;
        $client = Request::delete($uri);
        $this->getClient($client);
    }

    /**
     * 
     * @param type $nodeId
     * @return array type \openkm\bean\PropertyGroup
     */
    public function getGroups($nodeId) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_GET_GROUPS);
        $uri .= '?nodeId=' . $nodeId;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $propertyGroups = array();
        foreach ($response->body->propertyGroup as $propertyGroupXML) {
            $propertyGroups[] = $this->phpPropertyGroup($propertyGroupXML);
        }
        return $propertyGroups;
    }

    public function getAllGroups() {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_GET_ALL_GROUPS);
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $propertyGroups = array();
        foreach ($response->body->propertyGroup as $propertyGroupXML) {
            $propertyGroups[] = $this->phpPropertyGroup($propertyGroupXML);
        }
        return $propertyGroups;
    }

    /**
     * getProperties
     */
    public function getPropertyGroupProperties($nodeId, $grpName) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_GET_PROPERTIES);
        $uri .= '?nodeId=' . $nodeId . '&grpName=' . $grpName;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $formElementsComplex = array();
        foreach ($response->body->formElementComplex as $formElementComplexXML) {
            $formElementsComplex[] = $this->phpFormElementComplex($formElementComplexXML);
        }
        return $formElementsComplex;
    }

    /**
     * getPropertyGroupForm
     */
    public function getPropertyGroupForm($grpName) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_GET_PROPERTY_GROUP_FORM);
        $uri .= '?grpName=' . $grpName;
        $client = Request::get($uri);
        $response = $this->getClient($client);
        $formElementsComplex = array();
        foreach ($response->body->formElementComplex as $formElementComplexXML) {
            $formElementsComplex[] = $this->phpFormElementComplex($formElementComplexXML);
        }
        return $formElementsComplex;
    }

    public function setPropetyGroupProperties($nodeId, $grpName, $formElementList = array()) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_SET_PROPERTIES);
        $uri .= '?nodeId=' . $nodeId . '&grpName=' . $grpName;
        $client = Request::put($uri);
        $formElementsComplexXML = new \SimpleXMLElement('<formElementsComplex></formElementsComplex>');
        foreach ($formElementList as $formElementComplex) {
            $formElementComplexXML = $formElementsComplexXML->addChild('formElementComplex');
            $formElementComplexXML->addChild('height', $formElementComplex->getHeight());
            $formElementComplexXML->addChild('label', $formElementComplex->getLabel());
            $formElementComplexXML->addChild('name', $formElementComplex->getName());
            $formElementComplexXML->addChild('objClass', $formElementComplex->getObjClass());
            $formElementComplexXML->addChild('readonly', $formElementComplex->isReadonly());
            $formElementComplexXML->addChild('type', $formElementComplex->getType());
            $formElementComplexXML->addChild('value', $formElementComplex->getValue());
            $formElementComplexXML->addChild('width', $formElementComplex->getWidth());
            foreach ($formElementComplex->getOptions() as $option) {
                $optionXML = $formElementComplexXML->addChild('options');
                $optionXML->addChild('label', $option->getLabel());
                $optionXML->addChild('selected', $option->isSelected());
                $optionXML->addChild('value', $option->getValue());
            }
            foreach ($formElementComplex->getValidators as $validator) {
                $validatorXML = $formElementComplexXML->addChild('validators');
                $validatorXML->addChild('type', $validator->getType());
                $validatorXML->addChild('parameter', $validator->getParameter());
            }
        }
        $client->body($formElementsComplexXML->asXML());
        $this->getClient($client);
    }

    /**
     * setPropertiesSimple
     */
    public function setPropertyGroupPropertiesSimple($nodeId, $grpName, $properties = array()) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_SET_PROPERTIES_SIMPLE);
        $uri .= '?nodeId=' . $nodeId . '&grpName=' . $grpName;
        $client = Request::put($uri);
        $simplePropertiesGroupXML = new \SimpleXMLElement('<simplePropertiesGroup></simplePropertiesGroup>');
        foreach ($properties as $simplePropertyGroup) {
            $simplePropertyGroupXML = $simplePropertiesGroupXML->addChild('simplePropertyGroup');
            $simplePropertyGroupXML->addChild('name', $simplePropertyGroup->getName());
            $simplePropertyGroupXML->addChild('value', $simplePropertyGroup->getValue());
        }
        $client->body($simplePropertiesGroupXML->asXML());
        $this->getClient($client);
    }

    public function hasGroup($nodeId, $grpName) {
        $uri = UriHelper::getUri($this->host, UriHelper::PROPERTY_GROUP_HAS_GROUP);
        $uri .= '?nodeId=' . $nodeId . '&grpName=' . $grpName;
        $client = Request::get($uri);
        $response = $this->getClientWithHTMLResponse($client);
        return (string) $response->body;
    }

    private function phpPropertyGroup($propertyGroupXML) {
        $propertyGroup = new PropertyGroup();
        $propertyGroup->setLabel((string) $propertyGroupXML->label);
        $propertyGroup->setName((string) $propertyGroupXML->name);
        $propertyGroup->setReadonly((string) $propertyGroupXML->readonly);
        $propertyGroup->setVisible((string) $propertyGroupXML->visible);
        return $propertyGroup;
    }

    public function phpFormElementComplex($formElementComplexXML) {
        $formElementComplex = new FormElementComplex();
        $formElementComplex->setObjClass((string) $formElementComplexXML->objClass);
        $formElementComplex->setLabel((string) $formElementComplexXML->label);
        $formElementComplex->setName((string) $formElementComplexXML->name);
        $formElementComplex->setWidth((string) $formElementComplexXML->width);
        $formElementComplex->setHeight((string) $formElementComplexXML->height);
        $formElementComplex->setType((string) $formElementComplexXML->type);
        $formElementComplex->setValue((string) $formElementComplexXML->value);
//            $formElementComplex->setTransition((string)$formElementComplex->transition);
        $formElementComplex->setReadonly((string) $formElementComplexXML->readonly);
        $options = array();
        foreach ($formElementComplexXML->options as $optionXML) {
            $option = new Option();
            $option->setLabel((string) $optionXML->label);
            $option->setValue((string) $optionXML->value);
            $option->setSelected((string) $optionXML->selected);
            $options[] = $option;
        }
        $formElementComplex->setOptions($options);
        $validators = array();
        foreach ($formElementComplexXML->validators as $validatorXML) {
            $validator = new Validator();
            $validator->setType((string) $validatorXML->type);
            $validator->setParameter((string) $validatorXML->parameter);
            $validators[] = $validator;
        }
        $formElementComplex->setValidators($validators);
        return $formElementComplex;
    }

}

?>
