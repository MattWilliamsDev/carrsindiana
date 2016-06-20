<?php
/**
 * @version   $Id: manager.php 36 2011-01-20 12:59:29Z happy_noodle_boy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author    Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('ERROR_403');

jimport('joomla.html.parameter');

class WFParameter extends JParameter
{
	var $_data 	= null;
	
	var $_key 	= null;
	
	function __construct($data = null, $path = '', $keys = null)
	{
		parent::__construct('', $path);
		
		$this->_data = new StdClass();
		
		if ($data) {
			if (!is_object($data)) {
				$data = json_decode($data);
			}
			
			if ($keys) {
        		if (!is_array($keys)) {
        			$keys = explode('.', $keys);
        		}
        		
				$this->_key = $keys;
					
				foreach ($keys as $key) {
					$data = isset($data->$key) ? $data->$key : $data;
				}
       	 	}
			
			$this->bind($this->_data, $data);
		}
	}
	/**
	 * Method to recursively bind data to a parent object.
	 *
	 * @param	object	$parent	The parent object on which to attach the data values.
	 * @param	mixed	$data	An array or object of data to bind to the parent object.
	 *
	 * @return	void
	 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
	 */
	public function bind(&$parent, $data)
	{
		// Ensure the input data is an array.
		if (is_object($data)) {
			$data = get_object_vars($data);
		} else {
			$data = (array) $data;
		}

		foreach ($data as $k => $v) {
			if (self::is_assoc($v) || is_object($v)) {
				$parent->$k = new stdClass();
				$this->bind($parent->$k, $v);
			} else {
				$parent->$k = $v;
			}
		}
	}
	
	public function getAll($name = '')
	{
		$results = array();
		
		if ($name) {
			$groups = array($name => $this->getNumParams($name));
		} else {
			$groups = $this->getGroups();
		}
		
		foreach ($groups as $group => $num) {
			if (!isset($this->_xml[$group])) {
				return null;
			}
			
			$data = new StdClass();
			
			foreach ($this->_xml[$group]->children() as $param)  {
				$key 	= $param->attributes('name');
				$value 	= $this->get($key, $param->attributes('default'));
				
				$data->$key = $value;
			}
			
			$results[$group] = $data;
		}

		if ($name) {
			return $results[$name];
		}
		
		return $results;
	}
	
	/**
	 * Get a parameter value.
	 *
	 * @param	string	Registry path (e.g. editor.width)
	 * @param   string	Optional default value, returned if the internal value is null.
	 * @param 	string  Optional group name. If teh default vaue is null and the gorup value is set, the default value will be retrieved from the xml file
	 * @return	mixed	Value of entry or null
	 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
	 */
	public function get($path, $default = '')
	{
		$result = $default;
		
		// Explode the registry path into an array
		$nodes = is_array($path) ? $path : explode('.', $path);

		// Initialize the current node to be the registry root.
		$node = $this->_data;
		$found = false;
		// Traverse the registry to find the correct node for the result.
		foreach ($nodes as $n) {
			if (isset($node->$n)) {
				$node = $node->$n;
				$found = true;
			} else {
				$found = false;
				break;
			}
		}
		if ($found && $node !== null && $node !== '') {
			$result = $node;
		}
		
		return $result;
	}
	
	/**
	 * Render all parameters
	 *
	 * @access	public
	 * @param	string	The name of the control, or the default text area if a setup file is not found
	 * @return	array	Array of all parameters, each as array Any array of the label, the form element and the tooltip
	 * @since	1.5
	 */
	public function getParams($name = 'params', $group = '_default')
	{
		if (!isset($this->_xml[$group])) {
			return false;
		}
		$results = array();
		foreach ($this->_xml[$group]->children() as $param)  {
			$results[] = $this->getParam($param, $name, $group);
			
			// get sub-parameters
			if ($param->attributes('parameters')) {
				jimport('joomla.filesystem.folder');
			
				// load manifest files for extensions
				$files = JFolder::files(JPATH_SITE.DS.$param->attributes('parameters'), '\.xml$', false, true);
				
				// get the base key for the parameter
				$keys = explode('.', $param->attributes('name'));
				
				foreach ($files as $file) {										
					$key 			= $keys[0] . '.' . basename($file, '.xml');		
					$results[] 		= new WFParameter($this->_data, $file, $key);
				}
			}
		}
		return $results;
	}
	
	/**
	 * Render a parameter type
	 *
	 * @param	object	A param tag node
	 * @param	string	The control name
	 * @return	array	Any array of the label, the form element and the tooltip
	 * @since	1.5
	 */
	public function getParam(&$node, $control_name = 'params', $group = '_default')
	{
		//get the type of the parameter
		$type = $node->attributes('type');

		$element =& $this->loadElement($type);

		// error happened
		if ($element === false) {
			$result = array();
			$result[0] = $node->attributes('name');
			$result[1] = WFText::_('Element not defined for type').' = '.$type;
			$result[5] = $result[0];
			return $result;
		}
		
		$key = $node->attributes('name');
		if ($node->attributes('group')) {
			$key = $node->attributes('group') . '.' . $node->attributes('name');
		}
		
		//get value
		$value = $this->get($key, $node->attributes('default'));
		
		if (is_object($value)) {			
			$value = $this->get($group . '.' . $node->attributes('name'), $node->attributes('default'));
		}
		
		return $element->render($node, $value, $control_name);
	}
	
	private function _cleanAttribute($matches)
	{
		return $matches[1] . '="' . preg_replace('#([^a-z0-9_-]+)#i', '', $matches[2]) . '"';
	}
		
	public function render($name = 'params', $group = '_default')
	{
		$params = $this->getParams($name, $group);		
		$html 	= '<ul class="adminformlist">';
		
		foreach ($params as $item) {
			if (is_a($item, 'WFParameter')) {
				
				foreach ($item->getGroups() as $group => $num) {
					$label 	= $group;
					$class 	= '';
					$parent = '';
					
					$xml = $item->_xml[$group];
					
					if ($xml->attributes('parent')) {
						$parent = '[' . $xml->attributes('parent') . '][' . $group . ']';				
						$class 	= ' class="'. $xml->attributes('parent') .'"';
						$label	= $xml->attributes('parent') . '_' . $group;
					}

					$html .= '<div data-type="'. $group .'"'.$class.'>';
					$html .= '<h4>' . WFText::_('WF_' . strtoupper($label) . '_TITLE') . '</h4>';					
					//$html .= $item->render($name . '[' . $parent . '][' . $group . ']', $group);
					$html .= $item->render($name . $parent, $group);
					$html .= '</div>';
				}
			} else {
				$label 		= preg_replace_callback('#(for|id)="([^"]+)"#', array($this, '_cleanAttribute'), $item[0]);
				$element 	= preg_replace_callback('#(id)="([^"]+)"#', array($this, '_cleanAttribute'), $item[1]);
				
				$html .= '<li>' . $label . $element;
			}
		}
		
		$html .= '</li></ul>';
		
		return $html;
	}
	
	/**
	 * Check if a parent attribute is set. If it is, this parameter groups is included by the parent
	 */
	public function hasParent()
	{
		foreach ($this->_xml as $name => $group)  {
			if ($group->attributes('parent')) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Method to determine if an array is an associative array.
	 *
	 * @param	array		An array to test.
	 * @return	boolean		True if the array is an associative array.
	 * @link	http://www.php.net/manual/en/function.is-array.php#98305
	 */
	private function is_assoc($array) {
    	return (is_array($array) && (count($array) == 0 || 0 !== count(array_diff_key($array, array_keys(array_keys($array))))));
	}
	
	/**
	 * Convert an associate array to an object
	 * @param array Associative array
	 */
	public function array_to_object($array)
	{
		$object = new StdClass();
		
		foreach ($array as $key => $value) {
			$object->$key = is_array($value) ? self::array_to_object($value) : $value;
		}
		
		return $object;
	}
}
