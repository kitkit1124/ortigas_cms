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
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Website Name', 'config_name' => 'website_name', 'config_value' => 'Codifire', 'config_notes' => 'The name of the website'));
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Website Email', 'config_name' => 'website_email', 'config_value' => 'no-reply@codifire.cms', 'config_notes' => 'The email address to use when sending an email'));
		$this->db->insert($this->table, array('config_type'  => 'input', 'config_label'  => 'Website URL', 'config_name' => 'website_url', 'config_value' => site_url(), 'config_notes' => 'The website url with trailing slash (eg. http://www.website.com/).  Change this if CMS and website are in different domain.'));
		$this->db->insert($this->table, array('config_type'  => 'dropdown', 'config_label'  => 'Website Theme', 'config_name' => 'website_theme', 'config_value' => 'default', 'config_notes' => 'The name of the website\'s theme', 'config_values' => 'default'));
	}

	public function down()
	{
		$this->db->delete($this->table, array('config_name' => 'website_name'));
		$this->db->delete($this->table, array('config_name' => 'website_email'));
		$this->db->delete($this->table, array('config_name' => 'website_url'));
		$this->db->delete($this->table, array('config_name' => 'website_theme'));
	}
}