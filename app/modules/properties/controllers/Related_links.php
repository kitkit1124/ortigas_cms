<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Related_links Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Related_links extends MX_Controller {
	
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
		$this->load->model('related_links_model');
		$this->load->language('related_links');
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
		$this->acl->restrict('properties.related_links.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('related_links'));
		
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
		$this->template->add_css(module_css('properties', 'related_links_index'), 'embed');
		$this->template->add_js(module_js('properties', 'related_links_index'), 'embed');
		$this->template->write_view('content', 'related_links_index', $data);
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
		$this->acl->restrict('properties.related_links.list');
		$fields_data = [ 
			'section_id' 	=> $this->input->get('section_id'),
			'section_type'  => $this->input->get('section_type')
		]; 
		echo $this->related_links_model->get_datatables($fields_data);
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
		$this->acl->restrict('properties.related_links.' . $action, 'modal');

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
					'related_link_label'		=> form_error('related_link_label'),
					'related_link_link'			=> form_error('related_link_link'),
					'related_link_status'		=> form_error('related_link_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->related_links_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('properties', 'related_links_form'), 'embed');
		$this->template->add_js(module_js('properties', 'related_links_form'), 'embed');
		$this->template->write_view('content', 'related_links_form', $data);
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
		$this->acl->restrict('properties.related_links.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables_links';

		if ($this->input->post())
		{
			$this->related_links_model->delete($id);

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
		$this->form_validation->set_rules('related_link_label', lang('related_link_label'), 'required');
		$this->form_validation->set_rules('related_link_link', lang('related_link_link'), 'required');
		$this->form_validation->set_rules('related_link_status', lang('related_link_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'related_link_section_id'		=> $this->input->post('related_link_section_id'),
			'related_link_section_type'		=> $this->input->post('related_link_section_type'),
			'related_link_label'		=> $this->input->post('related_link_label'),
			'related_link_link'			=> $this->input->post('related_link_link'),
			'related_link_status'		=> $this->input->post('related_link_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->related_links_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->related_links_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Related_links.php */
/* Location: ./application/modules/properties/controllers/Related_links.php */