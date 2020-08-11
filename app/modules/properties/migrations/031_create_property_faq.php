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
class Migration_Create_property_faq extends CI_Migration {

	private $_table = 'property_faq';

	private $_permissions = array(
		array('FAQ Link', 'properties.property_faq.link'),
		array('FAQ List', 'properties.property_faq.list'),
		array('View FAQ', 'properties.property_faq.view'),
		array('Add FAQ', 'properties.property_faq.add'),
		array('Edit FAQ', 'properties.property_faq.edit'),
		array('Delete FAQ', 'properties.property_faq.delete'),
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
			'faq_property_id'	=> array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'faq_topic'			=> array('type' => 'TEXT', 'null' => TRUE),
			'faq_answer'		=> array('type' => 'TEXT', 'null' => TRUE),
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
		$this->dbforge->add_key('faq_property_id');

		$this->dbforge->add_key('faq_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		// $this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		// $this->migrations_model->delete_menus($this->_menus);
	}
}