<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pages_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Pages_model extends BF_Model 
{

	protected $table_name			= 'pages';
	protected $key					= 'page_id';

	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'page_created_on';
	protected $created_by_field		= 'page_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'page_modified_on';
	protected $modified_by_field	= 'page_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'page_deleted';
	protected $deleted_by_field		= 'page_deleted_by';

	public $metatag_key				= 'page_metatag_id';

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
			'page_id', 
			'page_title',
			'page_slug',
			'page_status',

			'page_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'page_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = page_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = page_modified_by', 'LEFT')
					->datatables($fields);
	}

	// --------------------------------------------------------------------

	/**
	 * get_frontend_widget
	 *
	 * @access	public
	 * @param	integer $id
	 * @return 	string $html
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_frontend_widget($id)
	{
		$page = $this->find($id);

		return $page->page_content;
	}

	// --------------------------------------------------------------------

	/**
	 * get_page_path
	 *
	 * @access	public
	 * @param	integer $parent_id
	 * @return 	string $path
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_page_path($parent_id)
	{
		$path = $this->_get_page_path($parent_id);

		// reverse, start from top level
		$path = array_reverse($path);

		// convert array to path
		$path = implode('/', $path);

		return $path;
	}

	// --------------------------------------------------------------------

	/**
	 * get_page_crumbs
	 *
	 * @access	public
	 * @param	integer $parent_id
	 * @return 	string $path
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_page_crumbs($parent_id)
	{
		$crumbs = $this->_get_page_crumbs($parent_id);

		// reverse, start from top level
		$crumbs = array_reverse($crumbs);

		return $crumbs;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_page_path
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @return 	array $paths
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_page_path($parent_id = 0, &$paths = array())
	{
		$page = $this->find($parent_id);

		if ($page)
		{
			$paths[] = $page->page_slug;

			$this->_get_page_path($page->page_parent_id, $paths);
		}

		return $paths;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_page_crumbs
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @return 	array $crumbs
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_page_crumbs($parent_id = 0, &$crumbs = array())
	{
		$page = $this->find($parent_id);

		if ($page)
		{
			$crumbs[] = array(
				'name' => $page->page_title,
				'uri' => $page->page_uri,
			);

			$this->_get_page_crumbs($page->page_parent_id, $crumbs);
		}

		return $crumbs;
	}
}