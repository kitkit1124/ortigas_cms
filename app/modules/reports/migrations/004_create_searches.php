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
class Migration_Create_searches extends CI_Migration {

	private $_table = 'property_searches';

	private $_permissions = array(
		array('Searches Link', 'reports.searches.link'),
		array('Searches List', 'reports.searches.list'),
		array('View Search', 'reports.searches.view'),
		array('Add Search', 'reports.searches.add'),
		array('Edit Search', 'reports.searches.edit'),
		array('Delete Search', 'reports.searches.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'reports',
			'menu_text' 		=> 'Searches',    
			'menu_link' 		=> 'reports/searches', 
			'menu_perm' 		=> 'reports.searches.link', 
			'menu_icon' 		=> 'fa fa-list-alt ', 
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
			'search_id'				=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'search_keyword'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'search_cat_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'search_price_id'		=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),
			'search_loc_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'unsigned' => TRUE, 'null' => FALSE),

			'search_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'search_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'search_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'search_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'search_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'search_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('search_id', TRUE);
		$this->dbforge->add_key('search_cat_id');
		$this->dbforge->add_key('search_price_id');
		$this->dbforge->add_key('search_loc_id');

		$this->dbforge->add_key('search_deleted');
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