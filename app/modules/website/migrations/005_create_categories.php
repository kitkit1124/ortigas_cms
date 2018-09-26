<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_categories extends CI_Migration 
{
	private $_table = 'categories';

	private $_permissions = array(
		array('Categories Link', 'website.categories.link'),
		array('Categories List', 'website.categories.list'),
		array('View Category', 'website.categories.view'),
		array('Add Category', 'website.categories.add'),
		array('Edit Category', 'website.categories.edit'),
		array('Delete Category', 'website.categories.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website', // none if parent or single menu
			'menu_text' 		=> 'Categories', 
			'menu_link' 		=> 'website/categories', 
			'menu_perm' 		=> 'website.categories.link', 
			'menu_icon' 		=> 'fa fa-tags', 
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
		$fields = array(
			'category_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'category_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'category_slug'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'category_uri'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'category_layout'		=> array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'right_sidebar'),
			'category_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),
			'category_parent_id' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'default' => 0),

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
		$this->dbforge->add_key('category_slug');
		$this->dbforge->add_key('category_uri');
		$this->dbforge->add_key('category_layout');
		$this->dbforge->add_key('category_status');
		$this->dbforge->add_key('category_parent_id');

		$this->dbforge->add_key('category_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// // add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// // add the module menu
		$this->migrations_model->add_menus($this->_menus);

		// add the initial values
		$data = array(
			array('category_name'  => 'News', 'category_slug' => 'news', 'category_uri' => 'category/news', 'category_status' => 'Active'),
		);
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// // delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// // delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}