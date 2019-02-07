<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Jobs Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Jobs extends MX_Controller {
	
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
		$this->load->model('jobs_model');
		$this->load->language('jobs');
		$this->load->model('careers/divisions_model');
		$this->load->model('careers/departments_model');
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
		$this->acl->restrict('careers.jobs.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('jobs'));
		
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
		$this->template->add_css(module_css('careers', 'jobs_index'), 'embed');
		$this->template->add_js(module_js('careers', 'jobs_index'), 'embed');
		$this->template->write_view('content', 'jobs_index', $data);
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
		$this->acl->restrict('careers.jobs.list');

		echo $this->jobs_model->get_datatables();
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
		$this->acl->restrict('careers.jobs.' . $action, 'modal');

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
					'job_career_id'			=> form_error('job_career_id'),
					'job_application_name'	=> form_error('job_application_name'),
					'job_email'				=> form_error('job_email'),
					'job_mobile'			=> form_error('job_mobile'),
					'job_document'			=> form_error('job_document'),
					'job_pitch'				=> form_error('job_pitch'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->jobs_model->find($id);


		$this->load->model('careers_model');
		$careers = $this->careers_model->get_select_careers();
		$data['careers'] = $careers;

		$career = $this->careers_model->find($data['record']->job_career_id);
		$data['divisions'] = $this->divisions_model->where('division_status','Active')->where('division_deleted',0)->find($career->career_div);
		$data['departments'] = $this->departments_model->where('department_status','Active')->where('department_deleted',0)->find($career->career_dept);


		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('careers', 'jobs_form'), 'embed');
		$this->template->add_js(module_js('careers', 'jobs_form'), 'embed');
		$this->template->write_view('content', 'jobs_form', $data);
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
		$this->acl->restrict('careers.jobs.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->jobs_model->delete($id);

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
		$this->form_validation->set_rules('job_career_id', lang('job_career_id'), 'required');
		$this->form_validation->set_rules('job_application_name', lang('job_application_name'), 'required');
		$this->form_validation->set_rules('job_email', lang('job_email'), 'required');
		$this->form_validation->set_rules('job_mobile', lang('job_mobile'), 'required');
		$this->form_validation->set_rules('job_document', lang('job_document'), 'required');
		$this->form_validation->set_rules('job_pitch', lang('job_pitch'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'job_career_id'			=> $this->input->post('job_career_id'),
			'job_application_name'	=> $this->input->post('job_application_name'),
			'job_email'				=> $this->input->post('job_email'),
			'job_mobile'			=> $this->input->post('job_mobile'),
			'job_document'			=> $this->input->post('job_document'),
			'job_pitch'				=> $this->input->post('job_pitch'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->jobs_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->jobs_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Jobs.php */
/* Location: ./application/modules/careers/controllers/Jobs.php */