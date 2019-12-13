<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Seller_groups_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Seller_groups_model extends BF_Model {

	protected $table_name			= 'seller_groups';
	protected $key					= 'seller_group_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'seller_group_created_on';
	protected $created_by_field		= 'seller_group_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'seller_group_modified_on';
	protected $modified_by_field	= 'seller_group_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'seller_group_deleted';
	protected $deleted_by_field		= 'seller_group_deleted_by';

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
			'seller_group_id',
			'seller_group_name',
			'seller_group_status',

			'seller_group_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'seller_group_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = seller_group_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = seller_group_modified_by', 'LEFT')
					->datatables($fields);
	}
}