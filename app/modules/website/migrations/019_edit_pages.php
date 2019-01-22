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
class Migration_Edit_pages extends CI_Migration 
{
	private $_table = 'pages';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('pages'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Websites module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'page_latitude'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'page_longitude'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'page_map_name'			=> array('type' => 'TEXT', 'null' => TRUE),
		);
		
		$this->dbforge->add_column($this->_table, $fields);
	
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'page_latitude');
		$this->dbforge->drop_column($this->_table, 'page_longitude');
		$this->dbforge->drop_column($this->_table, 'page_map_name');
	}
}