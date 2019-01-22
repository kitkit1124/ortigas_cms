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
class Migration_Create_property_leasing_spaces extends CI_Migration {

	private $_table = 'property_leasing_spaces';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// create the table
		$fields = array(
			'lease_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'lease_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'lease_content'		=> array('type' => 'TEXT', 'null' => TRUE),
			'lease_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => TRUE),

			'lease_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'lease_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'lease_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'lease_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'lease_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'lease_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);	

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('lease_id', TRUE);
		$this->dbforge->add_key('lease_name');
		$this->dbforge->add_key('lease_status');

		$this->dbforge->add_key('lease_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		$data = array(
			array('lease_name'  => 'Office Space'),
			array('lease_name'  => 'Retail Space'),
		);

		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);
	}
}