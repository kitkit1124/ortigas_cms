<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 20185, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_page_tagposts extends CI_Migration 
{
	private $_table = 'page_tagposts';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'page_tagposts_id' 					=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'page_tagposts_page_id' 			=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => FALSE),
			'page_tagposts_post_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('page_tagposts_id', TRUE);
		$this->dbforge->add_key('page_tagposts_page_id');
		$this->dbforge->add_key('page_tagposts_post_id');
		$this->dbforge->create_table($this->_table, TRUE);

	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);
	}
}