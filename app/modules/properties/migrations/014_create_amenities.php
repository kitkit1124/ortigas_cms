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
class Migration_Create_amenities extends CI_Migration {

	private $_table = 'property_amenities';

	private $_permissions = array(
		array('Amenities Link', 'properties.amenities.link'),
		array('Amenities List', 'properties.amenities.list'),
		array('View Amenity', 'properties.amenities.view'),
		array('Add Amenity', 'properties.amenities.add'),
		array('Edit Amenity', 'properties.amenities.edit'),
		array('Delete Amenity', 'properties.amenities.delete'),
	);

	// private $_menus = array(
	// 	array(
	// 		'menu_parent'		=> 'properties',
	// 		'menu_text' 		=> 'Amenities',    
	// 		'menu_link' 		=> 'properties/amenities', 
	// 		'menu_perm' 		=> 'properties.amenities.link', 
	// 		'menu_icon' 		=> 'fa fa-leaf', 
	// 		'menu_order' 		=> 2, 
	// 		'menu_active' 		=> 1
	// 	),
	// );

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// create the table
		$fields = array(
			'amenity_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'amenity_property_id'	=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'amenity_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'amenity_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'amenity_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'amenity_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'amenity_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'amenity_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'amenity_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'amenity_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('amenity_id', TRUE);
		$this->dbforge->add_key('amenity_name');
		$this->dbforge->add_key('amenity_status');

		$this->dbforge->add_key('amenity_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		// $this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		// $this->migrations_model->delete_menus($this->_menus);
	}
}