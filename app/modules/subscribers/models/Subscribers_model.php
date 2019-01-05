<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Subscribers_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		OCLP Administrator <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Subscribers_model extends BF_Model {

	protected $table_name			= 'subscribers';
	protected $key					= 'subscriber_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'subscriber_created_on';
	protected $created_by_field		= 'subscriber_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'subscriber_modified_on';
	protected $modified_by_field	= 'subscriber_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'subscriber_deleted';
	protected $deleted_by_field		= 'subscriber_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	OCLP Administrator <webdevs@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'subscriber_id',
			'subscriber_email',
			'subscriber_status',

			'subscriber_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'subscriber_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = subscriber_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = subscriber_modified_by', 'LEFT')
					->datatables($fields);
	}
}