<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Grants_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Grants_model extends BF_Model 
{
	protected $table_name			= 'grants';
	protected $key					= 'grant_id';
	protected $log_user				= FALSE;
	protected $set_created			= FALSE;
	protected $set_modified			= FALSE;
	protected $soft_deletes			= FALSE;

	// --------------------------------------------------------------------

	/**
	 * check_grants
	 *
	 * @access	public
	 * @param	integer $group_id
	 * @param	integer $permission_id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function check_grants($group_id, $permission_id)
	{
		if (is_array($group_id))
		{
			$this->db->where_in('grant_group_id', $group_id);
		}
		else
		{
			$this->db->where('grant_group_id', $group_id);
		}

		$this->db->where('grant_permission_id', $permission_id); 
		$this->db->where('grant_access !=', 0);
		$this->db->order_by('grant_access');
		$query = $this->db->get($this->table_name);
		$result = $query->row();

		return ($result) ? $result->grant_access : FALSE;
	}
}