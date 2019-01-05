<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Subscribers Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		OCLP Administrator <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Subscribers extends MX_Controller {
	
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
		$this->load->model('subscribers_model');
		$this->load->language('subscribers');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	OCLP Administrator <webdevs@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('subscribers.subscribers.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('subscribers'));
		
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
		$this->template->add_css(module_css('subscribers', 'subscribers_index'), 'embed');
		$this->template->add_js(module_js('subscribers', 'subscribers_index'), 'embed');
		$this->template->write_view('content', 'subscribers_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	OCLP Administrator <webdevs@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('subscribers.subscribers.list');

		echo $this->subscribers_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	OCLP Administrator <webdevs@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('subscribers.subscribers.' . $action, 'modal');

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
					'subscriber_email'		=> form_error('subscriber_email'),
					'subscriber_status'		=> form_error('subscriber_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->subscribers_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('subscribers', 'subscribers_form'), 'embed');
		$this->template->add_js(module_js('subscribers', 'subscribers_form'), 'embed');
		$this->template->write_view('content', 'subscribers_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	OCLP Administrator <webdevs@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('subscribers.subscribers.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->subscribers_model->delete($id);

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
	 * @author 	OCLP Administrator <webdevs@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('subscriber_email', lang('subscriber_email'), 'required|valid_email');
		$this->form_validation->set_rules('subscriber_status', lang('subscriber_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'subscriber_email'		=> $this->input->post('subscriber_email'),
			'subscriber_status'		=> $this->input->post('subscriber_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->subscribers_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->subscribers_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Subscribers.php */
/* Location: ./application/modules/subscribers/controllers/Subscribers.php */