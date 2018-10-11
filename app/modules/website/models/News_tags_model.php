<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * News_tags_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class News_tags_model extends BF_Model {

	protected $table_name			= 'news_tags';
	protected $key					= 'news_tag_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'news_tag_created_on';
	protected $created_by_field		= 'news_tag_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'news_tag_modified_on';
	protected $modified_by_field	= 'news_tag_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'news_tag_deleted';
	protected $deleted_by_field		= 'news_tag_deleted_by';

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
			'news_tag_id',
			'news_tag_name',
			'news_tag_description',
			'news_tag_status',

			'news_tag_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'news_tag_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = news_tag_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = news_tag_modified_by', 'LEFT')
					->datatables($fields);
	}

	public function get_active_tags(){
		$query = $this
				->where('news_tag_status', 'Active')
				->where('news_tag_deleted', 0)
				->order_by('news_tag_name', 'ASC')
				->format_dropdown('news_tag_id', 'news_tag_name', TRUE);

		return $query;		
	}

}