<?php

/**
* @author Daniel Ecer
* @package exmenu
* @copyright (C) 2005-2023 Daniel Ecer (de.siteof.de)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

defined('_JEXEC') or die();


use Joomla\CMS\Factory;


class modExmenuHelper {
	public static function getAjax() {
		// Get module parameters
		jimport('joomla.application.module.helper');
		$app = Factory::getApplication();
		$url  = $app->input->get('url');
		if ($url != '') {
			$app->redirect($url);
		}
		return $url;
	}
}