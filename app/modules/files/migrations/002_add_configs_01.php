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
class Migration_Add_configs_01 extends CI_Migration
{

	var $table = 'configs';

	function __construct()
	{
		parent::__construct();
	}
	
	public function up()
	{
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Image Size (Large)', 'config_name' => 'image_size_large', 'config_value' => '1600x1200', 'config_notes' => 'The size of the image when resized to large'));
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Image Size (Medium)', 'config_name' => 'image_size_medium', 'config_value' => '800x600', 'config_notes' => 'The size of the image when resized to medium'));
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Image Size (Small)', 'config_name' => 'image_size_small', 'config_value' => '400x300', 'config_notes' => 'The size of the image when resized to small'));
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Image Size (Thumb)', 'config_name' => 'image_size_thumb', 'config_value' => '200x150', 'config_notes' => 'The size of the image when resized to thumbnail'));
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Youtube API Key', 'config_name' => 'youtube_api_key', 'config_value' => 'AIzaSyDbEXfnIyT-OWpQ7luEuStNcgu0935_5x4', 'config_notes' => 'Youtube API key'));
	}

	public function down()
	{
		$this->db->delete($this->table, array('config_name' => 'image_size_large'));
		$this->db->delete($this->table, array('config_name' => 'image_size_medium'));
		$this->db->delete($this->table, array('config_name' => 'image_size_small'));
		$this->db->delete($this->table, array('config_name' => 'image_size_thumb'));
		$this->db->delete($this->table, array('config_name' => 'youtube_api_key'));
	}
}