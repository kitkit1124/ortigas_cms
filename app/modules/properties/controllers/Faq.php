<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * property_faq Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Faq extends MX_Controller {
	
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
		$this->load->model('faq_model');
		$this->load->language('faq');
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
		$fields_data = [ 
			'property_id' 	=> $this->input->get('property_id')
		]; 
		echo $this->faq_model->get_datatables($fields_data);
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
		$this->acl->restrict('properties.property_faq.' . $action, 'modal');

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
					'faq_topic'		=> form_error('faq_topic'),
					'faq_answer'			=> form_error('faq_answer'),
					'faq_status'		=> form_error('faq_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->faq_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('properties', 'faq_form'), 'embed');
		$this->template->add_js(module_js('properties', 'faq_form'), 'embed');
		$this->template->write_view('content', 'faq_form', $data);
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
		$this->acl->restrict('properties.property_faq.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables_faq';

		if ($this->input->post())
		{
			$this->faq_model->delete($id);

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
		$this->form_validation->set_rules('faq_topic', lang('faq_topic'), 'required');
		$this->form_validation->set_rules('faq_answer', lang('faq_answer'), 'required');
		$this->form_validation->set_rules('faq_status', lang('faq_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'faq_property_id'	=> $this->input->post('faq_property_id'),
			'faq_topic'			=> $this->input->post('faq_topic'),
			'faq_answer'		=> $this->input->post('faq_answer'),
			'faq_status'		=> $this->input->post('faq_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->faq_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->faq_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file property_faq.php */
/* Location: ./application/modules/properties/controllers/property_faq.php */