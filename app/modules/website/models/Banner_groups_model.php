<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Banner_groups_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Banner_groups_model extends BF_Model {

	protected $table_name			= 'banner_groups';
	protected $key					= 'banner_group_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'banner_group_created_on';
	protected $created_by_field		= 'banner_group_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'banner_group_modified_on';
	protected $modified_by_field	= 'banner_group_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'banner_group_deleted';
	protected $deleted_by_field		= 'banner_group_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'banner_group_id',
			'banner_group_name',

			'banner_group_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'banner_group_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = banner_group_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = banner_group_modified_by', 'LEFT')
					->datatables($fields);
	}
}