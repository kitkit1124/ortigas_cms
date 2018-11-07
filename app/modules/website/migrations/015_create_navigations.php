<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_navigations extends CI_Migration 
{
	private $_table = 'navigations';

	private $_permissions = array(
		array('Navigations Link', 'website.navigations.link'),
		array('Navigations List', 'website.navigations.list'),
		array('View Navigation', 'website.navigations.view'),
		array('Add Navigation', 'website.navigations.add'),
		array('Edit Navigation', 'website.navigations.edit'),
		array('Delete Navigation', 'website.navigations.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website', // 'none' if parent menu or single menu; or menu_link of parent
			'menu_text' 		=> 'Navigations', 
			'menu_link' 		=> 'website/navigations', 
			'menu_perm' 		=> 'website.navigations.link', 
			'menu_icon' 		=> 'fa fa-hand-pointer-o', 
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
		$fields = array(
			'navigation_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'navigation_is_parent'		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'default' => 0),
			'navigation_group_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => TRUE, 'null' => FALSE),
			'navigation_parent_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => TRUE, 'default' => 0),
			'navigation_source'			=> array('type' => 'SET("categories","pages")', 'null' => TRUE),
			'navigation_source_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => TRUE, 'null' => TRUE),
			'navigation_name'			=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'navigation_link'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'navigation_target'			=> array('type' => 'SET("_top","_blank")', 'default' => '_top'),
			'navigation_type'			=> array('type' => 'SET("Internal","External")', 'null' => FALSE),
			'navigation_status'			=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'navigation_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'navigation_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'navigation_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'navigation_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'navigation_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'navigation_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('navigation_id', TRUE);
		$this->dbforge->add_key('navigation_is_parent');
		$this->dbforge->add_key('navigation_group_id');
		$this->dbforge->add_key('navigation_parent_id');
		$this->dbforge->add_key('navigation_source');
		$this->dbforge->add_key('navigation_source_id');
		$this->dbforge->add_key('navigation_name');
		$this->dbforge->add_key('navigation_link');
		$this->dbforge->add_key('navigation_target');
		$this->dbforge->add_key('navigation_type');
		$this->dbforge->add_key('navigation_status');

		$this->dbforge->add_key('navigation_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		// add the initial values
		$data = array(
			array(
				'navigation_group_id'  	=> 1,
				'navigation_parent_id'  => 0,
				'navigation_name'  		=> 'Home',
				'navigation_link'  		=> '',
				'navigation_type'  		=> 'Internal',
				'navigation_status'  	=> 'Active'
			),
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