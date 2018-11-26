<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Seo_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Seo_model extends BF_Model {

	protected $table_name			= 'seo';
	protected $key					= 'seo_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'seo_created_on';
	protected $created_by_field		= 'seo_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'seo_modified_on';
	protected $modified_by_field	= 'seo_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'seo_deleted';
	protected $deleted_by_field		= 'seo_deleted_by';

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
			'seo_id',
			'seo_title',
			'seo_content',
			'seo_status',

			'seo_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'seo_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = seo_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = seo_modified_by', 'LEFT')
					->datatables($fields);
	}
}