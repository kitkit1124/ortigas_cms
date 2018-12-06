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
class Migration_Create_image_sliders extends CI_Migration {

	private $_table = 'image_sliders';

	private $_permissions = array(
		array('Image Sliders Link', 'properties.image_sliders.link'),
		array('Image Sliders List', 'properties.image_sliders.list'),
		array('View Image Slider', 'properties.image_sliders.view'),
		array('Add Image Slider', 'properties.image_sliders.add'),
		array('Edit Image Slider', 'properties.image_sliders.edit'),
		array('Delete Image Slider', 'properties.image_sliders.delete'),
	);

	// private $_menus = array(
	// 	array(
	// 		'menu_parent'		=> 'properties',
	// 		'menu_text' 		=> 'Image Sliders',    
	// 		'menu_link' 		=> 'properties/image_sliders', 
	// 		'menu_perm' 		=> 'properties.image_sliders.link', 
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
			'image_slider_id'				=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'image_slider_section_type'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),
			'image_slider_section_id'		=> array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE),
			'image_slider_image'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_slider_title'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_slider_title_size'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'image_slider_title_pos'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_slider_caption'			=> array('type' => 'TEXT', 'null' => FALSE),
			'image_slider_caption_size'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'image_slider_caption_pos'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_slider_alt_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'image_slider_order'			=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'image_slider_status'			=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'image_slider_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'image_slider_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'image_slider_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'image_slider_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'image_slider_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'image_slider_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('image_slider_id', TRUE);
		$this->dbforge->add_key('image_slider_section_type');
		$this->dbforge->add_key('image_slider_section_id');
		$this->dbforge->add_key('image_slider_image');
		$this->dbforge->add_key('image_slider_title');

		$this->dbforge->add_key('image_slider_deleted');
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