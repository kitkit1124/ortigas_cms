<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Units Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Units extends MX_Controller {
	
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
		$this->load->model('units_model');
		$this->load->language('units');
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
		$this->acl->restrict('properties.units.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('units'));
		
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
		$this->template->add_css(module_css('properties', 'units_index'), 'embed');
		$this->template->add_js(module_js('properties', 'units_index'), 'embed');
		$this->template->write_view('content', 'units_index', $data);
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
		$this->acl->restrict('properties.units.list');

		echo $this->units_model->get_datatables();
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
		$this->acl->restrict('properties.units.' . $action, 'modal');

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
					'unit_property_id'		=> form_error('unit_property_id'),
					'unit_floor_id'			=> form_error('unit_floor_id'),
					'unit_room_type_id'		=> form_error('unit_room_type_id'),
					'unit_number'			=> form_error('unit_number'),
					'unit_size'				=> form_error('unit_size'),
					'unit_price'			=> form_error('unit_price'),
					'unit_downpayment'		=> form_error('unit_downpayment'),
					'unit_image'			=> form_error('unit_image'),
					'unit_status'			=> form_error('unit_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->units_model->find($id);

		$this->load->model('properties_model');
		$data['properties'] = $this->properties_model->get_active_properties();
		
		if($id) {		

			$unit =  $this->units_model->get_unit($id);		

			$this->load->model('floors_model');
			$floors = $this->floors_model->get_active_floors($unit->property_id);

			if($floors){
				foreach ($floors as $key => $value) {
					$data['floors'][$value->floor_id] = $value->floor_level;
				}
			}

			$this->load->model('room_types_model');
			$room_types = $this->room_types_model->get_active_room_types($unit->property_id);
			
			if($room_types){
				foreach ($room_types as $key => $value) {
					$data['room_types'][$value->room_type_id] = $value->room_type_name;
				}
			}
		}

		$data['image_quality']['size'] = 'Max file size: 1 MB';
		$data['image_quality']['resolution'] = 'Ideal image size: 500 x 500';

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('properties', 'units_form'), 'embed');
		$this->template->add_js(module_js('properties', 'units_form'), 'embed');
		$this->template->write_view('content', 'units_form', $data);
		$this->template->render();
	}

	public function get_floors(){
		if (!$this->input->is_ajax_request()) {	show_404();	}
		$property_id = $_GET['property_id'];
		if($property_id){
			$this->load->model('floors_model');
			$floors = $this->floors_model->get_active_floors($property_id);
			echo json_encode($floors);
		}
	}

	public function get_room_type(){
		if (!$this->input->is_ajax_request()) {	show_404();	}
		$property_id = $_GET['property_id'];
		if($property_id){
			$this->load->model('room_types_model');
			$room_types = $this->room_types_model->get_active_room_types($property_id);
			echo json_encode($room_types);
		}
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
		$this->acl->restrict('properties.units.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->units_model->delete($id);

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
		$this->form_validation->set_rules('unit_property_id', lang('unit_property_id'), 'required');
		$this->form_validation->set_rules('unit_floor_id', lang('unit_floor_id'), 'required');
		$this->form_validation->set_rules('unit_room_type_id', lang('unit_room_type_id'), 'required');
		$this->form_validation->set_rules('unit_number', lang('unit_number'), 'required');
		// $this->form_validation->set_rules('unit_size', lang('unit_size'), 'required');
		// $this->form_validation->set_rules('unit_price', lang('unit_price'), 'required');
		// $this->form_validation->set_rules('unit_downpayment', lang('unit_downpayment'), 'required');
		$this->form_validation->set_rules('unit_image', lang('unit_image'), 'required');
		$this->form_validation->set_rules('unit_status', lang('unit_status'), 'required');

		$pid =  $this->input->post('unit_property_id');
		$fid =  $this->input->post('unit_floor_id');
		$rid =  $this->input->post('unit_room_type_id');
		$name =  $this->input->post('unit_number');
		$con_name =  $pid.$fid.$rid.$name;
		$orig_name = $this->input->post('unit_property_id_original').$this->input->post('unit_floor_id_original').$this->input->post('unit_room_type_id_original').$this->input->post('unit_number_original');
		$duplicate = $this->units_model->find_by(
			array(
				'unit_property_id'	=>$pid,
				'unit_floor_id' 	=>$fid,
				'unit_room_type_id' =>$rid,
				'unit_number'		=>$name,
				'unit_deleted' 		=> 0

			)
		);
			
		if ($action == 'edit'){
			if($orig_name == $con_name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('unit_number', lang('unit_number'), 'required|is_unique["unit_number"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('unit_number', lang('unit_number'), 'required|is_unique["unit_number"]');
			}
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'unit_property_id'		=> $this->input->post('unit_property_id'),
			'unit_floor_id'		=> $this->input->post('unit_floor_id'),
			'unit_room_type_id'		=> $this->input->post('unit_room_type_id'),
			'unit_number'		=> $this->input->post('unit_number'),
			'unit_size'		=> $this->input->post('unit_size'),
			'unit_price'		=> $this->input->post('unit_price'),
			'unit_downpayment'		=> $this->input->post('unit_downpayment'),
			'unit_image'		=> $this->input->post('unit_image'),
			'unit_status'		=> $this->input->post('unit_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->units_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->units_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Units.php */
/* Location: ./application/modules/properties/controllers/Units.php */