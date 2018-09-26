<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Social_plugins_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Social_plugins_model extends BF_Model {

	protected $table_name			= 'social_plugins';
	protected $key					= 'social_plugin_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'social_plugin_created_on';
	protected $created_by_field		= 'social_plugin_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'social_plugin_modified_on';
	protected $modified_by_field	= 'social_plugin_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'social_plugin_deleted';
	protected $deleted_by_field		= 'social_plugin_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function get_datatables($start_date, $end_date)
	{
		$fields = array(
			'social_plugin_url',
			'SUM(social_plugin_count) AS social_plugin_count',
		);

		return $this->join('users as creator', 'creator.id = social_plugin_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = social_plugin_modified_by', 'LEFT')
					->where('social_plugin_date BETWEEN "' . $start_date . '" AND "' . $end_date . '"')
					->order_by('social_plugin_count', 'DESC')
					->group_by('social_plugin_url')
					->datatables($fields);
	}
}