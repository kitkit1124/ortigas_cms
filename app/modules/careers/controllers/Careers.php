<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Careers Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Careers extends MX_Controller {
	
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
		$this->load->model('careers_model');
		$this->load->language('careers');
		$this->load->model('department_model');
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
		$this->acl->restrict('careers.careers.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('careers'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		
		
		
		// render the page
		$this->template->add_css(module_css('careers', 'careers_index'), 'embed');
		$this->template->add_js(module_js('careers', 'careers_index'), 'embed');
		$this->template->write_view('content', 'careers_index', $data);
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
		$this->acl->restrict('careers.careers.list');

		echo $this->careers_model->get_datatables();
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
		$this->acl->restrict('careers.careers.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['page_subhead'] = lang($action . '_subhead');
		$data['action'] = $action;

		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('careers/careers'));
		$this->breadcrumbs->push(lang($action . '_heading'), site_url('careers/careers/' . $action));


		if ($this->input->post())
		{
			if ($career_id = $this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'id' => $career_id, 'action' => $action, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'career_position_title'		=> form_error('career_position_title'),
					'career_dept'				=> form_error('career_dept'),
					'career_req'				=> form_error('career_req'),
					'career_res'				=> form_error('career_res'),
					'career_location'			=> form_error('career_location'),
					'career_latitude'			=> form_error('career_latitude'),
					'career_longitude'			=> form_error('career_longitude'),
					'career_status'				=> form_error('career_status'),
				);
				echo json_encode($response);
				exit;
			}
		}


		if ($action != 'add') $data['record'] = $this->careers_model->find($id);


		if ($action == 'view')
		{
			$this->template->add_js('$(".tab-content :input").attr("disabled", true);', 'embed');
		}

		$data['dept'] = $this->department_model->get_active_dept();

		// render the page
		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_js('npm/tinymce/jquery.tinymce.min.js');

		$this->template->add_css(module_css('careers', 'careers_form'), 'embed');
		$this->template->add_js(module_js('careers', 'careers_form'), 'embed');
		$this->template->write_view('content', 'careers_form', $data);
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
		$this->acl->restrict('careers.careers.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->careers_model->delete($id);

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
		$this->form_validation->set_rules('career_position_title', lang('career_position_title'), 'required');
		$this->form_validation->set_rules('career_dept', lang('career_dept'), 'required');
		$this->form_validation->set_rules('career_req', lang('career_req'), 'required');
		$this->form_validation->set_rules('career_res', lang('career_res'), 'required');
		$this->form_validation->set_rules('career_location', lang('career_location'), 'required');
		$this->form_validation->set_rules('career_latitude', lang('career_latitude'), 'required');
		$this->form_validation->set_rules('career_longitude', lang('career_longitude'), 'required');
		$this->form_validation->set_rules('career_status', lang('career_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'career_position_title'		=> $this->input->post('career_position_title'),
			'career_dept'		=> $this->input->post('career_dept'),
			'career_req'		=> $this->input->post('career_req'),
			'career_res'		=> $this->input->post('career_res'),
			'career_location'		=> $this->input->post('career_location'),
			'career_latitude'		=> $this->input->post('career_latitude'),
			'career_longitude'		=> $this->input->post('career_longitude'),
			'career_status'		=> $this->input->post('career_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->careers_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->careers_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Careers.php */
/* Location: ./application/modules/careers/controllers/Careers.php */