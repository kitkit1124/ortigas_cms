<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Migration_Add_customers_002 extends CI_Migration 
{
	private $_table = 'customers';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('customers'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Customers module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
	
			'customer_mname' => array('type' => 'VARCHAR', 'after' => 'customer_fname','constraint' => 100, 'null' => TRUE),
		);	

		$this->dbforge->add_column($this->_table, $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'customer_mname');
	}
}