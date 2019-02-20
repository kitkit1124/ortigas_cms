<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Videos Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Aldrin Magno <aldrin.magno@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Videos extends MX_Controller 
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
		$this->load->model('videos_model');
		$this->load->model('video_uploads_model');
		$this->load->language('videos');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('files.videos.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('videos'));
		
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
		$this->template->add_css(module_css('files', 'videos_index'), 'embed');
		$this->template->add_js(module_js('files', 'videos_index'), 'embed');
		$this->template->write_view('content', 'videos_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('files.videos.list');

		echo $this->videos_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * rte
	 *
	 * @access	public
	 * @param	string $type
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	function rte($type = 'mce')
	{
		$action = 'add';

		$this->acl->restrict('files.videos.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		$this->load->view('videos_rte_' . $type, $data);
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('files.videos.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($info = $this->_save($action, $id))
			{
				$data['record'] = $this->videos_model->find($info);
				echo json_encode(array('success' => true, 'message' => lang($action . '_success'), 'info' => $data['record'])); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'video_name'		=> form_error('video_name'),
					'video_link'		=> form_error('video_link'),
					'video_type'		=> form_error('video_type'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->videos_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');
		$this->template->add_css(module_css('files', 'videos_form'), 'embed');
		$this->template->add_js(module_js('files', 'videos_form'), 'embed');
		$this->template->write_view('content', 'videos_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * view
	 *
	 * @access	public
	 * @param   $id integer
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	function view($id)
	{
		$this->acl->restrict('files.videos.view', 'modal');

		$data['record'] = $this->videos_model->find($id);
		$data['page_heading'] = $data['record']->video_name;

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('files', 'videos_view'), 'embed');
		$this->template->add_js(module_js('files', 'videos_view'), 'embed');
		$this->template->write_view('content', 'videos_view', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('files.videos.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->videos_model->delete($id);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}


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
		$config['allowed_types'] = 'mp4|avi';
		$config['file_size']  = 20000;
		$config['max_size']	= 20000;
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
			$video_data = $this->upload->data();

			// add to db

			$folder = str_replace(getenv('UPLOAD_FOLDER'),"",$folder);
			$data = array(
			    'video_location'     => $folder.'/'.$video_data['file_name']
			);
			$this->video_uploads_model->update(1, $data);

			//$response = $this->_resize($image_data, $folder);
			
			$response = array(
				'status'	=> 'success',
				'message'	=> lang('add_success'),
				'video_source'	=> $folder.'/'.$video_data['file_name'],
			);

			echo json_encode($response);
			exit;
		}
	}



	// --------------------------------------------------------------------

	/**
	 * _save
	 *
	 * @access	private
	 * @param	string $action
	 * @param 	integer $id
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('video_name', lang('video_name'), 'required');
		$this->form_validation->set_rules('video_link_id', lang('video_link_id'), 'required');
		$this->form_validation->set_rules('video_type', lang('video_type'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$link_youtube = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $this->input->post('video_link_id') . '&key=' . $this->config->item('youtube_api_key');
		$link_vimeo = 'http://vimeo.com/api/v2/video/' . $this->input->post('video_link_id') . '.json';

		$type = "";
		$thumb = 'http://img.youtube.com/vi/' . $this->input->post('video_link_id') . '/default.jpg';

		// // check if youtube video id correct
		// if($this->input->post('video_type') == "Youtube")
		// if(@file_get_contents($link_youtube))
		// {
		// 	$youtube = file_get_contents($link_youtube);
		// 	$json1 = json_decode($youtube, true);
		// }

		// // check if vimeo id is correct
		// if($this->input->post('video_type') == "Vimeo")
		// if(@file_get_contents($link_vimeo))
		// {
		// 	$vimeo = file_get_contents($link_vimeo);
		// 	$json2 = json_decode($vimeo, true);
		// }

		// // get thumbnail and video name in youtube/vimeo
		// if (isset($json1['items']['0']['snippet']['thumbnails']['medium']['url']))
		// {
		// 	$type = 'Youtube';

		// 	$thumb = $json1['items']['0']['snippet']['thumbnails']['medium']['url'];
		// 	$name = $json1['items']['0']['snippet']['title'];
		// }
		// elseif (isset($json2[0]['thumbnail_medium']))
		// {
		// 	$thumb = $json2[0]['thumbnail_medium'];
		// 	$name = $json2[0]['title'];

		// 	$type = 'Vimeo';
		// }
		// else
		// {
		// 	return FALSE;
		// }

		$data = array(
			'video_name'		=> $this->input->post('video_name'),
			'video_link_id'		=> $this->input->post('video_link_id'),
			'video_type'		=> $this->input->post('video_type'),
			'video_thumb'		=> $thumb
		);
		if ($action == 'add')
		{
			$insert_id = $this->videos_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->videos_model->update($id, $data);
		}
		return $return;
	}
}

/* End of file Videos.php */
/* Location: ./application/modules/files/controllers/Videos.php */