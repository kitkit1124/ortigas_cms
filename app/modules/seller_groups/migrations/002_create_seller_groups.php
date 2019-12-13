<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_seller_groups extends CI_Migration {

	private $_table = 'seller_groups';

	private $_permissions = array(
		array('Seller Groups Link', 'seller_groups.seller_groups.link'),
		array('Seller Groups List', 'seller_groups.seller_groups.list'),
		array('View Seller Group', 'seller_groups.seller_groups.view'),
		array('Add Seller Group', 'seller_groups.seller_groups.add'),
		array('Edit Seller Group', 'seller_groups.seller_groups.edit'),
		array('Delete Seller Group', 'seller_groups.seller_groups.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'seller_groups',
			'menu_text' 		=> 'Seller Groups',    
			'menu_link' 		=> 'seller_groups/seller_groups', 
			'menu_perm' 		=> 'seller_groups.seller_groups.link', 
			'menu_icon' 		=> 'fa fa-leaf', 
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
			'seller_group_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'seller_group_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'seller_group_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'seller_group_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seller_group_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seller_group_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seller_group_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seller_group_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'seller_group_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('seller_group_id', TRUE);
		$this->dbforge->add_key('seller_group_name');
		$this->dbforge->add_key('seller_group_status');

		$this->dbforge->add_key('seller_group_deleted');
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