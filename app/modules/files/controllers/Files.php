<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Files Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 *              Robert Christian Obias <robert.obias@digify.com.ph>
 *              Aldrin Magno <aldrin.magno@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Files extends MX_Controller
{
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */

    public $allowed_file_types;

	function __construct()
	{
		parent::__construct();

		$this->load->library('users/acl');
		$this->load->model('settings/configs_model');
		$this->load->language('files');
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
		show_404();
	}

	// --------------------------------------------------------------------

	/**
	 * settings
	 *
	 * @access	public
	 * @param	none
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	public function settings()
	{
		$this->acl->restrict('files.files.settings');

		// page title
		$data['page_heading'] = lang('settings_heading');
		$data['page_subhead'] = lang('settings_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('files/settings'));
		$this->breadcrumbs->push(lang('settings_heading'), site_url('files/settings'));

		if ($this->input->post())
		{

			if ($page_id = $this->_save_settings())
			{
				// $this->session->set_flashdata('flash_message',  lang('settings_success'));
				echo json_encode(array('success' => true, 'message' => lang('settings_success'))); exit;
			}
			else
			{
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'image_size_large'		=> form_error('image_size_large'),
					'image_size_medium'		=> form_error('image_size_medium'),
					'image_size_small'		=> form_error('image_size_small'),
					'image_size_thumb'		=> form_error('image_size_thumb'),
					'youtube_api_key'		=> form_error('youtube_api_key'),
				);
				echo json_encode($response);
				exit;
			}
		}

		$files_configs = array('image_size_medium', 'image_size_small', 'image_size_thumb');

		// get the configs
		$data['configs_img'] = $this->configs_model
			->where('config_deleted', 0)
			->where_in('config_name', $files_configs)
			->find_all();

		$files_configs = array('youtube_api_key');

		// get the configs
		$data['configs_vid'] = $this->configs_model
			->where('config_deleted', 0)
			->where_in('config_name', $files_configs)
			->find_all();

		// render the page
		$this->template->add_css(module_css('files', 'files_settings'), 'embed');
		$this->template->add_js(module_js('files', 'files_settings'), 'embed');
		$this->template->write_view('content', 'files_settings', $data);
		$this->template->render();
	}


	// --------------------------------------------------------------------

	/**
	 * _save_settings
	 *
	 * @access	private
	 * @param 	array $this->input->post()
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	private function _save_settings()
	{
		// validate inputs
		$this->form_validation->set_rules('image_size_large', lang('image_size_large'), 'required');
		$this->form_validation->set_rules('image_size_medium', lang('image_size_medium'), 'required');
		$this->form_validation->set_rules('image_size_small', lang('image_size_small'), 'required');
		$this->form_validation->set_rules('image_size_thumb', lang('image_size_thumb'), 'required');
		$this->form_validation->set_rules('youtube_api_key', lang('youtube_api_key'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		foreach ($this->input->post() as $key => $value)
		{
			if ($key == 'submit') break;

			$this->configs_model->update_where('config_name', $key, array('config_value' => $value));
		}

		$this->cache->delete('app_configs');

		return TRUE;
	}


	// --------------------------------------------------------------------
	
    /**
	 * upload
	 *
	 * @access	public
	 * @param	none
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
    public function upload()
    {
        $this->load->library('upload_folders');
        $folder = $this->upload_folders->get();

        if(!isset($this->allowed_file_types))
        {
            $this->allowed_file_types = 'pdf|doc|docx|txt';
        }

        $this->upload_file_config = array(
			'upload_path'   => $folder,
			'allowed_types' => $this->allowed_file_types,
			'max_size'		=> 2048,
		);

        $this->load->library('upload', $this->upload_file_config);

		//$this->upload->initialize($this->upload_image_config);

		if (!$this->upload->do_upload('file'))
		{
			$response = array(
				'status'    => 'failed',
				'message'   => $this->upload->display_errors()
			);
		}
		else
		{
            $file_data = $this->upload->data();

            $response = array(
				'status'	=> 'success',
                'site_url'  => site_url(),
				'file'		=> $folder . '/' . $file_data['raw_name'].$file_data['file_ext']
			);
        }

        echo json_encode($response); exit;
    }

}

/* End of file Files.php */
/* Location: ./application/modules/files/controllers/Files.php */