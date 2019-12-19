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
class Migration_Add_ph_provinces extends CI_Migration 
{
	private $_table = 'provinces';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// add the initial values
		$file = fopen(APPPATH . "modules/areas/models/ph_provinces.csv","r");

		$data = array();
		while(! feof($file))
		{
			
			$province = fgetcsv($file);
			if ($province)
			{
				$province = array_map("utf8_encode", $province); // handles the encoding
				$data[] = array(
					'province_code' 		=> $province[0],
					'province_name' 		=> $province[1],
					'province_region' 		=> $province[2], 
					'province_country' 		=> $province[3],
				);
			}
		}
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{

	}
}