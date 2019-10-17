<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Payments_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Payments_model extends BF_Model {

	protected $table_name			= 'payments';
	protected $key					= 'payment_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'payment_created_on';
	protected $created_by_field		= 'payment_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'payment_modified_on';
	protected $modified_by_field	= 'payment_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'payment_deleted';
	protected $deleted_by_field		= 'payment_deleted_by';

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
			'payment_id',
			'payment_reservation_id',
			'payment_paynamics_no',
			'payment_status',

			'payment_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'payment_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = payment_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = payment_modified_by', 'LEFT')
					->datatables($fields);
	}
}