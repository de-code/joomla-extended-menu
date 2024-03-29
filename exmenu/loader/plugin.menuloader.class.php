<?php
/**
* @version $Id: plugin.menuloader.class.php 517 2011-06-12 12:47:20Z  $
* @author Daniel Ecer
* @package exmenu
* @copyright (C) 2005-2011 Daniel Ecer (de.siteof.de)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

defined('_JEXEC') or die();

// no direct access
if (!defined('EXTENDED_MENU_HOME')) {
	die('Restricted access');
}


use Joomla\CMS\Plugin\PluginHelper;


/**
 * @since 1.0.0
 */
class PluginExtendedMenuLoader extends AbstractExtendedMenuLoader {

	function loadBySourceValues($sourceValues) {
		return $this->loadByPluginAndSourceName($sourceValues);
	}

	function loadByPluginAndSourceName($sourceValues) {
		$results = FALSE;
		$pluginName	= implode(',', $sourceValues);
		if (function_exists('jimport')) {
			PluginHelper::importPlugin('exmenu');
			$dispatcher = JDispatcher::getInstance();
			$results = $dispatcher->trigger('onLoadMenu', array($this, $pluginName));
		} else {
			global $_MAMBOTS;
			$_MAMBOTS->loadBotGroup('exmenu');
			$results = $_MAMBOTS->trigger('onLoadMenu', array($this, $pluginName), FALSE);
		}
		$result = FALSE;
		foreach($results as $r) {
			$result |= $r;
		}
		if (!$result) {
			trigger_error('exmenu: no plugin found for the name "'.$pluginName.'"', E_USER_NOTICE);
		}
		return $result;
	}
}

?>