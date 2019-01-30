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
class Migration_Edit_properties_02 extends CI_Migration 
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
			'property_availability' => array('type' => 'VARCHAR', 'after' => 'property_status', 'constraint' => 20, 'null' => FALSE),
			'property_link_label' => array('type' => 'VARCHAR', 'after' => 'property_website', 'constraint' => 255, 'null' => FALSE),
			'property_order' => array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 9999),
		);
		
		$this->dbforge->add_column($this->_table, $fields);
		$this->db->update($this->_table, array('property_availability' => 'RFO'));
	}
	
	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'property_availability');
		$this->dbforge->drop_column($this->_table, 'property_link_label');
		$this->dbforge->drop_column($this->_table, 'property_order');
	}
}