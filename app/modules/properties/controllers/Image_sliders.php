<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Image_sliders Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Image_sliders extends MX_Controller {
	
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
		$this->load->model('image_sliders_model');
		$this->load->language('image_sliders');
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
		$this->acl->restrict('properties.image_sliders.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('image_sliders'));
		
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
		$this->template->add_css(module_css('properties', 'image_sliders_index'), 'embed');
		$this->template->add_js(module_js('properties', 'image_sliders_index'), 'embed');
		$this->template->write_view('content', 'image_sliders_index', $data);
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
		$this->acl->restrict('properties.image_sliders.list');

		echo $this->image_sliders_model->get_datatables();
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
		$this->acl->restrict('properties.image_sliders.' . $action, 'modal');

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
					'image_slider_section_type'		=> form_error('image_slider_section_type'),
					'image_slider_section_id'		=> form_error('image_slider_section_id'),
					'image_slider_image'		=> form_error('image_slider_image'),
					'image_slider_title'		=> form_error('image_slider_title'),
					'image_slider_title_size'		=> form_error('image_slider_title_size'),
					'image_slider_title_pos'		=> form_error('image_slider_title_pos'),
					'image_slider_caption'		=> form_error('image_slider_caption'),
					'image_slider_caption_size'		=> form_error('image_slider_caption_size'),
					'image_slider_caption_pos'		=> form_error('image_slider_caption_pos'),
					'image_slider_status'		=> form_error('image_slider_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->image_sliders_model->find($id);


		

		// render the page
		$this->template->set_template('modal');

		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');

		$this->template->add_css(module_css('properties', 'image_sliders_form'), 'embed');
		$this->template->add_js(module_js('properties', 'image_sliders_form'), 'embed');
		$this->template->write_view('content', 'image_sliders_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------
	/**
	 * reorder
	 *
	 * @access	public
	 * @param	array $this->input->post('banner_ids')
	 * @author 	Gutz Marzan <gutzby.marzan@digify.com.ph>
	 */
	function reorder()
	{
		$this->acl->restrict('properties.image_sliders.edit', 'modal');

		$slider_ids = $this->input->post('slider_ids');


		// get the banners
		$sliders = $this->image_sliders_model
			->where_in('image_slider_id', $slider_ids)
			->find_all();

		if ($sliders)
		{
			foreach ($sliders as $slider)
			{
				// update the banner
				$this->image_sliders_model->update($slider->image_slider_id, array(
					'image_slider_order' => array_search($slider->image_slider_id, $slider_ids)
				));
			}
		}

		echo json_encode(array('success' => true, 'message' => lang('reorder_success'))); exit;
	
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
		$this->acl->restrict('properties.image_sliders.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		// $data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->image_sliders_model->delete($id);


			$this->session->set_flashdata('flash_message', lang('delete_success'));
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
		$this->form_validation->set_rules('image_slider_section_type', lang('image_slider_section_type'), 'required');
		$this->form_validation->set_rules('image_slider_section_id', lang('image_slider_section_id'), 'required');
		$this->form_validation->set_rules('image_slider_image', lang('image_slider_image'), 'required');
		// $this->form_validation->set_rules('image_slider_title', lang('image_slider_title'), 'required');
		// $this->form_validation->set_rules('image_slider_title_size', lang('image_slider_title_size'), 'required');
		// $this->form_validation->set_rules('image_slider_title_pos', lang('image_slider_title_pos'), 'required');
		// $this->form_validation->set_rules('image_slider_caption', lang('image_slider_caption'), 'required');
		// $this->form_validation->set_rules('image_slider_caption_size', lang('image_slider_caption_size'), 'required');
		// $this->form_validation->set_rules('image_slider_caption_pos', lang('image_slider_caption_pos'), 'required');
		$this->form_validation->set_rules('image_slider_status', lang('image_slider_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'image_slider_section_type'		=> $this->input->post('image_slider_section_type'),
			'image_slider_section_id'		=> $this->input->post('image_slider_section_id'),
			'image_slider_image'			=> $this->input->post('image_slider_image'),
			'image_slider_title'			=> $this->input->post('image_slider_title'),
			'image_slider_title_size'		=> $this->input->post('image_slider_title_size'),
			'image_slider_title_pos'		=> $this->input->post('image_slider_title_pos'),
			'image_slider_caption'			=> $this->input->post('image_slider_caption'),
			'image_slider_caption_size'		=> $this->input->post('image_slider_caption_size'),
			'image_slider_caption_pos'		=> $this->input->post('image_slider_caption_pos'),
			'image_slider_alt_image'			=> $this->input->post('image_slider_alt_image'),
			'image_slider_status'			=> $this->input->post('image_slider_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->image_sliders_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->image_sliders_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Image_sliders.php */
/* Location: ./application/modules/properties/controllers/Image_sliders.php */