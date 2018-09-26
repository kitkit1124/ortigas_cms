<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Categories_model extends BF_Model 
{

	protected $table_name			= 'categories';
	protected $key					= 'category_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'category_created_on';
	protected $created_by_field		= 'category_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'category_modified_on';
	protected $modified_by_field	= 'category_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'category_deleted';
	protected $deleted_by_field		= 'category_deleted_by';

	public $metatag_key				= 'category_metatag_id';

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
			'category_id', 
			'category_name',
			'category_uri',
			'category_status',

			'category_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'category_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = category_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = category_modified_by', 'LEFT')
					->datatables($fields);
	}

	// --------------------------------------------------------------------

	/**
	 * get_category_path
	 *
	 * @access	public
	 * @param	integer $parent_id
	 * @return 	string $path
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_category_path($parent_id)
	{
		$path = $this->_get_category_path($parent_id);

		// reverse, start from top level
		$path = array_reverse($path);

		// convert array to path
		$path = implode('/', $path);

		return $path;
	}

	// --------------------------------------------------------------------

	/**
	 * get_category_crumbs
	 *
	 * @access	public
	 * @param	integer $parent_id
	 * @return 	string $path
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_category_crumbs($parent_id)
	{
		$crumbs = $this->_get_category_crumbs($parent_id);

		// reverse, start from top level
		$crumbs = array_reverse($crumbs);

		return $crumbs;
	}

	// --------------------------------------------------------------------

	/**
	 * get_category_checkboxes
	 *
	 * @access	public
	 * @param	integer $parent_id
	 * @return 	string $path
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_category_checkboxes($parent_id = 0)
	{
		$checkboxes = $this->_get_category_checkboxes($parent_id);

		return $checkboxes;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_category_path
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @return 	array $paths
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_category_path($parent_id = 0, &$paths = array())
	{
		$category = $this->find($parent_id);

		if ($category)
		{
			$paths[] = $category->category_slug;

			$this->_get_category_path($category->category_parent_id, $paths);
		}

		return $paths;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_category_crumbs
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @return 	array $crumbs
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_category_crumbs($parent_id = 0, &$crumbs = array())
	{
		$category = $this->find($parent_id);

		if ($category)
		{
			$crumbs[] = array(
				'name' => $category->category_name,
				'uri' => $category->category_uri,
			);

			$this->_get_category_crumbs($category->category_parent_id, $crumbs);
		}

		return $crumbs;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_category_checkboxes
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @return 	array $crumbs
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_category_checkboxes($parent_id = 0, &$checkboxes = array(), &$indent = 0)
	{
		$categories = $this
			->where('category_parent_id', $parent_id)
			->order_by('category_name', 'asc')
			->where('category_deleted', 0)
			->find_all();

		if ($categories)
		{
			foreach ($categories as $category)
			{
				$uri = explode('/', $category->category_uri);

				$category->category_indent = (count($uri) - 2) * 20;
				$checkboxes[] = $category;
				$this->_get_category_checkboxes($category->category_id, $checkboxes, $indent);
			}
		}

		return $checkboxes;
	}
}