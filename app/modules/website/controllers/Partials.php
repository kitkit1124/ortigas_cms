<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Partials Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Partials extends MX_Controller 
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
		$this->load->model('partials_model');
		$this->load->language('partials');
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
		$this->acl->restrict('website.partials.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/partials'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/partials'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// datatables
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		// render the page
		$this->template->add_css(module_css('website', 'partials_index'), 'embed');
		$this->template->add_js(module_js('website', 'partials_index'), 'embed');
		$this->template->write_view('content', 'partials_index', $data);
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
		$this->acl->restrict('website.partials.list');

		echo $this->partials_model->get_datatables();
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
		$this->acl->restrict('website.partials.' . $action, 'modal');

		// page title
		$data['page_heading'] = lang($action . '_heading');
		$data['page_subhead'] = lang($action . '_subhead');
		$data['action'] = $action;
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/partials'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/partials'));
		$this->breadcrumbs->push(lang($action . '_heading'), site_url('website/partials/' . $action));

		if ($this->input->post())
		{
			if ($partial_id = $this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'action' => $action, 'id' => $partial_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'partial_title'			=> form_error('partial_title'),
					'partial_content'		=> form_error('partial_content'),
					'partial_status'		=> form_error('partial_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->partials_model->find($id);

		// render the page
		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_js('npm/tinymce/jquery.tinymce.min.js');
		
		if ($action == 'view')
		{
			$this->template->add_js('$(".tab-content :input").attr("disabled", true);', 'embed');
		}

		$this->template->add_css(module_css('website', 'partials_form'), 'embed');
		$this->template->add_js(module_js('website', 'partials_form'), 'embed');
		$this->template->write_view('content', 'partials_form', $data);
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
		$this->acl->restrict('website.partials.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->partials_model->delete($id);

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
		$this->form_validation->set_rules('partial_title', lang('partial_title'), 'required|max_length[255]');
		$this->form_validation->set_rules('partial_content', lang('partial_content'), 'required');
		$this->form_validation->set_rules('partial_status', lang('partial_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'partial_title'			=> $this->input->post('partial_title'),
			'partial_content'		=> $this->input->post('partial_content'),
			'partial_status'		=> $this->input->post('partial_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->partials_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$this->partials_model->update($id, $data);
			$return = $id;
		}

		return $return;

	}
}

/* End of file Partials.php */
/* Location: ./application/modules/website/controllers/Partials.php */