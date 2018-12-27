<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Posts_model extends BF_Model 
{

	protected $table_name			= 'posts';
	protected $key					= 'post_id';

	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'post_created_on';
	protected $created_by_field		= 'post_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'post_modified_on';
	protected $modified_by_field	= 'post_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'post_deleted';
	protected $deleted_by_field		= 'post_deleted_by';

	public $metatag_key				= 'post_metatag_id';

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
			'post_id', 
			'post_title',
			'post_slug',
			'post_posted_on',
			'post_status',

			'post_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'post_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = post_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = post_modified_by', 'LEFT')
					->order_by('post_posted_on','desc')
					->datatables($fields);
	}

	public function get_posts($fields){
		if(isset($fields['news']) && $fields['news']){
			$this->where('category_name', $fields['news']);
		}

		$query = $this->where('post_status', 'Posted')
				->where('post_deleted', 0)
				->order_by('post_posted_on','DESC')
				->order_by('post_title', 'ASC')
				->join('post_categories', 'post_categories.post_category_post_id = post_id' )
				->join('categories', 'category_id = post_categories.post_category_category_id')
				->format_dropdown('post_id', 'post_title', TRUE);

		return $query;		
	}
}