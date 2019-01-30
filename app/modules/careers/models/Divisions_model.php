<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Divisions_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Divisions_model extends BF_Model {

	protected $table_name			= 'career_divisions';
	protected $key					= 'division_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'division_created_on';
	protected $created_by_field		= 'division_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'division_modified_on';
	protected $modified_by_field	= 'division_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'division_deleted';
	protected $deleted_by_field		= 'division_deleted_by';

	public $metatag_key				= 'division_metatag_id';

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
			'division_id',
			'division_name',
			'department_name',
			'division_status',

			'division_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'division_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)',

			'division_department_id'
		);

		return $this->join('users as creator', 'creator.id = division_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = division_modified_by', 'LEFT')
					->join('career_departments', 'career_departments.department_id = division_department_id', 'LEFT')
					->order_by('department_name','ASC')
					->order_by('division_name','ASC')
					->datatables($fields);
	}

	// public function get_select_divisions($department_id = null){

	// 	if($department_id){

	// 		$this->where('division_department_id', $department_id);
	// 	}

	// 	$query = $this->where('division_status', 'Active')
	// 			->where('division_deleted', 0)
	// 			->order_by('division_name', 'ASC')
	// 			->format_dropdown('division_id', 'division_name', TRUE);

	// 	return $query;		
	// }


	public function get_active_divisions($department_id = null){
	$query = $this->where('division_status', 'Active')
			->where('division_deleted', 0)
			->where('division_department_id', $department_id)
			->order_by('division_name', 'ASC')
			->find_all();

	return $query;		
	}

	public function get_select_divisions(){
		$query = $this->where('division_status', 'Active')
				->where('division_deleted', 0)
				->order_by('division_name', 'ASC')
				->format_dropdown('division_id', 'division_name', TRUE);

		return $query;		
	}

}