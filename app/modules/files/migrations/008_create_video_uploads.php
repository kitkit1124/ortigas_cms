<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutz Marzan <codifire@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_video_uploads extends CI_Migration 
{
	private $_table = 'video_uploads';

	private $_permissions = array(
		array('Videos Link', 'files.videos.link'),
		array('Videos List', 'files.videos.list'),
		array('View Video', 'files.videos.view'),
		array('Add Video', 'files.videos.add'),
		array('Edit Video', 'files.videos.edit'),
		array('Delete Video', 'files.videos.delete'),
	);


	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'video_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'video_name'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'video_section'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),
			'video_section_id'	=> array('type' => 'SMALLINT','constraint' => 5, 'unsigned' => TRUE, 'null' => FALSE),

			'video_title'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'video_caption'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'video_text_pos'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'video_button_text'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'video_link'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),

			'video_location'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'video_status'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'video_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'video_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'video_modified_by' => array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'video_modified_on' => array('type' => 'DATETIME', 'null' => TRUE),
			'video_deleted' 	=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'video_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('video_id', TRUE);
		$this->dbforge->add_key('video_name');
		$this->dbforge->add_key('video_type');

		$this->dbforge->add_key('video_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		$data = array(
			array('video_name'  => 'Main', 'video_section' => 1, 'video_section_id' => 1, 'video_location' => '', 'video_status'  => 'Active')
		);
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		// $this->migrations_model->delete_menus($this->_menus);
	}
}