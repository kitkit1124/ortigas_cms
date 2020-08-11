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
		$this->load->model('departments_model');
		$this->load->model('divisions_model');
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
					'career_div'				=> form_error('career_div'),
					'career_image'				=> form_error('career_image'),
					'career_req'				=> form_error('career_req'),
					'career_res'				=> form_error('career_res'),
					'career_location'			=> form_error('career_location'),
					'career_latitude'			=> form_error('career_latitude'),
					'career_longitude'			=> form_error('career_longitude'),
					'career_status'				=> form_error('career_status'),
					'career_slug'				=> form_error('career_slug'),
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

		$data['divisions'] = $this->divisions_model->get_select_divisions();
		
		if($id) {		
			$career =  $this->careers_model->find($id); 

			$data['departments'] = $this->departments_model->get_departments($career->career_div);		

		}

		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

		// render the page
		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_js('npm/tinymce/jquery.tinymce.min.js');

		$this->template->add_css(module_css('website', 'banners_index'), 'embed');
		$this->template->add_css(module_css('careers', 'careers_form'), 'embed');
		$this->template->add_js(module_js('careers', 'careers_form'), 'embed');
		$this->template->write_view('content', 'careers_form', $data);
		$this->template->render();
	}

	public function get_divisions(){
		if (!$this->input->is_ajax_request()) {	show_404();	}
		$department_id = $_GET['department_id'];
		if($department_id){
			$this->load->model('divisions_model');
			$divisions = $this->divisions_model->get_active_divisions($department_id);
			echo json_encode($divisions);
		}
	}

	public function get_departments(){
		if (!$this->input->is_ajax_request()) {	show_404();	}
		$division_id = $_GET['division_id'];
		if($division_id){
			$this->load->model('departments_model');
			$departments = $this->departments_model->get_active_divisions_form($division_id);
			echo json_encode($departments);
		}
	}

	function form_upload($action = 'add', $id = FALSE)
	{
		// $this->acl->restrict('properties.properties.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($post_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $post_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('careers', 'form_upload'), 'embed');
		$this->template->add_js(module_js('careers', 'form_upload'), 'embed');
		$this->template->write_view('content', 'form_upload', $data);
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
		$this->form_validation->set_rules('career_div', lang('career_div'), 'required');
		$this->form_validation->set_rules('career_image', lang('career_image'), 'required');
		$this->form_validation->set_rules('career_req', lang('career_req'), 'required');
		$this->form_validation->set_rules('career_res', lang('career_res'), 'required');
		$this->form_validation->set_rules('career_location', lang('career_location'), 'required');
		$this->form_validation->set_rules('career_latitude', lang('career_latitude'), 'required');
		$this->form_validation->set_rules('career_longitude', lang('career_longitude'), 'required');
		$this->form_validation->set_rules('career_status', lang('career_status'), 'required');


		$div =  $this->input->post('career_div');
		$dept =  $this->input->post('career_dept');
		$name =  $this->input->post('career_position_title');
		$con_name =  $div.$dept.$name;
		$orig_name = $this->input->post('career_div_original').$this->input->post('career_dept_original').$this->input->post('career_position_title_original');
		$duplicate = $this->careers_model->find_by(
			array(
				'career_div' 	=>$div,
				'career_dept' =>$dept,
				'career_position_title'	=>$name,
				'career_deleted'	=> 0,

			)
		);
			
		if ($action == 'edit'){
			if($orig_name == $con_name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('career_position_title', lang('career_position_title'), 'required|is_unique["career_position_title"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('career_position_title', lang('career_position_title'), 'required|is_unique["career_position_title"]');
			}
		}


		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$slug = url_title($this->input->post('career_position_title'), '-', TRUE);

		if($this->input->post('career_slug') && $this->input->post('career_slug')){
			$slug = $this->input->post('career_slug');
		}

		$data = array(
			'career_position_title'		=> $this->input->post('career_position_title'),
			'career_slug'				=> $slug,
			'career_dept'				=> $this->input->post('career_dept'),
			'career_div'				=> $this->input->post('career_div'),
			'career_image'				=> $this->input->post('career_image'),
			'career_alt_image'			=> $this->input->post('career_alt_image'),
			'career_req'				=> utf8_encode($this->input->post('career_req')),
			'career_res'				=> utf8_encode($this->input->post('career_res')),
			'career_location'			=> $this->input->post('career_location'),
			'career_latitude'			=> $this->input->post('career_latitude'),
			'career_longitude'			=> $this->input->post('career_longitude'),
			'career_status'				=> $this->input->post('career_status'),
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