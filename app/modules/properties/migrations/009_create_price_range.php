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
class Migration_Create_price_range extends CI_Migration {

	private $_table = 'price_range';

	private $_permissions = array(
		array('Price Range Link', 'properties.price_range.link'),
		array('Price Range List', 'properties.price_range.list'),
		array('View Price Range', 'properties.price_range.view'),
		array('Add Price Range', 'properties.price_range.add'),
		array('Edit Price Range', 'properties.price_range.edit'),
		array('Delete Price Range', 'properties.price_range.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Price Range',    
			'menu_link' 		=> 'properties/price_range', 
			'menu_perm' 		=> 'properties.price_range.link', 
			'menu_icon' 		=> 'fa fa-dollar', 
			'menu_order' 		=> 9, 
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
			'price_range_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'price_range_label'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'price_range_min'		=> array('type' => 'FLOAT', 'null' => FALSE),
			'price_range_max'		=> array('type' => 'FLOAT', 'null' => FALSE),
			'price_range_status'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'price_range_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'price_range_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'price_range_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'price_range_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'price_range_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'price_range_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('price_range_id', TRUE);
		$this->dbforge->add_key('price_range_label');
		$this->dbforge->add_key('price_range_status');

		$this->dbforge->add_key('price_range_deleted');
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