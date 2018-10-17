<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Searches Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Searches extends MX_Controller {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */
	function __construct()
	{
		parent::__construct();

		if (! $this->db->table_exists('property_locations'))
		{
			show_error('This page requires the Property module');
		}

		$this->load->library('users/acl');
		$this->load->model('searches_model');
		$this->load->language('searches');
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
		$this->acl->restrict('reports.searches.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('searches'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		$data['searches_keyword'] = $this->searches_model->find_all();

		$data['searches_category'] = $this->searches_model->get_search_result('search_cat_id');
		$data['searches_location'] = $this->searches_model->get_search_result('search_loc_id');
		$data['searches_price']	   = $this->searches_model->get_search_result('search_price_id');
		
		// render the page
		$this->template->add_css(module_css('reports', 'searches_index'), 'embed');
		$this->template->add_js(module_js('reports', 'searches_index'), 'embed');
		$this->template->write_view('content', 'searches_index', $data);
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
		$this->acl->restrict('reports.searches.list');

		echo $this->searches_model->get_datatables();
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
		$this->acl->restrict('reports.searches.' . $action, 'modal');

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
					'search_keyword'		=> form_error('search_keyword'),
					'search_cat_id'		=> form_error('search_cat_id'),
					'search_price_id'		=> form_error('search_price_id'),
					'search_loc_id'		=> form_error('search_loc_id'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->searches_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('reports', 'searches_form'), 'embed');
		$this->template->add_js(module_js('reports', 'searches_form'), 'embed');
		$this->template->write_view('content', 'searches_form', $data);
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
		$this->acl->restrict('reports.searches.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->searches_model->delete($id);

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
		$this->form_validation->set_rules('search_keyword', lang('search_keyword'), 'required');
		$this->form_validation->set_rules('search_cat_id', lang('search_cat_id'), 'required');
		$this->form_validation->set_rules('search_price_id', lang('search_price_id'), 'required');
		$this->form_validation->set_rules('search_loc_id', lang('search_loc_id'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'search_keyword'		=> $this->input->post('search_keyword'),
			'search_cat_id'		=> $this->input->post('search_cat_id'),
			'search_price_id'		=> $this->input->post('search_price_id'),
			'search_loc_id'		=> $this->input->post('search_loc_id'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->searches_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->searches_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Searches.php */
/* Location: ./application/modules/reports/controllers/Searches.php */