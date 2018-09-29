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
class Migration_Create_units extends CI_Migration {

	private $_table = 'units';

	private $_permissions = array(
		array('Units Link', 'properties.units.link'),
		array('Units List', 'properties.units.list'),
		array('View Unit', 'properties.units.view'),
		array('Add Unit', 'properties.units.add'),
		array('Edit Unit', 'properties.units.edit'),
		array('Delete Unit', 'properties.units.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Units',    
			'menu_link' 		=> 'properties/units', 
			'menu_perm' 		=> 'properties.units.link', 
			'menu_icon' 		=> 'fa fa-cubes', 
			'menu_order' 		=> 7, 
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
			'unit_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'unit_property_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'null' => FALSE),
			'unit_floor_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'null' => FALSE),
			'unit_room_type_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'null' => FALSE),
			'unit_number'		=> array('type' => 'VARCHAR', 'constraint' => 50, 'null' => FALSE),
			'unit_size'		=> array('type' => 'VARCHAR', 'constraint' => 50, 'null' => FALSE),
			'unit_price'		=> array('type' => 'FLOAT', 'null' => FALSE),
			'unit_downpayment'		=> array('type' => 'FLOAT', 'null' => FALSE),
			'unit_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'unit_status'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'unit_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'unit_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'unit_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'unit_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'unit_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'unit_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('unit_id', TRUE);
		$this->dbforge->add_key('unit_property_id');
		$this->dbforge->add_key('unit_floor_id');
		$this->dbforge->add_key('unit_room_type_id');
		$this->dbforge->add_key('unit_number');
		$this->dbforge->add_key('unit_price');
		$this->dbforge->add_key('unit_downpayment');
		$this->dbforge->add_key('unit_status');

		$this->dbforge->add_key('unit_deleted');
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