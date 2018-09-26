<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_social_plugins extends CI_Migration {

	private $_table = 'social_plugins';

	private $_permissions = array(
		array('Social Plugins Link', 'social_plugins.social_plugins.link'),
		array('Social Plugins List', 'social_plugins.social_plugins.list'),
		array('View Social Plugins', 'social_plugins.social_plugins.view'),
		array('Add Social Plugins', 'social_plugins.social_plugins.add'),
		array('Edit Social Plugins', 'social_plugins.social_plugins.edit'),
		array('Delete Social Plugins Plugins', 'social_plugins.social_plugins.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none',
			'menu_text' 		=> 'Social Plugins', 
			'menu_link' 		=> 'social_plugins', 
			'menu_perm' 		=> 'social_plugins.social_plugins.link', 
			'menu_icon' 		=> 'fa fa-share-alt', 
			'menu_order' 		=> 3, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'social_plugins',
			'menu_text' 		=> 'Reports', 
			'menu_link' 		=> 'social_plugins/reports', 
			'menu_perm' 		=> 'social_plugins.social_plugins.link', 
			'menu_icon' 		=> 'fa fa-line-chart', 
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
			'social_plugin_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'social_plugin_channel'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'social_plugin_url'			=> array('type' => 'VARCHAR', 'constraint' => 500, 'null' => FALSE),
			'social_plugin_event'		=> array('type' => 'SET("click","visit")', 'null' => FALSE),
			'social_plugin_count'		=> array('type' => 'INT', 'null' => FALSE),
			'social_plugin_date'		=> array('type' => 'DATE', 'null' => FALSE),
			'social_plugin_user_agent'	=> array('type' => 'TEXT', 'unsigned' => TRUE, 'null' => FALSE),
			'social_plugin_ip'			=> array('type' => 'VARCHAR', 'constraint' => 50, 'null' => FALSE),

			'social_plugin_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'social_plugin_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'social_plugin_modified_by' => array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'social_plugin_modified_on' => array('type' => 'DATETIME', 'null' => TRUE),
			'social_plugin_deleted' 	=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'social_plugin_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('social_plugin_id', TRUE);
		$this->dbforge->add_key('social_plugin_channel');
		$this->dbforge->add_key('social_plugin_url');
		$this->dbforge->add_key('social_plugin_event');
		$this->dbforge->add_key('social_plugin_count');
		$this->dbforge->add_key('social_plugin_date');
		$this->dbforge->add_key('social_plugin_ip');

		$this->dbforge->add_key('social_plugin_deleted');
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