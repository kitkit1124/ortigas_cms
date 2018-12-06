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
class Migration_Create_estates extends CI_Migration {

	private $_table = 'estates';

	private $_permissions = array(
		array('Estates Link', 'properties.estates.link'),
		array('Estates List', 'properties.estates.list'),
		array('View Estate', 'properties.estates.view'),
		array('Add Estate', 'properties.estates.add'),
		array('Edit Estate', 'properties.estates.edit'),
		array('Delete Estate', 'properties.estates.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'properties',
			'menu_text' 		=> 'Estates',    
			'menu_link' 		=> 'properties/estates', 
			'menu_perm' 		=> 'properties.estates.link', 
			'menu_icon' 		=> 'fa fa-map', 
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
			'estate_id'				=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'estate_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'estate_slug'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'estate_text'			=> array('type' => 'TEXT', 'null' => FALSE),
			'estate_bottom_text'	=> array('type' => 'TEXT', 'null' => FALSE),
			'estate_latitude'		=> array('type' => 'FLOAT', 'null' => TRUE),
			'estate_longtitude'		=> array('type' => 'FLOAT', 'null' => TRUE),
			'estate_image'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'estate_alt_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'estate_thumb'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'estate_alt_thumb'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'estate_status'			=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'estate_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'estate_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'estate_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'estate_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'estate_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'estate_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('estate_id', TRUE);
		$this->dbforge->add_key('estate_name');
		$this->dbforge->add_key('estate_slug');
		$this->dbforge->add_key('estate_status');

		$this->dbforge->add_key('estate_deleted');
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