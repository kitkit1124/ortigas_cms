<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cities_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Cities_model extends BF_Model 
{

	protected $table_name			= 'cities';
	protected $key					= 'city_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'city_created_on';
	protected $created_by_field		= 'city_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'city_modified_on';
	protected $modified_by_field	= 'city_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'city_deleted';
	protected $deleted_by_field		= 'city_deleted_by';

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
			'city_id', 
			'city_name',
			'city_type',
			'province_name',
			'country_name',

			'city_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'city_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = city_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = city_modified_by', 'LEFT')
					->join('provinces', 'province_code = city_province', 'LEFT')
					->join('countries', 'country_code2 = city_country', 'LEFT')
					->datatables($fields);
	}
}