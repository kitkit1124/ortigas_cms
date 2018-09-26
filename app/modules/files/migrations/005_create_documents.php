<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <codifire@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_documents extends CI_Migration 
{
	private $_table = 'documents';

	private $_permissions = array(
		array('Documents Link', 'files.documents.link'),
		array('Documents List', 'files.documents.list'),
		array('View Document', 'files.documents.view'),
		array('Add Document', 'files.documents.add'),
		array('Edit Document', 'files.documents.edit'),
		array('Delete Document', 'files.documents.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'files', // 'none' if parent menu or single menu; or menu_link of parent
			'menu_text' 		=> 'Documents', 
			'menu_link' 		=> 'files/documents', 
			'menu_perm' 		=> 'files.documents.link', 
			'menu_icon' 		=> 'fa fa-folder-o', 
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
		$fields = array(
			'document_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'document_name'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'document_file'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'document_thumb'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),

			'document_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'document_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'document_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'document_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'document_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'document_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('document_id', TRUE);
		$this->dbforge->add_key('document_name');
		$this->dbforge->add_key('document_file');

		$this->dbforge->add_key('document_deleted');
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