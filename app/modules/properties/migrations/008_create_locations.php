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
class Migration_Create_locations extends CI_Migration {

	private $_table = 'property_locations';

	private $_permissions = array(
		array('Locations Link', 'properties.locations.link'),
		array('Locations List', 'properties.locations.list'),
		array('View Location', 'properties.locations.view'),
		array('Add Location', 'properties.locations.add'),
		array('Edit Location', 'properties.locations.edit'),
		array('Delete Location', 'properties.locations.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Locations',    
			'menu_link' 		=> 'properties/locations', 
			'menu_perm' 		=> 'properties.locations.link', 
			'menu_icon' 		=> 'fa fa-map-marker', 
			'menu_order' 		=> 8, 
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
			'location_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'location_name'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'location_status'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'location_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'location_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'location_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'location_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'location_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'location_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('location_id', TRUE);
		$this->dbforge->add_key('location_name');
		$this->dbforge->add_key('location_status');

		$this->dbforge->add_key('location_deleted');
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