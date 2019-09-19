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
class Migration_Edit_estates_03 extends CI_Migration 
{
	private $_table = 'estates';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('estates'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Properties module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'estate_location_id' => array('type' => 'TINYINT', 'after' => 'estate_id', 'constraint' => 3),
		);
		
		$this->dbforge->add_column($this->_table, $fields);
	}

	public function down()
	{
	}
}