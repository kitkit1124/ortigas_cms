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
class Migration_Create_regions extends CI_Migration 
{
	private $_table = 'regions';

	private $_permissions = array(
		array('Regions Link', 'areas.regions.link'),
		array('Regions List', 'areas.regions.list'),
		array('View Region', 'areas.regions.view'),
		array('Add Region', 'areas.regions.add'),
		array('Edit Region', 'areas.regions.edit'),
		array('Delete Region', 'areas.regions.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'areas', // none if parent or single menu
			'menu_text' 		=> 'Regions', 
			'menu_link' 		=> 'areas/regions', 
			'menu_perm' 		=> 'areas.regions.link', 
			'menu_icon' 		=> 'fa fa-sitemap', 
			'menu_order' 		=> 3, 
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
			'region_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'region_country'		=> array('type' => 'CHAR', 'constraint' => 2, 'null' => FALSE),
			'region_code'			=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),
			'region_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'region_short_name'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
			'region_group'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),

			'region_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'region_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'region_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'region_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'region_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'region_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('region_id', TRUE);
		$this->dbforge->add_key('region_country');
		$this->dbforge->add_key('region_code');
		$this->dbforge->add_key('region_name');
		$this->dbforge->add_key('region_short_name');
		$this->dbforge->add_key('region_group');

		$this->dbforge->add_key('region_deleted');
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