<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Add_admin_menu extends CI_Migration 
{

	private $_permissions = array(
		array('Modules Link', 'admin.module.link'),
		array('List Modules', 'admin.module.list'),
		array('Add Modules', 'admin.module.add'),
		array('Delete Modules', 'admin.module.delete'),
		array('Migrate Databases', 'admin.migrations.migrate'),
		array('Rollback Databases', 'admin.migrations.rollback'),
	);

	private $_menus = array(		
		array(
			'menu_parent'		=> 'admin',
			'menu_text' 		=> 'Modules', 
			'menu_link' 		=> 'admin/module/action/list', 
			'menu_perm' 		=> 'admin.module.link', 
			'menu_icon' 		=> 'fa fa-sitemap', 
			'menu_order' 		=> 1, 
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