<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * Configs_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

class Configs_model extends BF_Model 
{
	protected $table_name			= 'configs';
	protected $key					= 'config_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'config_created_on';
	protected $created_by_field		= 'config_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'config_modified_on';
	protected $modified_by_field	= 'config_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'config_deleted';
	protected $deleted_by_field		= 'config_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access  public
	 * @param   none
	 * @author  Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'config_id', 
			'config_label',
			'config_value',
			'config_notes',

			'config_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as modifier', 'modifier.id = config_modified_by', 'LEFT')
					->datatables($fields);
	}
}
