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
class Migration_Add_ph_regions extends CI_Migration 
{
	private $_table = 'regions';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// add the initial values
		$file = fopen(APPPATH . "modules/areas/models/ph_regions.csv","r");

		$data = array();
		while(! feof($file))
		{
			
			$region = fgetcsv($file);
			if ($region)
			{
				$region = array_map("utf8_encode", $region); // handles the encoding
				$data[] = array(
					'region_code' 		=> $region[0],
					'region_name' 		=> $region[1],
					'region_short_name' => $region[2], 
					'region_group' 		=> $region[3],
					'region_country' 	=> $region[4],
				);
			}
		}
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{

	}
}