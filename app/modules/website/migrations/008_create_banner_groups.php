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
class Migration_Create_banner_groups extends CI_Migration {

	private $_table = 'banner_groups';

	private $_permissions = array(
		array('Banner Groups Link', 'website.banner_groups.link'),
		array('Banner Groups List', 'website.banner_groups.list'),
		array('View Banner Group', 'website.banner_groups.view'),
		array('Add Banner Group', 'website.banner_groups.add'),
		array('Edit Banner Group', 'website.banner_groups.edit'),
		array('Delete Banner Group', 'website.banner_groups.delete'),
	);

	private $_menus = array(
		
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
			'banner_group_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'banner_group_name'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),

			'banner_group_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'banner_group_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'banner_group_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'banner_group_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'banner_group_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'banner_group_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('banner_group_id', TRUE);
		$this->dbforge->add_key('banner_group_name');

		$this->dbforge->add_key('banner_group_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		$data = array(
			array('banner_group_name'  => 'Home'),
			array('banner_group_name'  => 'Estates'),
			array('banner_group_name'  => 'Projects'),
			array('banner_group_name'  => 'News'),
			array('banner_group_name'  => 'Careers'),
			array('banner_group_name'  => 'Inquire'),
			array('banner_group_name'  => 'About Us'),
			array('banner_group_name'  => 'Established Communities'),
			array('banner_group_name'  => 'Investor Relations'),
			array('banner_group_name'  => 'S&C Accreditation'),
			array('banner_group_name'  => 'Data Privacy')
			
		);
		$this->db->insert_batch($this->_table, $data);
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