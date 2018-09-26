<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migrations Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2016, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Migrations extends MX_Controller 
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
		$this->load->library('migration');
		$this->load->language('migrations');
	}

	// --------------------------------------------------------------------

	/**
	 * rollback
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function rollback($module = FALSE, $version = 1)
	{
		if (! $module) show_404();

		$this->acl->restrict('admin.migrations.rollback', 'modal');

		$data['page_heading'] = lang('rollback_heading');
		$data['page_confirm'] = lang('rollback_confirm');
		$data['page_button'] = lang('button_rollback');

		if ($this->input->post())
		{
			if ($this->migration->init_module($module)) 
			{
				if (! $this->migration->version($version)) 
				{
					echo json_encode(array('success' => FALSE, 'message' => $this->migration->error_string())); exit;
				}
				else 
				{
					$this->cache->delete('app_menu');
					$this->cache->delete('app_grants');
					
					$this->session->set_flashdata('flash_message', lang('rollback_success'));
					echo json_encode(array('success' => TRUE)); exit;
				}
			}
			else
			{
				echo json_encode(array('success' => FALSE, 'message' => 'There was an error with the rollback.')); exit;
			}
		}

		$this->load->view('../../modules/core/views/confirm', $data);	
	}

	// --------------------------------------------------------------------

	/**
	 * migrate
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function migrate($module = FALSE, $action = 'install')
	{
		if (! $module) show_404();

		$this->acl->restrict('admin.migrations.migrate', 'modal');

		$data['page_heading'] = ($action == 'install') ? lang('install_heading') : lang('migrate_heading');
		$data['page_confirm'] = ($action == 'install') ? lang('install_confirm') : lang('migrate_confirm');
		$data['page_button'] = ($action == 'install') ? lang('button_install') : lang('button_upgrade');

		if ($this->input->post())
		{
			if ($this->migration->init_module($module)) 
			{
				if (! $this->migration->current()) 
				{
					echo json_encode(array('success' => FALSE, 'message' => $this->migration->error_string())); exit;
				}
				else 
				{
					$this->cache->delete('app_menu');
					$this->cache->delete('app_grants');

					$this->session->set_flashdata('flash_message', ($action == 'install') ? lang('install_success') :lang('migrate_success'));
					echo json_encode(array('success' => TRUE)); exit;
				}
			}
			else
			{
				echo json_encode(array('success' => FALSE, 'message' => 'There was an error.')); exit;
			}
		}

		$this->load->view('../../modules/core/views/confirm', $data);	
	}
}

/* End of file Migrations.php */
/* Location: ./application/modules/admin/controllers/Migrations.php */