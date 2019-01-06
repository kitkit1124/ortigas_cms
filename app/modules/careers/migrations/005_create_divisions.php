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
class Migration_Create_divisions extends CI_Migration {

	private $_table = 'career_divisions';

	private $_permissions = array(
		array('Divisions Link', 'careers.divisions.link'),
		array('Divisions List', 'careers.divisions.list'),
		array('View Division', 'careers.divisions.view'),
		array('Add Division', 'careers.divisions.add'),
		array('Edit Division', 'careers.divisions.edit'),
		array('Delete Division', 'careers.divisions.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'careers',
			'menu_text' 		=> 'Divisions',    
			'menu_link' 		=> 'careers/divisions', 
			'menu_perm' 		=> 'careers.divisions.link', 
			'menu_icon' 		=> 'fa fa-university', 
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
		// create the table
		$fields = array(
			'division_id'			=> array('type' => 'TINYINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'division_department_id'=> array('type' => 'TINYINT', 'constraint' => 3, 'null' => FALSE),
			'division_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'division_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'division_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'division_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'division_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'division_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'division_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'division_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('division_id', TRUE);

		$this->dbforge->add_key('division_deleted');
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