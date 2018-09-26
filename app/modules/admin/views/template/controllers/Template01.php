<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * {{ucf_plural_module_name}} Class
 *
 * @package	{{package_name}}
 * @version		{{module_version}}
 * @author 		{{author_name}} <{{author_email}}>
 * @copyright 	Copyright (c) {{copyright_year}}, {{copyright_name}}
 * @link		{{copyright_link}}
 */
class {{ucf_plural_module_name}} extends MX_Controller {
	
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
		$this->load->language('{{lc_plural_module_name}}');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	{{author_name}} <{{author_email}}>
	 */
	public function index()
	{
		$this->acl->restrict('{{parent_module}}.{{lc_plural_module_name}}.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('{{lc_plural_module_name}}'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		{{embed_datetime_plugin}}
		
		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

		// render the page
		$this->template->add_css(module_css('{{parent_module}}', '{{lc_plural_module_name}}_index'), 'embed');
		$this->template->add_js(module_js('{{parent_module}}', '{{lc_plural_module_name}}_index'), 'embed');
		$this->template->write_view('content', '{{lc_plural_module_name}}_index', $data);
		$this->template->render();
	}	
}

/* End of file {{ucf_plural_module_name}}.php */
/* Location: ./application/modules/{{parent_module}}/controllers/{{ucf_plural_module_name}}.php */