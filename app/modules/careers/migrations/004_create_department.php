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
class Migration_Create_department extends CI_Migration {

	private $_table = 'career_department';

	private $_permissions = array(
		array('Department Link', 'careers.department.link'),
		array('Department List', 'careers.department.list'),
		array('View Dept', 'careers.department.view'),
		array('Add Dept', 'careers.department.add'),
		array('Edit Dept', 'careers.department.edit'),
		array('Delete Dept', 'careers.department.delete'),
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
			'dept_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'dept_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),

			'dept_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'dept_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'dept_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'dept_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'dept_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'dept_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('dept_id', TRUE);
		$this->dbforge->add_key('dept_name');

		$this->dbforge->add_key('dept_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		$data = array(
			array('dept_name'  => 'Department 1'),
			array('dept_name'  => 'Department 2'),
			array('dept_name'  => 'Department 3'),
		);
		$this->db->insert_batch($this->_table, $data);

	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);
	}
}