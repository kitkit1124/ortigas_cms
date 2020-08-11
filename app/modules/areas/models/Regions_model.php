<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Regions_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Regions_model extends BF_Model 
{

	protected $table_name			= 'regions';
	protected $key					= 'region_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'region_created_on';
	protected $created_by_field		= 'region_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'region_modified_on';
	protected $modified_by_field	= 'region_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'region_deleted';
	protected $deleted_by_field		= 'region_deleted_by';

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
			'region_id',
			'region_name',
			'region_code',
			'region_short_name',
			'region_group',
			'country_name',

			'region_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'region_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = region_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = region_modified_by', 'LEFT')
					->join('countries', 'country_code2 = region_country', 'LEFT')
					->datatables($fields);
	}
}