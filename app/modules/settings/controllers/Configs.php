<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Configs Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Configs extends CI_Controller 
{
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->driver('cache', $this->config->item('cache_drivers'));
		
		$this->load->library('users/acl');
		$this->load->model('configs_model');
		$this->load->language('configs');
	}
	
	// --------------------------------------------------------------------
	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function index() 
	{
		$this->acl->restrict('settings.configs.list');

		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'),   site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('settings/configs'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('settings/configs'));

		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		// render the output
		$this->template->add_css(module_css('settings', 'configs_index'), 'embed');
		$this->template->add_js(module_js('settings', 'configs_index'), 'embed');
		$this->template->write_view('content', 'settings/configs_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------
	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function datatables() 
	{
		$this->acl->restrict('settings.configs.list');

		echo $this->configs_model->get_datatables();
	}
	
	/**
	 * form Displays the form for add/edit
	 * 
	 * @access public
	 * @param string $action int $id
	 * @author Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function form($action, $id = 0) 
	{
		// check the current user's permission
		$this->acl->restrict('settings.configs.'.$action, 'modal');

		// set the page variables
		$data = array(
			'page_heading' => lang($action.'_heading'),
			'page_type'    => $action,
			'config'       => ($id ? $this->configs_model->find($id) : '')
		);

		// process the form
		if($this->input->post()) 
		{
			if($this->_save($action, $id)) 
			{
				echo json_encode(array('success' => true, 'message' => lang($action.'_success'))); exit();
			}
			else 
			{
				$response = array(
					'success' => FALSE,
					'message' => lang('validation_error'),
					'errors'  => array(
						// 'config_name'  => form_error('config_name'),
						'config_value' => form_error('config_value')
					)
				);

				echo json_encode($response); exit();
			}
		}
		
		$this->template->set_template('modal');
		$this->template->add_js(module_js('settings', 'configs_form'), 'embed');
		$this->template->write_view('content', 'configs_form', $data);
		
		$this->template->render();
	}


	// --------------------------------------------------------------------
	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function delete($id) 
	{
		// check the current user's permission
		$this->acl->restrict('settings.configs.delete', 'modal');

		// set the page variables
		$data['page_heading']  = lang('delete_heading');
		$data['page_confirm']  = lang('delete_confirm');
		$data['page_button']   = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		// process the form
		if($this->input->post())
		{
			$this->configs_model->delete($id);

			$this->cache->delete('app_configs');
			
			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		// render the output
		$this->load->view('../../modules/core/views/confirm', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * _save
	 *
	 * @access	private
	 * @param	string $type
	 * @param 	integer $id
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	private function _save($type = 'add', $id = 0)
	{
		// validate inputs
		// $this->form_validation->set_rules('config_name', lang('config_name'), 'required');
		$this->form_validation->set_rules('config_value', lang('config_value'), 'required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if($this->form_validation->run($this) == FALSE) 
		{
			return FALSE;
		}

		// set the data
		$data = array(
			// 'config_name'  => $this->input->post('config_name'),
			'config_value' => $this->input->post('config_value'), 
		);

		// add or update the db
		if($type == 'add') 
		{
			$return = $this->configs_model->insert($data);
		} 
		else if($type == 'edit') 
		{
			$return = $this->configs_model->update($id, $data);
		}
		
		$configs = $this->configs_model->find_all_by('config_deleted', 0);
		
		if($configs)
		{
			$configs_arr = array();
			foreach($configs as $key=>$val)
			{
				$configs_arr[] = array(
					// 'config_name'  => $val->config_name,
					'config_value' => $val->config_value
				);
			}
		}
		
		$this->cache->delete('app_configs');
		
		return $return;
	}
}

/* End of file configs.php */
/* Location: ./application/modules/configs/controllers/configs.php */