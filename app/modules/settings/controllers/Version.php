<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Version Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Version extends MX_Controller 
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
		echo $this->config->item('app_version');
	}
}

/* End of file Version.php */
/* Location: ./application/modules/settings/controllers/Version.php */