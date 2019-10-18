<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Customers_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Customers_model extends BF_Model {

	protected $table_name			= 'customers';
	protected $key					= 'customer_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'customer_created_on';
	protected $created_by_field		= 'customer_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'customer_modified_on';
	protected $modified_by_field	= 'customer_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'customer_deleted';
	protected $deleted_by_field		= 'customer_deleted_by';

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
			'customer_id',
			'customer_fname',
			'customer_lname',
			'customer_telno',
			'customer_mobileno',
			'customer_email',
			'customer_id_type',
			'customer_id_details',
			'customer_mailing_country',
			'customer_mailing_house_no',
			'customer_mailing_street',
			'customer_mailing_city',
			'customer_mailing_brgy',
			'customer_mailing_zip_code',
			'customer_billing_country',
			'customer_billing_house_no',
			'customer_billing_street',
			'customer_billing_city',
			'customer_billing_brgy',
			'customer_billing_zip_code',

			'customer_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'customer_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		$callback = array(
            array(
                'method'  => array('Callbacks', 'customers')
            )
        );

		return $this->join('users as creator', 'creator.id = customer_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = customer_modified_by', 'LEFT')
					->datatables($fields,$callback);
	}
}