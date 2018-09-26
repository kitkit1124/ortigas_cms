<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph> (From SEO module)
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_metatags extends CI_Migration 
{
	private $_table = 'metatags';

	private $_permissions = array(
		array('Metatags Link', 'metatags.metatags.link'),
		array('Metatags List', 'metatags.metatags.list'),
		array('View Metatag', 'metatags.metatags.view'),
		array('Add Metatag', 'metatags.metatags.add'),
		array('Edit Metatag', 'metatags.metatags.edit'),
		array('Delete Metatag', 'metatags.metatags.delete'),
	);

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'metatag_id' 					=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'metatag_title'					=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'metatag_keywords'				=> array('type' => 'TEXT', 'null' => TRUE),
			'metatag_description'			=> array('type' => 'TEXT', 'null' => TRUE),
			'metatag_og_title'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'metatag_og_image'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'metatag_og_description'		=> array('type' => 'TEXT', 'null' => TRUE),
			'metatag_twitter_title'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'metatag_twitter_image'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'metatag_twitter_description'	=> array('type' => 'TEXT', 'null' => TRUE),

			'metatag_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'metatag_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'metatag_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'metatag_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'metatag_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'metatag_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('metatag_id', TRUE);

		$this->dbforge->add_key('metatag_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);
	}
}