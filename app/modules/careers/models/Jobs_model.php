<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Jobs_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Jobs_model extends BF_Model {

	protected $table_name			= 'career_applicants';
	protected $key					= 'job_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'job_created_on';
	protected $created_by_field		= 'job_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'job_modified_on';
	protected $modified_by_field	= 'job_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'job_deleted';
	protected $deleted_by_field		= 'job_deleted_by';

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
			'job_id',
			'career_position_title',
			'job_applicant_name',
			'job_email',
			'job_mobile',
			'job_document',
			'job_pitch',
			'job_referred',

			'job_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'job_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)',

			'job_career_id'
		);

		return $this->join('users as creator', 'creator.id = job_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = job_modified_by', 'LEFT')
					->join('careers', 'careers.career_id = job_career_id', 'LEFT')
					->datatables($fields);
	}
}