<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Continents_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Continents_model extends BF_Model 
{

	protected $table_name			= 'continents';
	protected $key					= 'continent_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'continent_created_on';
	protected $created_by_field		= 'continent_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'continent_modified_on';
	protected $modified_by_field	= 'continent_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'continent_deleted';
	protected $deleted_by_field		= 'continent_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@gmanmi.com>
	 */
	public function get_datatables()
	{
		$fields = array(
			'continent_id', 
			'continent_name',

			'continent_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'continent_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = continent_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = continent_modified_by', 'LEFT')
					->datatables($fields);
	}
}