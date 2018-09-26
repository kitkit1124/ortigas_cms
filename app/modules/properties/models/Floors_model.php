<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Floors_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Floors_model extends BF_Model {

	protected $table_name			= 'floors';
	protected $key					= 'floor_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'floor_created_on';
	protected $created_by_field		= 'floor_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'floor_modified_on';
	protected $modified_by_field	= 'floor_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'floor_deleted';
	protected $deleted_by_field		= 'floor_deleted_by';

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
			'floor_id',
			'property_name',
			'floor_level',
			'floor_image',
			'floor_status',

			'floor_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'floor_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)',

			'floor_property_id'


		);

		return $this->join('users as creator', 'creator.id = floor_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = floor_modified_by', 'LEFT')
					->join('properties', 'properties.property_id = floor_property_id', 'LEFT')
					->order_by('property_name','ASC')
					->order_by('floor_level','ASC')
					->datatables($fields);
	}

	public function get_active_floors($property_id = null){
		$query = $this->floors_model
				->select('floors.*, property_name')
				->where('floor_status', 'Active')
				->where('floor_deleted', 0)
				->where('floor_property_id', $property_id)
				->order_by('property_name', 'ASC')
				->order_by('floor_level','ASC')
				->join('properties', 'properties.property_id = floor_property_id', 'LEFT')
				->find_all();

		return $query;		
	}
}