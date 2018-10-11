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
class Migration_Create_property_types extends CI_Migration {

	private $_table = 'property_types';

	private $_permissions = array(
		array('Development Types Link', 'properties.property_types.link'),
		array('Development Types List', 'properties.property_types.list'),
		array('View Development Type', 'properties.property_types.view'),
		array('Add Development Type', 'properties.property_types.add'),
		array('Edit Development Type', 'properties.property_types.edit'),
		array('Delete Development Type', 'properties.property_types.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Devt Types',    
			'menu_link' 		=> 'properties/property_types', 
			'menu_perm' 		=> 'properties.property_types.link', 
			'menu_icon' 		=> 'fa fa-building-o', 
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
			'property_type_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'property_type_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'property_type_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'property_type_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'property_type_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'property_type_modified_by' => array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'property_type_modified_on' => array('type' => 'DATETIME', 'null' => TRUE),
			'property_type_deleted' 	=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'property_type_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('property_type_id', TRUE);
		$this->dbforge->add_key('property_type_name');
		$this->dbforge->add_key('property_type_status');

		$this->dbforge->add_key('property_type_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		$data = array(
			array('property_type_name'  => 'Condo', 'property_type_status'  => 'Active'),
			array('property_type_name'  => 'Townhouse', 'property_type_status'  => 'Active'),
			array('property_type_name'  => 'Office for lease', 'property_type_status'  => 'Active'),
			array('property_type_name'  => 'Office for sale', 'property_type_status'  => 'Active')
		);
		$this->db->insert_batch($this->_table, $data);
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