<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Posts extends MX_Controller 
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
			$this->session->set_flashdata('flash_error', 'Posts module requires the Files module');
			redirect($this->session->userdata('redirect'), 'refresh');
		}

		$this->load->config('config');
		$this->load->model('post_categories_model');
		$this->load->model('post_properties_model');
		$this->load->model('categories_model');
		$this->load->model('posts_model');
		$this->load->model('properties/properties_model');
		$this->load->model('news_tags_model');
		$this->load->model('post_tags_model');
		// $this->load->model('sidebars_model');
		$this->load->language('posts');
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
		$this->acl->restrict('website.posts.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/posts'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/posts'));

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
		$this->template->add_css(module_css('website', 'posts_index'), 'embed');
		$this->template->add_js(module_js('website', 'posts_index'), 'embed');
		$this->template->write_view('content', 'posts_index', $data);
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
		$this->acl->restrict('website.posts.list');

		echo $this->posts_model->get_datatables();
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
		$this->acl->restrict('website.posts.' . $action);

		// page title
		$data['page_heading'] = lang($action . '_heading');
		$data['page_subhead'] = lang($action . '_subhead');
		$data['action'] = $action;
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/posts'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/posts'));
		$this->breadcrumbs->push(lang($action . '_heading'), site_url('website/posts/' . $action));

		if ($this->input->post())
		{
			if ($post_id = $this->_save($action, $id))
			{
				$this->session->set_flashdata('flash_message',  lang($action . '_success'));
				echo json_encode(array('success' => true, 'action' => $action, 'id' => $post_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'post_title'		=> form_error('post_title'),
					'post_content'		=> form_error('post_content'),
					'post_image'		=> form_error('post_image'),
					'post_categories'	=> form_error('post_categories[]'),
					'post_properties'	=> form_error('post_properties[]'),
					'post_tags'			=> form_error('post_tags[]'),
					'post_posted_on'	=> form_error('post_posted_on'),
					'post_layout'		=> form_error('post_layout'),
					'post_slug'			=> form_error('post_slug'),
					'post_facebook'		=> form_error('post_facebook'),
					'post_twitter'		=> form_error('post_twitter'),
					'post_instagram'	=> form_error('post_instagram'),
					'post_linkedin'		=> form_error('post_linkedin'),
					'post_youtube'		=> form_error('post_youtube'),
					// 'post_sidebar_id'	=> form_error('post_sidebar_id'),
					'post_status'		=> form_error('post_status'),
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

	
		$properties = $this->properties_model->get_active_properties();
		unset($properties['']);
		$data['properties']  = $properties;

		$tags = $this->news_tags_model->get_active_tags();
		unset($tags['']);
		$data['tags']  = $tags;

		$current_categories = array();
		$current_properties= array();
		$current_tags= array();
		if ($action != 'add') 
		{
			$data['record'] = $this->posts_model->find($id);
			$current_categories = $this->post_categories_model->get_current_categories($id);
			$current_properties = $this->post_properties_model->get_current_properties($id);
			$current_tags 		= $this->post_tags_model->get_current_tags($id);
		}



		// all categories
		// $data['categories'] = $this->categories_model
		// 	->where('category_deleted', 0)
		// 	->order_by('category_parent_id', 'asc')
		// 	->find_all();

		$data['categories'] = $this->categories_model->get_category_checkboxes();
	
		$data['current_categories'] = array_keys($current_categories);
		$data['current_properties'] = array_keys($current_properties);
		$data['current_tags'] 		= array_keys($current_tags);


		// render the page
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		$this->template->add_css('npm/tinymce/skins/lightgray/skin.min.css');
		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_css('npm/datetimepicker/DateTimePicker.min.css');
		$this->template->add_js('npm/datetimepicker/DateTimePicker.min.js');

		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');

		$this->template->add_css('npm/select2/css/select2.min.css');
		$this->template->add_js('npm/select2/js/select2.min.js');
		
		if ($action == 'view')
		{
			$this->template->add_js('$(".tab-content :input").attr("disabled", true);', 'embed');
		}
		$this->template->add_css(module_css('website', 'posts_form'), 'embed');
		$this->template->add_css(module_css('website', 'banners_index'), 'embed');
		$this->template->add_js(module_js('website', 'posts_form'), 'embed');
		$this->template->write_view('content', 'posts_form', $data);
		$this->template->render();
	}


	function form_upload($action = 'add', $id = FALSE)
	{
		// $this->acl->restrict('properties.properties.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($post_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $post_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('website', 'form_upload'), 'embed');
		$this->template->add_js(module_js('website', 'form_upload'), 'embed');
		$this->template->write_view('content', 'form_upload', $data);
		$this->template->render();
	}


	function form_document($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('files.documents.' . $action, 'modal');

		$data['page_heading'] = 'Upload Document';
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
					'document_name'		=> form_error('document_name'),
					'document_file'		=> form_error('document_file'),
					'document_thumb'	=> form_error('document_thumb'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->documents_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('files', 'documents_form'), 'embed');
		$this->template->add_js(module_js('website', 'form_document'), 'embed');
		$this->template->write_view('content', 'files/documents_form', $data);
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
		$this->acl->restrict('website.posts.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->posts_model->delete($id);

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
		$this->form_validation->set_rules('post_title', lang('post_title'), 'required');
		$this->form_validation->set_rules('post_content', lang('post_content'), 'required');
		$this->form_validation->set_rules('post_categories[]', lang('post_categories'), 'required');
		$this->form_validation->set_rules('post_image', lang('post_image'), 'required');
		$this->form_validation->set_rules('post_posted_on', lang('post_posted_on'), 'required');
		$this->form_validation->set_rules('post_layout', lang('post_layout'), 'required');
		$this->form_validation->set_rules('post_status', lang('post_status'), 'required');
		$this->form_validation->set_rules('post_tags[]', lang('post_tags'), 'required');



		$name = $this->input->post('post_title');
		$orig_name = $this->input->post('post_title_orig');
		$duplicate = $this->posts_model->find_by(array('post_title' => $name, 'post_deleted' => 0));
			
		if ($action == 'edit'){
			if($orig_name == $name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('post_title', lang('post_title'), 'required|is_unique["post_title"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('post_title', lang('post_title'), 'required|is_unique["post_title"]');
			}
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		


		if (in_array($this->input->post('post_layout'), array('right_sidebar', 'left_sidebar'))) 
		{
			$this->form_validation->set_rules('post_sidebar_id', lang('post_sidebar_id'), 'required');
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$slug = url_title($this->input->post('post_title'), '-', TRUE);

		if($this->input->post('post_slug') && $this->input->post('post_slug')){
			$slug = $this->input->post('post_slug');
		}

		$data = array(
			'post_title'		=> $this->input->post('post_title'),
			'post_alt_image'	=> $this->input->post('post_alt_image'),
			'post_slug'			=> $slug,
			'post_content'		=> utf8_encode($this->input->post('post_content')),
			'post_image'		=> $this->input->post('post_image'),
			'post_posted_on'	=> $this->input->post('post_posted_on'),
			'post_layout'		=> $this->input->post('post_layout'),
			'post_facebook'		=> $this->input->post('post_facebook'),
			'post_twitter'		=> $this->input->post('post_twitter'),
			'post_instagram'	=> $this->input->post('post_instagram'),
			'post_linkedin'		=> $this->input->post('post_linkedin'),
			'post_youtube'		=> $this->input->post('post_youtube'),
			'post_document'		=> $this->input->post('post_document'),
			// 'post_sidebar_id'	=> $this->input->post('post_sidebar_id'),
			'post_status'		=> $this->input->post('post_status'),
		);
		// $data = $this->security->xss_clean($data);
		

		if ($action == 'add')
		{
			$id = $this->posts_model->insert($data);
			$return = (is_numeric($id)) ? $id : FALSE;
		}
		else if ($action == 'edit')
		{
			$this->posts_model->update($id, $data);

			// delete the existing categories
			$this->post_categories_model->delete_where(array('post_category_post_id' => $id));

			// delete the cache
			$this->output->delete_cache('/post/' . url_title($this->input->post('post_title'), '-', TRUE));

			$return = $id;
		}

		// add the categories
		$categories = $this->input->post('post_categories');
		// pr($categories);
		if ($categories)
		{
			foreach ($categories as $category)
			{
				$data = array(
					'post_category_post_id' => $id,
					'post_category_category_id' => $category
				);
				$this->post_categories_model->insert($data);
			}
		}

		$properties = $this->input->post('post_properties');

		$delete_where_id = array( 'post_properties_post_id' => $id);
		$this->post_properties_model->delete_where($delete_where_id);

		if ($properties)
		{
			foreach ($properties as $property)
			{	
				$data = array(
					'post_properties_post_id' => $id,
					'post_properties_property_id' => $property
				);

				$this->post_properties_model->insert($data);
			}
		}


		$tags = $this->input->post('post_tags');

		$delete_where_id = array( 'post_tag_post_id' => $id);
		$this->post_tags_model->delete_where($delete_where_id);

		if ($tags)
		{
			foreach ($tags as $tag)
			{	
				$data = array(
					'post_tag_post_id' => $id,
					'post_tag_tag_id'  => $tag
				);

				$this->post_tags_model->insert($data);
			}
		}

		return $return;

	}
}

/* End of file Posts.php */
/* Location: ./application/modules/website/controllers/Posts.php */