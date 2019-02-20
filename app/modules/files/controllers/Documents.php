<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Documents Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Aldrin Magno <aldrin.magno@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Documents extends MX_Controller 
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
		$this->load->model('documents_model');
		$this->load->language('documents');
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
		$this->acl->restrict('files.documents.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('documents'));
		
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
		$this->template->add_css(module_css('files', 'documents_index'), 'embed');
		$this->template->add_js(module_js('files', 'documents_index'), 'embed');
		$this->template->write_view('content', 'documents_index', $data);
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
		$this->acl->restrict('files.documents.list');

		echo $this->documents_model->get_datatables();
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
		$this->acl->restrict('files.documents.' . $action, 'modal');

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
		$this->template->add_js(module_js('files', 'documents_form'), 'embed');
		$this->template->write_view('content', 'documents_form', $data);
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
		$this->acl->restrict('files.documents.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->documents_model->delete($id);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
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

		$this->acl->restrict('files.documents.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		$this->load->view('documents_rte_' . $type, $data);
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
		$config['allowed_types'] = 'xlsx|docx|one|pptx|doc|xlsb|xls|asd|dotx|dot|docm|ppt|pptm|xltx|ppsm|xla|ppsx|xlt|ppsx|xlt|psw|uot|hwp|odm|sxg|sxc|sxc|pdf|docx';
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
			// upload the document
			$document_data = $this->upload->data();

			// determine thumbnail
			switch ($document_data['file_ext'])
			{
				case ".docx":
				case ".doc":
				case ".dotx":
				case ".dot":
				case ".docm":
					$thumb = 'fa fa-file-word-o fa-5x';
					break;
				case ".xlsx":
				case ".xlsb":
				case ".xls":
				case ".xltx":
				case ".xla":
				case ".xlt":
					$thumb = 'fa fa-file-excel-o fa-5x';
					break;
				case ".pptx":
				case ".ppt":
				case ".pptm":
				case ".ppsm":
				case ".ppsx":
				case ".psw":
					$thumb = 'fa fa-file-powerpoint-o fa-5x';
					break;
				case ".pdf":
					$thumb = 'fa fa-file-pdf-o fa-5x';
					break;
			}

			$document_name = $document_data['orig_name'];

			// add to db

			$folder = str_replace(getenv('UPLOAD_FOLDER'),"",$folder);
			
			$data = array(
				'document_name'		=> $document_name,
				'document_file'		=> $folder . '/' . $document_name,
				'document_thumb'	=> $thumb
			);
			$this->documents_model->insert($data);

			echo json_encode($data);
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
		$this->form_validation->set_rules('document_name', lang('document_name'), 'required');
		$this->form_validation->set_rules('document_file', lang('document_file'), 'required');
		$this->form_validation->set_rules('document_thumb', lang('document_thumb'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'document_name'		=> $this->input->post('document_name'),
			'document_file'		=> $this->input->post('document_file'),
			'document_thumb'	=> $this->input->post('document_thumb'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->documents_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->documents_model->update($id, $data);
		}
		
		return $return;
	}
}

/* End of file Documents.php */
/* Location: ./application/modules/files/controllers/Documents.php */