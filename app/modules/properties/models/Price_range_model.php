<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Price_range_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Price_range_model extends BF_Model {

	protected $table_name			= 'price_range';
	protected $key					= 'price_range_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'price_range_created_on';
	protected $created_by_field		= 'price_range_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'price_range_modified_on';
	protected $modified_by_field	= 'price_range_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'price_range_deleted';
	protected $deleted_by_field		= 'price_range_deleted_by';

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
			'price_range_id',
			'price_range_label',
			'price_range_min',
			'price_range_max',
			'price_range_status',

			'price_range_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'price_range_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = price_range_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = price_range_modified_by', 'LEFT')
					->datatables($fields);
	}

	public function get_active_price_range(){
		$query = $this->where('price_range_status', 'Active')
				->where('price_range_deleted', 0)
				->order_by('price_range_label', 'ASC')
				->format_dropdown('price_range_id', 'price_range_label', TRUE);

		return $query;		
	}
}