<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Property_pages_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutz Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2020, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Property_pages_model extends BF_Model {

	protected $table_name			= 'property_pages';
	protected $key					= 'page_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'page_created_on';
	protected $created_by_field		= 'page_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'page_modified_on';
	protected $modified_by_field	= 'page_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'page_deleted';
	protected $deleted_by_field		= 'page_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutz Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'page_id',
			'page_title',
			'page_status',

			'page_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'page_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = page_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = page_modified_by', 'LEFT')
					->datatables($fields);
	}

	public function get_active_property_pages(){
		$query = $this->where('page_status', 'Active')
				->where('page_deleted', 0)
				->format_dropdown('page_id', 'page_title', TRUE);

		return $query;		
	}
}