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
class Migration_Create_floors extends CI_Migration {

	private $_table = 'floors';

	private $_permissions = array(
		array('Floors Link', 'properties.floors.link'),
		array('Floors List', 'properties.floors.list'),
		array('View Floor', 'properties.floors.view'),
		array('Add Floor', 'properties.floors.add'),
		array('Edit Floor', 'properties.floors.edit'),
		array('Delete Floor', 'properties.floors.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Floor Plan',    
			'menu_link' 		=> 'properties/floors', 
			'menu_perm' 		=> 'properties.floors.link', 
			'menu_icon' 		=> 'fa fa-columns', 
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
		// create the table
		$fields = array(
			'floor_id'			=> array('type' => 'SMALLINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'floor_property_id'	=> array('type' => 'SMALLINT', 'constraint' => 5, 'null' => FALSE),
			'floor_level'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'floor_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'floor_alt_image'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'floor_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'floor_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'floor_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'floor_modified_by' => array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'floor_modified_on' => array('type' => 'DATETIME', 'null' => TRUE),
			'floor_deleted' 	=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'floor_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('floor_id', TRUE);
		$this->dbforge->add_key('floor_property_id');
		$this->dbforge->add_key('floor_level');
		$this->dbforge->add_key('floor_status');

		$this->dbforge->add_key('floor_deleted');
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