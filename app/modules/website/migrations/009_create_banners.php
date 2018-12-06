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
class Migration_Create_banners extends CI_Migration {

	private $_table = 'banners';

	private $_permissions = array(
		array('Banners Link', 'website.banners.link'),
		array('Banners List', 'website.banners.list'),
		array('View Banner', 'website.banners.view'),
		array('Add Banner', 'website.banners.add'),
		array('Edit Banner', 'website.banners.edit'),
		array('Delete Banner', 'website.banners.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website',
			'menu_text' 		=> 'Banners',    
			'menu_link' 		=> 'website/banners', 
			'menu_perm' 		=> 'website.banners.link', 
			'menu_icon' 		=> 'fa fa-map-signs', 
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
			'banner_id'		=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'banner_banner_group_id'		=> array('type' => 'SMALLINT', 'constraint' => 5, 'null' => FALSE),
			'banner_thumb'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'banner_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'banner_alt_image'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'banner_caption'	=> array('type' => 'TEXT', 'null' => TRUE),
			'banner_link'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'banner_target'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'banner_order'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'banner_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'banner_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'banner_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'banner_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'banner_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'banner_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'banner_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('banner_id', TRUE);
		$this->dbforge->add_key('banner_banner_group_id');
		$this->dbforge->add_key('banner_order');
		$this->dbforge->add_key('banner_status');

		$this->dbforge->add_key('banner_deleted');
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