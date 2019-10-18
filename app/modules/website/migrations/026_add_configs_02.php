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
class Migration_Add_configs_02 extends CI_Migration
{

	var $table = 'configs';

	function __construct()
	{
		parent::__construct();
	}
	
	public function up()
	{
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Assets URL', 'config_name' => 'assets_url', 'config_value' => 'http://cms.assets.local/', 'config_notes' => 'Assets Url'));
	
	}

	public function down()
	{
		$this->db->delete($this->table, array('config_name' => 'image_size_large'));
		
	}
}