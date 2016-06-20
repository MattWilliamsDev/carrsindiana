<?php
/**
 * @version		$Id: list.php 108 2011-02-26 16:40:33Z happy_noodle_boy $
 * @package		JCE
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * * @copyright	Copyright (C) 2009 Ryan Demmer. All rights reserved.
 * @license		GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a select element
 */

class JElementList extends JElement
{
    /**
     * Element type
     *
     * @access	protected
     * @var		string
     */
    var $_name = 'List';
    
    function fetchElement($name, $value, &$node, $control_name)
    {
        $ctrl 		= $control_name.'['.$name.']';
        $attribs 	= array();   
        $new 		= '';
		$class 		= '';
        
        $options 	= array();
        $values 	= array();
		
		if ($class = $node->attributes('class')) {
            $attribs[] = 'class="'.$class.'"';
        } else {
            $attribs[] = 'class="inputbox"';
        }

        foreach ($node->children() as $option) {
            $val 			= $option->attributes('value');
            $text 			= $option->data();
			$disabled		= $option->attributes('disabled') ? true : false;

			if (is_array($value)) {
				$key = array_search($val, $value);							
				if ($key !== false) {					
					$options[$key] 	= JHTML::_('select.option', $val, WFText::_($text), 'value', 'text', $disabled);
				}				
			} else {
				$options[] = JHTML::_('select.option', $val, WFText::_($text), 'value', 'text', $disabled);
			}

            // create temp values
			$values[] = $val;
        }
		
		// re-sort options by key
		ksort($options);
		
		// method to append additional values to options array
		if (is_array($value)) {
			$diff = array_diff($values, $value);
			foreach ($node->children() as $option) {
				$val 	= $option->attributes('value');
				$text 	= $option->data();
				if (in_array($val, $diff)) {
					$options[] 	= JHTML::_('select.option', $val, WFText::_($text));
				}	
			}
		}
		
		// revert to default values
        if ($value == '' || $value == 'default')
            $value = $node->attributes('defaults');

        // editable lists
        if (strpos($class, 'editable') !== false) {
        	// pattern data attribute for editable select input box
            if ($node->attributes('pattern')) {
            	$attribs[] = 'data-pattern="'. $node->attributes('pattern') .'"';
            }
	        // editable lists - add value to list
	        if (!in_array($value, $values) && !$node->attributes('multiple')) {
	            $options[] = JHTML::_('select.option', $value, WFText::_($value));
	            
	            
	        }
        }

		// multiple lists
        if ($node->attributes('multiple')) {
            $attribs[]	 = 'multiple="multiple"';
            $ctrl 		.= '[]';
			
			$value 		 = !is_array($value) ? explode('|', $value) : $value;
        }
        
        return JHTML::_('select.genericlist', $options, $ctrl, implode(' ', $attribs), 'value', 'text', $value, $control_name.$name);
    }
}
?>
