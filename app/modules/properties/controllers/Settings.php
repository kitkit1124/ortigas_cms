<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Settings extends MX_Controller {
	
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
		$this->load->model('settings_model');
		$this->load->language('settings');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('properties.settings.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('settings'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		$data['divisions'] = $this->settings_model->order_by('setting_order', 'ASC')->find_all();

		$this->template->add_js('mods/jquery-ui/jquery-ui.min.js');
		
		// render the page
		$this->template->add_css(module_css('properties', 'settings_index'), 'embed');
		$this->template->add_js(module_js('properties', 'settings_index'), 'embed');
		$this->template->write_view('content', 'settings_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('properties.settings.list');

		echo $this->settings_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('properties.settings.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'setting_division'		=> form_error('setting_division'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->settings_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('properties', 'settings_form'), 'embed');
		$this->template->add_js(module_js('properties', 'settings_form'), 'embed');
		$this->template->write_view('content', 'settings_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('properties.settings.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->settings_model->delete($id);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}


	// --------------------------------------------------------------------

	/**
	 * _save
	 *
	 * @access	private
	 * @param	string $action
	 * @param 	integer $id
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('setting_division', lang('setting_division'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'setting_division'		=> $this->input->post('setting_division'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->settings_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->settings_model->update($id, $data);
		}

		return $return;

	}

	/**
	 * reorder
	 *
	 * @access	public
	 * @param	array $this->input->post('banner_ids')
	 * @author 	Gutz Marzan <gutzby.marzan@digify.com.ph>
	 */
	function reorder()
	{
		// $this->acl->restrict('properties.settings.edit', 'modal');

		$ids = $this->input->post('ids');


		// get the banners
		$divisions = $this->settings_model
			->where_in('setting_id', $ids)
			->find_all();

		if ($divisions)
		{
			foreach ($divisions as $division)
			{
				// update the banner
				$this->settings_model->update($division->setting_id, array(
					'setting_order' => array_search($division->setting_id, $ids)
				));
			}
		}

		echo json_encode(array('success' => true, 'message' => lang('reorder_success'))); exit;
	
	}
	//
}

/* End of file Settings.php */
/* Location: ./application/modules/properties/controllers/Settings.php */