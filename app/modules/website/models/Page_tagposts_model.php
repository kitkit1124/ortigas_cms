<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Page_tagposts_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 20185, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Page_tagposts_model extends BF_Model 
{

	protected $table_name			= 'page_tagposts';
	protected $key					= 'page_tagposts_id';

	protected $log_user				= FALSE;
	protected $set_created			= FALSE;
	protected $set_modified			= FALSE;
	protected $soft_deletes			= FALSE;

	// --------------------------------------------------------------------

	/**
	 * 
	 *
	 * @access	public
	 * @param	none
	 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	
	// public function get_tagged_posts($id)
	// {
	// 	$result = $this
	// 		->join('posts', 'properties.property_id = post_properties_property_id', 'LEFT')
	// 		->where('post_properties_post_id', $id)
	// 		->format_dropdown('property_id', 'property_name');

	// 	return $result;
	// }

/*
	->where('post_status', 'Posted')
	->where('post_deleted', 0)
		->order_by('post_title', 'ASC')
			->join('pages', 'pages.page_id = page_tagpost_page_id', 'LEFT')
	*/
	public function get_current_posts($id){
		
		$query = $this
				->join('posts', 'posts.post_id = page_tagposts_post_id', 'LEFT')
				->where('page_tagposts_page_id', $id)
				->format_dropdown('post_id', 'post_title', TRUE);

		return $query;		
	}


}