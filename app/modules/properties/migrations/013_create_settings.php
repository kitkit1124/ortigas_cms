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
class Migration_Create_settings extends CI_Migration {

	private $_table = 'property_settings';

	private $_permissions = array(
		array('Settings Link', 'properties.settings.link'),
		array('Settings List', 'properties.settings.list'),
		array('View Setting', 'properties.settings.view'),
		array('Add Setting', 'properties.settings.add'),
		array('Edit Setting', 'properties.settings.edit'),
		array('Delete Setting', 'properties.settings.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Settings',    
			'menu_link' 		=> 'properties/settings', 
			'menu_perm' 		=> 'properties.settings.link', 
			'menu_icon' 		=> 'fa fa-gear', 
			'menu_order' 		=> 11, 
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
			'setting_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'setting_division'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'setting_order'			=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),

			'setting_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'setting_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'setting_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'setting_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'setting_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'setting_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('setting_id', TRUE);

		$this->dbforge->add_key('setting_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);


		$data = array(
			array('setting_division'  => 'Overview Description', 
				'setting_order'  => '0'),
			array('setting_division'  => 'Amenities',
				'setting_order'  => '1'),
			array('setting_division'  => 'Slider',
				'setting_order'  => '2'),
			array('setting_division'  => 'Locations',
				'setting_order'  => '3'),
			array('setting_division'  => 'Unit Floorplan',
				'setting_order'  => '4'),
			array('setting_division'  => 'Building Floorplan',
				'setting_order'  => '5'),
			array('setting_division'  => 'Construction Update',
				'setting_order'  => '6'),
			array('setting_division'  => 'Related Residences',
				'setting_order'  => '7'),
			array('setting_division'  => 'SEO Content',
				'setting_order'  => '8'),
			array('setting_division'  => 'Related News',
				'setting_order'  => '9'),
			array('setting_division'  => 'Recommended Links',
				'setting_order'  => '10'),
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