<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Partials_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Partials_model extends BF_Model 
{

	protected $table_name			= 'partials';
	protected $key					= 'partial_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'partial_created_on';
	protected $created_by_field		= 'partial_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'partial_modified_on';
	protected $modified_by_field	= 'partial_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'partial_deleted';
	protected $deleted_by_field		= 'partial_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'partial_id', 
			'partial_title',
			'partial_status',

			'partial_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'partial_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = partial_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = partial_modified_by', 'LEFT')
					->datatables($fields);
	}
}