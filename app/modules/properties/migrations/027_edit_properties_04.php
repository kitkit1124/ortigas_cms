<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutz Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Edit_properties_04 extends CI_Migration 
{
	private $_table = 'properties';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('properties'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Properties module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'property_location_description' => array('type' => 'TEXT', 'null' => TRUE),
			'property_amenities_description' => array('type' => 'TEXT', 'null' => TRUE)
		);
		
		$this->dbforge->add_column($this->_table, $fields);
	}
	
	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'property_map_name');
	}
}