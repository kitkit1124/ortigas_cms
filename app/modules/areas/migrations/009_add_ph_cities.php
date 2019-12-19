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
class Migration_Add_ph_cities extends CI_Migration 
{
	private $_table = 'cities';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// add the initial values
		$file = fopen(APPPATH . "modules/areas/models/ph_cities.csv","r");

		$data = array();
		while(! feof($file))
		{
			
			$city = fgetcsv($file);
			if ($city)
			{
				$city = array_map("utf8_encode", $city); // handles the encoding
				$data[] = array(
					'city_name' 		=> $city[0],
					'city_type' 		=> $city[1],
					'city_province' 	=> $city[2], 
					'city_country' 		=> $city[3],
				);
			}
		}
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{

	}
}