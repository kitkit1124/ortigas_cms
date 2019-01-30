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
class Migration_Create_navigation_settings extends CI_Migration {

	private $_table = 'navigation_settings';


	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// create the table
		$fields = array(
			'nav_setting_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'nav_setting_color_theme'		=> array('type' => 'SET("Default","White")', 'null' => FALSE),

			'nav_setting_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'nav_setting_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'nav_setting_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'nav_setting_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'nav_setting_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'nav_setting_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('nav_setting_id', TRUE);

		$this->dbforge->add_key('nav_setting_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		$this->db->insert($this->_table, array('nav_setting_color_theme'=>'Default'));
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);
	}
}