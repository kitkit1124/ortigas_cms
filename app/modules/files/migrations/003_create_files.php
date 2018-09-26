<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_files extends CI_Migration 
{
	private $_permissions = array(
		array('Files Link', 'files.files.link'),
		array('Edit Settings', 'files.files.settings'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none', // 'none' if parent menu or single menu; or menu_link of parent
			'menu_text' 		=> 'Files', 
			'menu_link' 		=> 'files', 
			'menu_perm' 		=> 'files.files.link', 
			'menu_icon' 		=> 'fa fa-file-image-o', 
			'menu_order' 		=> 5, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'files',
			'menu_text' 		=> 'Settings', 
			'menu_link' 		=> 'files/settings', 
			'menu_perm' 		=> 'files.files.settings', 
			'menu_icon' 		=> 'fa fa-cogs', 
			'menu_order' 		=> 99, 
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