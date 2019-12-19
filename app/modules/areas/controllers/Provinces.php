<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Provinces Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Provinces extends MX_Controller 
{
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
		$this->load->model('provinces_model');
		$this->load->language('provinces');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('areas.provinces.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('provinces'));
		
		// datatables
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		// render the page
		$this->template->add_css(module_css('areas', 'provinces_index'), 'embed');
		$this->template->add_js(module_js('areas', 'provinces_index'), 'embed');
		$this->template->write_view('content', 'provinces_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('areas.provinces.list');

		echo $this->provinces_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('areas.provinces.' . $action, 'modal');

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
					'province_code'			=> form_error('province_code'),
					'province_name'			=> form_error('province_name'),
					'province_region'		=> form_error('province_region'),
					'province_country'		=> form_error('province_country'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->provinces_model->find($id);

		// get the countries
		$this->load->model('countries_model');
		$data['countries'] = $this->countries_model
			->where('country_deleted', 0)
			->order_by('country_name', 'asc')
			->format_dropdown('country_code2', 'country_name', TRUE);

		// get the regions
		$this->load->model('regions_model');
		$data['regions'] = $this->regions_model
			->where('region_deleted', 0)
			->order_by('region_name', 'asc')
			->format_dropdown('region_code', 'region_name', TRUE);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('areas', 'provinces_form'), 'embed');
		$this->template->add_js(module_js('areas', 'provinces_form'), 'embed');
		$this->template->write_view('content', 'provinces_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('areas.provinces.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->provinces_model->delete($id);

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
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('province_code', lang('province_code'), 'required');
		$this->form_validation->set_rules('province_name', lang('province_name'), 'required');
		// $this->form_validation->set_rules('province_region', lang('province_region'), 'required');
		// $this->form_validation->set_rules('province_country', lang('province_country'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'province_code'			=> $this->input->post('province_code'),
			'province_name'			=> $this->input->post('province_name'),
			'province_region'		=> $this->input->post('province_region'),
			'province_country'		=> $this->input->post('province_country'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->provinces_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->provinces_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Provinces.php */
/* Areas: ./application/modules/areas/controllers/Provinces.php */