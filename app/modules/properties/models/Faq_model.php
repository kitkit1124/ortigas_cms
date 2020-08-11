<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Faq_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Faq_model extends BF_Model {

	protected $table_name			= 'property_faq';
	protected $key					= 'faq_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'faq_created_on';
	protected $created_by_field		= 'faq_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'faq_modified_on';
	protected $modified_by_field	= 'faq_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'faq_deleted';
	protected $deleted_by_field		= 'faq_deleted_by';

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
			'faq_property_id',
			'faq_topic',
			'faq_answer',
			'faq_status',
			'faq_order',
			
			'faq_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'faq_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		if(isset($fields_data['property_id']) && $fields_data['property_id']){
			$this->where('faq_property_id', $fields_data['property_id']);
		}

		return $this->join('users as creator', 'creator.id = faq_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = faq_modified_by', 'LEFT')
					->datatables($fields);
	}
}