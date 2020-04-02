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
class Migration_Create_provinces extends CI_Migration 
{
	private $_table = 'provinces';

	private $_permissions = array(
		array('Provinces Link', 'areas.provinces.link'),
		array('Provinces List', 'areas.provinces.list'),
		array('View Province', 'areas.provinces.view'),
		array('Add Province', 'areas.provinces.add'),
		array('Edit Province', 'areas.provinces.edit'),
		array('Delete Province', 'areas.provinces.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'areas', // none if parent or single menu
			'menu_text' 		=> 'Provinces', 
			'menu_link' 		=> 'areas/provinces', 
			'menu_perm' 		=> 'areas.provinces.link', 
			'menu_icon' 		=> 'fa fa-university', 
			'menu_order' 		=> 4, 
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
			'province_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'province_code'			=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),
			'province_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'province_region'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => TRUE),
			'province_country'		=> array('type' => 'CHAR', 'constraint' => 2, 'null' => FALSE),

			'province_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'province_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'province_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'province_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'province_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'province_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('province_id', TRUE);
		$this->dbforge->add_key('province_code');
		$this->dbforge->add_key('province_name');
		$this->dbforge->add_key('province_region');
		$this->dbforge->add_key('province_country');
		
		$this->dbforge->add_key('province_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// // add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// // add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// // delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// // delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}