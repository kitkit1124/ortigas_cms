<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Add_configs_01 extends CI_Migration {

	private $_table = 'configs';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// prepare default record
		$data = array(
					array(
							"config_type" 		=> "input,checkbox",
							"config_values" 	=> NULL,
							"config_label" 		=> "Share Buttons",
							"config_name" 		=> "share_buttons",
							"config_value" 		=> '[{"id":"facebook","name":"Facebook","icon":"fa fa-facebook","status":1},{"id":"twitter","name":"Twitter","icon":"fa fa-twitter","status":1},{"id":"googleplus","name":"Google+","icon":"fa fa-google-plus","status":1},{"id":"linkedin","name":"LinkedIn","icon":"fa fa-linkedin","status":1},{"id":"pinterest","name":"Pinterest","icon":"fa fa-pinterest","status":1}]',
							"config_notes" 		=> "Social Media Buttons",
							"config_deleted" 	=> "0"
						),

					array(
							"config_type" 		=> "dropdown",
							"config_values" 	=> 'horizontal,vertical',
							"config_label" 		=> "Share Buttons Orientation",
							"config_name" 		=> "share_buttons_orientation",
							"config_value" 		=> "horizontal",
							"config_notes" 		=> "Social Media Buttons Orientation",
							"config_deleted" 	=> "0"
						)
				);

		// insert record
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// prepare condition
		$where = array("config_name" => "share_buttons");
		// delete record
		$this->db->delete($this->_table, $where);

		// prepare condition
		$where = array("config_name" => "share_buttons_orientation");
		// delete record
		$this->db->delete($this->_table, $where);
	}
}