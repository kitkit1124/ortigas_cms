<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Units_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Units_model extends BF_Model {

	protected $table_name			= 'units';
	protected $key					= 'unit_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'unit_created_on';
	protected $created_by_field		= 'unit_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'unit_modified_on';
	protected $modified_by_field	= 'unit_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'unit_deleted';
	protected $deleted_by_field		= 'unit_deleted_by';

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
			'unit_id',
			'property_name',
			'floor_level',
			'unit_number',
			'room_type_name',
			'unit_size',
			'unit_price',
			'unit_downpayment',
			'unit_image',
			'unit_status',

			'unit_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'unit_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)',

			'unit_property_id',
			'unit_floor_id',
			'unit_room_type_id'
		);

		return $this->join('users as creator', 'creator.id = unit_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = unit_modified_by', 'LEFT')
					->join('properties', 'properties.property_id = unit_property_id', 'LEFT')
					->join('floors', 'floors.floor_id = unit_floor_id', 'LEFT')
					->join('room_types', 'room_types.room_type_id = unit_room_type_id', 'LEFT')
					->order_by('property_name','ASC')
					->order_by('floor_level','ASC')
					->order_by('unit_number','ASC')
					->datatables($fields);
	}

	public function get_unit($unit_id = 0){
		$query = $this->units_model
				->where('unit_status', 'Active')
				->where('unit_deleted', 0)
				->order_by('unit_id', 'ASC')
				->join('floors','floors.floor_id = unit_floor_id')
				->join('properties', 'properties.property_id = floors.floor_property_id')
				->find($unit_id);

		return $query;		
	}

	public function get_all_unit(){
		$query = $this->units_model
				->select('unit_id as id','property_name as name')
				->where('unit_status', 'Active')
				->where('unit_deleted', 0)
				->join('floors','floors.floor_id = unit_floor_id')
				->join('properties', 'properties.property_id = floors.floor_property_id')
				->order_by('unit_id', 'ASC')
				->find_all();

		return $query;		
	}
}