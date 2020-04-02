<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Categories extends MX_Controller {
	
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
		$this->load->model('categories_model');
		$this->load->language('categories');
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
		$this->acl->restrict('properties.categories.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('categories'));
		
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
		$this->template->add_css(module_css('properties', 'categories_index'), 'embed');
		$this->template->add_js(module_js('properties', 'categories_index'), 'embed');
		$this->template->write_view('content', 'categories_index', $data);
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
		$this->acl->restrict('properties.categories.list');

		echo $this->categories_model->get_datatables();
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
		$this->acl->restrict('properties.categories.' . $action, 'modal');

		// $data['page_heading'] = lang($action . '_heading');
		$data['page_heading'] = lang($action . '_heading');
		$data['page_subhead'] = lang($action . '_subhead');
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
					'category_name'			=> form_error('category_name'),
					'category_image'		=> form_error('category_image'),
					'category_description'	=> form_error('category_description'),
					'category_snippet_quote'	=> form_error('category_snippet_quote'),
					'category_bottom_description'	=> form_error('category_bottom_description'),
					'category_status'		=> form_error('category_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') {
			$data['record'] = $this->categories_model->find($id);
		}

		// render the page
		// $this->template->set_template('modal');

		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_js('npm/tinymce/jquery.tinymce.min.js');

		$this->template->add_css(module_css('properties', 'related_links_index'), 'embed');
		$this->template->add_js(module_js('properties', 'related_links_index'), 'embed');

		$this->template->add_css(module_css('website', 'banners_index'), 'embed');
		$this->template->add_css(module_css('properties', 'categories_form'), 'embed');
		$this->template->add_js(module_js('properties', 'categories_form'), 'embed');
		$this->template->write_view('content', 'categories_form', $data);
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
		$this->acl->restrict('properties.categories.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->categories_model->delete($id);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}


	public function reorder_view()
	{
	
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('reorder_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('properties'));
		$this->breadcrumbs->push(lang('reorder_subhead'), site_url('properties/reorder_view'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		$data['categories'] = $this->categories_model->get_active_categories_order();

		$this->template->add_js('mods/jquery-ui/jquery-ui.min.js');
		
		// render the page
		$this->template->add_css(module_css('properties', 'settings_index'), 'embed');
		$this->template->add_css(module_css('properties', 'reorder_index'), 'embed');
		$this->template->add_js(module_js('properties', 'reorder_index'), 'embed');
		$this->template->write_view('content', 'reorder_index', $data);
		$this->template->render();
	}

	/**
	 * reorder
	 *
	 * @access	public
	 * @param	array $this->input->post('banner_ids')
	 * @author 	Gutz Marzan <gutzby.marzan@digify.com.ph>
	 */
	
	function reorder()
	{

		$ids = $this->input->post('ids');

		// get the banners
		$categories = $this->categories_model
			->where_in('category_id', $ids)
			->find_all();

		if ($categories)
		{
			foreach ($categories as $value)
			{
				// update the banner
				$this->categories_model->update($value->category_id, array(
					'category_order' => array_search($value->category_id, $ids)
				));
			}
		}

		echo json_encode(array('success' => true, 'message' => lang('reorder_success'))); exit;
	
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
		$this->form_validation->set_rules('category_name', lang('category_name'), 'required');
		$this->form_validation->set_rules('category_image', lang('category_image'), 'required');
		$this->form_validation->set_rules('category_description', lang('category_description'), 'required');
		$this->form_validation->set_rules('category_snippet_quote', lang('category_snippet_quote'), 'required');
		$this->form_validation->set_rules('category_status', lang('category_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		$name = $this->input->post('category_name');
		$orig_name = $this->input->post('category_name_original');
		$duplicate = $this->categories_model->find_by(array('category_name' => $name, 'category_deleted' => 0));
			
		if ($action == 'edit'){
			if($orig_name == $name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('category_name', lang('category_name'), 'required|is_unique["category_name"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('category_name', lang('category_name'), 'required|is_unique["category_name"]');
			}
		}
		

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'category_name'			=> $this->input->post('category_name'),
			'category_image'		=> $this->input->post('category_image'),
			'category_alt_image'	=> $this->input->post('category_alt_image'),
			'category_description'	=> utf8_encode($this->input->post('category_description')),
			'category_snippet_quote'	=> utf8_encode($this->input->post('category_snippet_quote')),
			'category_bottom_description'	=> utf8_encode($this->input->post('category_bottom_description')),
			'category_status'		=> $this->input->post('category_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->categories_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->categories_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Categories.php */
/* Location: ./application/modules/properties/controllers/Categories.php */