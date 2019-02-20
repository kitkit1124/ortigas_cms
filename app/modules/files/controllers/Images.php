<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Images Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Aldrin Magno <aldrin.magno@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Images extends MX_Controller 
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
		$this->load->model('images_model');
		$this->load->language('images');
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
		$this->acl->restrict('files.images.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('files'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('files/images'));
		
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
		$this->template->add_css(module_css('files', 'images_index'), 'embed');
		$this->template->add_js(module_js('files', 'images_index'), 'embed');
		$this->template->write_view('content', 'images_index', $data);
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
		$this->acl->restrict('files.images.list');

		echo $this->images_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * view
	 *
	 * @access	public
	 * @param   $id integer
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function view($id, $action = 'edit')
	{
		$this->acl->restrict('files.images.view', 'modal');

		$data['record'] = $this->images_model->find($id);
		$data['page_heading'] = $data['record']->image_name;

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
					'image_name'		=> form_error('image_name'),
				);
				echo json_encode($response);
				exit;
			}
		}

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('files', 'images_view'), 'embed');
		$this->template->add_js(module_js('files', 'images_view'), 'embed');
		$this->template->write_view('content', 'images_view', $data);
		$this->template->render();
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
		$this->acl->restrict('files.images.' . $action, 'modal');

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
					'image_name'		=> form_error('image_name'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->images_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_css('npm/dropzone/dropzone.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_js('npm/dropzone/dropzone.js');
		$this->template->add_css(module_css('files', 'images_form'), 'embed');
		$this->template->add_js(module_js('files', 'images_form'), 'embed');
		$this->template->write_view('content', 'images_form', $data);
		$this->template->render();
	}


	// --------------------------------------------------------------------

	/**
	 * rte
	 *
	 * @access	public
	 * @param	string $type
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function rte($type = 'mce')
	{
		$action = 'add';

		$this->acl->restrict('files.images.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		$this->load->view('images_rte_' . $type, $data);
	}

	// --------------------------------------------------------------------

	/**
	 * modal
	 *
	 * @access	public
	 * @param	string $type
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function modal($field_id)
	{
		$action = 'add';

		$this->acl->restrict('files.images.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;
		$data['field_id'] = $field_id;

		$this->load->view('images_modal', $data);
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
		$this->acl->restrict('files.images.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$image = $this->images_model->find($id);

			if ($image)
			{
				// delete the original image
				if (file_exists(FCPATH . $image->image_file))
				{
					unlink(FCPATH . $image->image_file);
				}

				// delete the thumbnail
				if (file_exists(FCPATH . $image->image_thumb))
				{
					unlink(FCPATH . $image->image_thumb);
				}

				// delete the db record
				$this->images_model->delete($id);
			}

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * upload
	 *
	 * @access	public
	 * @param	
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	public function upload()
	{
		$this->acl->restrict('files.images.add');

		// get the current upload folder
		$this->load->library('upload_folders');
		$folder = $this->upload_folders->get();

		// upload config
		$config = array();
		$config['upload_path'] = $folder;
		$config['allowed_types'] = 'jpeg|jpg|png|gif';
		$config['max_size']	= 0;
		$config['max_width']  = 0;
		$config['max_height']  = 0;
		// $config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if ($this->security->xss_clean($_FILES['file'], TRUE) === FALSE)
		{
			$response = array(
				'status'    => 'failed',
				'error'     => 'Invalid file'
			);
			echo json_encode($response); exit;
		}
		elseif ( ! $this->upload->do_upload('file'))
		{
			$response = array(
				'status'    => 'failed',
				'error'     => $this->upload->display_errors()
			);
			echo json_encode($response); exit;
		}
		else
		{
			// upload the image
			$image_data = $this->upload->data();

			// resize the image
			$response = $this->_resize($image_data, $folder);

			echo json_encode($response);
			exit;
		}
	}


	// --------------------------------------------------------------------

	/**
	 * crop
	 *
	 * @access	public
	 * @param	array $image_data
	 * @param 	integer $id
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	public function crop()
	{
		if(!$this->input->post())
		{
			$this->acl->restrict('files.images.list');

			// page title
			$data['page_heading'] = lang('index_heading');
			$data['page_subhead'] = lang('index_crop');

			$data['record'] = $this->images_model->find($this->uri->segment(4));

			// breadcrumbs
			$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
			$this->breadcrumbs->push(lang('crumb_module'), site_url('files'));
			$this->breadcrumbs->push(lang('index_heading'), site_url('files/images'));

			$this->template->add_css(module_css('files', 'Jcrop'), 'embed');
			$this->template->add_css(module_css('files', 'images_view'), 'embed');
			$this->template->add_js(module_js('files', 'Jcrop'), 'embed');
			$this->template->add_js(module_js('files', 'crop_modal'), 'embed');

			// session breadcrumb
			$this->session->set_userdata('redirect', current_url());

			// render the page
			$this->template->add_css(module_css('files', 'images_index'), 'embed');
			$this->template->add_js(module_js('files', 'images_index'), 'embed');
			$this->template->write_view('content', 'images_crop', $data);
			$this->template->render();

		}
		else
		{
			$ini_filename = $this->input->post('path');
			// convert image to binary
			$im = imagecreatefromjpeg($ini_filename);

			//crop image
			$param = array('x' => $this->input->post('cropx'), 'y' => $this->input->post('cropy'), 'width' => $this->input->post('cropw'), 'height' => $this->input->post('croph'));
			$thumb_im = imagecrop($im, $param);

			$t = substr(uniqid(), -4);

			// generate crop image
			$ext = strstr($this->input->post('path_only'), '.');
			$path = strstr($this->input->post('path_only'), '.', true) . $t . '-crop' . $ext;
			imagejpeg($thumb_im, $path, 100);

			// get the current upload folder
			$this->load->library('upload_folders');
			$folder = $this->upload_folders->get();

			if (strpos($this->input->post('cropname'), ".") === true)
			{
				$image_name = strstr($this->input->post('cropname'), '.', true) . $t . '-crop';
			}
			else
			{
				$image_name = strstr($this->input->post('cropname'), '.', true) . $t . '-crop';
			}
			$image_data = array(
				'full_path' 	=> $this->input->post('path_only'),
				'raw_name' 		=> $image_name,
				'file_ext' 		=> $ext,
				'image_width' 	=> (int) $this->input->post('cropw'),
				'image_height' 	=> (int) $this->input->post('croph'),
				'orig_name' 	=> $image_name . $ext
			);

			// resize the image
			$this->_resize($image_data, $folder);

			header('Location: ' . base_url() . 'files/images');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _resize
	 *
	 * @access	private
	 * @param	array $image_data
	 * @param 	integer $id
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	private function _resize($image_data, $folder)
	{
		$this->load->library('image_lib');

		$image_sizes = array('large', 'medium', 'small', 'thumb');

		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_data['full_path'];
		$config['maintain_ratio'] = TRUE;
		$config['master_dim'] = 'width';

		$image_file = $folder . '/' . $image_data['raw_name'].$image_data['file_ext'];

		foreach ($image_sizes as $image_size)
		{
			$size = $this->config->item('image_size_' . $image_size);
			// check for correct size format
			if (preg_match('/^[0-9]*x[0-9]*$/', $size))
			{
				list($width, $height) = explode('x', $size);

				// resize only if the image is bigger
				if ($image_data['image_width'] > $width)
				{
					// resize the image
					$config['width'] = $width;
					$config['height'] = $height;
					$config['quality'] = '100%';
					$config['new_image'] =  $folder . '/' . $image_data['raw_name'] . '_' . $image_size . $image_data['file_ext'];
					$this->image_lib->initialize($config);
					$this->image_lib->resize();

					$new_image[$image_size] = $folder . '/' . $image_data['raw_name'].'_' . $image_size  . $image_data['file_ext'];
				}
			}
		}

		$image_file = str_replace(getenv('UPLOAD_FOLDER'),"",$image_file);

		// add to db
		$data = array(
			'image_width'		=> $image_data['image_width'],
			'image_height'		=> $image_data['image_height'],
			'image_name'		=> $image_data['orig_name'],
			'image_file'		=> $image_file,
			'image_large'		=> (isset($new_image['large'])) ? str_replace(getenv('UPLOAD_FOLDER'),"",$new_image['large']) : '',
			'image_medium'		=> (isset($new_image['medium'])) ? str_replace(getenv('UPLOAD_FOLDER'),"",$new_image['medium']) : '',
			'image_small'		=> (isset($new_image['small'])) ? str_replace(getenv('UPLOAD_FOLDER'),"",$new_image['small']) : '',
			'image_thumb'		=> (isset($new_image['thumb'])) ? str_replace(getenv('UPLOAD_FOLDER'),"",$new_image['thumb']) : $image_file,
		);
		$this->images_model->insert($data);

		// output
		$response = array(
			'status'	=> 'success',
			'message'	=> lang('add_success'),
			'name'		=> $image_data['raw_name'],
			'host'		=> (NULL !== $this->config->item('website_url')) ? $this->config->item('website_url') : site_url(),
			'image'		=> $image_file,
			'large'		=> $data['image_large'],
			'medium'	=> $data['image_medium'],
			'small'		=> $data['image_small'],
			'thumb'		=> $data['image_thumb'],
		);

		return $response;
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
	 //	$this->form_validation->set_rules('image_width', lang('image_width'), 'required');
	 //	$this->form_validation->set_rules('image_height', lang('image_height'), 'required');
	 	$this->form_validation->set_rules('image_name', lang('image_name'), 'required');
	 //	$this->form_validation->set_rules('image_file', lang('image_file'), 'required');
	 //	$this->form_validation->set_rules('image_thumb', lang('image_thumb'), 'required');

	 	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
	 	if ($this->form_validation->run($this) == FALSE)
	 	{
	 		return FALSE;
	 	}

	 	$data = array(
	 	//	'image_width'		=> $this->input->post('image_width'),
	 	//	'image_height'		=> $this->input->post('image_height'),
	 		'image_name'		=> $this->input->post('image_name'),
	 	//	'image_file'		=> $this->input->post('image_file'),
	 	//	'image_thumb'		=> $this->input->post('image_thumb'),
	 	);
		

	 	if ($action == 'add')
	 	{
	 		$insert_id = $this->images_model->insert($data);
	 		$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
	 	}
	 	else if ($action == 'edit')
	 	{
	 		$return = $this->images_model->update($id, $data);
	 	}

	 	return $return;
	 }
}

/* End of file Images.php */
/* Location: ./application/modules/files/controllers/Images.php */