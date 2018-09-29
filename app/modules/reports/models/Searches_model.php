<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Searches_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Searches_model extends BF_Model {

	protected $table_name			= 'property_searches';
	protected $key					= 'search_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'search_created_on';
	protected $created_by_field		= 'search_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'search_modified_on';
	protected $modified_by_field	= 'search_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'search_deleted';
	protected $deleted_by_field		= 'search_deleted_by';

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
			'search_id',
			'search_keyword',
			'search_cat_id',
			'search_price_id',
			'search_loc_id',

			'search_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'search_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = search_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = search_modified_by', 'LEFT')
					->datatables($fields);
	}

	public function get_search_result($field = null){
		$query = $this->select("count(*) as 'numrows', category_name, location_name, price_range_label, ".$field)
		->group_by($field)
		->join('property_locations', 'property_locations.location_id = search_loc_id', 'LEFT')
		->join('property_categories', 'property_categories.category_id = search_cat_id', 'LEFT')
		->join('price_range', 'price_range.price_range_id = search_price_id', 'LEFT')
		->find_all();

		return $query;
	}
}