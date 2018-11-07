<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Navigations_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Navigations_model extends BF_Model 
{

	protected $table_name			= 'navigations';
	protected $key					= 'navigation_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'navigation_created_on';
	protected $created_by_field		= 'navigation_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'navigation_modified_on';
	protected $modified_by_field	= 'navigation_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'navigation_deleted';
	protected $deleted_by_field		= 'navigation_deleted_by';

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
			'navigation_id', 
			'navigation_group_id',
			'navigation_parent_id',
			'navigation_name',
			'navigation_link',
			'navigation_target',
			'navigation_type',
			'navigation_status',

			'navigation_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'navigation_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = navigation_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = navigation_modified_by', 'LEFT')
					->datatables($fields);
	}

	// --------------------------------------------------------------------

	/**
	 * get_nestable_navigations
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @return 	string $html
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_nestable_navigations($group_id)
	{
		$html = $this->_get_navigations($group_id);

		return $html;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_navigations
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @param 	string $html
	 * @return 	string $html
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_navigations($group_id, $parent_id = 0, &$html = '')
	{
		$parent_id = ($parent_id) ? $parent_id : 0;
		$outer_li = ($parent_id === 0) ? 'outer' : '';

		$navs = $this->where('navigation_deleted', 0)
			->where('navigation_parent_id', $parent_id)
			->where('navigation_group_id', $group_id)
			->find_all();

		if ($navs)
		{
			$html .= "<ol class=\"dd-list {$outer_li}\">\n";
			foreach ($navs as $nav)
			{
				// $html .= "<li class=\"dd-item dd3-item\" data-name=\"{$nav->navigation_name}\" data-link=\"{$nav->navigation_link}\" data-target=\"{$nav->navigation_target}\" data-res=\"{$nav->navigation_source}\" data-resid=\"{$nav->navigation_source_id}\">\n";
				// $html .= "<div class=\"dd-handle dd3-handle\">Drag</div><div class=\"dd3-content\"><a href=\"javascript:;\" class=\"dd-name\">{$nav->navigation_name}</a><span class=\"pull-right\"><span class=\"fa fa-times navdel\"></span></span></div>\n";
				$html .= "<li class=\"dd-item\" data-name=\"{$nav->navigation_name}\" data-link=\"{$nav->navigation_link}\" data-target=\"{$nav->navigation_target}\" data-res=\"{$nav->navigation_source}\" data-resid=\"{$nav->navigation_source_id}\">\n";
				$html .= "<div class=\"dd-handle\"><span class=\"dd-nodrag\"><a href=\"javascript:;\" class=\"dd-name\">{$nav->navigation_name}</a></span><span class=\"dd-nodrag\"><a href=\"javascript:;\" class=\"pull-right\"><span class=\"fa fa-times navdel\"></span></a></span></div>\n";
				$this->_get_navigations($group_id, $nav->navigation_id, $html);
				$html .= "</li>\n";
			}
			$html .= "</ol>\n";
		}

		return $html;
	}

	// --------------------------------------------------------------------

	/**
	 * get_frontend_navigations
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @return 	string $html
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_frontend_navigations($group_id)
	{
		$html = $this->_get_frontend_navigations($group_id);

		return $html;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_navigations
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @param 	string $html
	 * @return 	string $html
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_frontend_navigations($group_id, $parent_id = 0, &$html = '', $ul_class = '')
	{
		$parent_id = ($parent_id) ? $parent_id : 0;
		$outer_li = ($parent_id === 0) ? 'outer' : '';

		$navs = $this->where('navigation_deleted', 0)
			->where('navigation_parent_id', $parent_id)
			->where('navigation_group_id', $group_id)
			->find_all();

		if ($navs)
		{
			$ul_class = ($ul_class) ? $ul_class : 'nav navbar-nav';
			$html .= '<ul class="' . $ul_class . '">' . PHP_EOL;
			foreach ($navs as $nav)
			{
				if ($nav->navigation_is_parent)
				{
					$li_class = (!$parent_id) ? ' class="dropdown"' : ' class="dropdown-submenu"';
					$a_class = ' class="dropdown-toggle" data-toggle="dropdown"';
					$ul_class = 'dropdown-menu';
					$caret = (!$parent_id) ? ' <span class="caret"></span>' : '';
				}
				else
				{
					$li_class = '';
					$a_class = '';
					$ul_class = '';
					$caret = '';
				}

				$link = ($nav->navigation_type == 'Internal') ? site_url($nav->navigation_link) : $nav->navigation_link;

				$html .= '<li' . $li_class . '>' . PHP_EOL;
				$html .= '<a' . $a_class .  ' href="' . $link . '" target="' . $nav->navigation_target . '">' . $nav->navigation_name . $caret . '</a>' . PHP_EOL;
				$this->_get_frontend_navigations($group_id, $nav->navigation_id, $html, $ul_class);
				$html .= '</li>' . PHP_EOL;
			}
			$html .= '</ul>' . PHP_EOL;
		}

		return $html;
	}

	// --------------------------------------------------------------------

	/**
	 * get_frontend_navigations
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @return 	string $html
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_navigation_widget($group_id)
	{
		$html = $this->_get_navigation_widget($group_id);

		return $html;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_navigations
	 *
	 * @access	private
	 * @param 	integer $parent_id
	 * @param 	string $html
	 * @return 	string $html
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _get_navigation_widget($group_id, $parent_id = 0, &$html = '', $ul_class = '')
	{
		$parent_id = ($parent_id) ? $parent_id : 0;
		$outer_li = ($parent_id === 0) ? 'outer' : '';

		$navs = $this->where('navigation_deleted', 0)
			->where('navigation_parent_id', $parent_id)
			->where('navigation_group_id', $group_id)
			->find_all();

		if ($navs)
		{
			$ul_class = ($ul_class) ? $ul_class : 'navigation';
			$html .= '<ul class="' . $ul_class . '">' . PHP_EOL;
			foreach ($navs as $nav)
			{
				if ($nav->navigation_is_parent)
				{
					$li_class = (!$parent_id) ? ' class="navigation-menu"' : ' class="navigation-submenu"';
					$a_class = ' class="navigation-link"';
					$ul_class = 'navigation-parent';
					// $caret = (!$parent_id) ? ' <span class="caret"></span>' : '';
				}
				else
				{
					$li_class = '';
					$a_class = '';
					$ul_class = '';
					// $caret = '';
				}

				$link = ($nav->navigation_type == 'Internal') ? site_url($nav->navigation_link) : $nav->navigation_link;

				$html .= '<li' . $li_class . '>' . PHP_EOL;
				$html .= '<a' . $a_class .  ' href="' . $link . '" target="' . $nav->navigation_target . '">' . $nav->navigation_name . '</a>' . PHP_EOL;
				$this->_get_navigation_widget($group_id, $nav->navigation_id, $html, $ul_class);
				$html .= '</li>' . PHP_EOL;
			}
			$html .= '</ul>' . PHP_EOL;
		}

		return $html;
	}
}