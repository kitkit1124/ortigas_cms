<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Floors Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Floors extends MX_Controller {
	
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
		$this->load->model('floors_model');
		$this->load->language('floors');
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
		$this->acl->restrict('properties.floors.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('floors'));
		
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
		$this->template->add_css(module_css('properties', 'floors_index'), 'embed');
		$this->template->add_js(module_js('properties', 'floors_index'), 'embed');
		$this->template->write_view('content', 'floors_index', $data);
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
		$this->acl->restrict('properties.floors.list');

		echo $this->floors_model->get_datatables();
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
		$this->acl->restrict('properties.floors.' . $action, 'modal');

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
					'floor_property_id'		=> form_error('floor_property_id'),
					'floor_level'		=> form_error('floor_level'),
					'floor_image'		=> form_error('floor_image'),
					'floor_status'		=> form_error('floor_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->floors_model->find($id);

		$this->load->model('properties_model');
		$data['properties'] = $this->properties_model->get_active_properties();
		$data['image_quality']['size'] = 'Max file size: 1 MB';
		$data['image_quality']['resolution'] = 'Ideal image size: 500 x 500';

		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('website', 'banners_index'), 'embed');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('properties', 'floors_form'), 'embed');
		$this->template->add_js(module_js('properties', 'floors_form'), 'embed');
		$this->template->write_view('content', 'floors_form', $data);
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
		$this->acl->restrict('properties.floors.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->floors_model->delete($id);

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
		$this->form_validation->set_rules('floor_property_id', lang('floor_property_id'), 'required');
		$this->form_validation->set_rules('floor_level', lang('floor_level'), 'required');
		$this->form_validation->set_rules('floor_image', lang('floor_image'), 'required');
		$this->form_validation->set_rules('floor_status', lang('floor_status'), 'required');

		$pid =  $this->input->post('floor_property_id');
		$name =  $this->input->post('floor_level');
		$idname =  $this->input->post('floor_property_id').$this->input->post('floor_level');
		$orig_name = $this->input->post('floor_property_id_original').$this->input->post('floor_level_original');
		$duplicate = $this->floors_model->find_by(array('floor_property_id'=>$pid, 'floor_level'=>$name, 'floor_deleted' => 0)); 
			
		if ($action == 'edit'){
			if($orig_name == $idname){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('floor_level', lang('floor_level'), 'required|is_unique["floor_level"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('floor_level', lang('floor_level'), 'required|is_unique["floor_level"]');
			}
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'floor_property_id'		=> $this->input->post('floor_property_id'),
			'floor_level'			=> $this->input->post('floor_level'),
			'floor_image'			=> $this->input->post('floor_image'),
			'floor_alt_image'		=> $this->input->post('floor_alt_image'),
			'floor_status'			=> $this->input->post('floor_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->floors_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->floors_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Floors.php */
/* Location: ./application/modules/properties/controllers/Floors.php */