<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dashboard Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Dashboard extends CI_Controller 
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
		$this->load->language('dashboard');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function index()
	{
		// cache this page for 2 mins
		// $this->output->cache(2);
		
		// check if database is already installed
		// comment out these lines after installation
		$this->load->dbutil();
		if (! $this->db->table_exists('users'))
		{
			show_error('You must run the installer to use this app.');
		}

		$permission = $this->acl->restrict('dashboard.dashboard.list', 'return');
		if (!$permission) show_404();

		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('dashboard'));

		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		$this->template->write_view('content', 'dashboard_index', $data);
		$this->template->render();
	}
}

/* End of file dashboard.php */
/* Location: ./application/modules/dashboard/controllers/dashboard.php */