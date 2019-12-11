<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Sellers Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Sellers extends MX_Controller {
	
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
		$this->load->model('sellers_model');
		$this->load->language('sellers');
		$this->load->model('seller_groups/seller_groups_model');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('sellers.sellers.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('sellers'));
		
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
		$this->template->add_css(module_css('sellers', 'sellers_index'), 'embed');
		$this->template->add_js(module_js('sellers', 'sellers_index'), 'embed');
		$this->template->write_view('content', 'sellers_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('sellers.sellers.list');

		echo $this->sellers_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('sellers.sellers.' . $action, 'modal');

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
					'seller_first_name'		=> form_error('seller_first_name'),
					'seller_middle_name'		=> form_error('seller_middle_name'),
					'seller_last_name'		=> form_error('seller_last_name'),
					'seller_email'		=> form_error('seller_email'),
					'seller_mobile'		=> form_error('seller_mobile'),
					'seller_address'		=> form_error('seller_address'),
					'seller_group_id'		=> form_error('seller_group_id'),
					'seller_status'		=> form_error('seller_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->sellers_model->find($id);

		$data['seller_groups'] = $this->seller_groups_model
			->where('seller_group_deleted', 0)
			->where('seller_group_status', 'Active')
			->format_dropdown('seller_group_id', 'seller_group_name', TRUE);
	

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('sellers', 'sellers_form'), 'embed');
		$this->template->add_js(module_js('sellers', 'sellers_form'), 'embed');
		$this->template->write_view('content', 'sellers_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('sellers.sellers.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->sellers_model->delete($id);

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
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('seller_first_name', lang('seller_first_name'), 'required');
		$this->form_validation->set_rules('seller_middle_name', lang('seller_middle_name'), 'required');
		$this->form_validation->set_rules('seller_last_name', lang('seller_last_name'), 'required');
		$this->form_validation->set_rules('seller_email', lang('seller_email'), 'required');
		$this->form_validation->set_rules('seller_mobile', lang('seller_mobile'), 'required');
		$this->form_validation->set_rules('seller_address', lang('seller_address'), 'required');
		$this->form_validation->set_rules('seller_group_id', lang('seller_group_id'), 'required');
		$this->form_validation->set_rules('seller_status', lang('seller_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'seller_first_name'		=> $this->input->post('seller_first_name'),
			'seller_middle_name'		=> $this->input->post('seller_middle_name'),
			'seller_last_name'		=> $this->input->post('seller_last_name'),
			'seller_email'		=> $this->input->post('seller_email'),
			'seller_mobile'		=> $this->input->post('seller_mobile'),
			'seller_address'		=> $this->input->post('seller_address'),
			'seller_group_id'		=> $this->input->post('seller_group_id'),
			'seller_status'		=> $this->input->post('seller_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->sellers_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->sellers_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Sellers.php */
/* Location: ./application/modules/sellers/controllers/Sellers.php */