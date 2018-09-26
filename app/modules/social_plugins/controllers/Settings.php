<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Social_plugins Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Settings extends MX_Controller {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */

	var $start_date;
	var $end_date;

	function __construct()
	{
		parent::__construct();

		$this->load->library('users/acl');
		$this->load->model('social_plugins_model');
		$this->load->model('settings/configs_model');
		$this->load->language('social_plugin_settings');

		$this->start_date 	= date('Y-m-d', strtotime("today -30 days"));
		$this->end_date 	= date('Y-m-d', strtotime("today"));

	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('social_plugins.settings.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('social_plugins/reports'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('social_plugins/settings'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());

		if ($this->input->post())
		{

			if ($page_id = $this->_save_settings())
			{
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

		// get the configs
		$data['social_media_button'] = $this->configs_model
			->where('config_deleted', 0)
			->where('config_name', 'share_buttons')
			->find_all();			

		// get the configs
		$data['social_media_orientation'] = $this->configs_model
			->where('config_deleted', 0)
			->where('config_name', 'share_buttons_orientation')
			->find_all();
		
		// add plugins
		$this->template->add_css(module_css('social_plugins', 'social_plugin_settings'), 'embed');
		$this->template->add_js(module_js('social_plugins', 'social_plugin_settings'), 'embed');
		$this->template->write_view('content', 'social_plugin_settings', $data);
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
		foreach ($this->input->post() as $key => $value)
		{
			if ($key == 'submit') break;

			$this->configs_model->update_where('config_name', $key, array('config_value' => $value));
		}

		$this->cache->delete('app_configs');	

		return TRUE;

	}
}

/* End of file Social_plugins.php */
/* Location: ./application/modules/social_plugins/controllers/Social_plugins.php */