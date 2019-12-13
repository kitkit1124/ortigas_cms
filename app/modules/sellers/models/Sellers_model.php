<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Sellers_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Sellers_model extends BF_Model {

	protected $table_name			= 'sellers';
	protected $key					= 'seller_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'seller_created_on';
	protected $created_by_field		= 'seller_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'seller_modified_on';
	protected $modified_by_field	= 'seller_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'seller_deleted';
	protected $deleted_by_field		= 'seller_deleted_by';

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
			'seller_id',
			'seller_first_name',
			'seller_middle_name',
			'seller_last_name',
			'seller_email',
			'seller_mobile',
			'seller_address',
			'seller_group_id',
			'seller_status',

			'seller_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'seller_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = seller_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = seller_modified_by', 'LEFT')
					->datatables($fields);
	}
}