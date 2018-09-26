<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Roles Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Roles extends CI_Controller 
{
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */
	function __construct()
	{
		parent::__construct();

		$this->load->library('users/acl');
		$this->load->model('permissions_model');
		$this->load->model('grants_model');
		$this->load->model('groups_model');

		$this->load->language('roles');
		$this->load->language('ion_auth');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function index()
	{
		$this->acl->restrict('users.roles.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_users'), site_url('users'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('users/roles'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		$this->template->add_js(module_js('users', 'roles_index'), 'embed');
		$this->template->write_view('content', 'roles_index', $data, FALSE);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function datatables()
	{
		$this->acl->restrict('users.roles.list');
		$fields = array('id', 'name', 'description');
 
		echo $this->groups_model->datatables($fields);
	}

	// --------------------------------------------------------------------

	/**
	 * add
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function add()
	{
		$this->acl->restrict('users.roles.add', 'modal');
		$data['page_heading'] = lang('add_heading');
		// $data['page_subhead'] = lang('add_subhead');
		$data['page_type'] = 'add';

		if ($this->input->post())
		{
			// pr($this->input->post()); exit;
			if ($this->_save('add'))
			{
				echo json_encode(array('success' => true, 'message' => lang('add_success'))); exit;
			}
			else
			{	 
				if ($this->ion_auth->errors())
				{
					$response['success'] = FALSE;
					$response['message'] = $this->ion_auth->errors();
					echo json_encode($response);
					exit;
				}
				else
				{
					$response['success'] = FALSE;
					$response['message'] = lang('validation_error');
					$response['errors'] = array(
						'group_name'			=> form_error('group_name'),
						'group_description'		=> form_error('group_description')
					);
					echo json_encode($response);
					exit;
				}
			}
		}

		$this->template->set_template('modal');
		$this->template->add_js(module_js('users', 'roles_form'), 'embed');
		$this->template->write_view('content', 'roles_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * edit
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function edit($group_id)
	{
		$this->acl->restrict('users.roles.edit', 'modal');

		$data['page_heading'] = lang('edit_heading');
		$data['page_type'] = 'edit';

		if ($this->input->post())
		{
			if ($this->_save('edit', $group_id))
			{
				echo json_encode(array('success' => true, 'message' => lang('edit_success'))); exit;
			}
			else
			{	
				if ($this->ion_auth->errors())
				{
					$response['success'] = FALSE;
					$response['message'] = $this->ion_auth->errors();
					echo json_encode($response);
					exit;
				}
				else
				{
					$response['success'] = FALSE;
					$response['message'] = lang('validation_error');
					$response['errors'] = array(
						'group_name'			=> form_error('group_name'),
						'group_description'		=> form_error('group_description')
					);
					echo json_encode($response);
					exit;
				}
			}
		}

		$data['record'] = $this->ion_auth->group($group_id)->row();

		$this->template->set_template('modal');
		$this->template->add_js(module_js('users', 'roles_form'), 'embed');
		$this->template->write_view('content', 'roles_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function delete($id)
	{
		$this->acl->restrict('users.roles.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->groups_model->delete($id);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}
	

	// --------------------------------------------------------------------

	/**
	 * access
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function access($group_id)
	{
		$this->acl->restrict('users.roles.edit');
		
		$data['page_heading'] = lang('permissions_heading');
		$data['page_subhead'] = lang('permissions_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_users'), site_url('users'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('users/roles'));
		$this->breadcrumbs->push(lang('permissions_heading'), site_url('users/roles/access/'.$group_id));

		$this->session->set_userdata('redirect', current_url());
		
		// get the group info
		$data['group'] = $this->groups_model->find($group_id);

		// get the modules
		$modules = array_keys(controller_list()); // see common_helper.php
		ksort($modules);
		// pr($modules);

		// get the permissions
		$permissions = $this->permissions_model->order_by('permission_id')->where('permission_active', 1)->find_all();

		// get the group's permissions
		$grants = $this->grants_model
			->join('permissions', 'permission_id = grant_permission_id')
			->where('grant_group_id', $group_id)
			->where('grant_access !=', 0)
			->format_dropdown('grant_id', 'permission_code');
		$group_permissions = array_values($grants);
		// pr($group_permissions);

		$grants = array();
		foreach ($permissions as $permission)
		{
			list($mod, $cont, $func) = explode('.', $permission->permission_code);

			$grants[$mod][] = array(
				'id' 		=> $permission->permission_id,
				'code' 		=> $permission->permission_code,
				'name' 		=> $permission->permission_name,
				'access'	=> (in_array($permission->permission_code, $group_permissions)) ? 'allow' : 'deny'
			);
		}

		$data['grants'] = $grants;
		
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		$this->template->add_js('npm/blockUI/jquery.blockUI.js');

		$this->template->add_css(module_css('users', 'roles_access'), 'embed');
		$this->template->add_js(module_js('users', 'roles_access'), 'embed');
		$this->template->write_view('content', 'roles_access', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * update_permission
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @param	integer $permission_id
	 * @param	integer $permission_level
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	// function update_permission($group_id, $permission_id, $permission_level)
	// {
	// 	$this->acl->restrict('users.roles.edit');
	// 	log_message('debug', $permission_level);

	// 	if ($permission = $this->grants_model->find_by(array('grant_group_id' => $group_id, 'grant_permission_id' => $permission_id)))
	// 	{
	// 		$this->grants_model->update($permission->grant_id, array('grant_access' => $permission_level));

	// 		$response['success'] = TRUE;
	// 		echo json_encode($response);
	// 		exit;
	// 	}
	// 	else
	// 	{
	// 		$data = array(
	// 			'grant_group_id' 		=> $group_id,
	// 			'grant_permission_id'	=> $permission_id,
	// 			'grant_access'		=> $permission_level,
	// 			// 'grant_deleted'		=> 0
	// 		);
	// 		$id = $this->grants_model->insert($data);

	// 		if ($id)
	// 		{
	// 			$response['success'] = TRUE;
	// 			echo json_encode($response);
	// 			exit;
	// 		} 
	// 		else
	// 		{
	// 			$response['success'] = FALSE;
	// 			echo json_encode($response);
	// 			exit;
	// 		}
	// 	}
	// }

	// --------------------------------------------------------------------

	/**
	 * update_access
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @param	integer $permission_id
	 * @param	integer $permission_level
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function update_access()
	{
		$this->acl->restrict('users.roles.edit');

		// check if grant exists
		$grant = $this->grants_model
			->find_by(array(
				'grant_group_id' 		=> $this->input->post('group_id'), 
				'grant_permission_id' 	=> $this->input->post('permission_id')
			));

		$this->cache->delete('app_menu');
		$this->cache->delete('app_grants');

		if ($grant)
		{
			$this->grants_model->update($grant->grant_id, array('grant_access' => $this->input->post('permission_level')));
			echo json_encode(array('success' => TRUE)); exit;
		}
		else
		{
			$data = array(
				'grant_group_id' 		=> $this->input->post('group_id'),
				'grant_permission_id'	=> $this->input->post('permission_id'),
				'grant_access'			=> $this->input->post('permission_level'),
			);
			$id = $this->grants_model->insert($data);

			if ($id)
			{
				echo json_encode(array('success' => TRUE)); exit;
			} 
			else
			{
				echo json_encode(array('success' => FALSE)); exit;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _save
	 *
	 * @access	private
	 * @param	string $type
	 * @param 	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _save($type = 'add', $group_id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('group_name', lang('label_role'), 'required');
		$this->form_validation->set_rules('group_description', lang('label_description'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'name' => $this->input->post('group_name'),
			'description' => $this->input->post('group_description')
		);
		
		if ($type == 'add')
		{
			$id = $this->groups_model->insert($data);

			return (is_numeric($id)) ? $id : FALSE;
		}
		else if ($type == 'edit')
		{
			return $this->groups_model->update($group_id, $data);
		}

		// if ($type == 'add')
		// {
		// 	$group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('group_description'));

		// 	// $this->_delete_cache();

		// 	return (is_numeric($group_id)) ? $group_id : FALSE;
		// }
		// else if ($type == 'edit')
		// {
		// 	$return = $this->ion_auth->update_group($group_id, $this->input->post('group_name'), $this->input->post('group_description'));

		// 	// $this->_delete_cache();
			
		// 	return ($return) ? TRUE : FALSE;
		// }
	}
}

/* End of file Roles.php */
/* Location: ./application/modules/users/controllers/Roles.php */