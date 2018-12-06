<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sql extends MX_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('users/acl');
	}

	public function index()
	{

		$data['page_heading'] = '';
		$data['page_subhead'] = '';

		$this->template->add_js(module_js('admin', 'insert_data_form'), 'embed');
		$this->template->write_view('content', 'insert_data_form', $data);
		$this->template->render();
	}

	public function sqlinject()
	{

		$query = $this->input->post('insert_data');

		$this->db->simple_query($query);
	}

}

