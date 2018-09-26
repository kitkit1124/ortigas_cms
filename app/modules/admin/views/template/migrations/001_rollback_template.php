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
class Migration_Rollback_{{lc_plural_module_name}} extends CI_Migration {

	function __construct()
	{
		parent::__construct();
	}
	
	public function up()
	{

	}

	public function down()
	{
		
	}
}