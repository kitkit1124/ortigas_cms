<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Locations_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Locations_model extends BF_Model {

	protected $table_name			= 'property_locations';
	protected $key					= 'location_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'location_created_on';
	protected $created_by_field		= 'location_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'location_modified_on';
	protected $modified_by_field	= 'location_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'location_deleted';
	protected $deleted_by_field		= 'location_deleted_by';

	public $metatag_key				= 'location_metatag_id';

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
			'location_id',
			'location_name',
			'location_status',

			'location_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'location_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = location_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = location_modified_by', 'LEFT')
					->datatables($fields);
	}

	public function get_active_locations(){
		$query = $this->locations_model
				->where('location_status', 'Active')
				->where('location_deleted', 0)
				->order_by('location_name', 'ASC')
				->format_dropdown('location_id', 'location_name', TRUE);

		return $query;		
	}
}