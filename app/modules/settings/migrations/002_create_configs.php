<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.2
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_configs extends CI_Migration 
{
	private $_table = 'configs';

	private $_permissions = array(
		// array('Settings Link', 'settings.settings.link'), 

		array('Configurations Link', 'settings.configs.link'), 
		array('List Configurations', 'settings.configs.list'), 
		array('View Configuration', 'settings.configs.view'),
		array('Add Configuration', 'settings.configs.add'),
		array('Edit Configuration', 'settings.configs.edit'),
		array('Delete Configuration', 'settings.configs.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'admin', // none if parent or single menu
			'menu_text'			=> 'Settings', 
			'menu_link'			=> 'settings/configs', 
			'menu_perm'			=> 'settings.configs.link', 
			'menu_icon'			=> 'fa fa-cogs', 
			'menu_order'		=> 3, 
			'menu_active'		=> 1
		),
	);

	public function __construct() 
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
		$this->load->database();
	}
	
	public function up() 
	{
		$fields = array(
			'config_id'				=> array('type'  => 'SMALLINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'config_type'			=> array('type'	 => 'VARCHAR',  'constraint'  => 100, 'null' => FALSE),
			'config_values'			=> array('type'  => 'TEXT',  'null'  => TRUE), // for dropdown, radio and checkbox
			'config_label'			=> array('type'	 => 'VARCHAR',  'constraint'  => 100, 'null' => FALSE),
			'config_name'			=> array('type'	 => 'VARCHAR',  'constraint'  => 100, 'null' => FALSE),
			'config_value'			=> array('type'  => 'TEXT',  'null'  => FALSE),
			'config_notes'			=> array('type'  => 'TEXT',  'null'  => TRUE),
			'config_created_by'		=> array('type'  => 'MEDIUMINT', 'unsigned'    => TRUE, 'null' => TRUE),
			'config_created_on'		=> array('type'  => 'DATETIME',  'null'     => TRUE),
			'config_modified_by'	=> array('type'  => 'MEDIUMINT', 'unsigned' => TRUE, 'null'=> TRUE),
			'config_modified_on'	=> array('type'  => 'DATETIME',  'null' => TRUE),
			'config_deleted'		=> array('type'  => 'TINYINT',   'constraint' => 1,  'unsigned' => TRUE,  'null' => FALSE, 'default' => 0),
			'config_deleted_by'		=> array('type'  => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE), 
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('config_id', TRUE);
		$this->dbforge->add_key('config_type');
		$this->dbforge->add_key('config_label');
		$this->dbforge->add_key('config_name');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
		
		// add the initial values
		$data = array(
			array(
				'config_type'  => 'input', 
				'config_label'  => 'Application Title', 
				'config_name'  => 'app_name', 
				'config_value' => 'Codifire CMS', 
				'config_notes'  => 'The name of this application'
			),
			array(
				'config_type'  => 'input', 
				'config_label'  => 'Application Email', 
				'config_name'  => 'app_email', 
				'config_value' => 'admin@codifire.cms', 
				'config_notes'  => 'The email address to use when sending an email'
			),
			array(
				'config_type'  => 'input', 
				'config_label'  => 'Application Version', 
				'config_name'  => 'app_version', 
				'config_value' => '1.0.0', 
				'config_notes'  => 'The current version of the application'
			),
		);
		$this->db->insert_batch($this->_table, $data);
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