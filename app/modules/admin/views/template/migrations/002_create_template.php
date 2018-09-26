<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		{{package_name}}
 * @version		{{module_version}}
 * @author 		{{author_name}} <{{author_email}}>
 * @copyright 	Copyright (c) {{copyright_year}}, {{copyright_name}}
 * @link		{{copyright_link}}
 */
class Migration_Create_{{lc_plural_module_name}} extends CI_Migration {

	private $_table = '{{lc_plural_module_name}}';

	private $_permissions = array(
		array('{{ucf_plural_module_name_text}} Link', '{{parent_module}}.{{lc_plural_module_name}}.link'),
		array('{{ucf_plural_module_name_text}} List', '{{parent_module}}.{{lc_plural_module_name}}.list'),
		array('View {{ucf_singular_module_name_text}}', '{{parent_module}}.{{lc_plural_module_name}}.view'),
		array('Add {{ucf_singular_module_name_text}}', '{{parent_module}}.{{lc_plural_module_name}}.add'),
		array('Edit {{ucf_singular_module_name_text}}', '{{parent_module}}.{{lc_plural_module_name}}.edit'),
		array('Delete {{ucf_singular_module_name_text}}', '{{parent_module}}.{{lc_plural_module_name}}.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> '{{parent_module}}',
			'menu_text' 		=> '{{ucf_plural_module_name_text}}',    
			'menu_link' 		=> '{{parent_module}}/{{lc_plural_module_name}}', 
			'menu_perm' 		=> '{{parent_module}}.{{lc_plural_module_name}}.link', 
			'menu_icon' 		=> 'fa {{module_icon}}', 
			'menu_order' 		=> {{module_order}}, 
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
		// create the table
		{{migration_table}}

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		{{drop_table}}

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}