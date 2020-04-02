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
class Migration_Create_countries extends CI_Migration 
{
	private $_table = 'countries';

	private $_permissions = array(
		array('Countries Link', 'areas.countries.link'),
		array('Countries List', 'areas.countries.list'),
		array('View Country', 'areas.countries.view'),
		array('Add Country', 'areas.countries.add'),
		array('Edit Country', 'areas.countries.edit'),
		array('Delete Country', 'areas.countries.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'areas', // none if parent or single menu
			'menu_text' 		=> 'Countries', 
			'menu_link' 		=> 'areas/countries', 
			'menu_perm' 		=> 'areas.countries.link', 
			'menu_icon' 		=> 'fa fa-flag', 
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
		$fields = array(
			'country_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'country_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'country_code2'			=> array('type' => 'CHAR', 'constraint' => 2, 'null' => FALSE),
			'country_code3'			=> array('type' => 'CHAR', 'constraint' => 3, 'null' => FALSE),
			'country_continent'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),

			'country_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'country_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'country_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'country_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'country_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'country_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('country_id', TRUE);
		$this->dbforge->add_key('country_name');
		$this->dbforge->add_key('country_code2');
		$this->dbforge->add_key('country_code3');
		$this->dbforge->add_key('country_continent');

		$this->dbforge->add_key('country_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// // add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// // add the module menu
		$this->migrations_model->add_menus($this->_menus);

		// add the initial values
		$file = fopen(APPPATH . "modules/areas/models/countries.csv","r");

		$data = array();
		while(! feof($file))
		{
			$country = fgetcsv($file);
			if ($country)
			{
				$country = array_map("utf8_encode", $country); // handles the encoding
				$data[] = array(
					'country_name' => $country[3],
					'country_code2' => $country[0], 
					'country_code3' => $country[1], 
					'country_continent' => $country[2], 
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