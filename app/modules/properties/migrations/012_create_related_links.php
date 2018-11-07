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
class Migration_Create_related_links extends CI_Migration {

	private $_table = 'related_links';

	private $_permissions = array(
		array('Related Links Link', 'properties.related_links.link'),
		array('Related Links List', 'properties.related_links.list'),
		array('View Related Link', 'properties.related_links.view'),
		array('Add Related Link', 'properties.related_links.add'),
		array('Edit Related Link', 'properties.related_links.edit'),
		array('Delete Related Link', 'properties.related_links.delete'),
	);

	// private $_menus = array(
	// 	array(
	// 		'menu_parent'		=> 'properties',
	// 		'menu_text' 		=> 'Related Links',    
	// 		'menu_link' 		=> 'properties/related_links', 
	// 		'menu_perm' 		=> 'properties.related_links.link', 
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
			'related_link_id'			=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'related_link_section_id'	=> array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'related_link_section_type'	=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),
			'related_link_label'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'related_link_link'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'related_link_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'related_link_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'related_link_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'related_link_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'related_link_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'related_link_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'related_link_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('related_link_id', TRUE);
		$this->dbforge->add_key('related_link_label');
		$this->dbforge->add_key('related_link_link');

		$this->dbforge->add_key('related_link_deleted');
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