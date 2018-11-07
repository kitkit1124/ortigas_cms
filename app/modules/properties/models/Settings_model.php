<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Settings_model extends BF_Model {

	protected $table_name			= 'property_settings';
	protected $key					= 'setting_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'setting_created_on';
	protected $created_by_field		= 'setting_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'setting_modified_on';
	protected $modified_by_field	= 'setting_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'setting_deleted';
	protected $deleted_by_field		= 'setting_deleted_by';

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
			'setting_id',
			'setting_division',
			'setting_order',

			'setting_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'setting_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = setting_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = setting_modified_by', 'LEFT')
					->datatables($fields);
	}
}