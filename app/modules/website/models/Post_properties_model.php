<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Post_properties_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 20185, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Post_properties_model extends BF_Model 
{

	protected $table_name			= 'post_properties';
	protected $key					= 'post_properties_id';

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
	 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function get_current_properties($id)
	{
		$result = $this
			->join('properties', 'properties.property_id = post_properties_property_id', 'LEFT')
			->where('post_properties_post_id', $id)
			->format_dropdown('property_id', 'property_name');

		return $result;
	}
}