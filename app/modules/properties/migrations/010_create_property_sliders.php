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
class Migration_Create_property_sliders extends CI_Migration {

	private $_table = 'property_sliders';

	private $_permissions = array(
		array('Property Sliders Link', 'properties.property_sliders.link'),
		array('Property Sliders List', 'properties.property_sliders.list'),
		array('View Property Slider', 'properties.property_sliders.view'),
		array('Add Property Slider', 'properties.property_sliders.add'),
		array('Edit Property Slider', 'properties.property_sliders.edit'),
		array('Delete Property Slider', 'properties.property_sliders.delete'),
	);

	// private $_menus = array(
	// 	array(
			// 'menu_parent'		=> 'properties',
			// 'menu_text' 		=> 'Property Sliders',    
			// 'menu_link' 		=> 'properties/property_sliders', 
			// 'menu_perm' 		=> 'properties.property_sliders.link', 
			// 'menu_icon' 		=> 'fa fa-picture-o', 
			// 'menu_order' 		=> 2, 
			// 'menu_active' 		=> 1
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
			'property_slider_id'			=> array('type' => 'SMALLINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'property_slider_property_id'	=> array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => TRUE, 'null' => FALSE),
			'property_slider_image'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'property_slider_title'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_slider_title_size'	=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => TRUE),
			'property_slider_title_pos'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_slider_caption'		=> array('type' => 'TEXT', 'null' => TRUE),
			'property_slider_caption_size'	=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => TRUE),
			'property_slider_caption_pos'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'property_slider_order'			=> array('type' => 'TINYINT', 'constraint' => 3, 'null' => FALSE),
			'property_slider_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'property_slider_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'property_slider_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'property_slider_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'property_slider_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'property_slider_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'property_slider_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('property_slider_id', TRUE);
		$this->dbforge->add_key('property_slider_property_id');
		$this->dbforge->add_key('property_slider_order');
		$this->dbforge->add_key('property_slider_status');

		$this->dbforge->add_key('property_slider_deleted');
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