<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Messages_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Messages_model extends BF_Model {

	protected $table_name			= 'messages';
	protected $key					= 'message_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'message_created_on';
	protected $created_by_field		= 'message_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'message_modified_on';
	protected $modified_by_field	= 'message_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'message_deleted';
	protected $deleted_by_field		= 'message_deleted_by';

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
			'message_id',
			'message_email',
			'message_section',
			'property_name',
			'message_name',
			'message_content',
			'message_status',

			'message_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'message_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = message_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = message_modified_by', 'LEFT')
					->join('properties', 'properties.property_id = message_section_id', 'LEFT')
					->datatables($fields);
	}

	public function get_mails()
	{
		

		return $this
				->join('properties', 'properties.property_id = message_section_id', 'LEFT')
				->find();

	}
}