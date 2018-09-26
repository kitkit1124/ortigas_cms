<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migrations_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Migrations_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function add_permissions($permissions = array())
	{
		// add the module permissions
		if ($permissions)
		{
			foreach ($permissions as $permission)
			{
				// add the permission
				$this->db->insert('permissions', array(
					'permission_name' => $permission[0], 
					'permission_code' => $permission[1], 
					'permission_active' => 1
				));

				$permission_id = $this->db->insert_id();

				// also grant access to admin
				$this->db->insert('grants', array(
					'grant_group_id' => 1, 
					'grant_permission_id' => $permission_id, 
					'grant_access' => 1
				));
			}
		}
	}

	public function add_menus($menus = array())
	{
		// add the module menu
		if ($menus)
		{
			foreach ($menus as $menu)
			{
				$link = explode('/', $menu['menu_link']);
				// if (isset($link[1]) && $menu['menu_parent'] == $link[1])
				if ($menu['menu_parent'] == 'none')
				{
					$parent = 0;
				}
				else
				{
					// get the parent id
					$query = $this->db->query("SELECT menu_id FROM {$this->db->dbprefix('menus')} WHERE menu_link = '{$menu['menu_parent']}'");
					// log_message('debug', print_r($query, TRUE));
					// $row = $query->row();
					
					if ($row = $query->row())
					{
						$parent = $row->menu_id;
					}
					else
					{
						$parent = 0;
					}
				}
				$menu['menu_parent'] = $parent;
				$this->db->insert('menus', $menu);
			}
		}
	}

	public function delete_permissions($permissions = array())
	{
		// delete the permissions
		if ($permissions)
		{
			foreach ($permissions as $permission)
			{
				$this->db->delete('permissions', array('permission_code' => $permission[1]));
			}
		}
	}

	public function delete_menus($menus = array())
	{
		// delete the menu
		if ($menus)
		{
			foreach ($menus as $menu)
			{
				$this->db->delete('menus', array('menu_link' => $menu['menu_link']));
			}
		}
	}
}