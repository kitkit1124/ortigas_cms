<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Estates Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Estates extends MX_Controller {
	
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
		$this->load->model('estates_model');
		$this->load->language('estates');
		$this->load->model('related_links_model');
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
		$this->acl->restrict('properties.estates.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('estates'));
		
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
		$this->template->add_css(module_css('properties', 'estates_index'), 'embed');
		$this->template->add_js(module_js('properties', 'estates_index'), 'embed');
		$this->template->write_view('content', 'estates_index', $data);
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
		$this->acl->restrict('properties.estates.list');

		echo $this->estates_model->get_datatables();
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
		$this->acl->restrict('properties.estates.' . $action, 'modal');

		// page title
		$data['page_heading'] = lang($action . '_heading');
		$data['page_subhead'] = lang($action . '_subhead');
		$data['action'] = $action;

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('properties/estates'));
		$this->breadcrumbs->push(lang($action . '_heading'), site_url('properties/estates/' . $action));

		if ($this->input->post())
		{
			if ($estate_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $estate_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'estate_name'			=> form_error('estate_name'),
					'estate_slug'			=> form_error('estate_slug'),
					'estate_text'			=> form_error('estate_text'),
					'estate_bottom_text'			=> form_error('estate_bottom_text'),
					'estate_latitude'		=> form_error('estate_latitude'),
					'estate_longtitude'		=> form_error('estate_longtitude'),
					'estate_image'			=> form_error('estate_image'),
					'estate_thumb'			=> form_error('estate_thumb'),
					'estate_status'			=> form_error('estate_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') {
			$data['record'] = $this->estates_model->find($id);

			// get the banners
			$this->load->model('image_sliders_model');
			$data['sliders'] = $this->image_sliders_model
				->where('image_slider_deleted', 0)
				->where('image_slider_section_id', $id)
				->where('image_slider_section_type', 'estates')
				->order_by('image_slider_order', 'asc')
				->order_by('image_slider_id', 'desc')
				->find_all();
		}


		
		if ($action == 'view')
		{
			$this->template->add_js('$(".tab-content :input").attr("disabled", true);', 'embed');
		}

		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_js('npm/tinymce/jquery.tinymce.min.js');

		$this->template->add_css(module_css('properties', 'related_links_index'), 'embed');
		$this->template->add_js(module_js('properties', 'related_links_index'), 'embed');

		// render the page
		$this->template->add_css(module_css('properties', 'estates_form'), 'embed');
		$this->template->add_js(module_js('properties', 'estates_form'), 'embed');
		$this->template->write_view('content', 'estates_form', $data);
		$this->template->render();
	}



	function form_upload($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('properties.estates.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($estate_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $estate_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'estate_name'			=> form_error('estate_name'),
					'estate_slug'			=> form_error('estate_slug'),
					'estate_text'			=> form_error('estate_text'),
					'estate_latitude'		=> form_error('estate_latitude'),
					'estate_longtitude'		=> form_error('estate_longtitude'),
					'estate_image'			=> form_error('estate_image'),
					'estate_thumb'			=> form_error('estate_thumb'),
					'estate_status'			=> form_error('estate_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('properties', 'form_upload'), 'embed');
		$this->template->add_js(module_js('properties', 'estates_form_image'), 'embed');
		$this->template->write_view('content', 'form_upload', $data);
		$this->template->render();
	}


	function form_upload_thumb($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('properties.estates.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($estate_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $estate_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'estate_name'			=> form_error('estate_name'),
					'estate_slug'			=> form_error('estate_slug'),
					'estate_text'			=> form_error('estate_text'),
					'estate_latitude'		=> form_error('estate_latitude'),
					'estate_longtitude'		=> form_error('estate_longtitude'),
					'estate_image'			=> form_error('estate_image'),
					'estate_thumb'			=> form_error('estate_thumb'),
					'estate_status'			=> form_error('estate_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('properties', 'form_upload'), 'embed');
		$this->template->add_js(module_js('properties', 'estates_form_thumb'), 'embed');
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
		$this->acl->restrict('properties.estates.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->estates_model->delete($id);

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
		$this->form_validation->set_rules('estate_name', lang('estate_name'), 'required');
		$this->form_validation->set_rules('estate_text', lang('estate_text'), 'required');
		$this->form_validation->set_rules('estate_latitude', lang('estate_latitude'), 'max_length[255]');
		$this->form_validation->set_rules('estate_longtitude', lang('estate_longtitude'), 'max_length[255]');
		$this->form_validation->set_rules('estate_image', lang('estate_image'), 'required');
		$this->form_validation->set_rules('estate_thumb', lang('estate_thumb'), 'required');
		$this->form_validation->set_rules('estate_status', lang('estate_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		$name = $this->input->post('estate_name');
		$orig_name = $this->input->post('estate_name_original');
		$duplicate = $this->estates_model->find_by(array('estate_name' => $name, 'estate_deleted' => 0));
			
		if ($action == 'edit'){
			if($orig_name == $name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('estate_name', lang('estate_name'), 'required|is_unique["estate_name"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('estate_name', lang('estate_name'), 'required|is_unique["estate_name"]');
			}
		}

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'estate_name'			=> $this->input->post('estate_name'),
			'estate_slug'			=> url_title($this->input->post('estate_name'), '-', TRUE),
			'estate_text'			=> $this->input->post('estate_text'),
			'estate_bottom_text'	=> $this->input->post('estate_bottom_text'),
			'estate_latitude'		=> $this->input->post('estate_latitude'),
			'estate_longtitude'		=> $this->input->post('estate_longtitude'),
			'estate_image'			=> $this->input->post('estate_image'),
			'estate_alt_image'		=> $this->input->post('estate_alt_image'),
			'estate_thumb'			=> $this->input->post('estate_thumb'),
			'estate_alt_thumb'		=> $this->input->post('estate_alt_thumb'),
			'estate_status'			=> $this->input->post('estate_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->estates_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->estates_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Estates.php */
/* Location: ./application/modules/properties/controllers/Estates.php */