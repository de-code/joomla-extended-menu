<?php
/**
* @version $Id: plugin.menuview.class.php 517 2011-06-12 12:47:20Z  $
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

/**
 * @since 1.0.0
 */
class PluginExtendedMenuView extends AbstractExtendedMenuView {

	var $pluginMenuViewName = '';
	var $menuNodeList = array();
	var $level = 0;

	function renderAsString($menuNodeList, $level = 0) {
		global $_MAMBOTS;
		$params = $this->params;
		$this->pluginMenuViewName = $params->get('menu_view_plugin_name', '');
		$this->menuNodeList = $menuNodeList;
		$this->level = $level;
		$_MAMBOTS->loadBotGroup('exmenu');
		$results = $_MAMBOTS->trigger('onShowMenu', array($this, $this->pluginMenuViewName), FALSE);
		if (is_array($results)) {
			$results = implode('', $results);
		}
		return $results;
	}

	function getMenuNodeList() {
		return $this->menuNodeList;
	}
}

?>