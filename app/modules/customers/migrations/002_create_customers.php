<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_customers extends CI_Migration {

	private $_table = 'customers';

	private $_permissions = array(
		array('Customers Link', 'customers.customers.link'),
		array('Customers List', 'customers.customers.list'),
		array('View Customer', 'customers.customers.view'),
		array('Add Customer', 'customers.customers.add'),
		array('Edit Customer', 'customers.customers.edit'),
		array('Delete Customer', 'customers.customers.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'customers',
			'menu_text' 		=> 'Customers',    
			'menu_link' 		=> 'customers/customers', 
			'menu_perm' 		=> 'customers.customers.link', 
			'menu_icon' 		=> 'fa fa-user', 
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
		// create the table
		$fields = array(
			'customer_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'customer_fname'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_lname'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_telno'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_mobileno'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_email'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_id_type'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_id_details'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_mailing_country'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_mailing_house_no'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_mailing_street'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_mailing_city'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_mailing_brgy'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_mailing_zip_code'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_billing_country'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_billing_house_no'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_billing_street'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_billing_city'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_billing_brgy'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'customer_billing_zip_code'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),

			'customer_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'customer_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'customer_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'customer_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'customer_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'customer_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('customer_id', TRUE);

		$this->dbforge->add_key('customer_deleted');
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