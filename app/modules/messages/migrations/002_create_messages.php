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
class Migration_Create_messages extends CI_Migration {

	private $_table = 'messages';

	private $_permissions = array(
		array('Messages Link', 'messages.messages.link'),
		array('Messages List', 'messages.messages.list'),
		array('View Message', 'messages.messages.view'),
		array('Add Message', 'messages.messages.add'),
		array('Edit Message', 'messages.messages.edit'),
		array('Delete Message', 'messages.messages.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none',
			'menu_text' 		=> 'Mails',    
			'menu_link' 		=> 'messages', 
			'menu_perm' 		=> 'messages.messages.link', 
			'menu_icon' 		=> 'fa fa-envelope', 
			'menu_order' 		=> 4, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'messages',
			'menu_text' 		=> 'Inbox',    
			'menu_link' 		=> 'messages/messages', 
			'menu_perm' 		=> 'messages.messages.link', 
			'menu_icon' 		=> 'fa fa-envelope', 
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
			'message_id'			=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'message_type'			=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'message_section'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'message_section_id'	=> array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'message_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'message_email'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'message_mobile'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'message_location'		=> array('type' => 'VARCHAR', 'constraint' => 500, 'null' => TRUE),
			'message_content'		=> array('type' => 'TEXT', 'null' => FALSE),
			'message_status'		=> array('type' => 'SET("0","1")', 'null' => FALSE),

			'message_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'message_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'message_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'message_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'message_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'message_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('message_id', TRUE);
		$this->dbforge->add_key('message_section');
		$this->dbforge->add_key('message_section_id');
		$this->dbforge->add_key('message_name');
		$this->dbforge->add_key('message_email');
		$this->dbforge->add_key('message_status');

		$this->dbforge->add_key('message_deleted');
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