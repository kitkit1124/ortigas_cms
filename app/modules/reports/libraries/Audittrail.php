<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Audittrail Class
 *
 * This class adds database activities
 *
 * @package		Audittrail
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014, Randy Nivales
 * @link		
 */

class Audittrail
{

	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->database();
	}

	public function insert($action, $table, $data = array())
	{
		if ($this->CI->db->table_exists('audittrails'))
		{
			$data = array(
				'audittrail_action'			=> $action,
				'audittrail_table'			=> $table,
				'audittrail_data'			=> json_encode($data),
				'audittrail_user_ip'		=> $this->CI->input->ip_address(),
				'audittrail_user_agent'		=> $this->CI->input->user_agent(),
				'audittrail_created_by' 	=> $this->CI->session->userdata('user_id'),
				'audittrail_created_on' 	=> date('Y-m-d H:i:s'),
			);

			$this->CI->db->insert('audittrails', $data);

			log_message('debug', print_r($data, TRUE));
		}

		return TRUE;
	}
}

/* End of file Audittrail.php */
/* Location: ./application/modules/reports/libraries/Audittrail.php */