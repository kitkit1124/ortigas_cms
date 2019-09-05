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
class Migration_Edit_news_tags extends CI_Migration {

	private $_table = 'news_tags';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('news_tags'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Websites module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'news_tag_slug' => array('type' => 'VARCHAR', 'after' => 'news_tag_description', 'constraint' => 255, 'null' => TRUE),
		);	

		$this->dbforge->add_column($this->_table, $fields);
	}

	public function down()
	{
	
	}
}