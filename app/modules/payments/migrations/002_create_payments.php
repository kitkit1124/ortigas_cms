<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_payments extends CI_Migration {

	private $_table = 'payments';

	private $_permissions = array(
		array('Payments Link', 'payments.payments.link'),
		array('Payments List', 'payments.payments.list'),
		array('View Payment', 'payments.payments.view'),
		array('Add Payment', 'payments.payments.add'),
		array('Edit Payment', 'payments.payments.edit'),
		array('Delete Payment', 'payments.payments.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'payments',
			'menu_text' 		=> 'Payments',    
			'menu_link' 		=> 'payments/payments', 
			'menu_perm' 		=> 'payments.payments.link', 
			'menu_icon' 		=> 'fa fa-money', 
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
			'payment_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'payment_reservation_id'		=> array('type' => 'INT', 'constraint' => 10, 'null' => FALSE),
			'payment_type'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'payment_paynamics_no'		=> array('type' => 'varchar', 'constraint' => 255, 'null' => TRUE),
			'payment_encoded_details'		=> array('type' => 'TEXT', 'null' => FALSE),
			'payment_status'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),

			'payment_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'payment_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'payment_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'payment_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'payment_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'payment_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('payment_id', TRUE);

		$this->dbforge->add_key('payment_deleted');
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