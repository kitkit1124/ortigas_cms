<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Departments_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Departments_model extends BF_Model {

	protected $table_name			= 'career_departments';
	protected $key					= 'department_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'department_created_on';
	protected $created_by_field		= 'department_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'department_modified_on';
	protected $modified_by_field	= 'department_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'department_deleted';
	protected $deleted_by_field		= 'department_deleted_by';

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
			'department_id',
			'department_name',
			'division_name',
			'department_status',

			'department_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'department_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = department_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = department_modified_by', 'LEFT')
					->join('career_divisions', 'career_divisions.division_id = department_division_id', 'LEFT')
					->datatables($fields);
	}

	public function get_active_departments(){
		$query = $this->where('department_status', 'Active')
				->where('department_deleted', 0)
				->order_by('department_name', 'ASC')
				->format_dropdown('department_id', 'department_name', TRUE);

		return $query;		
	}


	public function get_active_divisions_form($division_id = null){
	$query = $this->where('department_status', 'Active')
			->where('department_deleted', 0)
			->where('department_division_id', $division_id)
			->order_by('department_name', 'ASC')
			->find_all();

	return $query;		
	}


	public function get_active_departments_ajax($division_id = null){
	$query = $this->where('department_status', 'Active')
			->where('department_deleted', 0)
			->where('department_division_id', $division_id)
			->order_by('department_name', 'ASC')
			->find_all();

	return $query;		
	}

	public function get_departments($division_id = null){

		if($division_id){
			$this->where('department_division_id', $division_id);
		}

		$query = $this->where('department_status', 'Active')
				->where('department_deleted', 0)
				->order_by('department_name', 'ASC')
				->format_dropdown('department_id', 'department_name', TRUE);

		return $query;		
	}
}