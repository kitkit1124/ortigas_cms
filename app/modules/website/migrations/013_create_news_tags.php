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
class Migration_Create_news_tags extends CI_Migration {

	private $_table = 'news_tags';

	private $_permissions = array(
		array('Tags Link', 'website.news_tags.link'),
		array('Tags List', 'website.news_tags.list'),
		array('View Tag', 'website.news_tags.view'),
		array('Add Tag', 'website.news_tags.add'),
		array('Edit Tag', 'website.news_tags.edit'),
		array('Delete Tag', 'website.news_tags.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website',
			'menu_text' 		=> 'Tags',    
			'menu_link' 		=> 'website/news_tags', 
			'menu_perm' 		=> 'website.news_tags.link', 
			'menu_icon' 		=> 'fa fa-tags', 
			'menu_order' 		=> 4, 
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
			'news_tag_id'			=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'news_tag_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'news_tag_description'	=> array('type' => 'TEXT', 'null' => FALSE),
			'news_tag_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'news_tag_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'news_tag_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'news_tag_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'news_tag_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'news_tag_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'news_tag_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('news_tag_id', TRUE);
		$this->dbforge->add_key('news_tag_name');
		$this->dbforge->add_key('news_tag_status');

		$this->dbforge->add_key('news_tag_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		$data = array(
			array('news_tag_name' => 'Tag', 'news_tag_status' => 'Active'),
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