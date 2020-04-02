<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutz Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2020, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_property_pages extends CI_Migration {

	private $_table = 'property_pages';

	private $_permissions = array(
		array('Property Pages Link', 'properties.property_pages.link'),
		array('Property Pages List', 'properties.property_pages.list'),
		array('View Page', 'properties.property_pages.view'),
		array('Add Page', 'properties.property_pages.add'),
		array('Edit Page', 'properties.property_pages.edit'),
		array('Delete Page', 'properties.property_pages.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Pages',    
			'menu_link' 		=> 'properties/property_pages', 
			'menu_perm' 		=> 'properties.property_pages.link', 
			'menu_icon' 		=> 'fa fa-file-text', 
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
			'page_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'page_title'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'page_content'		=> array('type' => 'TEXT', 'null' => TRUE),
			'page_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'page_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'page_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'page_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'page_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'page_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'page_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('page_id', TRUE);

		$this->dbforge->add_key('page_deleted');
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