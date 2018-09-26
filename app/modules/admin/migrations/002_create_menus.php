<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Migration_Create_menus extends CI_Migration 
{
	private $_table = 'menus';

	private $_permissions = array(
		array('Admin Link', 'admin.admin.link'),
		array('Menu Link', 'admin.menus.link'),
		array('List Menu', 'admin.menus.list'),
		array('View Menu', 'admin.menus.view'),
		array('Add Menu', 'admin.menus.add'),
		array('Edit Menu', 'admin.menus.edit'),
		array('Delete Menu', 'admin.menus.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none', // 'none' if parent or single menu; link of parent if child. eg, malls
			'menu_text'			=> 'Dashboard', 
			'menu_link'			=> 'dashboard', 
			'menu_perm'			=> 'dashboard.dashboard.link', 
			'menu_icon'			=> 'fa fa-dashboard', 
			'menu_order'		=> 1, 
			'menu_active'		=> 1
		),
		array(
			'menu_parent'		=> 'none', 
			'menu_text' 		=> 'Admin', 
			'menu_link' 		=> 'admin', 
			'menu_perm' 		=> 'admin.admin.link', 
			'menu_icon' 		=> 'fa fa-cog', 
			'menu_order' 		=> 255, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'admin',
			'menu_text' 		=> 'Menus', 
			'menu_link' 		=> 'admin/menus', 
			'menu_perm' 		=> 'admin.menus.link', 
			'menu_icon' 		=> 'fa fa-list-ul', 
			'menu_order' 		=> 2, 
			'menu_active' 		=> 1
		),
		
		array(
			'menu_parent'		=> 'none', 
			'menu_text'			=> 'Users', 
			'menu_link'			=> 'users', 
			'menu_perm'			=> 'users.users.link', 
			'menu_icon'			=> 'fa fa-users', 
			'menu_order'		=> 253, 
			'menu_active'		=> 1
		),
		array(
			'menu_parent'		=> 'users',
			'menu_text' 		=> 'Users', 
			'menu_link' 		=> 'users/users', 
			'menu_perm' 		=> 'users.users.link', 
			'menu_icon' 		=> 'fa fa-users', 
			'menu_order' 		=> 1, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'users',
			'menu_text' 		=> 'Roles', 
			'menu_link' 		=> 'users/roles', 
			'menu_perm' 		=> 'users.roles.link', 
			'menu_icon' 		=> 'fa fa-street-view', 
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
		$fields = array(
			'menu_id' 				=> array('type' => 'SMALLINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'menu_text' 			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'menu_link' 			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'menu_perm' 			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'menu_icon' 			=> array('type' => 'VARCHAR', 'constraint' => 40, 'null' => FALSE),
			'menu_parent' 			=> array('type' => 'SMALLINT', 'unsigned' => TRUE, 'null' => TRUE),
			'menu_order' 			=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => TRUE),
			'menu_active' 			=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => TRUE),
			'menu_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'menu_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'menu_modified_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'menu_modified_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'menu_deleted' 			=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => TRUE, 'default' => 0),
			'menu_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('menu_id', TRUE);
		$this->dbforge->add_key('menu_text');
		$this->dbforge->add_key('menu_active');
		$this->dbforge->add_key('menu_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}