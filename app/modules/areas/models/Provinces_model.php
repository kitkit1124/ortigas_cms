<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Provinces_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Provinces_model extends BF_Model 
{

	protected $table_name			= 'provinces';
	protected $key					= 'province_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'province_created_on';
	protected $created_by_field		= 'province_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'province_modified_on';
	protected $modified_by_field	= 'province_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'province_deleted';
	protected $deleted_by_field		= 'province_deleted_by';

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
			'province_id', 
			'province_name',
			'province_code',
			'region_name',
			'country_name',

			'province_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'province_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = province_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = province_modified_by', 'LEFT')
					->join('regions', 'region_code = province_region', 'LEFT')
					->join('countries', 'country_code2 = province_country', 'LEFT')
					->datatables($fields);
	}
}