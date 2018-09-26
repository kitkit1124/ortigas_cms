<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_images extends CI_Migration 
{
	private $_table = 'images';

	private $_permissions = array(
		array('Images Link', 'files.images.link'),
		array('Images List', 'files.images.list'),
		array('View Image', 'files.images.view'),
		array('Upload Image', 'files.images.add'),
		array('Edit Image', 'files.images.edit'),
		array('Delete Image', 'files.images.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'files', // 'none' if parent menu or single menu; or menu_link of parent
			'menu_text' 		=> 'Images', 
			'menu_link' 		=> 'files/images', 
			'menu_perm' 		=> 'files.images.link', 
			'menu_icon' 		=> 'fa fa-file-image-o', 
			'menu_order' 		=> 1, 
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
			'image_id' 				=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'image_width'			=> array('type' => 'MEDIUMINT', 'constraint' => 8, 'null' => TRUE),
			'image_height'			=> array('type' => 'MEDIUMINT', 'constraint' => 8, 'null' => TRUE),
			'image_name'			=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
			'image_file'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_large'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_medium'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_small'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'image_thumb'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),

			'image_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'image_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'image_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'image_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'image_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'image_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('image_id', TRUE);
		$this->dbforge->add_key('image_width');
		$this->dbforge->add_key('image_height');
		$this->dbforge->add_key('image_name');

		$this->dbforge->add_key('image_deleted');
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