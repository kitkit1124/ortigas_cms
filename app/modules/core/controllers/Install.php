<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Install extends CI_Controller 
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

		$this->load->library('migration');
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
		// TODO: check for successful db connection; else, show how to setup db

		// $this->load->dbutil();
		// if (! $this->dbutil->database_exists($this->db->database))
		// {
		// 	show_error('There was an error connecting to the database. Please setup the database and configure application/config/' . ENVIRONMENT . '/database.php');
		// }

		// install the core tables
		if ($this->_migrate('users') AND $this->_migrate('admin') AND $this->_migrate('settings') AND $this->_migrate('reports'))
		{
			redirect(''); // redirect to dashboard
		}
		else
		{
			show_error('There was an error with the migration.');
		}
	}


	// --------------------------------------------------------------------

	/**
	 * _migrate
	 *
	 * @access	private
	 * @param	string $module
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _migrate($module)
	{
		if ($this->migration->init_module($module)) 
		{
			if (! $this->migration->current()) 
			{
				show_error($this->migration->error_string());
			}
			else 
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}
}