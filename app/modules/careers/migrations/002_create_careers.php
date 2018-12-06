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
class Migration_Create_careers extends CI_Migration {

	private $_table = 'careers';

	private $_permissions = array(
		array('Careers Link', 'careers.careers.link'),
		array('Careers List', 'careers.careers.list'),
		array('View Career', 'careers.careers.view'),
		array('Add Career', 'careers.careers.add'),
		array('Edit Career', 'careers.careers.edit'),
		array('Delete Career', 'careers.careers.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none',
			'menu_text' 		=> 'Careers',    
			'menu_link' 		=> 'careers', 
			'menu_perm' 		=> 'careers.careers.link', 
			'menu_icon' 		=> 'fa fa-briefcase', 
			'menu_order' 		=> 4, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'careers',
			'menu_text' 		=> 'Careers',    
			'menu_link' 		=> 'careers/careers', 
			'menu_perm' 		=> 'careers.careers.link', 
			'menu_icon' 		=> 'fa fa-briefcase', 
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
		// create the table
		$fields = array(
			'career_id'					=> array('type' => 'SMALLINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'career_position_title'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'career_slug'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'career_dept'				=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'career_div'				=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'career_req'				=> array('type' => 'TEXT', 'null' => FALSE),
			'career_res'				=> array('type' => 'TEXT', 'null' => FALSE),
			'career_location'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'career_latitude'			=> array('type' => 'FLOAT', 'null' => TRUE),
			'career_longitude'			=> array('type' => 'FLOAT', 'null' => TRUE),
			'career_image'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'career_alt_image'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'career_status'				=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'career_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'career_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'career_modified_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'career_modified_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'career_deleted' 			=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'career_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('career_id', TRUE);
		$this->dbforge->add_key('career_position_title');
		$this->dbforge->add_key('career_dept');
		$this->dbforge->add_key('career_div');
		$this->dbforge->add_key('career_location');
		$this->dbforge->add_key('career_status');

		$this->dbforge->add_key('career_deleted');
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