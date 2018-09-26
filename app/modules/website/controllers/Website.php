<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Website Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Website extends MX_Controller 
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
		$this->load->model('settings/configs_model');
		$this->load->language('website');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function index()
	{
		
	}

	// --------------------------------------------------------------------

	/**
	 * settings
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function settings()
	{
		$this->acl->restrict('website.website.settings');

		// page title
		$data['page_heading'] = lang('settings_heading');
		$data['page_subhead'] = lang('settings_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/settings'));
		$this->breadcrumbs->push(lang('settings_heading'), site_url('website/settings'));

		if ($this->input->post())
		{

			if ($page_id = $this->_save_settings())
			{
				// $this->session->set_flashdata('flash_message',  lang('settings_success'));
				echo json_encode(array('success' => true, 'message' => lang('settings_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'website_name'		=> form_error('website_name'),
					'website_email'		=> form_error('website_email'),
					'website_url'		=> form_error('website_url'),
					'website_theme'		=> form_error('website_theme'),
				);
				echo json_encode($response);
				exit;
			}
		}

		$files_configs = array('website_name', 'website_email', 'website_url', 'website_theme');

		// get the configs
		$data['configs'] = $this->configs_model
			->where('config_deleted', 0)
			->where_in('config_name', $files_configs)
			->find_all();

		// render the page
		$this->template->add_css(module_css('website', 'website_settings'), 'embed');
		$this->template->add_js(module_js('website', 'website_settings'), 'embed');
		$this->template->write_view('content', 'website_settings', $data);
		$this->template->render();
	}


	// --------------------------------------------------------------------

	/**
	 * _save_settings
	 *
	 * @access	private
	 * @param 	array $this->input->post()
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	private function _save_settings()
	{
		// validate inputs
		$this->form_validation->set_rules('website_name', lang('website_name'), 'required');
		$this->form_validation->set_rules('website_email', lang('website_email'), 'required');
		$this->form_validation->set_rules('website_url', lang('website_url'), 'required');
		$this->form_validation->set_rules('website_theme', lang('website_theme'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		foreach ($this->input->post() as $key => $value)
		{
			if ($key == 'submit') break;

			$this->configs_model->update_where('config_name', $key, array('config_value' => $value));
		}

		$this->cache->delete('app_configs');	

		return TRUE;

	}
}

/* End of file Website.php */
/* Location: ./application/modules/website/controllers/Website.php */