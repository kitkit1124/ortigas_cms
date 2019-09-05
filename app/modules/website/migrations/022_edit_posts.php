<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutz Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Edit_posts extends CI_Migration 
{
	private $_table = 'posts';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('posts'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Websites module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'post_document'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'post_facebook'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'post_twitter'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'post_instagram'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'post_linkedin'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'post_youtube'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
		);
		
		$this->dbforge->add_column($this->_table, $fields);
	
	}

	public function down()
	{
		
	}
}