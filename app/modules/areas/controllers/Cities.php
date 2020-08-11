<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cities Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Cities extends MX_Controller 
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
		$this->load->model('cities_model');
		$this->load->language('cities');
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
		$this->acl->restrict('areas.cities.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('cities'));
		
		// datatables
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
	

		// render the page
		$this->template->add_css(module_css('areas', 'cities_index'), 'embed');
		$this->template->add_js(module_js('areas', 'cities_index'), 'embed');
		$this->template->write_view('content', 'cities_index', $data);
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
		$this->acl->restrict('areas.cities.list');

		echo $this->cities_model->get_datatables();
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
		$this->acl->restrict('areas.cities.' . $action, 'modal');

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
					'city_name'			=> form_error('city_name'),
					'city_code'			=> form_error('city_code'),
					'city_type'			=> form_error('city_type'),
					'city_province'		=> form_error('city_province'),
					'city_country'		=> form_error('city_country'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->cities_model->find($id);

		// get the countries
		$this->load->model('countries_model');
		$data['countries'] = $this->countries_model
			->where('country_deleted', 0)
			->order_by('country_name', 'asc')
			->format_dropdown('country_code2', 'country_name', TRUE);

		// get the provinces
		$this->load->model('provinces_model');
		$data['provinces'] = $this->provinces_model
			->where('province_deleted', 0)
			->order_by('province_name', 'asc')
			->format_dropdown('province_code', 'province_name', TRUE);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('areas', 'cities_form'), 'embed');
		$this->template->add_js(module_js('areas', 'cities_form'), 'embed');
		$this->template->write_view('content', 'cities_form', $data);
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
		$this->acl->restrict('areas.cities.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->cities_model->delete($id);

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
		$this->form_validation->set_rules('city_name', lang('city_name'), 'required');
		// $this->form_validation->set_rules('city_code', lang('city_code'), 'required');
		// $this->form_validation->set_rules('city_type', lang('city_type'), 'required');
		// $this->form_validation->set_rules('city_province', lang('city_province'), 'required');
		// $this->form_validation->set_rules('city_country', lang('city_country'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'city_name'			=> $this->input->post('city_name'),
			'city_code'			=> $this->input->post('city_code'),
			'city_type'			=> $this->input->post('city_type'),
			'city_province'		=> $this->input->post('city_province'),
			'city_country'		=> $this->input->post('city_country'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->cities_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->cities_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Cities.php */
/* Area: ./application/modules/areas/controllers/Cities.php */