<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Images_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Images_model extends BF_Model 
{

	protected $table_name			= 'images';
	protected $key					= 'image_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'image_created_on';
	protected $created_by_field		= 'image_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'image_modified_on';
	protected $modified_by_field	= 'image_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'image_deleted';
	protected $deleted_by_field		= 'image_deleted_by';

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
			'image_id',
			'image_width',
			'image_height',
			'image_name',
			'image_file',
			'image_thumb',
			'image_large',
			'image_medium',
			'image_small',

			'image_created_on',
			'concat(creator.first_name, " ", creator.last_name)',
			
		);

		return $this->join('users as creator', 'creator.id = image_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = image_modified_by', 'LEFT')
					->datatables($fields);
	}
}