<?php
/**
* @version $Id: mod_exmenu.php 509 2011-02-23 01:47:02Z  $
* @author Daniel Ecer
* @package exmenu
* @copyright (C) 2005-2011 Daniel Ecer (de.siteof.de)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Notice: some parts are based on the default mainmenu module.
* Beside this it were havily redesigned to separate module from view.
*/

defined('_JEXEC') or die();

// requested module allows to include other modules without immediately displaying them
if (!isset($requestedModule)) {
	$requestedModule	= 'exmenu';
}

if (!defined( '_EXTENDED_MENU_INCLUDED_' )) {
	/** ensure that functions are declared only once */
	define( '_EXTENDED_MENU_INCLUDED_', 1 );

	if (!defined('EXTENDED_MENU_HOME')) {
		define('EXTENDED_MENU_HOME', dirname(__FILE__).'/exmenu');
	}
	require_once(constant('EXTENDED_MENU_HOME').'/exmenu.class.php');
}

if ((isset($params)) && ($requestedModule == 'exmenu')) {
	if ((isset($module)) && (is_object($module)) && (isset($module->title))) {
		$params->def('title', $module->title);
	}
	ExtendedMenuModule::showModule($params);
}

?>