<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Property_types_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Property_types_model extends BF_Model {

	protected $table_name			= 'property_types';
	protected $key					= 'property_type_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'property_type_created_on';
	protected $created_by_field		= 'property_type_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'property_type_modified_on';
	protected $modified_by_field	= 'property_type_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'property_type_deleted';
	protected $deleted_by_field		= 'property_type_deleted_by';

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
			'property_type_id',
			'property_type_name',
			'property_type_status',

			'property_type_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'property_type_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = property_type_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = property_type_modified_by', 'LEFT')
					->datatables($fields);
	}

	public function get_active_property_types(){
		$query = $this->where('property_type_status', 'Active')
				->where('property_type_deleted', 0)
				->format_dropdown('property_type_id', 'property_type_name', TRUE);

		return $query;		
	}
}