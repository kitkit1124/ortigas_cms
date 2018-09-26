<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_audittrails extends CI_Migration 
{
	private $_table = 'audittrails';

	private $_permissions = array(
		array('Reports Link', 'reports.reports.link'),
		array('Audit Trails Link', 'reports.audittrails.link'),
		array('List Audit Trails', 'reports.audittrails.list'),
		array('View Audit Trails', 'reports.audittrails.view'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none', // none if parent or single menu
			'menu_text' 		=> 'Reports', 
			'menu_link' 		=> 'reports', 
			'menu_perm' 		=> 'reports.reports.link', 
			'menu_icon' 		=> 'fa fa-bar-chart', 
			'menu_order' 		=> 252, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'reports', // none if parent or single menu
			'menu_text' 		=> 'Audit Trails', 
			'menu_link' 		=> 'reports/audittrails', 
			'menu_perm' 		=> 'reports.audittrails.link', 
			'menu_icon' 		=> 'fa fa-archive', 
			'menu_order' 		=> 1, 
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
			'audittrail_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'audittrail_action' 		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'audittrail_table' 			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'audittrail_data' 			=> array('type' => 'TEXT', 'null' => FALSE),
			'audittrail_user_ip' 		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'audittrail_user_agent' 	=> array('type' => 'TEXT', 'null' => TRUE),
			'audittrail_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'audittrail_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'audittrail_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'audittrail_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('audittrail_id', TRUE);
		$this->dbforge->add_key('audittrail_action');
		$this->dbforge->add_key('audittrail_table');
		$this->dbforge->add_key('audittrail_created_by');
		$this->dbforge->add_key('audittrail_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}