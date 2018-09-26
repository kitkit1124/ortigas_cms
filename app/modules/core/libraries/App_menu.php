<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * App_menu Class
 *
 * @package		Codifire
 * @version		1.5
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2017, Randy Nivales
 * @link		randynivales@gmail.com
 */
class App_menu {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->driver('cache', $this->CI->config->item('cache_drivers'));

		log_message('debug', "App_menu Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * show
	 *
	 * Generates the navigation menu
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function show($type = FALSE)
	{
		// get the user's groups
		$user_groups = $this->CI->ion_auth->get_users_groups($this->CI->session->userdata('user_id'))->result();
		$group_ids = array();
		foreach ($user_groups as $group) $group_ids[] = $group->id;

		// get the grants
		$app_grants = $this->_get_grants();
		$grants = array();
		foreach ($app_grants as $grant)
		{
			if (in_array($grant->grant_group_id, $group_ids) AND $grant->grant_access == 1)
			{
				$grants[] = $grant->permission_code;
			}
		}
		// pr($grants);


		// get the menus
		$app_menus = $this->_get_menus();

		// pr($menus); exit;
		$navs = array();
		$subnavs = array();
		
		foreach ($app_menus as $menu)
		{
			if ($menu->menu_parent > 0)
			{
				$active = $this->_check_active($app_menus, $menu); 
				$subnavs[] = array(
					'menu_id'			=> $menu->menu_id,
					'menu_text'			=> $menu->menu_text,
					'menu_link'			=> $menu->menu_link,
					'menu_perm'			=> $menu->menu_perm,
					'menu_icon'			=> $menu->menu_icon,
					'menu_active'		=> $active,
					'menu_parent'		=> $menu->menu_parent,
				);
			}
			else
			{
				$active = $this->_check_active($app_menus, $menu, TRUE); 
				$navs[$menu->menu_id] = array(
					'menu_id'			=> $menu->menu_id,
					'menu_text'			=> $menu->menu_text,
					'menu_link'			=> $menu->menu_link,
					'menu_perm'			=> $menu->menu_perm,
					'menu_icon'			=> $menu->menu_icon,
					'menu_active'		=> $active,
				);
			}
		}


		foreach ($subnavs as $subnav)
		{
			$navs[$subnav['menu_parent']]['menu_child'][] = array(
				'menu_id'			=> $subnav['menu_id'],
				'menu_text'			=> $subnav['menu_text'],
				'menu_link'			=> $subnav['menu_link'],
				'menu_perm'			=> $subnav['menu_perm'],
				'menu_icon'			=> $subnav['menu_icon'],
				'menu_active'		=> $subnav['menu_active'],
			);
		}

		if ($type == 'dashboard')
		{
			// $html = '<ul class="nav nav-list">' . PHP_EOL;
			// pr($navs);
			$html = [];
			$html[] = '<div class="row" id="dashboard_icons">';
			foreach ($navs as $nav)
			{
				// parent menu
				if (in_array($nav['menu_perm'], $grants) and $nav['menu_text'] != 'Dashboard')
				{ 
					$icon = '<div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">';
					$icon .= '<a href="' . site_url($nav["menu_link"]) . '" class="btn btn-light btn-block pt-3 pb-2">';
					$icon .= '<i class="' . $nav['menu_icon'] . ' fa-3x"></i><br />';
					$icon .= $nav['menu_text'];
					$icon .= '</a>';
					$icon .= '</div>';

					$html[] = $icon;
				
					// pr($nav);
					if (isset($nav['menu_child']))
					{
						// remove the parent menu
						array_pop($html);
						// pr($html);

						// loop through child menu
						foreach ($nav['menu_child'] as $subnav)
						{
							if (in_array($subnav['menu_perm'], $grants))
							{
								$icon = '<div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">';
								$icon .= '<a href="' . site_url($subnav["menu_link"]) . '" class="btn btn-block btn-light pt-3 pb-2">';
								$icon .= '<i class="' . $subnav['menu_icon'] . ' fa-3x"></i><br />';
								// $icon .= $nav['menu_text'] . ': ';
								$icon .= $subnav['menu_text'] . '<br /><small class="text-muted">(' . $nav["menu_text"] . ')</small>';
								$icon .= '</a>';
								$icon .= '</div>';

								$html[] = $icon;
							}
						}
					}
				}
			}
			// $html .= '</ul>' . PHP_EOL;
			$html[] = '</div>';

			return implode(PHP_EOL, $html);
		}
		else
		{

			$html = '<ul class="list-unstyled">' . PHP_EOL;
			foreach ($navs as $nav)
			{
				// menu without child
				if (! isset($nav['menu_child']))
				{
					// parent menu
					// if ($this->CI->acl->restrict($nav['menu_perm'], 'return'))
					if (in_array($nav['menu_perm'], $grants))
					{
						$treeview = (isset($nav['menu_child'])) ? 'dropdown-toggle' : '';
						$active = ($nav['menu_active'] == 1) ? 'active' : '';
						// $arrow1 = ($nav['menu_active'] == 1) ? '<span class="arrow-left"></span>' : '';
						$html .= ($active) ? '<li class="' . $active . '">' : '<li>';
						$html .= PHP_EOL;
						$html .= '	<a class="' . $treeview . '" href="' . site_url($nav['menu_link']) . '"><i class="menu-icon ' . $nav['menu_icon'] . ' fa-fw"></i>';
						$html .= ' <span class="menu-text">' . $nav['menu_text'] . '</span>' . PHP_EOL;
						// $html .= (isset($nav['menu_child'])) ? '<b class="arrow fa fa-angle-down"></b>' : '';
						// $html .= '</a><b class="arrow"></b>' . PHP_EOL;
						$html .= '</a>' . PHP_EOL;
					}
				}

				// menu with child
				if (isset($nav['menu_child']))
				{
					$nav_html = '';

					// parent menu
					// if ($this->CI->acl->restrict($nav['menu_perm'], 'return'))
					if (in_array($nav['menu_perm'], $grants))
					{
						$treeview = (isset($nav['menu_child'])) ? 'dropdown-toggle' : '';
						$active = ($nav['menu_active'] == 1) ? 'active' : '';
						$expanded = ($nav['menu_active'] == 1) ? 'true' : 'false';
						$show = ($nav['menu_active'] == 1) ? 'show' : '';
						// $arrow1 = ($nav['menu_active'] == 1) ? '<span class="arrow-left"></span>' : '';
						// $nav_html = '<li class="' . $active . '">' . PHP_EOL;
						// $nav_html .= ($active) ? '<li class="' . $active . '">' : '<li>';
						$nav_html .= ($active) ? '<li>' : '<li>';
						
						$nav_html .= PHP_EOL;
						$nav_html .= '	<a href="#menu' . $nav['menu_id'] . '" aria-expanded="' . $expanded . '" data-toggle="collapse"><i class="menu-icon ' . $nav['menu_icon'] . ' fa-fw"></i>';
						$nav_html .= ' <span class="menu-text">' . $nav['menu_text'] . '</span>' . PHP_EOL;
						// $nav_html .= (isset($nav['menu_child'])) ? '	<b class="arrow fa fa-angle-down"></b>' : '	<b class="arrow fa fa-angle-down"></b>';
						// $nav_html .= '<b class="arrow"></b></a>' . PHP_EOL;
						$nav_html .= '</a>' . PHP_EOL;
					}


					// child menu
					$nav_html .= PHP_EOL . '	<ul id="menu' . $nav['menu_id'] . '" class="collapse list-unstyled ' . $show . '">' . PHP_EOL;

					$child_count = 0;
					foreach ($nav['menu_child'] as $child)
					{
						// if ($this->CI->acl->restrict($child['menu_perm'], 'return'))
						if (in_array($child['menu_perm'], $grants))
						{
							$active = ($child['menu_active'] == 1) ? 'active' : '';
							$arrow2 = ($child['menu_active'] == 1) ? '			<b class="arrow"></b>' : '			<b class="arrow"></b>';
							$nav_html .= PHP_EOL;
							$nav_html .= ($active) ? '		<li class="'.$active.'">' : '		<li>';
							$nav_html .= PHP_EOL;
							// $nav_html .= PHP_EOL . '		<li class="'.$active.'">' . PHP_EOL;
							$nav_html .= '			<a class="" href="' . site_url($child['menu_link']) . '"><i class="menu-icon fa-fw ' . $child['menu_icon'] . '"></i>';
							$nav_html .= ' ' . $child['menu_text'] . '</a>' . PHP_EOL;
							$nav_html .= $arrow2 . PHP_EOL . '		</li>' . PHP_EOL;

							$child_count++;
						}
					}
					

					$nav_html .= '	</ul>' . PHP_EOL;

					if ($child_count > 0)
					{
						$html .= $nav_html; 
					}
				}
				// if (isset($nav['menu_perm']) && ($this->CI->acl->restrict($nav['menu_perm'], 'return')))
				if (isset($nav['menu_perm']) && (in_array($nav['menu_perm'], $grants)))
				{
					// $arrow1 = ($treeview) ? '' : $arrow1;
					// $html .= $arrow1 . '</li>' . PHP_EOL;
					$html .= '</li>' . PHP_EOL;
				}
			}
			$html .= '</ul>' . PHP_EOL;

			return $html;
		}

		
	}

	// --------------------------------------------------------------------

	/**
	 * _check_active
	 *
	 * Generates the navigation menu
	 *
	 * @access	private
	 * @param	object $menus
	 * @param	object $menu
	 * @param	integer $parent
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _check_active($menus, $menu, $parent = FALSE)
	{
		if ($parent && $this->_check_child($menus, $menu))
		{
			return TRUE;
		}
		// else if (site_url($menu->menu_link) == current_url())
		else if (preg_match("/" . urlencode(site_url($menu->menu_link)) . "/", urlencode(current_url())))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _check_child
	 *
	 * Generates the navigation menu
	 *
	 * @access	private
	 * @param	object $menus
	 * @param	integer $parent
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _check_child($menus, $parent)
	{
		$return = FALSE;

		foreach ($menus as $child)
		{
			// if this menu is a child of the parent menu
			if ($child->menu_parent == $parent->menu_id)
			{
				// check if this child is the active menu
				// if (site_url($child->menu_link) == current_url())
				if (preg_match("/" . urlencode(site_url($child->menu_link)) . "/", urlencode(current_url())))
				{
					$return = TRUE;
					break;
				}
			}
		}

		return $return;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_grants
	 *
	 */
	public function _get_grants()
	{
		// get the grants
		if (! $app_grants = $this->CI->cache->get('app_grants'))
		{
			$app_grants = $this->CI->db
				->join('permissions', 'permission_id = grant_permission_id', 'LEFT')
				->get('grants')
				->result();

			$this->CI->cache->save('app_grants', $app_grants, 86400); // 1 day
		}

		return $app_grants;
	}

	// --------------------------------------------------------------------

	/**
	 * _get_menus
	 *
	 */
	public function _get_menus()
	{
		// get the menus
		if (! $app_menu = $this->CI->cache->get('app_menu'))
		{
			$app_menu = $this->CI->db->where('menu_active', 1)->where('menu_deleted', 0)
				->order_by('menu_order')->get('menus')->result();

			$this->CI->cache->save('app_menu', $app_menu, 86400); // 1 day
		}

		return $app_menu;
	}
}

/* End of file App_menu.php */
/* Location: ./application/libraries/App_menu.php */