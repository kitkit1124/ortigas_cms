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
class Migration_Edit_divisions extends CI_Migration 
{
	private $_table = 'career_divisions';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('careers'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Careers module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'division_slug'		 => array('type' => 'VARCHAR', 'after' => 'division_name', 'constraint' => 255, 'null' => TRUE),
			'division_content'	 => array('type' => 'TEXT', 'after' => 'division_slug', 'null' => FALSE),
			'division_seo_content' => array('type' => 'TEXT', 'after' => 'division_content', 'null' => FALSE),
			'division_image'	 => array('type' => 'VARCHAR', 'after' => 'division_seo_content', 'constraint' => 255, 'null' => TRUE),
			'division_alt_image' => array('type' => 'VARCHAR', 'after' => 'division_image', 'constraint' => 255, 'null' => TRUE),
		);	

		$this->dbforge->add_column($this->_table, $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'division_slug');
		$this->dbforge->drop_column($this->_table, 'division_content');
		$this->dbforge->drop_column($this->_table, 'division_seo_content');
		$this->dbforge->drop_column($this->_table, 'division_image');
		$this->dbforge->drop_column($this->_table, 'division_alt_image');
	}
}