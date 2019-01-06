<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Divisions Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Divisions extends MX_Controller {
	
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
		$this->load->model('divisions_model');
		$this->load->model('departments_model');
		$this->load->language('divisions');
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
		$this->acl->restrict('careers.divisions.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('divisions'));
		
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
		$this->template->add_css(module_css('careers', 'divisions_index'), 'embed');
		$this->template->add_js(module_js('careers', 'divisions_index'), 'embed');
		$this->template->write_view('content', 'divisions_index', $data);
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
		$this->acl->restrict('careers.divisions.list');

		echo $this->divisions_model->get_datatables();
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
		$this->acl->restrict('careers.divisions.' . $action, 'modal');

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
					'division_name'		=> form_error('division_name'),
					'division_status'		=> form_error('division_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->divisions_model->find($id);


		$data['departments'] = $this->departments_model->get_active_departments();

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('careers', 'divisions_form'), 'embed');
		$this->template->add_js(module_js('careers', 'divisions_form'), 'embed');
		$this->template->write_view('content', 'divisions_form', $data);
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
		$this->acl->restrict('careers.divisions.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->divisions_model->delete($id);

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
		// $this->form_validation->set_rules('division_department_id', lang('division_department_id'), 'required');
		$this->form_validation->set_rules('division_name', lang('division_name'), 'required');
		$this->form_validation->set_rules('division_status', lang('division_status'), 'required');


		// $did =  $this->input->post('division_department_id');
		$name =  $this->input->post('division_name');
		// $idname =  $this->input->post('division_department_id').$this->input->post('division_name');
		$orig_name = $this->input->post('division_name').$this->input->post('division_name_original');
		$duplicate = $this->divisions_model->find_by(array('division_name'=>$name, 'division_deleted'=>0));
			
		if ($action == 'edit'){
			if($orig_name == $name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('division_name', lang('division_name'), 'required|is_unique["division_name"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('division_name', lang('division_name'), 'required|is_unique["division_name"]');
			}
		}
		
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			// 'division_department_id'		=> $this->input->post('division_department_id'),
			'division_name'					=> $this->input->post('division_name'),
			'division_status'				=> $this->input->post('division_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->divisions_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->divisions_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Divisions.php */
/* Location: ./application/modules/careers/controllers/Divisions.php */