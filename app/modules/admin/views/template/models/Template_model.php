<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * {{ucf_plural_module_name}}_model Class
 *
 * @package		{{package_name}}
 * @version		{{module_version}}
 * @author 		{{author_name}} <{{author_email}}>
 * @copyright 	Copyright (c) {{copyright_year}}, {{copyright_name}}
 * @link		{{copyright_link}}
 */
class {{ucf_plural_module_name}}_model extends BF_Model {

	protected $table_name			= '{{lc_plural_module_name}}';
	protected $key					= '{{lc_singular_module_name}}_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= '{{lc_singular_module_name}}_created_on';
	protected $created_by_field		= '{{lc_singular_module_name}}_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= '{{lc_singular_module_name}}_modified_on';
	protected $modified_by_field	= '{{lc_singular_module_name}}_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= '{{lc_singular_module_name}}_deleted';
	protected $deleted_by_field		= '{{lc_singular_module_name}}_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	{{author_name}} <{{author_email}}>
	 */
	public function get_datatables()
	{
		$fields = array(
{{model_table_fields}}
			'{{lc_singular_module_name}}_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'{{lc_singular_module_name}}_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = {{lc_singular_module_name}}_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = {{lc_singular_module_name}}_modified_by', 'LEFT')
					->datatables($fields);
	}
}