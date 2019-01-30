<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Properties_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Properties_model extends BF_Model {

	protected $table_name			= 'properties';
	protected $key					= 'property_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'property_created_on';
	protected $created_by_field		= 'property_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'property_modified_on';
	protected $modified_by_field	= 'property_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'property_deleted';
	protected $deleted_by_field		= 'property_deleted_by';

	public $metatag_key				= 'property_metatag_id';

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
			'property_id',
			'property_name',
			'estate_name',
			'category_name',
			'location_name',
			'property_slug',
			'property_price_range_id',
			'property_overview',
			'property_image',
			'property_website',
			'property_facebook',
			'property_twitter',
			'property_instagram',
			'property_linkedin',
			'property_youtube',
			'property_latitude',
			'property_longitude',
			'property_nearby_malls',
			'property_nearby_markets',
			'property_nearby_hospitals',
			'property_nearby_schools',
			'property_tags',
			'property_status',


			'property_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'property_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)',


			'property_estate_id',
			'property_category_id',
			'property_location_id'
		);

		return $this->join('users as creator', 'creator.id = property_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = property_modified_by', 'LEFT')
					->join('estates', 'estates.estate_id = property_estate_id', 'LEFT')
					->join('property_categories', 'property_categories.category_id = property_category_id', 'LEFT')
					->join('property_locations', 'property_locations.location_id = property_location_id', 'LEFT')
					->datatables($fields);
	}

	public function get_active_properties(){
		$query = $this
				->where('property_status', 'Active')
				->where('property_deleted', 0)
				->order_by('property_name', 'ASC')
				->format_dropdown('property_id', 'property_name', TRUE);

		return $query;		
	}


	public function get_active_properties_order(){
		$query = $this
				->where('property_status', 'Active')
				->where('property_deleted', 0)
				->where_not_in('property_availability', 'Sold-Out')
				->order_by('property_order', 'ASC')
				->find_all();

		return $query;		
	}
}