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
class Migration_Create_sellers extends CI_Migration {

	private $_table = 'sellers';

	private $_permissions = array(
		array('Sellers Link', 'sellers.sellers.link'),
		array('Sellers List', 'sellers.sellers.list'),
		array('View Seller', 'sellers.sellers.view'),
		array('Add Seller', 'sellers.sellers.add'),
		array('Edit Seller', 'sellers.sellers.edit'),
		array('Delete Seller', 'sellers.sellers.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'sellers',
			'menu_text' 		=> 'Sellers',    
			'menu_link' 		=> 'sellers/sellers', 
			'menu_perm' 		=> 'sellers.sellers.link', 
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
			'seller_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'seller_first_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'seller_middle_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'seller_last_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'seller_email'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'seller_mobile'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'seller_address'		=> array('type' => 'TEXT', 'null' => TRUE),
			'seller_group_id'		=> array('type' => 'SET("Active","Disabled")', 'null' => TRUE),
			'seller_user_id'		=> array('type' => 'INT', 'constraint' => 10, 'null' => TRUE),
			'seller_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => TRUE),

			'seller_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seller_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seller_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seller_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seller_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'seller_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('seller_id', TRUE);
		$this->dbforge->add_key('seller_email');
		$this->dbforge->add_key('seller_group_id');
		$this->dbforge->add_key('seller_user_id');
		$this->dbforge->add_key('seller_status');

		$this->dbforge->add_key('seller_deleted');
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