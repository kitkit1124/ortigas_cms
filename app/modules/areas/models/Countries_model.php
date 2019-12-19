<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Countries_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Countries_model extends BF_Model 
{

	protected $table_name			= 'countries';
	protected $key					= 'country_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'country_created_on';
	protected $created_by_field		= 'country_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'country_modified_on';
	protected $modified_by_field	= 'country_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'country_deleted';
	protected $deleted_by_field		= 'country_deleted_by';

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
			'country_id', 
			'country_name',
			'country_code2',
			'country_code3',
			'country_continent',

			'country_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'country_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = country_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = country_modified_by', 'LEFT')
					->datatables($fields);
	}
}