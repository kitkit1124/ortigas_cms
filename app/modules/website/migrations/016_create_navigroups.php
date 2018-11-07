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
class Migration_Create_navigroups extends CI_Migration 
{
	private $_table = 'navigroups';

	private $_permissions = array(
		array('Navigation Groups Link', 'website.navigroups.link'),
		array('Navigation Groups List', 'website.navigroups.list'),
		array('View Navigation Groups', 'website.navigroups.view'),
		array('Add Navigation Groups', 'website.navigroups.add'),
		array('Edit Navigation Groups', 'website.navigroups.edit'),
		array('Delete Navigation Groups', 'website.navigroups.delete'),
	);

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'navigroup_id' 				=> array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'navigroup_name'			=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE),
			'navigroup_structure'		=> array('type' => 'TEXT', 'null' => FALSE),

			'navigroup_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'navigroup_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'navigroup_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'navigroup_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'navigroup_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'navigroup_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('navigroup_id', TRUE);
		$this->dbforge->add_key('navigroup_name');

		$this->dbforge->add_key('navigroup_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the initial values
		$data = array(
			array('navigroup_name'  => 'Main'),
			array('navigroup_name'  => 'Footer'),
		);
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);
	}
}