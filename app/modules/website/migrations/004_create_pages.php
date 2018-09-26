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
class Migration_Create_pages extends CI_Migration 
{
	private $_table = 'pages';

	private $_permissions = array(
		array('Pages Link', 'website.pages.link'),
		array('Pages List', 'website.pages.list'),
		array('View Page', 'website.pages.view'),
		array('Add Page', 'website.pages.add'),
		array('Edit Page', 'website.pages.edit'),
		array('Delete Page', 'website.pages.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website', // none if parent or single menu
			'menu_text' 		=> 'Pages', 
			'menu_link' 		=> 'website/pages', 
			'menu_perm' 		=> 'website.pages.link', 
			'menu_icon' 		=> 'fa fa-file-text', 
			'menu_order' 		=> 1, 
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
			'page_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'page_parent_id' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'default' => 0),
			'page_title'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'page_slug'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'page_uri'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'page_content'		=> array('type' => 'TEXT', 'null' => FALSE),
			'page_layout'		=> array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'right_sidebar'),
			'page_status'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'page_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'page_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'page_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'page_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'page_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'page_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('page_id', TRUE);
		$this->dbforge->add_key('page_parent_id');
		$this->dbforge->add_key('page_title');
		$this->dbforge->add_key('page_slug');
		$this->dbforge->add_key('page_uri');
		$this->dbforge->add_key('page_layout');
		$this->dbforge->add_key('page_status');

		$this->dbforge->add_key('page_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		// add the initial values
		$data = array(
			array('page_title' => 'Home', 'page_content' => 'Home', 'page_slug' => 'home', 'page_uri' => 'home', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'About Us', 'page_content' => 'About Us', 'page_slug' => 'about-us', 'page_uri' => 'about-us', 'page_layout' => 'left_sidebar', 'page_status' => 'Posted'),
			array('page_title' => 'Our Products', 'page_content' => 'Our Products', 'page_slug' => 'our-products', 'page_uri' => 'our-products', 'page_layout' => 'right_sidebar', 'page_status' => 'Posted'),
			array('page_title' => 'Contact Us', 'page_content' => 'Contact Us', 'page_slug' => 'contact-us', 'page_uri' => 'contact-us', 'page_layout' => 'narrow_width', 'page_status' => 'Posted'),
			// array('page_title' => 'Terms and Conditions', 'page_slug' => 'terms-and-conditions', 'page_uri' => 'terms-and-conditions', 'page_status' => 'Posted'),
		);
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}