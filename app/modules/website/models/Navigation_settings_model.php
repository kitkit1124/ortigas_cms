<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Navigation_settings_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Navigation_settings_model extends BF_Model {

	protected $table_name			= 'navigation_settings';
	protected $key					= 'nav_setting_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'nav_setting_created_on';
	protected $created_by_field		= 'nav_setting_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'nav_setting_modified_on';
	protected $modified_by_field	= 'nav_setting_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'nav_setting_deleted';
	protected $deleted_by_field		= 'nav_setting_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'nav_setting_id',
			'nav_setting_color_theme',

			'nav_setting_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'nav_setting_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = nav_setting_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = nav_setting_modified_by', 'LEFT')
					->datatables($fields);
	}
}