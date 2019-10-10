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
class Migration_Create_reservations extends CI_Migration {

	private $_table = 'reservations';

	private $_permissions = array(
		array('Reservations Link', 'reservations.reservations.link'),
		array('Reservations List', 'reservations.reservations.list'),
		array('View Reservation', 'reservations.reservations.view'),
		array('Add Reservation', 'reservations.reservations.add'),
		array('Edit Reservation', 'reservations.reservations.edit'),
		array('Delete Reservation', 'reservations.reservations.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'reservations',
			'menu_text' 		=> 'Reservations',    
			'menu_link' 		=> 'reservations/reservations', 
			'menu_perm' 		=> 'reservations.reservations.link', 
			'menu_icon' 		=> 'fa fas fa-sticky-note', 
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
		// create the table
		$fields = array(
			'reservation_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'reservation_customer_id'		=> array('type' => 'INT', 'constraint' => 10, 'null' => FALSE),
			'reservation_reference_no'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'reservation_project'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'reservation_property_specialist'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'reservation_sellers_group'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'reservation_unit_details'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'reservation_allocation'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'reservation_fee'		=> array('type' => 'DECIMAL(10,2)', 'null' => FALSE),
			'reservation_notes'		=> array('type' => 'TEXT', 'null' => FALSE),

			'reservation_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'reservation_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'reservation_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'reservation_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'reservation_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'reservation_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('reservation_id', TRUE);

		$this->dbforge->add_key('reservation_deleted');
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