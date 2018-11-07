<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Navigroups Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Navigroups extends MX_Controller 
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
		$this->load->model('navigroups_model');
		$this->load->language('navigroups');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	// public function index()
	// {
	// 	$this->acl->restrict('website.navigroups.list');
		
	// 	// page title
	// 	$data['page_heading'] = lang('index_heading');
	// 	$data['page_subhead'] = lang('index_subhead');
		
	// 	// breadcrumbs
	// 	$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
	// 	$this->breadcrumbs->push(lang('crumb_module'), site_url('navigroups'));
		
	// 	// session breadcrumb
	// 	$this->session->set_userdata('redirect', current_url());
		
	// 	// add plugins
	// 	$this->template->add_css('components/DataTables/datatables.min.css');
	// 	$this->template->add_js('components/DataTables/datatables.min.js');
		
	// 	// render the page
	// 	$this->template->add_css(module_css('website', 'navigroups_index'), 'embed');
	// 	$this->template->add_js(module_js('website', 'navigroups_index'), 'embed');
	// 	$this->template->write_view('content', 'navigroups_index', $data);
	// 	$this->template->render();
	// }

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	// public function datatables()
	// {
	// 	$this->acl->restrict('website.navigroups.list');

	// 	echo $this->navigroups_model->get_datatables();
	// }

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
		$this->acl->restrict('website.navigroups.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($id = $this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'id' => $id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'navigroup_name'		=> form_error('navigroup_name'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->navigroups_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('website', 'navigroups_form'), 'embed');
		$this->template->add_js(module_js('website', 'navigroups_form'), 'embed');
		$this->template->write_view('content', 'navigroups_form', $data);
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
		$this->acl->restrict('website.navigroups.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		// $data['datatables_id'] = '#datatables';
		$data['redirect_url'] = site_url('website/navigations');

		if ($this->input->post())
		{
			$this->navigroups_model->delete($id);

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
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph> (modify)
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('navigroup_name', lang('navigroup_name'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'navigroup_name'		=> $this->input->post('navigroup_name'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->navigroups_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->navigroups_model->update($id, $data) ? $id : FALSE; // adds return variable $id 
		}

		return $return;

	}
}

/* End of file Navigroups.php */
/* Location: ./application/modules/website/controllers/Navigroups.php */