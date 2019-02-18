<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Messages Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Messages extends MX_Controller {
	
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
		$this->load->model('messages_model');
		$this->load->model('properties/properties_model');
		$this->load->model('properties/estates_model');
		$this->load->model('properties/property_lease_spaces_model');
		$this->load->model('careers/careers_model');
		$this->load->model('website/posts_model');
		$this->load->language('messages');
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
		$this->acl->restrict('messages.messages.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('messages'));
		
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
		$this->template->add_css(module_css('messages', 'messages_index'), 'embed');
		$this->template->add_js(module_js('messages', 'messages_index'), 'embed');
		$this->template->write_view('content', 'messages_index', $data);
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
		$this->acl->restrict('messages.messages.list');

		echo $this->messages_model->get_datatables();
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
		$this->acl->restrict('messages.messages.' . $action, 'modal');

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
					'message_type'			=> form_error('message_type'),			
					'message_section'		=> form_error('message_section'),
					'message_section_id'	=> form_error('message_section_id'),
					'message_name'			=> form_error('message_name'),
					'message_email'			=> form_error('message_email'),
					'message_mobile'		=> form_error('message_mobile'),
					'message_location'		=> form_error('message_location'),
					'message_content'		=> form_error('message_content'),
					'message_status'		=> form_error('message_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add')
		$record = $this->messages_model->find($id);


		$data['record'] = $record;

		$section = $record->message_section;
        $section_id = $record->message_section_id;

		if(isset($section_id) && $section_id > 0){
			if($section == 'Estates'){
				$sec_data = $this->estates_model->find($section_id);
				$message_section_id = $sec_data->estate_name;
			}
			else if($section == 'Leasing Inquiry'){
				$sec_data = $this->property_lease_spaces_model->find($section_id);
				$message_section_id = $sec_data->lease_name;
			}
			else if($section == 'Career Inquiry'){
				$sec_data = $this->careers_model->find($section_id);
				$message_section_id = $sec_data->career_position_title;
			}
			else if($section == 'Residences' || $section == 'Malls' || $section == 'Offices' || $section == 'Sales Inquiry'){
				$sec_data = $this->properties_model->find($section_id);
				$message_section_id = $sec_data->property_name;
			}
		}
		else{
			$message_section_id = 'General';
		}


		$data['section'] = $message_section_id;

		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('messages', 'messages_form'), 'embed');
		$this->template->add_js(module_js('messages', 'messages_form'), 'embed');
		$this->template->write_view('content', 'messages_form', $data);
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
		$this->acl->restrict('messages.messages.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->messages_model->delete($id);

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
		$this->form_validation->set_rules('message_type', lang('message_type'), 'required');
		$this->form_validation->set_rules('message_section', lang('message_section'), 'required');
		$this->form_validation->set_rules('message_section_id', lang('message_section_id'), 'required');
		$this->form_validation->set_rules('message_name', lang('message_name'), 'required');
		$this->form_validation->set_rules('message_email', lang('message_email'), 'required');
		$this->form_validation->set_rules('message_mobile', lang('message_mobile'), 'required');
		$this->form_validation->set_rules('message_location', lang('message_location'), 'required');
		$this->form_validation->set_rules('message_status', lang('message_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'message_type'			=> $this->input->post('message_type'),
			'message_section'		=> $this->input->post('message_section'),
			'message_section_id'	=> $this->input->post('message_section_id'),
			'message_name'			=> $this->input->post('message_name'),
			'message_email'			=> $this->input->post('message_email'),
			'message_mobile'		=> $this->input->post('message_mobile'),
			'message_location'		=> $this->input->post('message_location'),
			'message_content'		=> $this->input->post('message_content'),
			'message_status'		=> $this->input->post('message_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->messages_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->messages_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Messages.php */
/* Location: ./application/modules/messages/controllers/Messages.php */