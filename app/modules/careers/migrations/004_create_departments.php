<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_departments extends CI_Migration {

	private $_table = 'career_departments';

	private $_permissions = array(
		array('Departments Link', 'careers.departments.link'),
		array('Departments List', 'careers.departments.list'),
		array('View Department', 'careers.departments.view'),
		array('Add Department', 'careers.departments.add'),
		array('Edit Department', 'careers.departments.edit'),
		array('Delete Department', 'careers.departments.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'careers',
			'menu_text' 		=> 'Departments',    
			'menu_link' 		=> 'careers/departments', 
			'menu_perm' 		=> 'careers.departments.link', 
			'menu_icon' 		=> 'fa fa-university', 
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
		// create the table
		$fields = array(
			'department_id'			=> array('type' => 'SMALLINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'department_division_id'=> array('type' => 'TINYINT', 'constraint' => 3, 'null' => FALSE),
			'department_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'department_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'department_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'department_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'department_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'department_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'department_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'department_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('department_id', TRUE);
		$this->dbforge->add_key('department_name');
		$this->dbforge->add_key('department_status');

		$this->dbforge->add_key('department_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}