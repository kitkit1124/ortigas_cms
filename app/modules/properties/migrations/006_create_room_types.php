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
class Migration_Create_room_types extends CI_Migration {

	private $_table = 'room_types';

	private $_permissions = array(
		array('Unit Types Link', 'properties.room_types.link'),
		array('Unit Types List', 'properties.room_types.list'),
		array('View Unit Type', 'properties.room_types.view'),
		array('Add Unit Type', 'properties.room_types.add'),
		array('Edit Unit Type', 'properties.room_types.edit'),
		array('Delete Unit Type', 'properties.room_types.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Unit Types',    
			'menu_link' 		=> 'properties/room_types', 
			'menu_perm' 		=> 'properties.room_types.link', 
			'menu_icon' 		=> 'fa fa-cube', 
			'menu_order' 		=> 6, 
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
			'room_type_id'			=> array('type' => 'SMALLINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'room_type_property_id'	=> array('type' => 'SMALLINT', 'constraint' => 5, 'null' => FALSE),
			'room_type_name'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'room_type_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'room_type_alt_image'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'room_type_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'room_type_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'room_type_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'room_type_modified_by' => array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'room_type_modified_on' => array('type' => 'DATETIME', 'null' => TRUE),
			'room_type_deleted' 	=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'room_type_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('room_type_id', TRUE);
		$this->dbforge->add_key('room_type_property_id');
		$this->dbforge->add_key('room_type_name');
		$this->dbforge->add_key('room_type_status');

		$this->dbforge->add_key('room_type_deleted');
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