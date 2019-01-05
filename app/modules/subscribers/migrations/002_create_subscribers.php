<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		OCLP Administrator <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_subscribers extends CI_Migration {

	private $_table = 'subscribers';

	private $_permissions = array(
		array('Subscribers Link', 'subscribers.subscribers.link'),
		array('Subscribers List', 'subscribers.subscribers.list'),
		array('View Subscriber', 'subscribers.subscribers.view'),
		array('Add Subscriber', 'subscribers.subscribers.add'),
		array('Edit Subscriber', 'subscribers.subscribers.edit'),
		array('Delete Subscriber', 'subscribers.subscribers.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'subscribers',
			'menu_text' 		=> 'Subscribers',    
			'menu_link' 		=> 'subscribers/subscribers', 
			'menu_perm' 		=> 'subscribers.subscribers.link', 
			'menu_icon' 		=> 'fa fa-users', 
			'menu_order' 		=> 4, 
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
			'subscriber_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'subscriber_email'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'subscriber_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'subscriber_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'subscriber_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'subscriber_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'subscriber_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'subscriber_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'subscriber_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('subscriber_id', TRUE);
		$this->dbforge->add_key('subscriber_email');

		$this->dbforge->add_key('subscriber_deleted');
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