<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Room_types Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Room_types extends MX_Controller {
	
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
		$this->load->model('room_types_model');
		$this->load->language('room_types');
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
		$this->acl->restrict('properties.room_types.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('room_types'));
		
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
		$this->template->add_css(module_css('properties', 'room_types_index'), 'embed');
		$this->template->add_js(module_js('properties', 'room_types_index'), 'embed');
		$this->template->write_view('content', 'room_types_index', $data);
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
		$this->acl->restrict('properties.room_types.list');

		echo $this->room_types_model->get_datatables();
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
		$this->acl->restrict('properties.room_types.' . $action, 'modal');

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
					'room_type_property_id'		=> form_error('room_type_property_id'),
					'room_type_name'		=> form_error('room_type_name'),
					'room_type_image'		=> form_error('room_type_image'),
					'room_type_status'		=> form_error('room_type_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->room_types_model->find($id);

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
		$this->template->add_css(module_css('properties', 'room_types_form'), 'embed');
		$this->template->add_js(module_js('properties', 'room_types_form'), 'embed');
		$this->template->write_view('content', 'room_types_form', $data);
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
		$this->acl->restrict('properties.room_types.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->room_types_model->delete($id);

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
		$this->form_validation->set_rules('room_type_property_id', lang('room_type_property_id'), 'required');
		$this->form_validation->set_rules('room_type_name', lang('room_type_name'), 'required');
		$this->form_validation->set_rules('room_type_image', lang('room_type_image'), 'required');
		$this->form_validation->set_rules('room_type_status', lang('room_type_status'), 'required');

		$pid =  $this->input->post('room_type_property_id');
		$name =  $this->input->post('room_type_name');
		$idname =  $this->input->post('room_type_property_id').$this->input->post('room_type_name');
		$orig_name = $this->input->post('room_type_property_id_original').$this->input->post('room_type_name_original');
		$duplicate = $this->room_types_model->find_by(array('room_type_property_id'=>$pid, 'room_type_name'=>$name, 'room_type_deleted' => 0));
			
		if ($action == 'edit'){
			if($orig_name == $idname){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('room_type_name', lang('room_type_name'), 'required|is_unique["room_type_name"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('room_type_name', lang('room_type_name'), 'required|is_unique["room_type_name"]');
			}
		}
		
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'room_type_property_id'	=> $this->input->post('room_type_property_id'),
			'room_type_name'		=> $this->input->post('room_type_name'),
			'room_type_image'		=> $this->input->post('room_type_image'),
			'room_type_alt_image'	=> $this->input->post('room_type_alt_image'),
			'room_type_status'		=> $this->input->post('room_type_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->room_types_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->room_types_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Room_types.php */
/* Location: ./application/modules/properties/controllers/Room_types.php */