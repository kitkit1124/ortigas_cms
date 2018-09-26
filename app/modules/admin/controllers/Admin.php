<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Admin extends MX_Controller 
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
		// redirect to the list of modules
		redirect('admin/module/action/list', 'refresh');
	}
}

/* End of file Admin.php */
/* Location: ./application/modules/admin/controllers/Admin.php */