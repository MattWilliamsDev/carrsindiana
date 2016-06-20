<?php
/**
 * @version   $Id: installer.php 131 2011-04-01 16:26:21Z happy_noodle_boy $
 * @package   JCE
 * @copyright Copyright (C) 2009 Ryan Demmer. All rights reserved.
 * @copyright Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license   GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
// Do not allow direct access
defined('_JEXEC') or die('Restricted access');

class WFInstaller extends JObject
{
    var $version = '2.0.0beta2';
    /**
     * @var Boolean Profiles table exists
     */
    var $profiles;
    /**
     * @var Boolean Profiles / Plugins tables exist
     */
    var $tables;
    /**
     * Constructor activating the default information of the class
     *
     * @access  protected
     */
    function __construct()
    {
        $language =& JFactory::getLanguage();
        $language->load('com_jce', JPATH_ADMINISTRATOR);
        
        JTable::addIncludePath(dirname(dirname(__FILE__)) . DS . 'tables');
    }
    /**
     * Returns a reference to a editor object
     *
     * This method must be invoked as:
     *    <pre>  $browser = &JContentEditor::getInstance();</pre>
     *
     * @access  public
     * @return  WF_The editor object.
     * @since 1.5
     */
    function &getInstance()
    {
        static $instance;
        
        if (!is_object($instance)) {
            $instance = new WFInstaller();
        }
        return $instance;
    }
    /**
     * Check upgrade / database status
     */
    function initCheck()
    {
        $this->profiles = $this->checkTable('#__wf_profiles');
        
        if ($this->profiles) {
            $this->profiles = $this->checkTableContents('#__wf_profiles');
        }
        
        if (!$this->checkComponent()) {
            return $this->install(true);
        }
        
        // Check Profiles DB
        if (!$this->profiles) {
            return $this->redirect();
        }
        // Check Editor is installed
        if (!$this->checkEditorFiles()) {
            return $this->redirect(WFText::_('WF_EDITOR_FILES_ERROR'), 'error');
        }
        if (!$this->checkEditor() && $this->checkEditorFiles()) {
            $link = JHTML::link('index.php?option=com_jce&amp;task=repair&amp;type=editor', WFText::_('WF_EDITOR_INSTALL'));
            return $this->redirect(WFText::_('WF_EDITOR_INSTALLED_MANUAL_ERROR') . ' - ' . $link, 'error');
        }
        // Check Editor is installed
        if (!$this->checkEditor()) {
            return $this->redirect(WFText::_('WF_EDITOR_INSTALLED_ERROR'), 'error');
        }
        // Check Editor version
        if (!$this->checkEditorVersion()) {
            return $this->redirect();
        }
        // Check Editor is enabled
        if (!$this->checkEditorEnabled()) {
            return $this->redirect(WFText::_('WF_EDITOR_ENABLED_ERROR'), 'error');
        }
    }
    
    function log($msg)
    {
        jimport('joomla.error.log');
        $log =& JLog::getInstance('upgrade.txt');
        $log->addEntry(array(
            'comment' => 'LOG: ' . $msg
        ));
    }
    
    /**
     * Redirect with message
     * @param object $msg[optional] Message to display
     * @param object $state[optional] Message type
     */
    function redirect($msg = '', $state = '')
    {
        $mainframe =& JFactory::getApplication();
        
        if ($msg) {
            $mainframe->enqueueMessage($msg, $state);
        }
        JRequest::setVar('view', 'cpanel');
        JRequest::setVar('task', '');
        
        return false;
    }
    /**
     * Upgrade database tables and remove legacy folders
     * @return Boolean
     */
    function upgrade($version)
    {
        $mainframe =& JFactory::getApplication();
        $db =& JFactory::getDBO();
        
        wfimport('admin.helpers.parameter');
		wfimport('admin.helpers.xml');
        
       	$base = dirname(dirname(__FILE__));
       	
       	if (version_compare($version, '2.0.0beta2', '<')) {
       		if ($this->checkTable('#__jce_profiles')) {
       			// get all groups data
                $query = 'SELECT * FROM #__jce_profiles';
                $db->setQuery($query);
                $profiles = $db->loadObjectList();
                
                if ($this->createProfilesTable()) {
                	$row =& JTable::getInstance('profiles', 'WFTable');
                	foreach ($profiles as $profile) {
                		$row->bind($profile);
                		$row->store();
                	}
                }
                
                // Drop tables
	            $query = 'DROP TABLE IF EXISTS #__jce_profiles';
	            $db->setQuery($query);
	            $db->query();
       		}
       	}
        
        // upgrade from 1.5.x to 2.0.0
        if (version_compare($version, '2.0.0', '<')) {        	
            // check for groups table / data
            if ($this->checkTable('#__jce_groups') && $this->checkTableContents('#__jce_groups')) {           	
            	// get plugin
            	$plugin = JPluginHelper::getPlugin('editors', 'jce');
                // get JCE component
                $table = JTable::getInstance('component');
                $table->loadByOption('com_jce');
                // process params to JSON string
                $params = WFParameterHelper::toObject($table->params);            
                // set params
                $table->params = json_encode(array('editor' => $params));
            	// store
            	$table->store();                
            	// get all groups data
                $query = 'SELECT * FROM #__jce_groups';
                $db->setQuery($query);
                $groups = $db->loadObjectList();
                
                // get all plugin data
                $query = 'SELECT id, name, icon FROM #__jce_plugins';
                $db->setQuery($query);
                $plugins = $db->loadAssocList('id');
                
                if ($this->createProfilesTable()) {
                    $row =& JTable::getInstance('profiles', 'WFTable');
                    
                    foreach ($groups as $group) {
                        // transfer row ids to names
                        foreach (explode(';', $group->rows) as $item) {
                            $icons = array();
                            foreach (explode(',', $item) as $id) {
                                // spacer
                                if ($id == '00') {
                                    $icons[] = 'spacer';
                                } else {
                                    if (isset($plugins[$id])) {
                                        $icons[] = $plugins[$id]['icon'];
                                    }
                                }
                            }
                            $rows[] = implode(',', $icons);
                        }
                        
                        $group->rows = implode(';', $rows);
                        
                        $names = array();
                        // transfer plugin ids to names
                        foreach (explode(',', $group->plugins) as $id) {
                            if (isset($plugins[$id])) {
                                $items[] = $plugins[$id]['name'];
                            }
                        }
                        $group->plugins = implode(',', $names);
                        
                        // bind data
                        $row->bind($group);
                        
                        if ($row->name == 'Default') {
                            $row->area = 0;
                        }
                        
                        if ($row->name == 'Front End') {
                            $row->area = 1;
                        }
                        
                        // convert params to JSON
                        $params = JCEParameterHelper::toObject($row->params);
                        $data 	= new StdClass();
                        
                        foreach($params as $key => $value) {
                        	$parts 	= explode('_', $key);
                        	$node 	= array_shift($parts);
                        	$key 	= implode('_', $parts);
                        	
                        	if ($value !== '') {
	                        	if (isset($data->$node) && is_object($data->$node)) {
	                        		$data->$node->$key = $value;
	                        	} else {
	                        		$data->$node = new StdClass();
	                        		$data->$node->$key = $value;
	                        	}
                        	}
                        }
                        
                        $row->params = json_encode($data);
                        $row->store();
                    }
                    
                    // Drop tables
                    $query = 'DROP TABLE IF EXISTS #__jce_groups';
                    $db->setQuery($query);
                    $db->query();
                    
                    // If profiles table empty due to error, install profiles data
                    if (!$this->checkTableContents('#__wf_profiles')) {
                        $this->installProfiles(true);
                    }
                    
                } else {
                    return false;
                }
                // Install profiles
            } else {
                $this->installProfiles(true);
            }
            
            // Drop tables
            $query = 'DROP TABLE IF EXISTS #__jce_plugins';
            $db->setQuery($query);
            $db->query();
            
            // Drop tables
            $query = 'DROP TABLE IF EXISTS #__jce_extensions';
            $db->setQuery($query);
            $db->query();
            
            // Remove Plugins menu item
            $query = 'DELETE FROM #__components' . ' WHERE admin_menu_link = ' . $db->Quote('option=com_jce&type=plugins');
            
            $db->setQuery($query);
            $db->query();
            
            // Update Component Name
            $query = 'UPDATE #__components' . ' SET name = ' . $db->Quote('COM_JCE') . ' WHERE ' . $db->Quote('option') . '=' . $db->Quote('com_jce') . ' AND parent = 0';
            
            $db->setQuery($query);
            $db->query();
            
            // Fix links for other views and edit names
            $menus = array(
                'install' 	=> 'installer',
                'group' 	=> 'profiles',
                'groups' 	=> 'profiles',
                'config' 	=> 'config'
            );
            
            $row = JTable::getInstance('component');
            
            foreach ($menus as $k => $v) {
                $query = 'SELECT id FROM #__components' . ' WHERE admin_menu_link = ' . $db->Quote('option=com_jce&type=' . $k);
                $db->setQuery($query);
                $id = $db->loadObject();
                
                if ($id) {
                    $row->load($id);
                    $row->name            = $v;
                    $row->admin_menu_link = 'option=com_jce&view=' . $v;
                    
                    if (!$row->store()) {
                        $mainframe->enqueueMessage('Unable to update Component Links for view : ' . strtoupper($v), 'error');
                    }
                }
            }
        }
        
        return true;
    }
    /**
     * Install Editor and Plugin packages
     * @return 
     */
    function install($manual = false)
    {
        jimport('joomla.installer.installer');
        jimport('joomla.installer.helper');
        
        $mainframe =& JFactory::getApplication();
        $db =& JFactory::getDBO();
        $installer =& JInstaller::getInstance();
        
        // set base path
        $base 	= dirname(dirname(__FILE__));
        
        $state = false;
        
        // Install the Administration Component menus
        if ($manual) {
            if (!$this->installComponent()) {
                $mainframe->enqueueMessage(WFText::_('WF_COMPONENT_MANUAL_INSTALL_FAIL'), 'error');
                $mainframe->redirect('index.php');
            } else {
                $mainframe->enqueueMessage(WFText::_('WF_COMPONENT_MANUAL_INSTALL_SUCCESS'));
            }
        }
        
        $upgrade = false;
        $version = $this->version;
        
        // check for upgrade
        $xml_file = $base . DS . 'jce.xml';
        
        if (is_file($xml_file)) {
            $xml = JApplicationHelper::parseXMLInstallFile($xml_file);
            
            if (preg_match('/([0-9\.]+)(beta|rc|dev|alpha)?([0-9]+?)/i', $xml['version'])) {
                // component version is less than current
                if (version_compare($xml['version'], $this->version, '<')) {
                    $upgrade = true;
                    $version = $xml['version'];
                }
                // invalid component version, check for groups table
            } else {
            	// check for old tables
        		if ($this->checkTable('#__jce_groups')) {
        			$version = '1.5.0';
        		}
        		
            	// check for old tables
        		if ($this->checkTable('#__jce_profiles')) {
        			$version = '2.0.0beta1';
        		}
            }
        } else {
        	// check for old tables
        	if ($this->checkTable('#__jce_groups')) {
        		$version = '1.5.0';
        	}
        }

        // perform upgrade
        if (version_compare($version, $this->version, '<')) {
        	$state = $this->upgrade($version);
        } else {
            // install plugins first
            $state = $this->installProfiles(true);
        }
        
        if ($state) {
            if ($manual) {
                $mainframe->redirect('index.php?option=com_jce');
            }

            $source   = $installer->getPath('source');
            $packages = $source . DS . 'packages';
            $backup   = $source . DS . 'backup';
            
            $language =& JFactory::getLanguage();
            $language->load('com_jce', JPATH_ADMINISTRATOR);
            
            $manifest = $installer->getPath('manifest');
            $version  = $this->version;
            
            // Component data
            if ($xml = JApplicationHelper::parseXMLInstallFile($manifest)) {
                $version = $xml['version'];
            }
            
            $message = '<table class="adminlist" style="width:50%;">' . '<thead><th colspan="3">' . WFText::_('WF_INSTALL_SUMMARY') . '</th>' . '<thead><th class="title" style="width:65%">' . WFText::_('WF_INSTALLER_EXTENSION') . '</th><th class="title" style="width:30%">' . WFText::_('WF_ADMIN_VERSION') . '</th><th class="title" style="width:5%">&nbsp;</th></thead>' . '<tr><td>' . WFText::_('WF_ADMIN_TITLE') . '</td><td>' . $version . '</td><td class="title" style="text-align:center;">' . JHTML::image(JURI::root() . 'administrator/components/com_jce/media/img/tick.png', WFText::_('WF_ADMIN_SUCCESS')) . '</td></tr>' . '<tr><td colspan="3">' . WFText::_('WF_ADMIN_DESC') . '</td></tr>';
            // set editor plugin package dir
            $editor = $base . DS . 'plugin';
            // install editor plugin
            if (is_dir($editor) && is_file($editor . DS . 'jce.php') && is_file($editor . DS . 'jce.xml')) {
            	$xml = JApplicationHelper::parseXMLInstallFile($editor . DS . 'jce.xml');
                    
                if ($result = $this->installEditorPlugin($editor)) {
                	$message .= $result;
                } else {
                    $message .= '<tr><td>' . WFText::_('WF_EDITOR_TITLE') . '</td><td>' . $xml['version'] . '</td><td class="title" style="text-align:center;">' . JHTML::image(JURI::root() . 'administrator/components/com_jce/media/img/error.png', WFText::_('WF_LABEL_ERROR')) . '</td></tr>';
                }
            }

            $message .= '</table>';
            
            $installer->set('message', $message);
        } else {
            $installer->abort();
        }
    }
    function uninstall()
    {
        $this->removeEditor();
    }
    
    /* TODO : */
    
    function installFromBackup()
    {
        return true;
    }
    
    /**
     * Remove a table
     * @return boolean
     * @param string $table Table to remove
     */
    function removeTable($table)
    {
        $db =& JFactory::getDBO();
        
        $query = 'DROP TABLE IF EXISTS #__jce_' . $table;
        $db->setQuery($query);
        return $db->query();
    }
    
    /**
     * Check whether the component is installed
     * @return 
     */
    function checkComponent()
    {
        $component = JComponentHelper::getComponent('com_jce', true);       
        return $component->enabled;
    }
    
    /**
     * Check whether a table exists
     * @return boolean 
     * @param string $table Table name
     */
	function checkTable($table)
	{
		$db		=& JFactory::getDBO();	
		
		$tables = $db->getTableList();
		
		if (!empty($tables)) {
			// swap array values with keys, convert to lowercase and return array keys as values
			$tables = array_keys(array_change_key_case(array_flip($tables)));
			// convert prefix to lowercase
			$prefix = strtolower($db->replacePrefix($table));
			
			return in_array($prefix, $tables);
		}
		
		// try with query
		$query = 'SELECT COUNT(id) FROM ' . $table;
		$db->setQuery($query);
		
		return $db->query();
	}
    
    /**
     * Check table contents
     * @return boolean 
     * @param string $table Table name
     */
    function checkTableContents($table)
    {
        $db =& JFactory::getDBO();
        $query = 'SELECT COUNT(id) FROM ' . $table;
        $db->setQuery($query);
        
        return $db->loadResult();
    }
    
    /**
     * Check whether a field exists
     * @return boolean 
     * @param string $table Table name
     */
    function checkField($table, $field)
    {
        $db =& JFactory::getDBO();
        
        $fields = $db->getTableFields($table);
        
        return array_key_exists($field, $fields[$table]);
    }
    
    /**
     * Remove all tables
     */
    function removeTables($uninstall = false)
    {
        $mainframe =& JFactory::getApplication();
        
        $db =& JFactory::getDBO();
        $tables = array(
            'plugins',
            'extensions',
            'groups',
            'profiles'
        );
        
        $list = $db->getTableList();
        
        foreach ($tables as $table) {
            if (in_array($db->replacePrefix('#__jce_' . $table), $list)) {
                if (!$this->removeTable($table)) {
                    $msg   = JText::sprintf('WF_DB_REMOVE_ERROR', ucfirst($table));
                    $state = 'error';
                } else {
                    $msg   = JText::sprintf('WF_DB_REMOVE_SUCCESS', ucfirst($table));
                    $state = '';
                }
                $mainframe->enqueueMessage($msg, $state);
            }
        }
        if (!$uninstall) {
            $mainframe->redirect('index.php?option=com_jce');
        }
    }
    
    function repairTables()
    {
        $table = JRequest::getString('table');
        
        if ($table) {
            $method = 'install' . ucfirst($table);
            
            if (method_exists($this, $method)) {
                return $this->$method();
            }
        }
    }
    /**
     * Check if all tables exist
     * @return boolean
     */
    function checkTables()
    {
        $ret    = false;
        $tables = array(
            'plugins',
            'profiles'
        );
        
        foreach ($tables as $table) {
            $ret = $this->checkTable($table);
        }
        return $ret;
    }
    /**
     * Remove all backup tables
     */
    function cleanupDB()
    {
        $db =& JFactory::getDBO();
        
        $tables = array(
            'plugins',
            'profiles',
            'groups',
            'extensions'
        );
        
        foreach ($tables as $table) {
            $query = 'DROP TABLE IF EXISTS #__jce_' . $table . '_tmp';
            $db->setQuery($query);
            
            $db->query();
        }
    }
    /**
     * Check whether the editor is installed
     * @return boolean
     */
    function checkEditor()
    {
        require_once(JPATH_LIBRARIES . DS . 'joomla' . DS . 'plugin' . DS . 'helper.php');
        return JPluginHelper::getPlugin('editors', 'jce');
    }
    /**
     * Check for existence of editor files and folder
     * @return boolean
     */
    function checkEditorFiles()
    {
        $path = WF_JOOMLA15 ? JPATH_PLUGINS . DS . 'editors' : JPATH_PLUGINS . DS . 'editors' . DS . 'jce';
        // Check for JCE plugin files
        return file_exists($path . DS . 'jce.php') && file_exists($path . DS . 'jce.xml');
    }
    /**
     * Check if the editor is enabled
     * @return boolean
     */
    function checkEditorEnabled()
    {
        return true;
    }
    /**
     * Check the installed component version
     * @return Version message
     */
    function checkEditorVersion()
    {
        jimport('joomla.filesystem.file');
        $file = WF_JOOMLA15 ? JPATH_PLUGINS . DS . 'editors' . DS . 'jce.xml' : JPATH_PLUGINS . DS . 'editors' . DS . 'jce' . DS . 'jce.xml';
        
        if (!JFile::exists($file)) {
            JError::raiseNotice('SOME ERROR CODE', WFText::_('WF_EDITOR_VERSION_ERROR'));
            return false;
        } else {
            if ($xml = JApplicationHelper::parseXMLInstallFile($file)) {
                $version = $xml['version'];
                
                // Development version
                if (strpos($this->version, '2.0.0beta2') !== false || strpos($version, '2.0.0beta2') !== false) {
                    return true;
                }
                
                if (version_compare($version, $this->version, '<')) {
                    JError::raiseNotice('SOME ERROR CODE', JText::sprintf('WF_EDITOR_VERSION_ERROR', $this->version));
                    return false;
                }
            }
        }
        
    }
    
    /**
     * Create the Profiles table
     * @return boolean
     */
    function createProfilesTable()
    {
        $mainframe =& JFactory::getApplication();
        
        $db =& JFactory::getDBO();
        
        $query = "CREATE TABLE IF NOT EXISTS `#__wf_profiles` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `description` varchar(255) NOT NULL,
        `users` text NOT NULL,
        `types` varchar(255) NOT NULL,
        `components` text NOT NULL,
        `area` tinyint(3) NOT NULL,
        `rows` text NOT NULL,
        `plugins` text NOT NULL,
        `published` tinyint(3) NOT NULL,
        `ordering` int(11) NOT NULL,
        `checked_out` tinyint(3) NOT NULL,
        `checked_out_time` datetime NOT NULL,
        `params` text NOT NULL,
        PRIMARY KEY (`id`)
        );";
        $db->setQuery($query);
        
        if (!$db->query()) {
            $mainframe->enqueueMessage(WFText::_('WF_INSTALL_TABLE_PROFILES_ERROR') . $db->stdErr(), 'error');
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Install Profiles
     * @return boolean
     * @param object $install[optional]
     */
    function installProfiles($install = false)
    {
        $mainframe =& JFactory::getApplication();
        
        $db =& JFactory::getDBO();
        
        $ret = false;
        
        JTable::addIncludePath(dirname(dirname(__FILE__)) . DS . 'profiles');
        
        if ($this->createProfilesTable()) {
            $ret = true;
            
            $query = 'SELECT count(id) FROM #__wf_profiles';
            $db->setQuery($query);
            
            $profiles = array(
                'Default' => false,
                'Front End' => false
            );
            
            // No Profiles table data
            if (!$db->loadResult()) {
                $path = dirname(dirname(__FILE__)) . DS . 'models';
                JModel::addIncludePath($path);
                
                $model 	=& JModel::getInstance('profiles', 'WFModel');
                $xml 	= $path . 'profiles.xml';
                
                // try root profiles.xml first
                if (!is_file($xml)) {
                    $xml = $path . DS . 'profiles.xml';
                }
                
                if (is_file($xml)) {
                    if (!$model->processImport($xml, true)) {
                        $mainframe->enqueueMessage(WFText::_('WF_INSTALL_PROFILES_ERROR'), 'error');
                    }
                } else {
                    $mainframe->enqueueMessage(WFText::_('WF_INSTALL_PROFILES_NOFILE_ERROR'), 'error');
                }
            }
        }
        if (!$install) {
            //$this->redirect();
            $mainframe->redirect('index.php?option=com_jce');
        }
        return $ret;
    }
    
    /**
     * Install the editor package
     * @return Array or false
     * @param object $path[optional] Path to package folder
     */
    function installEditorPlugin($source)
    {
        $mainframe =& JFactory::getApplication();
        
        $db =& JFactory::getDBO();
        
        $result = '';
        
        JTable::addIncludePath(JPATH_LIBRARIES . DS . 'joomla' . DS . 'database' . DS . 'table');
        
        $version = '';
        $name    = '';
        
        if ($xml = JApplicationHelper::parseXMLInstallFile($source . DS . 'jce.xml')) {
            $version = $xml['version'];
            $name    = $xml['name'];
        }
        
        $installer = new JInstaller();
        
        if ($installer->install($source)) {
            $language =& JFactory::getLanguage();
            $language->load('plg_editors_jce', JPATH_ADMINISTRATOR);
            
            $result = '<tr><td>' . WFText::_('WF_EDITOR_TITLE') . '</td><td>' . $version . '</td><td class="title" style="text-align:center;">' . JHTML::image(JURI::root() . 'administrator/components/com_jce/media/img/tick.png', WFText::_('WF_ADMIN_SUCCESS')) . '</td></tr>';
            
            if ($installer->message) {
                $result .= '<tr><td colspan="3">' . WFText::_($installer->message) . '</td></tr>';
            }
        }
        return $result;
    }
    /**
     * Install the Editor Component
     * @return boolean
     */
    function installComponent()
    {
        $mainframe =& JFactory::getApplication();
        
        $db =& JFactory::getDBO();
        
        jimport('joomla.installer.installer');
        require_once(JPATH_LIBRARIES . DS . 'joomla' . DS . 'installer' . DS . 'adapters' . DS . 'component.php');
        
        $installer =& JInstaller::getInstance();
        $installer->setPath('source', dirname(dirname(__FILE__)));
        $component = new JInstallerComponent($installer, $db);
        
        $component->install();
        
        return $this->checkComponent();
    }
    
    function getEditorID()
    {
        $db =& JFactory::getDBO();
        
        if (WF_JOOMLA15) {
            $query = 'SELECT id FROM #__plugins' . ' WHERE folder   = ' . $db->Quote('editors') . ' AND element   = ' . $db->Quote('jce');
        } else {
            $query = 'SELECT extension_id FROM #__extensions' . ' WHERE type  = ' . $db->Quote('plugin') . ' AND folder   = ' . $db->Quote('editors') . ' AND element = ' . $db->Quote('jce');
        }
        
        $db->setQuery($query);
        return $db->loadResult();
    }
    
    /**
     * Install the Editor Plugin
     * @return boolean
     * @param object $install[optional]
     */
    function installEditor($install = false)
    {
        $mainframe =& JFactory::getApplication();
        
        $db =& JFactory::getDBO();
        $path = JPATH_PLUGINS . DS . 'editors';
        $ret  = true;
        if ($this->checkEditorFiles()) {
            $name = 'JCE Editor';
            
            if ($xml = JApplicationHelper::parseXMLInstallFile($path . DS . 'jce.xml')) {
                $version = $xml['version'];
                $name    = $xml['name'];
            }
            
            JTable::addIncludePath(JPATH_LIBRARIES . DS . 'joomla' . DS . 'database' . DS . 'table');
            $table = WF_JOOMLA15 ? 'plugin' : 'extension';
            
            $row =& JTable::getInstance($table);
            
            // Get Editor id if installed
            $id = $this->getEditorID();
            
            // Load editor if valid id
            if ($id) {
                $row->load($id);
            }
            $row->name      = $name;
            $row->ordering  = 0;
            $row->folder    = 'editors';
            $row->element   = 'jce';
            $row->client_id = 0;
            
            if (WF_JOOMLA15) {
                $row->published = 1;
            } else {
                $row->enabled = 1;
            }
            
            if (!$row->store()) {
                $mainframe->enqueueMessage(WFText::_('Plugin') . ' ' . WFText::_('Install') . ': ' . $db->stderr(true));
                $ret = false;
            }
        } else {
            $mainframe->enqueueMessage(WFText::_('WF_EDITOR_FILES_MISSING'), 'error');
            $ret = false;
        }
        $mainframe->enqueueMessage(WFText::_('WF_EDITOR_INSTALL_SUCCESS'));
        $ret = true;
        
        if (!$install) {
            $this->redirect();
        } else {
            return $ret;
        }
    }
    /**
     * Uninstall the editor
     * @return boolean
     */
    function removeEditor()
    {
        $mainframe =& JFactory::getApplication();
        
        // Get Editor ID
        $id = $this->getEditorID();
        
        if ($id) {
            jimport('joomla.installer.installer');
            
            $installer = new JInstaller();
            
            if (!$installer->uninstall('plugin', $id)) {
                $mainframe->enqueueMessage(WFText::_('WF_EDITOR_REMOVE_ERROR'));
                return false;
            } else {
                $mainframe->enqueueMessage(WFText::_('WF_EDITOR_REMOVE_SUCCESS'));
                return true;
            }
            
            $mainframe->enqueueMessage($msg);
            return $ret;
        } else {
            $mainframe->enqueueMessage(WFText::_('WF_EDITOR_REMOVE_NOTFOUND'));
            
            return false;
        }
    }
}
?>