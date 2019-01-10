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
			'page_id' 				=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'page_parent_id' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'default' => 0),
			'page_title'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'page_heading_text'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'page_slug'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'page_uri'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'page_content'			=> array('type' => 'TEXT', 'null' => FALSE),
			'page_bottom_content'	=> array('type' => 'TEXT', 'null' => TRUE),
			'page_layout'			=> array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'right_sidebar'),
			'page_status'			=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'page_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'page_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'page_modified_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'page_modified_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'page_deleted' 			=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'page_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('page_id', TRUE);
		$this->dbforge->add_key('page_parent_id');
		$this->dbforge->add_key('page_title');
		$this->dbforge->add_key('page_heading_text');
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
			array('page_title' => 'Home', 'page_content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet turpis tincidunt, pretium turpis in, pharetra diam. Mauris nec felis sit amet felis facilisis scelerisque quis eget velit. Integer egestas laoreet elit id consequat. Proin nec luctus neque, eu elementum orci. Sed fermentum pretium nibh dictum tempus. Etiam eu egestas ipsum, pretium iaculis odio. Aliquam est orci, dignissim ut ullamcorper sed, feugiat lacinia sem. Aliquam viverra egestas mi in congue.</p>', 'page_slug' => 'home', 'page_uri' => 'home', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Estates', 'page_content' => '<p>Estates</p>', 'page_slug' => 'estates', 'page_uri' => 'estates', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Projects', 'page_content' => '<h1>Lorem Ipsum dolor sit Amet</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet turpis tincidunt, pretium turpis in, pharetra diam. Mauris nec felis sit amet felis facilisis scelerisque quis eget velit. Integer egestas laoreet elit id consequat. Proin nec luctus neque, eu elementum orci. Sed fermentum pretium nibh dictum tempus. Etiam eu egestas ipsum, pretium iaculis odio. Aliquam est orci, dignissim ut ullamcorper sed, feugiat lacinia sem. Aliquam viverra egestas mi in congue.</p>', 'page_slug' => 'projects', 'page_uri' => 'projects', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'News', 'page_content' => '<p>News</p>', 'page_slug' => 'news', 'page_uri' => 'news', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Careers', 'page_content' => '<p>Careers</p>', 'page_slug' => 'careers', 'page_uri' => 'careers', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Contact Us', 'page_content' => '<p>Contact Us</p>', 'page_slug' => 'contact-us', 'page_uri' => 'contact-us', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'About Us', 'page_content' => '<p>About Us</p>', 'page_slug' => 'about-us', 'page_uri' => 'about-us', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Established Communities', 'page_content' => 'Established Communities', 'page_slug' => 'established-communities', 'page_uri' => 'established-communities', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Investor Relations', 'page_content' => 'investor-relations', 'page_slug' => 'investor-relations', 'page_uri' => 'investor-relations', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Supplier and Contractor Accreditation', 'page_content' => 'Supplier and Contractor Accreditation', 'page_slug' => 'supplier-and-contractor-accreditation', 'page_uri' => 'supplier-and-contractor-accreditation', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Data Privacy Policy', 'page_content' => 'Privacy Policy', 'page_slug' => 'privacy-policy', 'page_uri' => 'privacy-policy', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Search Properties', 'page_content' => 'Search Properties', 'page_slug' => 'property_search', 'page_uri' => 'property_search', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
			array('page_title' => 'Global Search', 'page_content' => 'Global Search', 'page_slug' => 'global_search', 'page_uri' => 'global_search', 'page_layout' => 'full_width', 'page_status' => 'Posted'),
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