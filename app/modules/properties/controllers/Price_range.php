<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Price_range Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Price_range extends MX_Controller {
	
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
		$this->load->model('price_range_model');
		$this->load->language('price_range');
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
		$this->acl->restrict('properties.price_range.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('price_range'));
		
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
		$this->template->add_css(module_css('properties', 'price_range_index'), 'embed');
		$this->template->add_js(module_js('properties', 'price_range_index'), 'embed');
		$this->template->write_view('content', 'price_range_index', $data);
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
		$this->acl->restrict('properties.price_range.list');

		echo $this->price_range_model->get_datatables();
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
		$this->acl->restrict('properties.price_range.' . $action, 'modal');

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
					'price_range_label'		=> form_error('price_range_label'),
					'price_range_min'		=> form_error('price_range_min'),
					'price_range_max'		=> form_error('price_range_max'),
					'price_range_status'		=> form_error('price_range_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->price_range_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('properties', 'price_range_form'), 'embed');
		$this->template->add_js(module_js('properties', 'price_range_form'), 'embed');
		$this->template->write_view('content', 'price_range_form', $data);
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
		$this->acl->restrict('properties.price_range.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->price_range_model->delete($id);

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
		$this->form_validation->set_rules('price_range_label', lang('price_range_label'), 'required');
		$this->form_validation->set_rules('price_range_min', lang('price_range_min'), 'required|numeric');
		$this->form_validation->set_rules('price_range_max', lang('price_range_max'), 'required|numeric');
		$this->form_validation->set_rules('price_range_status', lang('price_range_status'), 'required');


		$name = $this->input->post('price_range_label');
		$orig_name = $this->input->post('price_range_label_original');
		$duplicate = $this->price_range_model->find_by('price_range_label', $name);
			
		if ($action == 'edit'){
			if($orig_name == $name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('price_range_label', lang('price_range_label'), 'required|is_unique["price_range_label"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('price_range_label', lang('price_range_label'), 'required|is_unique["price_range_label"]');
			}
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'price_range_label'		=> $this->input->post('price_range_label'),
			'price_range_min'		=> $this->input->post('price_range_min'),
			'price_range_max'		=> $this->input->post('price_range_max'),
			'price_range_status'		=> $this->input->post('price_range_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->price_range_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->price_range_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Price_range.php */
/* Location: ./application/modules/properties/controllers/Price_range.php */