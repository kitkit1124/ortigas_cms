<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Banners_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Banners_model extends BF_Model {

	protected $table_name			= 'banners';
	protected $key					= 'banner_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'banner_created_on';
	protected $created_by_field		= 'banner_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'banner_modified_on';
	protected $modified_by_field	= 'banner_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'banner_deleted';
	protected $deleted_by_field		= 'banner_deleted_by';

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
			'banner_id',
			'banner_banner_group_id',
			'banner_thumb',
			'banner_image',
			'banner_caption',
			'banner_link',
			'banner_target',
			'banner_order',
			'banner_status',

			'banner_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'banner_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = banner_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = banner_modified_by', 'LEFT')
					->datatables($fields);
	}
}