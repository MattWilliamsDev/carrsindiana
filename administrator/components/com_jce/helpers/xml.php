<?php
/**
 * @version   $Id: xml.php 107 2011-02-26 16:32:11Z happy_noodle_boy $
 * @package   JCE
 * @copyright Copyright (C) 2009 Ryan Demmer. All rights reserved.
 * @license   GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class WFXMLHelper
{
    function loadFile($file)
    {
    	$xml = & JFactory::getXMLParser('Simple');
    	
    	if (is_file($file) && $xml->loadFile($file)) {
    		return $xml;
    	}
    	
    	return null;
    }
	
	function getElement($xml, $name, $default = '')
    {
    	if (is_a($xml, 'JSimpleXML')) {
    		$element = $xml->document->getElementByPath($name);
        	return $element ? $element->data() : $default;
    	} else {
    		return (string)$xml->$name;
    	}
    }
    
    function getElements($xml, $name)
    {
        if (is_a($xml, 'JSimpleXML')) {
	        $element = $xml->document->getElementByPath($name);
	
	        if (is_a($element, 'JSimpleXMLElement') && count($element->children())) {
	        	return $element;
	        }
        } else {
        	return $xml->$name;
        }

        return array();
    }
    
    function getAttribute($xml, $name, $default = '')
    {
    	if (is_a($xml, 'JSimpleXML')) {
    		$value = (string) $xml->document->attributes($name);
    	} else {
    		$value = (string)$xml->attributes()->$name;
    	}
    	
    	return $value ? $value : $default;
    }
    
    function loadManifest($file)
    {
    	$xml =& JFactory::getXMLParser('Simple');
		
		if (!$xml->loadFile($file)) {
			unset($xml);
			return false;
		}
		
		return $xml;
    }
}