<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Categories extends MX_Controller 
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
		$this->load->config('config');
		$this->load->model('categories_model');
		// $this->load->model('sidebars_model');
		$this->load->language('categories');
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
		$this->acl->restrict('website.categories.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/categories'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/categories'));

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
		$this->template->add_css(module_css('website', 'categories_index'), 'embed');
		$this->template->add_js(module_js('website', 'categories_index'), 'embed');
		$this->template->write_view('content', 'categories_index', $data);
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
		$this->acl->restrict('website.categories.list');

		echo $this->categories_model->get_datatables();
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
		$this->acl->restrict('website.categories.' . $action, 'modal');

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
					'category_parent_id'	=> form_error('category_parent_id'),
					'category_name'			=> form_error('category_name'),
					'category_layout'		=> form_error('category_layout'),
					// 'category_sidebar_id'	=> form_error('category_sidebar_id'),
					'category_status'		=> form_error('category_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		// get the sidebars
		// $data['sidebar'] = $this->sidebars_model
		// 	->where('sidebar_deleted', 0)
		// 	->order_by('sidebar_name', 'asc')
		// 	->format_dropdown('sidebar_id', 'sidebar_name', TRUE);

		
		// get the categories
		$categories = $this->categories_model
			->where('category_deleted', 0)
			->order_by('category_name')
			->format_dropdown('category_id', 'category_name');

		$categories = $this->categories_model->get_category_checkboxes();
		
		$cats = array(0 => 'Top Level');
		if ($categories)
		{
			foreach ($categories as $category)
			{
				$cats[$category->category_id] = repeater(' - ', $category->category_indent/15) . $category->category_name; 
			}
		}
		$data['categories'] = $cats;


		if ($action != 'add')
		{
			// get the record
			$data['record'] = $this->categories_model->find($id);

			// remove the current category from parent categories
			unset($data['categories'][$id]);
		}

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('website', 'categories_form'), 'embed');
		$this->template->add_js(module_js('website', 'categories_form'), 'embed');
		$this->template->write_view('content', 'categories_form', $data);
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
		$this->acl->restrict('website.categories.delete', 'modal');

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
		$this->form_validation->set_rules('category_parent_id', lang('category_parent_id'), 'is_natural');
		$this->form_validation->set_rules('category_name', lang('category_name'), 'required');
		$this->form_validation->set_rules('category_layout', lang('category_layout'), 'required');
		$this->form_validation->set_rules('category_status', lang('category_status'), 'required');

		if (in_array($this->input->post('category_layout'), array('right_sidebar', 'left_sidebar')))
		{
			$this->form_validation->set_rules('category_sidebar_id', lang('category_sidebar_id'), 'required');			
		}


		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		// get the category path
		$path = $this->categories_model->get_category_path($this->input->post('category_parent_id'));
		$slug = url_title($this->input->post('category_name'), '-', TRUE);
		if ($path)
		{
			$uri = 'category/' . $path . '/' . $slug;
		}
		else
		{	
			$uri = 'category/' . $slug;
		}

		$data = array(
			'category_parent_id'	=> $this->input->post('category_parent_id'),
			'category_name'			=> $this->input->post('category_name'),
			'category_slug'			=> $slug,
			'category_uri'			=> $uri,
			'category_layout'		=> $this->input->post('category_layout'),
			// 'category_sidebar_id'	=> $this->input->post('category_sidebar_id'),
			'category_status'		=> $this->input->post('category_status'),
		);
		$data = $this->security->xss_clean($data);

		if ($action == 'add')
		{
			$insert_id = $this->categories_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->categories_model->update($id, $data);

			// also update the navigations
			// $this->load->model('navigations_model');
			// $this->navigations_model->update_where(array(
			// 	'navigation_source' => 'categories',
			// 	'navigation_source_id' => $id,
			// ), NULL, array('navigation_link' => $uri));

			// delete the cache
			$this->output->delete_cache('/' . $uri);
		}

		return $return;

	}
}

/* End of file Categories.php */
/* Location: ./application/modules/website/controllers/Categories.php */