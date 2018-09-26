<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Add_menus extends CI_Migration 
{
	private $_permissions = array(
		array('Website Link', 'website.website.link'),
		array('Edit Website Settings', 'website.website.settings'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'none', // none if parent or single menu
			'menu_text' 		=> 'Website', 
			'menu_link' 		=> 'website', 
			'menu_perm' 		=> 'website.website.link', 
			'menu_icon' 		=> 'fa fa-globe', 
			'menu_order' 		=> 2, 
			'menu_active' 		=> 1
		),
		array(
			'menu_parent'		=> 'website',
			'menu_text' 		=> 'Settings', 
			'menu_link' 		=> 'website/settings', 
			'menu_perm' 		=> 'website.website.settings', 
			'menu_icon' 		=> 'fa fa-cogs', 
			'menu_order' 		=> 99, 
			'menu_active' 		=> 1
		),
	);

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}