<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Reservations Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Reservations extends MX_Controller {
	
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
		$this->load->model('reservations_model');
		$this->load->language('reservations');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('reservations.reservations.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('reservations'));
		
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
		$this->template->add_css(module_css('reservations', 'reservations_index'), 'embed');
		$this->template->add_js(module_js('reservations', 'reservations_index'), 'embed');
		$this->template->write_view('content', 'reservations_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('reservations.reservations.list');

		echo $this->reservations_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('reservations.reservations.' . $action, 'modal');

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
					'reservation_reference_no'		=> form_error('reservation_reference_no'),
					'reservation_project'		=> form_error('reservation_project'),
					'reservation_property_specialist'		=> form_error('reservation_property_specialist'),
					'reservation_sellers_group'		=> form_error('reservation_sellers_group'),
					'reservation_unit_details'		=> form_error('reservation_unit_details'),
					'reservation_allocation'		=> form_error('reservation_allocation'),
					'reservation_fee'		=> form_error('reservation_fee'),
					'reservation_notes'		=> form_error('reservation_notes'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->reservations_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('reservations', 'reservations_form'), 'embed');
		$this->template->add_js(module_js('reservations', 'reservations_form'), 'embed');
		$this->template->write_view('content', 'reservations_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('reservations.reservations.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->reservations_model->delete($id);

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
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('reservation_reference_no', lang('reservation_reference_no'), 'required');
		$this->form_validation->set_rules('reservation_project', lang('reservation_project'), 'required');
		$this->form_validation->set_rules('reservation_property_specialist', lang('reservation_property_specialist'), 'required');
		$this->form_validation->set_rules('reservation_sellers_group', lang('reservation_sellers_group'), 'required');
		$this->form_validation->set_rules('reservation_unit_details', lang('reservation_unit_details'), 'required');
		$this->form_validation->set_rules('reservation_allocation', lang('reservation_allocation'), 'required');
		$this->form_validation->set_rules('reservation_fee', lang('reservation_fee'), 'required');
		$this->form_validation->set_rules('reservation_notes', lang('reservation_notes'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'reservation_reference_no'		=> $this->input->post('reservation_reference_no'),
			'reservation_project'		=> $this->input->post('reservation_project'),
			'reservation_property_specialist'		=> $this->input->post('reservation_property_specialist'),
			'reservation_sellers_group'		=> $this->input->post('reservation_sellers_group'),
			'reservation_unit_details'		=> $this->input->post('reservation_unit_details'),
			'reservation_allocation'		=> $this->input->post('reservation_allocation'),
			'reservation_fee'		=> $this->input->post('reservation_fee'),
			'reservation_notes'		=> $this->input->post('reservation_notes'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->reservations_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->reservations_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Reservations.php */
/* Location: ./application/modules/reservations/controllers/Reservations.php */