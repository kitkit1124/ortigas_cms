<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Menus_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Menus_model extends BF_Model 
{
	protected $table_name			= 'menus';
	protected $key					= 'menu_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'menu_created_on';
	protected $created_by_field		= 'menu_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'menu_modified_on';
	protected $modified_by_field	= 'menu_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'menu_deleted';
	protected $deleted_by_field		= 'menu_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access  public
	 * @param   none
	 * @author  Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'menu_id', 
			'menu_text',
			'menu_link',
			'menu_perm',
			'menu_icon',
			'menu_order',
			'menu_active',

			'menu_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'menu_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = menu_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = menu_modified_by', 'LEFT')
					->datatables($fields);
	}
}