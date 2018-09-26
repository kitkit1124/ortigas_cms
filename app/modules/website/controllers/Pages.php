<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pages Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Pages extends MX_Controller 
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
		
		// check for dependencies
		if (! $this->db->table_exists('images'))
		{
			$this->session->set_flashdata('flash_error', 'Pages module requires the Files module');
			redirect($this->session->userdata('redirect'), 'refresh');
		}

		$this->load->config('config');
		$this->load->model('pages_model');
		// $this->load->model('sidebars_model');
		$this->load->language('pages');
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
		$this->acl->restrict('website.pages.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/pages'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/pages'));

		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// datatables
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		$this->template->add_js('npm/tinymce/tinymce.min.js');

		// render the page
		$this->template->add_css(module_css('website', 'pages_index'), 'embed');
		$this->template->add_js(module_js('website', 'pages_index'), 'embed');
		$this->template->write_view('content', 'pages_index', $data);
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
		$this->acl->restrict('website.pages.list');

		echo $this->pages_model->get_datatables();
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
		$this->acl->restrict('website.pages.' . $action);

		// page title
		$data['page_heading'] = lang($action . '_heading');
		$data['page_subhead'] = lang($action . '_subhead');
		$data['action'] = $action;
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/pages'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/pages'));
		$this->breadcrumbs->push(lang($action . '_heading'), site_url('website/pages/' . $action));

		if ($this->input->post())
		{
			if ($page_id = $this->_save($action, $id))
			{
				$this->session->set_flashdata('flash_message',  lang($action . '_success'));
				echo json_encode(array('success' => true, 'action' => $action, 'id' => $page_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'page_parent_id'	=> form_error('page_parent_id'),
					'page_title'		=> form_error('page_title'),
					'page_content'		=> form_error('page_content'),
					'page_layout'		=> form_error('page_layout'),
					// 'page_sidebar_id'	=> form_error('page_sidebar_id'),
					'page_status'		=> form_error('page_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		// get the pages
		$data['pages'] = $this->pages_model
			->where('page_deleted', 0)
			->order_by('page_title', 'asc')
			->format_dropdown('page_id', 'page_title', TRUE);

		// // get the sidebars
		// $data['sidebar'] = $this->sidebars_model
		// 	->where('sidebar_deleted', 0)
		// 	->order_by('sidebar_name', 'asc')
		// 	->format_dropdown('sidebar_id', 'sidebar_name', TRUE);

		if ($action != 'add') $data['record'] = $this->pages_model->find($id);

		// render the page
		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_js('npm/tinymce/jquery.tinymce.min.js');
		// $this->template->add_css('npm/grid-editor/grideditor.css');
		// $this->template->add_js('npm/grid-editor/jquery.grideditor.min.js');		
		// $this->template->add_js('npm/grid-editor/jquery.grideditor.tinymce.js');
		// $this->template->add_js('mods/jquery-ui/jquery-ui.min.js');
		

		if ($action == 'view')
		{
			$this->template->add_js('$(".tab-content :input").attr("disabled", true);', 'embed');
		}
		//$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_css(module_css('website', 'pages_form'), 'embed');
		$this->template->add_js(module_js('website', 'pages_form'), 'embed');
		$this->template->write_view('content', 'pages_form', $data);
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
		$this->acl->restrict('website.pages.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->pages_model->delete($id);

			// update the frontend routes
			// $this->_update_routes();

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
		$this->form_validation->set_rules('page_title', lang('page_title'), 'required');
		$this->form_validation->set_rules('page_content', lang('page_content'), 'required');
		$this->form_validation->set_rules('page_layout', lang('page_layout'), 'required');
		$this->form_validation->set_rules('page_status', lang('page_status'), 'required');

		if (in_array($this->input->post('page_layout'), array('right_sidebar', 'left_sidebar'))) 
		{
			$this->form_validation->set_rules('page_sidebar_id', lang('page_sidebar_id'), 'required');
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}


		// get the page path
		$path = $this->pages_model->get_page_path($this->input->post('page_parent_id'));
		$slug = url_title($this->input->post('page_title'), '-', TRUE);
		if ($path)
		{
			$uri = $path . '/' . $slug;
		}
		else
		{	
			$uri = $slug;
		}

		$data = array(
			'page_parent_id'	=> $this->input->post('page_parent_id'),
			'page_title'		=> $this->input->post('page_title'),
			'page_slug'			=> url_title($this->input->post('page_title'), '-', TRUE),
			'page_uri'			=> $uri,
			'page_content'		=> $this->input->post('page_content'),
			'page_layout'		=> $this->input->post('page_layout'),
			// 'page_sidebar_id'	=> $this->input->post('page_sidebar_id'),
			'page_status'		=> $this->input->post('page_status'),
		);
		// $data = $this->security->xss_clean($data);
		

		if ($action == 'add')
		{
			$insert_id = $this->pages_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$this->pages_model->update($id, $data);

			// update the navigation uri
			// $this->load->model('navigations_model');
			// $this->navigations_model->update_where(array(
			// 	'navigation_source' => 'pages',
			// 	'navigation_source_id' => $id
			// ), NULL, array('navigation_link' => $uri));

			// delete the cache
			$this->output->delete_cache('/' . $uri);

			$return = $id;
		}



		// update the frontend routes
		// $this->_update_routes();

		return $return;

	}

	// --------------------------------------------------------------------

	/**
	 * _update_routes
	 *
	 * @access	private
	 * @param	none
	 * @return 	boolean
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	private function _update_routes()
	{
		$pages = $this->pages_model
			->where('page_deleted', 0)
			->where('page_status', 'Posted')
			->find_all();

		$data = array();
		if ($pages)
		{
			$data[] = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');';
			foreach ($pages as $page)
			{
				$data[] = '$route[\'' . $page->page_uri . '\'] = \'frontend/page/view/' . $page->page_uri . '\';';
			}

			$output = implode("\n", $data);

            write_file(APPPATH . 'cache/routes.php', $output);
		}

		return TRUE;
	}
}

/* End of file Pages.php */
/* Location: ./application/modules/website/controllers/Pages.php */