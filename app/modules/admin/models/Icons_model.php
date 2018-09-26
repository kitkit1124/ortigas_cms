<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Icons_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <codifire@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Icons_model extends BF_Model {

	protected $table_name			= 'icons';
	protected $key					= 'icon_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'icon_created_on';
	protected $created_by_field		= 'icon_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'icon_modified_on';
	protected $modified_by_field	= 'icon_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'icon_deleted';
	protected $deleted_by_field		= 'icon_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Digify Admin <codifire@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'icon_id', 
			'icon_group',
			'icon_code',
			'icon_status',

			'icon_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'icon_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = icon_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = icon_modified_by', 'LEFT')
					->datatables($fields);
	}
}