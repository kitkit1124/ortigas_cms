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
class Migration_Create_categories extends CI_Migration {

	private $_table = 'property_categories';

	private $_permissions = array(
		array('Categories Link', 'properties.categories.link'),
		array('Categories List', 'properties.categories.list'),
		array('View Category', 'properties.categories.view'),
		array('Add Category', 'properties.categories.add'),
		array('Edit Category', 'properties.categories.edit'),
		array('Delete Category', 'properties.categories.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Categories',    
			'menu_link' 		=> 'properties/categories', 
			'menu_perm' 		=> 'properties.categories.link', 
			'menu_icon' 		=> 'fa fa-tags', 
			'menu_order' 		=> 2, 
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
			'category_id'					=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'category_name'					=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'category_image'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'category_alt_image'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'category_description'			=> array('type' => 'TEXT', 'null' => TRUE),
			'category_bottom_description'	=> array('type' => 'TEXT', 'null' => TRUE),
			'category_status'				=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'category_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'category_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'category_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'category_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'category_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'category_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('category_id', TRUE);
		$this->dbforge->add_key('category_name');
		$this->dbforge->add_key('category_status');

		$this->dbforge->add_key('category_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		$data = array(
			array('category_name'  => 'Residences', 'category_image' => 'data/images/placeholder_category.jpg', 'category_status'  => 'Active'),
			array('category_name'  => 'Malls', 'category_image' => 'data/images/placeholder_category.jpg', 'category_status'  => 'Active'),
			array('category_name'  => 'Offices', 'category_image' => 'data/images/placeholder_category.jpg', 'category_status'  => 'Active'),
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