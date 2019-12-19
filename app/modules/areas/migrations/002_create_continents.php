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
class Migration_Create_continents extends CI_Migration 
{
	private $_table = 'continents';

	private $_permissions = array(
		array('Areas Link', 'areas.areas.link'),
		array('Continents Link', 'areas.continents.link'),
		array('Continents List', 'areas.continents.list'),
		array('View Continent', 'areas.continents.view'),
		array('Add Continent', 'areas.continents.add'),
		array('Edit Continent', 'areas.continents.edit'),
		array('Delete Continent', 'areas.continents.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none', // none if parent or single menu
			'menu_text' 		=> 'Areas', 
			'menu_link' 		=> 'areas', 
			'menu_perm' 		=> 'areas.areas.link', 
			'menu_icon' 		=> 'fa fa-map-marker', 
			'menu_order' 		=> 200, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'areas', // none if parent or single menu
			'menu_text' 		=> 'Continents', 
			'menu_link' 		=> 'areas/continents', 
			'menu_perm' 		=> 'areas.continents.link', 
			'menu_icon' 		=> 'fa fa-globe', 
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
			'continent_id' 				=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'continent_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),

			'continent_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'continent_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'continent_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'continent_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'continent_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'continent_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('continent_id', TRUE);
		$this->dbforge->add_key('continent_name');

		$this->dbforge->add_key('continent_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// // add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// // add the module menu
		$this->migrations_model->add_menus($this->_menus);

		// add the initial values
		$file = fopen(APPPATH . "modules/areas/models/continents.csv","r");

		$data = array();
		while(! feof($file))
		{
			$continent = fgetcsv($file);
			if ($continent)
			{
				$data[] = array(
					'continent_name' => $continent[0], 
				);
			}
		}
		$this->db->insert_batch($this->_table, $data);
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