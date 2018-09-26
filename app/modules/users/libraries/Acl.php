<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Acl Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Acl
{
	// protected $default_actions = array('List', 'View', 'Add', 'Edit', 'Delete');
	protected $default_actions = array('list');
	
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->add_package_path(APPPATH.'/third_party/IonAuth/');

		$this->CI->load->model('users/permissions_model');
		$this->CI->load->model('users/grants_model');
		$this->CI->load->library('ion_auth');
		$this->CI->load->library('session');
		// $this->CI->load->language('users');
		// $this->CI->load->language('ion_auth');
	}
	
	/**
	* Checks the user's permission to access a function
	*
	* @access  public
	* @param   string   name of the permission
	* @param   string   type of action -- redirect, return or modal
	* @param   string   the redirection url
	* @return  array    id of users within the current user's groups
	* @return  false    returns false if the user has no access
	*/
	public function restrict($permission_code, $action_type = 'redirect', $redirect_url = FALSE) 
	{
		// check if the user is logged in
		if (!$this->CI->ion_auth->logged_in()) 
		{
			if ($action_type == 'modal') 
			{
				echo "<script>$(document).ready(function() { window.location = site_url }); </script>";
				exit;
			}
			else
			{
				redirect('users/login?return=' . urlencode(current_url()), 'refresh');
			}
		}
		
		// get the logged in user
		$user_id = $this->CI->session->userdata('user_id');
		// pr($this->CI->session->userdata('user_id')); exit;
		
		// get the permission info
		$permission = $this->CI->permissions_model->find_by('permission_code', $permission_code);

		if (is_object($permission))
		{
			// get the user's groups
			$user_groups = $this->CI->ion_auth->get_users_groups($user_id)->result();
			$group_ids = array();
			foreach ($user_groups as $group) $group_ids[] = $group->id;
			
			$result = $this->CI->grants_model->check_grants($group_ids, $permission->permission_id);
			// log_message('debug', print_r($result, TRUE));
			if ($result)
			{	
				switch($result) 
				{
					// own record only
					case 3: 
						return array($user_id);
						break;

					// group records
					case 2: 
						$users = $this->CI->ion_auth->users($group_ids)->result();
						$user_ids = array();
						foreach ($users as $user)
						{
							$user_ids[] = $user->id;
 						}

						return $user_ids;
						break;

					// all records
					case 1: 
						return TRUE;
						break;

					// case 0: // no access
					// 	return FALSE;
					// 	break;
				}
				
			}
		}

		// actions
		if ($action_type == 'return')
		{
			return FALSE;
		}
		else if ($action_type == 'modal')
		{
			// echo "<script>$(document).ready(function() { $('#modal').modal('hide'); $('#modal_restricted').modal('show'); }); </script>";
			echo "<script>$(document).ready(function() { $('.modal').modal('hide'); alertify.error('" . lang('error_page_restricted') . "'); }); </script>";
			exit;
		}
		else if ($action_type == 'redirect')
		{
			// set the redirect
			if ($redirect_url)
			{
				$redirect_url = $redirect_url; 
			}
			else if ($this->CI->session->userdata('redirect'))
			{
				$redirect_url = $this->CI->session->userdata('redirect');
			}
			else
			{
				$redirect_url = '';
			}

			$this->CI->session->set_flashdata('flash_error', lang('error_page_restricted'));
			redirect($redirect_url, 'refresh');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * message
	 *
	 * @access	public
	 * @param	string $type (error or message)
	 * @param	string $message
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function message($type = 'error', $message = FALSE) 
	{
		if ($type == 'error')
		{
			echo "<script>$(document).ready(function() { alertify.error('" . $message . "'); }); $('.modal').modal('hide');</script>";
		}
		else
		{
			echo "<script>$(document).ready(function() { alertify.message('" . $message . "'); }); $('.modal').modal('hide');</script>";
		}
		exit;
	}

	// --------------------------------------------------------------------

	/**
	 * reconstruct
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	// public function reconstruct($group_id) 
	// {
	// 	$modules = controller_list();
	// 	debug($modules);
		
	// 	$permission_obj = $this->CI->permissions_model->find_all();
	// 	$permissions = array_values_by_key($permission_obj, 'permission_id', 'permission_code');
	// 	debug($permissions);

	// 	// $this->CI->load->controller('customers');
	// 	// pr(get_declared_classes()); exit;

	// 	foreach ($modules as $module => $mod_vals)
	// 	{
	// 		if ($mod_vals)
	// 		{
	// 			foreach ($mod_vals as $controller)
	// 			{
	// 				$controller_name = basename($controller['name'],".php");
	// 				debug($controller_name);

	// 				// $this->CI->load->library('../customers/customers')
	// 				// $class_methods = get_class_methods($this->customers());
	// 				// debug($class_methods);
					
	// 				foreach ($this->default_actions as $action)
	// 				{
	// 					$permission_code = ucfirst($module).'.'.ucfirst($controller_name).'.'.$action;
						
	// 					// check if permission is existing
	// 					if (!in_array($permission_code, $permissions))
	// 					{
	// 						// add the missing permission
	// 						$data = array(
	// 							'permission_code' => $permission_code,
	// 							'permission_active' => 1
	// 						);
	// 						$this->CI->permissions_model->insert($data);
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}
	// }
	
	// --------------------------------------------------------------------

	/**
	 * check_ownership
	 *
	 * @access	public
	 * @param	integer $user_id
	 * @param	array $group_user_ids
	 * @param	string $action_type
	 * @param	string $redirect_url
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function check_ownership($user_id, $group_user_ids, $action_type = 'redirect', $redirect_url = FALSE) 
	{
		if (in_array($user_id, $group_user_ids))
		{
			return TRUE;
		}
		else
		{
			// actions
			if ($action_type == 'return')
			{
				return FALSE;
			}
			else if ($action_type == 'modal')
			{
				echo "<script>$(document).ready(function() { $('#modal').modal('hide'); $('#modal_restricted').modal('show'); }); </script>";
				exit;
			}
			else if ($action_type == 'redirect')
			{
				// set the redirect
				if ($redirect_url)
				{
					$redirect_url = $redirect_url; 
				}
				else if ($this->CI->session->userdata('redirect'))
				{
					$redirect_url = $this->CI->session->userdata('redirect');
				}
				else
				{
					$redirect_url = '';
				}

				$this->CI->session->set_flashdata('flash_error', lang('error_page_restricted'));
				redirect($redirect_url, 'refresh');
			}
		}
	}
}