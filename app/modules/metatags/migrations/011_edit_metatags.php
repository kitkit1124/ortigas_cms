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
class Migration_Edit_metatags extends CI_Migration 
{
	private $_table = 'metatags';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('metatags'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Metatags module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'metatag_robots' 	=> array('type' => 'VARCHAR', 'after' => 'metatag_description', 'constraint' => 255, 'null' => FALSE),
			'metatag_code'		=> array('type' => 'TEXT', 'after' => 'metatag_robots', 'null' => FALSE),
		);
		
		$this->dbforge->add_column($this->_table, $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'metatag_robots');
		$this->dbforge->drop_column($this->_table, 'metatag_code');
	}
}