<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Related_links_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Related_links_model extends BF_Model {

	protected $table_name			= 'related_links';
	protected $key					= 'related_link_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'related_link_created_on';
	protected $created_by_field		= 'related_link_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'related_link_modified_on';
	protected $modified_by_field	= 'related_link_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'related_link_deleted';
	protected $deleted_by_field		= 'related_link_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function get_datatables($fields_data = null)
	{
		$fields = array(
			'related_link_id',
			'related_link_label',
			'related_link_link',
			'related_link_status',

			'related_link_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'related_link_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		if(isset($fields_data['section_id']) && $fields_data['section_id']){
			$this->where('related_link_section_id', $fields_data['section_id']);
		}

		if(isset($fields_data['section_type']) && $fields_data['section_type']){
			$this->where('related_link_section_type', $fields_data['section_type']);
		}

		return $this->join('users as creator', 'creator.id = related_link_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = related_link_modified_by', 'LEFT')
					->datatables($fields);
	}
}