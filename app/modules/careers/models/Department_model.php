<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Department_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Department_model extends BF_Model {

	protected $table_name			= 'career_department';
	protected $key					= 'dept_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'dept_created_on';
	protected $created_by_field		= 'dept_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'dept_modified_on';
	protected $modified_by_field	= 'dept_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'dept_deleted';
	protected $deleted_by_field		= 'dept_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */

	public function get_active_dept(){
		$query = $this->where('dept_deleted', 0)
				->order_by('dept_name', 'ASC')
				->format_dropdown('dept_id', 'dept_name', TRUE);

		return $query;		
	}

}