<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Post_categories_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Post_categories_model extends BF_Model 
{

	protected $table_name			= 'post_categories';
	protected $key					= 'post_category_category_id';

	protected $log_user				= FALSE;
	protected $set_created			= FALSE;
	protected $set_modified			= FALSE;
	protected $soft_deletes			= FALSE;

	// --------------------------------------------------------------------

	/**
	 * get_current_categories
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_current_categories($id)
	{
		$result = $this
			->join('categories', 'category_id = post_category_category_id', 'LEFT')
			->where('post_category_post_id', $id)
			->format_dropdown('category_id', 'category_name');

		return $result;
	}
}