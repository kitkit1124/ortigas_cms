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
class Migration_Create_properties extends CI_Migration {

	private $_table = 'properties';

	private $_permissions = array(
		array('Properties Link', 'properties.properties.link'),
		array('Properties List', 'properties.properties.list'),
		array('View Property', 'properties.properties.view'),
		array('Add Property', 'properties.properties.add'),
		array('Edit Property', 'properties.properties.edit'),
		array('Delete Property', 'properties.properties.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none',
			'menu_text' 		=> 'Properties',    
			'menu_link' 		=> 'properties', 
			'menu_perm' 		=> 'properties.properties.link', 
			'menu_icon' 		=> 'fa fa-building', 
			'menu_order' 		=> 3, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Properties',    
			'menu_link' 		=> 'properties/properties', 
			'menu_perm' 		=> 'properties.properties.link', 
			'menu_icon' 		=> 'fa fa-building', 
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
		// create the table
		$fields = array(
			'property_id'				=> array('type' => 'SMALLINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'property_estate_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'property_category_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'property_location_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'property_price_range_id'	=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'property_prop_type_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'property_is_featured'		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => TRUE),
			'property_name'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'property_slug'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'property_overview'			=> array('type' => 'TEXT', 'null' => TRUE),
			'property_bottom_overview'	=> array('type' => 'TEXT', 'null' => TRUE),
			'property_image'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'property_alt_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_logo'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_alt_logo'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_website'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_facebook'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_twitter'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_instagram'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_linkedin'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_youtube'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_latitude'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_longitude'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_nearby_malls'		=> array('type' => 'TEXT', 'null' => TRUE),
			'property_nearby_markets'		=> array('type' => 'TEXT', 'null' => TRUE),
			'property_nearby_hospitals'		=> array('type' => 'TEXT', 'null' => TRUE),
			'property_nearby_schools'		=> array('type' => 'TEXT', 'null' => TRUE),
			'property_tags'					=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_status'				=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),
			'property_construction_update'	=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => TRUE),
			'property_ground'				=> array('type' => 'VARCHAR', 'constraint' => 4, 'null' => TRUE),
			'property_presell'				=> array('type' => 'VARCHAR', 'constraint' => 4, 'null' => TRUE),
			'property_turnover'				=> array('type' => 'VARCHAR', 'constraint' => 4, 'null' => TRUE),

			'property_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'property_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'property_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'property_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'property_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'property_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('property_id', TRUE);
		$this->dbforge->add_key('property_estate_id');
		$this->dbforge->add_key('property_category_id');
		$this->dbforge->add_key('property_prop_type_id');
		$this->dbforge->add_key('property_location_id');
		$this->dbforge->add_key('property_name');
		$this->dbforge->add_key('property_slug');
		$this->dbforge->add_key('property_tags');
		$this->dbforge->add_key('property_status');

		$this->dbforge->add_key('property_deleted');
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