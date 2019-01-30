<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Categories_model extends BF_Model {

	protected $table_name			= 'property_categories';
	protected $key					= 'category_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'category_created_on';
	protected $created_by_field		= 'category_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'category_modified_on';
	protected $modified_by_field	= 'category_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'category_deleted';
	protected $deleted_by_field		= 'category_deleted_by';

	public $metatag_key				= 'category_metatag_id';

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
			'category_id',
			'category_name',
			'category_image',
			'category_status',

			'category_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'category_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = category_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = category_modified_by', 'LEFT')
					->datatables($fields);
	}

	public function get_active_categories(){
		$query = $this
				->where('category_status', 'Active')
				->where('category_deleted', 0)
				->order_by('category_id', 'asc')
				->format_dropdown('category_id', 'category_name', TRUE);

		return $query;		
	}

	public function get_active_categories_order(){
		$query = $this
				->where('category_status', 'Active')
				->where('category_deleted', 0)
				->order_by('category_order', 'asc')
				->find_all();

		return $query;		
	}
}