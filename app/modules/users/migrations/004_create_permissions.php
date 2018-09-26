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
class Migration_Create_permissions extends CI_Migration 
{
	private $_table = 'permissions';

	private $_permissions = array(
		array('Dashboard Link', 'dashboard.dashboard.link'),
		array('Dashboard Page', 'dashboard.dashboard.list'),
		
		array('Users Link', 'users.users.link'),
		array('List Users', 'users.users.list'),
		array('View Users', 'users.users.view'),
		array('Add Users', 'users.users.add'),
		array('Edit Users', 'users.users.edit'),
		array('Delete Users', 'users.users.delete'),

		array('Activate Users', 'users.users.activate'),
		array('Suspend Users', 'users.users.suspend'),
		array('Change Own Password', 'users.users.password'),
		array('Change Own Photo', 'users.users.photo'),
		array('Change Own Profile', 'users.users.profile'),
		
		array('Roles Link', 'users.roles.link'),
		array('List Roles', 'users.roles.list'),
		array('View Roles', 'users.roles.view'),
		array('Add Roles', 'users.roles.add'),
		array('Edit Roles', 'users.roles.edit'),
		array('Delete Roles', 'users.roles.delete'),
		
		// array('Permissions Link', 'users.permissions.link'),
		// array('List Permissions', 'users.permissions.list'),
		// array('View Permissions', 'users.permissions.view'),
		// array('Add Permissions', 'users.permissions.add'),
		// array('Edit Permissions', 'users.permissions.edit'),
		// array('Delete Permissions', 'users.permissions.delete')
	);

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'permission_id' 				=> array('type' => 'SMALLINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'permission_name' 				=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'permission_code' 				=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'permission_active' 			=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => TRUE),
			'permission_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'permission_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'permission_modified_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'permission_modified_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'permission_deleted' 			=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'permission_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('permission_id', TRUE);
		$this->dbforge->add_key('permission_name');
		$this->dbforge->add_key('permission_code');
		$this->dbforge->add_key('permission_active');
		$this->dbforge->add_key('permission_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);
	}
}