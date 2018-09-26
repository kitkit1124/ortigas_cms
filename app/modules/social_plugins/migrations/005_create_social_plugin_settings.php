<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_social_plugin_settings extends CI_Migration {

	private $_permissions = array(
		array('Social Plugin Settings Link', 'social_plugins.settings.link'),
		array('Social Plugin Settings List', 'social_plugins.settings.list'),
		array('View Social Plugin Settings', 'social_plugins.settings.view'),
		array('Add Social Plugin Settings', 'social_plugins.settings.add'),
		array('Edit Social Plugin Settings', 'social_plugins.settings.edit'),
		array('Delete Social Plugin Settings', 'social_plugins.settings.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'social_plugins',
			'menu_text' 		=> 'Settings', 
			'menu_link' 		=> 'social_plugins/settings', 
			'menu_perm' 		=> 'social_plugins.settings.link', 
			'menu_icon' 		=> 'fa fa-gears', 
			'menu_order' 		=> 3, 
			'menu_active' 		=> 1
		),
	);

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}