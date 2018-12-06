<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Banners Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Banners extends MX_Controller {
	
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
		$this->load->model('banners_model');
		$this->load->model('banner_groups_model');
		$this->load->model('files/video_uploads_model');
		$this->load->language('banners');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function index($id = FALSE)
	{
		$this->acl->restrict('website.banners.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('banners'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		if (!$id)
		{
			redirect('website/banners/1');
		}
		

		// active banner group
		$data['banner_group_id'] = $id;

		// get the banner groups
		$data['banner_groups'] = $this->banner_groups_model
			->where('banner_group_deleted', 0)
			->find_all();

		// get the banners
		$data['video'] = $this->video_uploads_model->find(1);

		$data['banners'] = $this->banners_model
			->where('banner_deleted', 0)
			->where('banner_status', 'Active')
			->where('banner_banner_group_id', $id)
			->order_by('banner_order', 'asc')
			->order_by('banner_id', 'desc')
			->find_all();


		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		$this->template->add_js('mods/jquery-ui/jquery-ui.min.js');
		
		// render the page
		$this->template->add_css(module_css('website', 'banners_index'), 'embed');
		$this->template->add_js(module_js('website', 'banners_index'), 'embed');
		$this->template->write_view('content', 'banners_index', $data);
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
		$this->acl->restrict('website.banners.list');

		echo $this->banners_model->get_datatables();
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
		$this->acl->restrict('website.banners.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($this->_save($action, $id))
			{
				$this->session->set_flashdata('flash_message', lang($action . '_success'));
				echo json_encode(array('success' => true, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'banner_banner_group_id'		=> form_error('banner_banner_group_id'),
					'banner_thumb'					=> form_error('banner_thumb'),
					'banner_image'					=> form_error('banner_image'),
					'banner_caption'				=> form_error('banner_caption'),
					'banner_link'					=> form_error('banner_link'),
					'banner_target'					=> form_error('banner_target'),
					'banner_order'					=> form_error('banner_order'),
					'banner_status'					=> form_error('banner_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->banners_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('website', 'banners_form'), 'embed');
		$this->template->add_js(module_js('website', 'banners_form'), 'embed');
		$this->template->write_view('content', 'banners_form', $data);
		$this->template->render();
	}

	function video_upload($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('website.banners.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($id = $this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'action' => $action, 'id' => $id, 'message' => lang($action . '_success'))); exit;
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
		$this->template->add_css(module_css('files', 'form_upload'), 'embed');
		$this->template->add_js(module_js('files', 'videos_form_upload'), 'embed');
		$this->template->write_view('content', 'files/videos_form_upload', $data);
		$this->template->render();
	}

	function main_video_save(){
		$id = $this->input->post('video_id');
		$data = array(
		    'video_status'     => $this->input->post('video_status'),
		);
		$this->video_uploads_model->update($id, $data);
	}

	function video_form(){
		$id = $this->input->post('video_id');
		$action = "edit";

		if ($this->input->post())
		{
			if ($this->_save_video($id))
			{
				$this->session->set_flashdata('flash_message', lang($action . '_success'));
				echo json_encode(array('success' => true, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'video_title'			=> form_error('video_title'),
					'video_caption'			=> form_error('video_caption'),
					'video_text_pos'		=> form_error('video_text_pos'),
					'video_button_text'		=> form_error('video_button_text'),
					'video_link'			=> form_error('video_link'),
				);
				echo json_encode($response);
				exit;
			}
		}
	}


	private function _save_video($id = 0)
	{
		// validate inputs
		
		$this->form_validation->set_rules('video_title', lang('video_title'), 'required');
		$this->form_validation->set_rules('video_caption', lang('video_caption'), 'required');
		$this->form_validation->set_rules('video_text_pos', lang('video_text_pos'), 'required');
		$this->form_validation->set_rules('video_button_text', lang('video_button_text'), 'required');
		$this->form_validation->set_rules('video_link', lang('video_link'), 'required');
	

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'video_title'			=> $this->input->post('video_title'),
			'video_caption'			=> $this->input->post('video_caption'),
			'video_text_pos'		=> $this->input->post('video_text_pos'),
			'video_button_text'		=> $this->input->post('video_button_text'),
			'video_link'			=> $this->input->post('video_link'),
		);
		

		$return = $this->video_uploads_model->update($id, $data);
	

		return $return;
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
		$this->acl->restrict('website.banners.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		//$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->banners_model->delete($id);

			$this->session->set_flashdata('flash_message', lang('delete_success'));
			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * reorder
	 *
	 * @access	public
	 * @param	array $this->input->post('banner_ids')
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function reorder()
	{
		$this->acl->restrict('website.banners.edit', 'modal');

		$banner_ids = $this->input->post('banner_ids');


		// get the banners
		$banners = $this->banners_model
			->where_in('banner_id', $banner_ids)
			->find_all();

		if ($banners)
		{
			foreach ($banners as $banner)
			{
				// update the banner
				$this->banners_model->update($banner->banner_id, array(
					'banner_order' => array_search($banner->banner_id, $banner_ids)
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
		// $this->form_validation->set_rules('banner_banner_group_id', lang('banner_banner_group_id'), 'required');
		// $this->form_validation->set_rules('banner_thumb', lang('banner_thumb'), 'required');
		$this->form_validation->set_rules('banner_image', lang('banner_image'), 'required');
		// $this->form_validation->set_rules('banner_caption', lang('banner_caption'), 'max_length[255]');
		// $this->form_validation->set_rules('banner_link', lang('banner_link'), 'required');
		// $this->form_validation->set_rules('banner_target', lang('banner_target'), 'required');
		// $this->form_validation->set_rules('banner_order', lang('banner_order'), 'required');
		$this->form_validation->set_rules('banner_status', lang('banner_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'banner_thumb'			=> $this->input->post('banner_thumb'),
			'banner_image'			=> $this->input->post('banner_image'),
			'banner_alt_image'		=> $this->input->post('banner_alt_image'),
			'banner_caption'		=> $this->input->post('banner_caption'),
			'banner_link'			=> $this->input->post('banner_link'),
			'banner_target'			=> $this->input->post('banner_target'),
			'banner_status'			=> $this->input->post('banner_status'),
		);
		

		if ($action == 'add')
		{
			$data['banner_banner_group_id'] = $id;
			$data['banner_order'] = $id;
			$insert_id = $this->banners_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->banners_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Banners.php */
/* Location: ./application/modules/website/controllers/Banners.php */