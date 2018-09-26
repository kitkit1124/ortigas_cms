<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * {{ucf_plural_module_name}} Class
 *
 * @package		{{package_name}}
 * @version		{{module_version}}
 * @author 		{{author_name}} <{{author_email}}>
 * @copyright 	Copyright (c) {{copyright_year}}, {{copyright_name}}
 * @link		{{copyright_link}}
 */
class {{ucf_plural_module_name}} extends MX_Controller {
	
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
		{{module_model}}
		$this->load->language('{{lc_plural_module_name}}');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	{{author_name}} <{{author_email}}>
	 */
	public function index()
	{
		$this->acl->restrict('{{parent_module}}.{{lc_plural_module_name}}.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('{{lc_plural_module_name}}'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		{{embed_datetime_plugin}}
		{{embed_jqueryui_plugin}}
		
		// render the page
		$this->template->add_css(module_css('{{parent_module}}', '{{lc_plural_module_name}}_index'), 'embed');
		$this->template->add_js(module_js('{{parent_module}}', '{{lc_plural_module_name}}_index'), 'embed');
		$this->template->write_view('content', '{{lc_plural_module_name}}_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	{{author_name}} <{{author_email}}>
	 */
	public function datatables()
	{
		$this->acl->restrict('{{parent_module}}.{{lc_plural_module_name}}.list');

		echo $this->{{lc_plural_module_name}}_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	{{author_name}} <{{author_email}}>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('{{parent_module}}.{{lc_plural_module_name}}.' . $action, 'modal');

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
{{controller_form_errors}}				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->{{lc_plural_module_name}}_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('{{parent_module}}', '{{lc_plural_module_name}}_form'), 'embed');
		$this->template->add_js(module_js('{{parent_module}}', '{{lc_plural_module_name}}_form'), 'embed');
		$this->template->write_view('content', '{{lc_plural_module_name}}_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	{{author_name}} <{{author_email}}>
	 */
	function delete($id)
	{
		$this->acl->restrict('{{parent_module}}.{{lc_plural_module_name}}.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->{{lc_plural_module_name}}_model->delete($id);

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
	 * @author 	{{author_name}} <{{author_email}}>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
{{controller_form_validations}}
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
{{controller_form_fields}}		);
		

		if ($action == 'add')
		{
			$insert_id = $this->{{lc_plural_module_name}}_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->{{lc_plural_module_name}}_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file {{ucf_plural_module_name}}.php */
/* Location: ./application/modules/{{parent_module}}/controllers/{{ucf_plural_module_name}}.php */