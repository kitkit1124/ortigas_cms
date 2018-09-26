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
class Migration_Create_social_plugin_contents extends CI_Migration {

	private $_permissions = array(
		array('Contents Link', 'social_plugins.contents.link'),
		array('Contents List', 'social_plugins.contents.list'),
		array('View Contents', 'social_plugins.contents.view'),
		array('Add Contents', 'social_plugins.contents.add'),
		array('Edit Contents', 'social_plugins.contents.edit'),
		array('Delete Contents', 'social_plugins.contents.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'social_plugins',
			'menu_text' 		=> 'Content Pages', 
			'menu_link' 		=> 'social_plugins/contents', 
			'menu_perm' 		=> 'social_plugins.contents.link', 
			'menu_icon' 		=> 'fa fa-files-o', 
			'menu_order' 		=> 2, 
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