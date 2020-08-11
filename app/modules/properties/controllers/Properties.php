<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Properties Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Properties extends MX_Controller {
	
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
		$this->load->model('properties_model');
		$this->load->language('properties');
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
		$this->acl->restrict('properties.properties.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('properties'));
		
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
		$this->template->add_css(module_css('properties', 'properties_index'), 'embed');
		$this->template->add_js(module_js('properties', 'properties_index'), 'embed');
		$this->template->write_view('content', 'properties_index', $data);
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
		$this->acl->restrict('properties.properties.list');

		echo $this->properties_model->get_datatables();
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
		$this->acl->restrict('properties.properties.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['page_subhead'] = lang($action . '_subhead');
		$data['action'] = $action;

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('properties/properties'));
		$this->breadcrumbs->push(lang($action . '_heading'), site_url('properties/properties/' . $action));

		if ($this->input->post())
		{
			if ($property_id = $this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'action' => $action, 'id' => $property_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'property_estate_id'		=> form_error('property_estate_id'),
					'property_category_id'		=> form_error('property_category_id'),
					'property_location_id'		=> form_error('property_location_id'),
					'property_price_range_id'	=> form_error('property_price_range_id'),
					'property_prop_type_id'		=> form_error('property_prop_type_id'),
					'property_is_featured'		=> form_error('property_is_featured'),
					'property_name'				=> form_error('property_name'),
					'property_slug'				=> form_error('property_slug'),
					'property_overview'			=> form_error('property_overview'),
					'property_snippet_quote'	=> form_error('property_snippet_quote'),
					'property_image'			=> form_error('property_image'),
					'property_thumb'			=> form_error('property_thumb'),
					'property_logo'				=> form_error('property_logo'),
					'property_link_label'		=> form_error('property_link_label'),
					'property_website'			=> form_error('property_website'),
					'property_facebook'			=> form_error('property_facebook'),
					'property_twitter'			=> form_error('property_twitter'),
					'property_instagram'		=> form_error('property_instagram'),
					'property_linkedin'			=> form_error('property_linkedin'),
					'property_youtube'			=> form_error('property_youtube'),
					'property_map_name'			=> form_error('property_map_name'),
					'property_latitude'			=> form_error('property_latitude'),
					'property_longitude'		=> form_error('property_longitude'),
					'property_nearby_malls'		=> form_error('property_nearby_malls'),
					'property_nearby_markets'		=> form_error('property_nearby_markets'),
					'property_nearby_hospitals'		=> form_error('property_nearby_hospitals'),
					'property_nearby_schools'		=> form_error('property_nearby_schools'),
					'property_tags'					=> form_error('property_tags'),
					'property_status'				=> form_error('property_status'),
					'property_availability'			=> form_error('property_availability'),
					'property_construction_update'	=> form_error('property_construction_update'),
					'property_ground'				=> form_error('property_ground'),
					'property_presell'				=> form_error('property_presell'),
					'property_turnover'				=> form_error('property_turnover'),
					'property_slug'					=> form_error('property_slug'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') {
			$data['record'] = $this->properties_model->find($id);

			// get the banners
			$this->load->model('image_sliders_model');
			$data['sliders'] = $this->image_sliders_model
				->where('image_slider_deleted', 0)
				->where('image_slider_section_id', $id)
				->where('image_slider_section_type', 'properties')
				->order_by('image_slider_order', 'asc')
				->order_by('image_slider_id', 'desc')
				->find_all();

			$this->load->model('image_sliders_model');
			$data['construction_sliders'] = $this->image_sliders_model
				->where('image_slider_deleted', 0)
				->where('image_slider_section_id', $id)
				->where('image_slider_section_type', 'construction')
				->order_by('image_slider_order', 'asc')
				->order_by('image_slider_id', 'desc')
				->find_all();
		}


		$this->load->model('categories_model');
		$data['categories'] = $this->categories_model->get_active_categories();

		$this->load->model('estates_model');
		$data['estates'] = $this->estates_model->get_active_estates();

		$this->load->model('locations_model');
		$data['locations'] = $this->locations_model->get_active_locations();

		$this->load->model('property_types_model');
		$data['property_types'] = $this->property_types_model->get_active_property_types();

		$this->load->model('price_range_model');
		$data['price_range'] = $this->price_range_model->get_active_price_range();

		$data['featured_numrows'] = $this->properties_model->count_by(array('property_status'=>'Active', 'property_deleted'=>0, 'property_is_featured'=>1));
		
		$this->load->model('property_pages_model');
		$data['property_pages'] = $this->property_pages_model->get_active_property_pages();


		if ($action == 'view')
		{
			$this->template->add_js('$(".tab-content :input").attr("disabled", true);', 'embed');
		}
		// render the page

		$this->template->add_js('npm/tinymce/tinymce.min.js');
		$this->template->add_js('npm/tinymce/jquery.tinymce.min.js');

		$this->template->add_js('mods/jquery-ui/jquery-ui.min.js');

		$this->template->add_js('npm/tagsinput/tagsinput.js');
		$this->template->add_js('npm/tagsinput/tagsinput.js');
		
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

		$this->template->add_css(module_css('properties', 'related_links_index'), 'embed');
		$this->template->add_js(module_js('properties', 'related_links_index'), 'embed');

		$this->template->add_css(module_css('properties', 'amenities_index'), 'embed');
		$this->template->add_js(module_js('properties', 'amenities_index'), 'embed');

		$this->template->add_css(module_css('properties', 'faq_index'), 'embed');
		$this->template->add_js(module_js('properties', 'faq_index'), 'embed');

		$this->template->add_css(module_css('website', 'banners_index'), 'embed');
		$this->template->add_css(module_css('properties', 'properties_form'), 'embed');
		$this->template->add_js(module_js('properties', 'properties_form'), 'embed');
		$this->template->write_view('content', 'properties_form', $data);
		$this->template->render();
	}

	function form_upload($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('properties.properties.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($property_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $property_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		$data['image_quality']['size'] = 'Max file size: 1 MB';
		$data['image_quality']['resolution'] = 'Ideal image size: 1920 x 410';

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('properties', 'form_upload'), 'embed');
		$this->template->add_js(module_js('properties', 'properties_form_image'), 'embed');
		$this->template->write_view('content', 'form_upload', $data);
		$this->template->render();
	}

	function form_upload_logo($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('properties.properties.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($property_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $property_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		$data['image_quality']['size'] = 'Max file size: 1 MB';
		$data['image_quality']['resolution'] = 'Ideal image size: 300 x 300';

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('properties', 'form_upload'), 'embed');
		$this->template->add_js(module_js('properties', 'properties_form_logo'), 'embed');
		$this->template->write_view('content', 'form_upload', $data);
		$this->template->render();
	}


	function form_upload_thumb($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('properties.properties.' . $action, 'modal');

		// page title
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($property_id = $this->_save($action, $id))
			{

				echo json_encode(array('success' => true, 'action' => $action, 'id' => $property_id, 'message' => lang($action . '_success'))); exit;
			}
			else
			{
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		$data['image_quality']['size'] = 'Max file size: 1 MB';
		$data['image_quality']['resolution'] = 'Ideal image size: 300 x 300';
		
		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('properties', 'form_upload'), 'embed');
		$this->template->add_js(module_js('properties', 'properties_form_thumb'), 'embed');
		$this->template->write_view('content', 'form_upload', $data);
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
		$this->acl->restrict('properties.properties.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->properties_model->delete($id);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}


	// --------------------------------------------------------------------

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
		
		$data['property'] = $this->properties_model->get_active_properties_order();

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
		$properties = $this->properties_model
			->where_in('property_id', $ids)
			->find_all();

		if ($properties)
		{
			foreach ($properties as $value)
			{
				// update the banner
				$this->properties_model->update($value->property_id, array(
					'property_order' => array_search($value->property_id, $ids)
				));
			}
		}

		echo json_encode(array('success' => true, 'message' => lang('reorder_success'))); exit;
	
	}
	//

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
		$this->form_validation->set_rules('property_estate_id', lang('property_estate_id'), 'required');
		$this->form_validation->set_rules('property_category_id', lang('property_category_id'), 'required');
		$this->form_validation->set_rules('property_location_id', lang('property_location_id'), 'required');
		// $this->form_validation->set_rules('property_price_range_id', lang('property_price_range_id'), 'required');
		$this->form_validation->set_rules('property_prop_type_id', lang('property_prop_type_id'), 'required');
		$this->form_validation->set_rules('property_name', lang('property_name'), 'required|max_length[255]');
		$this->form_validation->set_rules('property_overview', lang('property_overview'), 'required');
		$this->form_validation->set_rules('property_snippet_quote', lang('property_snippet_quote'), 'required');
		$this->form_validation->set_rules('property_image', lang('property_image'), 'required');
		$this->form_validation->set_rules('property_thumb', lang('property_thumb'), 'required');
		//$this->form_validation->set_rules('property_website', lang('property_website'), 'required');
		$this->form_validation->set_rules('property_facebook', lang('property_facebook'), 'max_length[255]');
		$this->form_validation->set_rules('property_twitter', lang('property_twitter'), 'max_length[255]');
		$this->form_validation->set_rules('property_instagram', lang('property_instagram'), 'max_length[255]');
		$this->form_validation->set_rules('property_linkedin', lang('property_linkedin'), 'max_length[255]');
		$this->form_validation->set_rules('property_youtube', lang('property_youtube'), 'max_length[255]');
		// $this->form_validation->set_rules('property_latitude', lang('property_latitude'), 'required|max_length[255]');
		// $this->form_validation->set_rules('property_longitude', lang('property_longitude'), 'required|max_length[255]');
		//$this->form_validation->set_rules('property_nearby_malls', lang('property_nearby_malls'), 'required');
		//$this->form_validation->set_rules('property_nearby_markets', lang('property_nearby_markets'), 'required');
		//$this->form_validation->set_rules('property_nearby_hospitals', lang('property_nearby_hospitals'), 'required');
		//$this->form_validation->set_rules('property_nearby_schools', lang('property_nearby_schools'), 'required');
		$this->form_validation->set_rules('property_availability', lang('property_availability'), 'required');
		$this->form_validation->set_rules('property_status', lang('property_status'), 'required');


		$name = $this->input->post('property_name');
		$orig_name = $this->input->post('property_name_original');
		$duplicate = $this->properties_model->find_by(array('property_name' => $name, 'property_deleted' => 0));
			
		if ($action == 'edit'){
			if($orig_name == $name){}
			else{
				if($duplicate){
				$this->form_validation->set_rules('property_name', lang('property_name'), 'required|is_unique["property_name"]');
				}
			}
		}
		if ($action == 'add'){
			if($duplicate){
			$this->form_validation->set_rules('property_name', lang('property_name'), 'required|is_unique["property_name"]');
			}
		}
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$slug = url_title($this->input->post('property_name'), '-', TRUE);

		if($this->input->post('property_slug') && $this->input->post('property_slug')){
			$slug = $this->input->post('property_slug');
		}

		$data = array(
			'property_estate_id'		=> $this->input->post('property_estate_id'),
			'property_category_id'		=> $this->input->post('property_category_id'),
			'property_location_id'		=> $this->input->post('property_location_id'),
			'property_price_range_id'	=> $this->input->post('property_price_range_id'),
			'property_prop_type_id'		=> $this->input->post('property_prop_type_id'),
			'property_is_featured'		=> $this->input->post('property_is_featured'),
			'property_name'				=> $this->input->post('property_name'),
			'property_overview'			=> utf8_encode($this->input->post('property_overview')),
			'property_snippet_quote  '	=> utf8_encode($this->input->post('property_snippet_quote')),
			'property_bottom_overview'	=> utf8_encode($this->input->post('property_bottom_overview')),
			'property_page_id'			=> $this->input->post('property_page_id'),
			'property_slug'				=> $slug,
			'property_image'			=> $this->input->post('property_image'),
			'property_alt_image'		=> $this->input->post('property_alt_image'),
			'property_thumb'			=> $this->input->post('property_thumb'),
			'property_alt_thumb'		=> $this->input->post('property_alt_thumb'),
			'property_logo'				=> $this->input->post('property_logo'),
			'property_alt_logo'			=> $this->input->post('property_alt_logo'),
			'property_link_label'		=> $this->input->post('property_link_label'),
			'property_website'			=> $this->input->post('property_website'),
			'property_facebook'			=> $this->input->post('property_facebook'),
			'property_twitter'			=> $this->input->post('property_twitter'),
			'property_instagram'		=> $this->input->post('property_instagram'),
			'property_linkedin'			=> $this->input->post('property_linkedin'),
			'property_youtube'			=> $this->input->post('property_youtube'),
			'property_map_name'			=> $this->input->post('property_map_name'),
			'property_latitude'			=> $this->input->post('property_latitude'),
			'property_longitude'		=> $this->input->post('property_longitude'),
			'property_nearby_malls'		=> $this->input->post('property_nearby_malls'),
			'property_nearby_markets'	=> $this->input->post('property_nearby_markets'),
			'property_nearby_hospitals'	=> $this->input->post('property_nearby_hospitals'),
			'property_nearby_schools'	=> $this->input->post('property_nearby_schools'),
			'property_tags'				=> $this->input->post('property_tags'),
			'property_status'			=> $this->input->post('property_status'),
			'property_availability'		=> $this->input->post('property_availability'),
			'property_construction_update'=> $this->input->post('property_construction_update'),
			'property_ground'			=> $this->input->post('property_ground'),
			'property_presell'			=> $this->input->post('property_presell'),
			'property_turnover'			=> $this->input->post('property_turnover'),
			'property_location_description'		=> $this->input->post('property_location_description'),
			'property_amenities_description'	=> $this->input->post('property_amenities_description'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->properties_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->properties_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Properties.php */
/* Location: ./application/modules/properties/controllers/Properties.php */