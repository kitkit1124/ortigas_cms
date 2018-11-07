<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Amenities_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Amenities_model extends BF_Model {

	protected $table_name			= 'property_amenities';
	protected $key					= 'amenity_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'amenity_created_on';
	protected $created_by_field		= 'amenity_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'amenity_modified_on';
	protected $modified_by_field	= 'amenity_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'amenity_deleted';
	protected $deleted_by_field		= 'amenity_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function get_datatables($fields_data = null)
	{
		$fields = array(
			'amenity_id',
			'amenity_name',
			'amenity_status',

			'amenity_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'amenity_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		if(isset($fields_data['property_id']) && $fields_data['property_id']){
			$this->where('amenity_property_id', $fields_data['property_id']);
		}

		return $this->join('users as creator', 'creator.id = amenity_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = amenity_modified_by', 'LEFT')
					->datatables($fields);
	}
}