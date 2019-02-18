<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Metatags Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Metatags extends MX_Controller 
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
		$this->load->model('metatags_model');
		$this->load->language('metatags');
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
	function form($module = FALSE, $model = FALSE, $id = FALSE)
	{
		// check the parameters
		if (!$module OR !$model OR !$id)
		{
			$this->acl->message('error', 'Invalid request');
		}

		// get the record
		$model = $model . '_model';
		$this->load->model($module . '/' . $model);
		$record = $this->$model->find($id);
		$data['content'] = $record;

		// get the metatag key 
		$metatag_key = $this->$model->metatag_key;
		
		// check if metatag_key exists
		if (! isset($metatag_key) OR ! isset($record->$metatag_key))
		{
			$this->acl->message('error', 'Meta tag key does not exist or Metatags module is not installed');
		}

		$action = ($record->$metatag_key) ? 'edit' : 'add';

		$this->acl->restrict('metatags.metatags.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		if ($this->input->post())
		{
			$id = ($action == 'add') ? $id : $record->$metatag_key;
			if ($this->_save($module, $model, $action, $id))
			{
				echo json_encode(array('success' => true, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(			
					'metatag_robots'				=> form_error('metatag_robots'),
					'metatag_code'					=> form_error('metatag_code'),		
					'metatag_title'					=> form_error('metatag_title'),
					'metatag_keywords'				=> form_error('metatag_keywords'),
					'metatag_description'			=> form_error('metatag_description'),
					'metatag_og_title'				=> form_error('metatag_og_title'),
					'metatag_og_image'				=> form_error('metatag_og_image'),
					'metatag_og_description'		=> form_error('metatag_og_description'),
					'metatag_twitter_title'			=> form_error('metatag_twitter_title'),
					'metatag_twitter_image'			=> form_error('metatag_twitter_image'),
					'metatag_twitter_description'	=> form_error('metatag_twitter_description'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->metatags_model->find($record->$metatag_key);

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
		$this->template->add_css(module_css('metatags', 'metatags_form'), 'embed');
		$this->template->add_js(module_js('metatags', 'metatags_form'), 'embed');
		$this->template->write_view('content', 'metatags_form', $data);
		$this->template->render();
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
	private function _save($module, $model, $action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('metatag_title', lang('metatag_title'), 'required');
		// $this->form_validation->set_rules('metatag_keywords', lang('metatag_keywords'), 'required');
		// $this->form_validation->set_rules('metatag_description', lang('metatag_description'), 'required');
		// $this->form_validation->set_rules('metatag_og_title', lang('metatag_og_title'), 'required');
		// $this->form_validation->set_rules('metatag_og_image', lang('metatag_og_image'), 'required');
		// $this->form_validation->set_rules('metatag_og_url', lang('metatag_og_url'), 'required');
		// $this->form_validation->set_rules('metatag_og_description', lang('metatag_og_description'), 'required');
		// $this->form_validation->set_rules('metatag_twitter_title', lang('metatag_twitter_title'), 'required');
		// $this->form_validation->set_rules('metatag_twitter_image', lang('metatag_twitter_image'), 'required');
		// $this->form_validation->set_rules('metatag_twitter_url', lang('metatag_twitter_url'), 'required');
		// $this->form_validation->set_rules('metatag_twitter_description', lang('metatag_twitter_description'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'metatag_robots'				=> $this->input->post('metatag_robots'),
			'metatag_code'				=> $this->input->post('metatag_code'),
			'metatag_title'					=> $this->input->post('metatag_title'),
			'metatag_keywords'				=> $this->input->post('metatag_keywords'),
			'metatag_description'			=> $this->input->post('metatag_description'),
			'metatag_og_title'				=> $this->input->post('metatag_og_title'),
			'metatag_og_image'				=> $this->input->post('metatag_og_image'),
			'metatag_og_description'		=> $this->input->post('metatag_og_description'),
			'metatag_twitter_title'			=> $this->input->post('metatag_twitter_title'),
			'metatag_twitter_image'			=> $this->input->post('metatag_twitter_image'),
			'metatag_twitter_description'	=> $this->input->post('metatag_twitter_description'),
		);

		if ($action == 'add')
		{
			$insert_id = $this->metatags_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;

			// also update the parent record
			$this->load->model($module . '/' . $model);
			$this->$model->update($id, array($this->$model->metatag_key => $insert_id));
		}
		else
		{
			$return = $this->metatags_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Metatags.php */
/* Location: ./application/modules/metatags/controllers/Metatags.php */