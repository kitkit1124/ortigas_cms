<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Regions Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Regions extends MX_Controller 
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
		$this->load->model('regions_model');
		$this->load->language('regions');
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
		$this->acl->restrict('areas.regions.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('regions'));
		
		// datatables
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		// render the page
		$this->template->add_css(module_css('areas', 'regions_index'), 'embed');
		$this->template->add_js(module_js('areas', 'regions_index'), 'embed');
		$this->template->write_view('content', 'regions_index', $data);
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
		$this->acl->restrict('areas.regions.list');

		echo $this->regions_model->get_datatables();
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
		$this->acl->restrict('areas.regions.' . $action, 'modal');

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
					'region_country'	=> form_error('region_country'),
					'region_code'		=> form_error('region_code'),
					'region_name'		=> form_error('region_name'),
					'region_short_name'	=> form_error('region_short_name'),
					'region_group'		=> form_error('region_group'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->regions_model->find($id);

		// get the countries
		$this->load->model('countries_model');
		$data['countries'] = $this->countries_model
			->where('country_deleted', 0)
			->order_by('country_name', 'asc')
			->format_dropdown('country_code2', 'country_name', TRUE);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('areas', 'regions_form'), 'embed');
		$this->template->add_js(module_js('areas', 'regions_form'), 'embed');
		$this->template->write_view('content', 'regions_form', $data);
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
		$this->acl->restrict('areas.regions.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->regions_model->delete($id);

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
		// $this->form_validation->set_rules('region_country', lang('region_country'), 'required');
		$this->form_validation->set_rules('region_code', lang('region_code'), 'required');
		$this->form_validation->set_rules('region_name', lang('region_name'), 'required');
		// $this->form_validation->set_rules('region_short_name', lang('region_short_name'), 'required');
		// $this->form_validation->set_rules('region_group', lang('region_group'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'region_country'	=> $this->input->post('region_country'),
			'region_code'		=> $this->input->post('region_code'),
			'region_name'		=> $this->input->post('region_name'),
			'region_short_name'	=> $this->input->post('region_short_name'),
			'region_group'		=> $this->input->post('region_group'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->regions_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->regions_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Regions.php */
/* Location: ./application/modules/areas/controllers/Regions.php */