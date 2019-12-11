<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Reservations_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Reservations_model extends BF_Model {

	protected $table_name			= 'reservations';
	protected $key					= 'reservation_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'reservation_created_on';
	protected $created_by_field		= 'reservation_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'reservation_modified_on';
	protected $modified_by_field	= 'reservation_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'reservation_deleted';
	protected $deleted_by_field		= 'reservation_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'reservation_id',
			'customer_fname',
			'customer_lname',
			'reservation_reference_no',
			'reservation_project',
			'reservation_property_specialist',
			'reservation_sellers_group',
			'reservation_unit_details',
			'reservation_allocation',
			'reservation_fee',
			'reservation_notes',

			'reservation_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'reservation_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		$callback = array(
            array(
                'method'  => array('Callbacks', 'reservation_customers')
            )
        );

		return $this->join('users as creator', 'creator.id = reservation_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = reservation_modified_by', 'LEFT')
					->join('customers','customer_id = reservation_customer_id','LEFT')
					->datatables($fields,$callback);
	}
}