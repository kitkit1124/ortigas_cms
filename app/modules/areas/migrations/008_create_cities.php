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
class Migration_Create_cities extends CI_Migration 
{
	private $_table = 'cities';

	private $_permissions = array(
		array('Cities Link', 'areas.cities.link'),
		array('Cities List', 'areas.cities.list'),
		array('View City', 'areas.cities.view'),
		array('Add City', 'areas.cities.add'),
		array('Edit City', 'areas.cities.edit'),
		array('Delete City', 'areas.cities.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'areas', // none if parent or single menu
			'menu_text' 		=> 'Cities', 
			'menu_link' 		=> 'areas/cities', 
			'menu_perm' 		=> 'areas.cities.link', 
			'menu_icon' 		=> 'fa fa-map-marker', 
			'menu_order' 		=> 5, 
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
			'city_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'city_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'city_code'			=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => TRUE),
			'city_type'			=> array('type' => 'VARCHAR', 'constraint' => 40, 'null' => TRUE),
			'city_province'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => TRUE),
			'city_country'		=> array('type' => 'CHAR', 'constraint' => 2, 'null' => TRUE),

			'city_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'city_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'city_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'city_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'city_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'city_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('city_id', TRUE);
		$this->dbforge->add_key('city_name');
		$this->dbforge->add_key('city_code');
		$this->dbforge->add_key('city_type');
		$this->dbforge->add_key('city_province');
		$this->dbforge->add_key('city_country');

		$this->dbforge->add_key('city_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// // add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// // add the module menu
		$this->migrations_model->add_menus($this->_menus);
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