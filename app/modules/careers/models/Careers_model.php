<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Careers_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Careers_model extends BF_Model {

	protected $table_name			= 'careers';
	protected $key					= 'career_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'career_created_on';
	protected $created_by_field		= 'career_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'career_modified_on';
	protected $modified_by_field	= 'career_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'career_deleted';
	protected $deleted_by_field		= 'career_deleted_by';

	public $metatag_key				= 'career_metatag_id';

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
			'career_id',
			'career_position_title',
			'department_name',
			'career_req',
			'career_res',
			'career_location',
			'career_latitude',
			'career_longitude',
			'career_status',

			'career_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'career_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = career_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = career_modified_by', 'LEFT')
					->join('career_departments', 'career_departments.department_id = career_dept', 'LEFT')
					->join('career_divisions', 'career_divisions.division_id = career_div', 'LEFT')
					->datatables($fields);
	}

	public function get_select_careers(){
	$query = $this->where('career_status', 'Active')
			->where('career_deleted', 0)
			->order_by('career_position_title', 'ASC')
			->format_dropdown('career_id', 'career_position_title', TRUE);

	return $query;		
	}
}