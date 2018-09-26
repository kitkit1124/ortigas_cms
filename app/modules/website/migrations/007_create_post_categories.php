<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_post_categories extends CI_Migration 
{
	private $_table = 'post_categories';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'post_category_id' 				=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'post_category_post_id' 		=> array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE),
			'post_category_category_id' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => FALSE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('post_category_id', TRUE);
		$this->dbforge->add_key('post_category_post_id');
		$this->dbforge->add_key('post_category_category_id');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the initial values
		$data = array(
			array('post_category_post_id'  => 1, 'post_category_category_id' => 1),
			array('post_category_post_id'  => 2, 'post_category_category_id' => 1),
			array('post_category_post_id'  => 3, 'post_category_category_id' => 1),
		);
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);
	}
}