<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Room_types_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Room_types_model extends BF_Model {

	protected $table_name			= 'room_types';
	protected $key					= 'room_type_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'room_type_created_on';
	protected $created_by_field		= 'room_type_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'room_type_modified_on';
	protected $modified_by_field	= 'room_type_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'room_type_deleted';
	protected $deleted_by_field		= 'room_type_deleted_by';

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
			'room_type_id',
			'property_name',
			'room_type_name',
			'room_type_image',
			'room_type_status',

			'room_type_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'room_type_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)',

			'room_type_property_id'
		);

		return $this->join('users as creator', 'creator.id = room_type_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = room_type_modified_by', 'LEFT')
					->join('properties', 'properties.property_id = room_type_property_id', 'LEFT')
					->order_by('property_name','ASC')
					->order_by('room_type_name','ASC')
					->datatables($fields);
	}

	public function get_active_room_types($property_id = null){
		$query = $this->room_types_model
				->select('room_types.*, property_name')
				->where('room_type_status', 'Active')
				->where('room_type_deleted', 0)
				->where('room_type_property_id', $property_id)
				->order_by('property_name', 'ASC')
				->order_by('room_type_name','ASC')
				->join('properties', 'properties.property_id = room_type_id', 'LEFT')
				->find_all();

		return $query;		
	}
}