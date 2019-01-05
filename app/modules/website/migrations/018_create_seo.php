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
class Migration_Create_seo extends CI_Migration {

	private $_table = 'seo';

	private $_permissions = array(
		array('Seo Link', 'website.seo.link'),
		array('Seo List', 'website.seo.list'),
		array('View Seo', 'website.seo.view'),
		array('Add Seo', 'website.seo.add'),
		array('Edit Seo', 'website.seo.edit'),
		array('Delete Seo', 'website.seo.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website',
			'menu_text' 		=> 'SEO',    
			'menu_link' 		=> 'website/seo', 
			'menu_perm' 		=> 'website.seo.link', 
			'menu_icon' 		=> 'fa fa fa-line-chart', 
			'menu_order' 		=> 9, 
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
			'seo_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'seo_title'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'seo_content'		=> array('type' => 'TEXT', 'null' => FALSE),
			'seo_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'seo_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seo_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seo_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seo_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seo_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'seo_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('seo_id', TRUE);
		$this->dbforge->add_key('seo_title');
		$this->dbforge->add_key('seo_status');

		$this->dbforge->add_key('seo_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);


		$data = array(
			array('seo_title'  => 'HEAD', 'seo_content' => '<!--SEO1-->', 'seo_status' => 'Active'),
			array('seo_title'  => 'START BODY', 'seo_content' => '<!--SEO2-->', 'seo_status' => 'Active'),
			array('seo_title'  => 'END BODY', 'seo_content' => '<!--SEO3-->','seo_status' => 'Active'),
			array('seo_title'  => 'FOOTER', 'seo_content' => '<!--SEO4-->','seo_status' => 'Active'),
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