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
class Migration_Create_faqs extends CI_Migration {

	private $_table = 'faqs';

	private $_permissions = array(
		array('Faqs Link', 'faqs.faqs.link'),
		array('Faqs List', 'faqs.faqs.list'),
		array('View Faq', 'faqs.faqs.view'),
		array('Add Faq', 'faqs.faqs.add'),
		array('Edit Faq', 'faqs.faqs.edit'),
		array('Delete Faq', 'faqs.faqs.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'faqs',
			'menu_text' 		=> 'FAQ',    
			'menu_link' 		=> 'faqs/faqs', 
			'menu_perm' 		=> 'faqs.faqs.link', 
			'menu_icon' 		=> 'fa fa-question-circle', 
			'menu_order' 		=> 10, 
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
			'faq_id'			=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'faq_question'		=> array('type' => 'VARCHAR', 'constraint' => 500, 'null' => FALSE),
			'faq_instruction'	=> array('type' => 'TEXT', 'null' => FALSE),
			'faq_order'			=> array('type' => 'TINYINT', 'constraint' => 3, 'null' => FALSE),
			'faq_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'faq_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'faq_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'faq_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'faq_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'faq_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'faq_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('faq_id', TRUE);
		$this->dbforge->add_key('faq_question');

		$this->dbforge->add_key('faq_deleted');
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