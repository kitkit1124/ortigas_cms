<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Locations Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Locations extends MX_Controller {
	
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
		$this->load->model('locations_model');
		$this->load->language('locations');
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
		$this->acl->restrict('properties.locations.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('locations'));
		
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
		$this->template->add_css(module_css('properties', 'locations_index'), 'embed');
		$this->template->add_js(module_js('properties', 'locations_index'), 'embed');
		$this->template->write_view('content', 'locations_index', $data);
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
		$this->acl->restrict('properties.locations.list');

		echo $this->locations_model->get_datatables();
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
		$this->acl->restrict('properties.locations.' . $action, 'modal');

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
					'location_name'		=> form_error('location_name'),
					'location_image'		=> form_error('location_image'),
					'location_status'		=> form_error('location_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->locations_model->find($id);


		
		$data['image_quality']['size'] = 'Max file size: 1 MB';
		$data['image_quality']['resolution'] = 'Ideal image size: 500 x 500';

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('website', 'banners_index'), 'embed');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');

		$this->template->add_css(module_css('properties', 'locations_form'), 'embed');
		$this->template->add_js(module_js('properties', 'locations_form'), 'embed');
		$this->template->write_view('content', 'locations_form', $data);
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
		$this->acl->restrict('properties.locations.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->locations_model->delete($id);

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
		$this->form_validation->set_rules('location_name', lang('location_name'), 'required');
		$this->form_validation->set_rules('location_image', lang('location_image'), 'required');
		$this->form_validation->set_rules('location_status', lang('location_status'), 'required');


		$name = $this->input->post('location_name');
		$orig_name = $this->input->post('location_name_original');
		$duplicate = $this->locations_model->find_by('location_name', $name);
			
		if ($action == 'edit'){
			if($orig_name == $name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('location_name', lang('location_name'), 'required|is_unique["location_name"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('location_name', lang('location_name'), 'required|is_unique["location_name"]');
			}
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'location_name'		=> $this->input->post('location_name'),
			'location_description'	=> $this->input->post('location_description'),
			'location_image'		=> $this->input->post('location_image'),
			'location_status'		=> $this->input->post('location_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->locations_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->locations_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Locations.php */
/* Location: ./application/modules/properties/controllers/Locations.php */