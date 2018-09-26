<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Auditlogs_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Audittrails_model extends BF_Model 
{

	protected $table_name			= 'audittrails';
	protected $key					= 'audittrail_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'audittrail_created_on';
	protected $created_by_field		= 'audittrail_created_by';

	protected $set_modified			= FALSE;

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'audittrail_deleted';
	protected $deleted_by_field		= 'audittrail_deleted_by';

	public function get_datatables()
	{
		$fields = array(
			'audittrail_id', 
			'audittrail_action', 
			'audittrail_table', 
			'CONCAT(first_name, " ", last_name)',
			'audittrail_user_ip', 
			'audittrail_created_on'
		);
		return $this->join('users', 'id = audittrail_created_by', 'LEFT')->datatables($fields);
	}

	// --------------------------------------------------------------------

	/**
	 * export
	 *
	 * @access	public
	 * @param	string
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function export($keyword)
	{
		$fields = array(
			'audittrail_id', 
			'audittrail_action', 
			'audittrail_table', 
			'audittrail_data', 
			'first_name',
			'last_name',
			'audittrail_user_ip', 
			'audittrail_created_on'
		);

		// prepare fields
		$select_fields = implode(', ', $fields);

		// $condition
		$condition = "";

		if (! empty($keyword))
		{
			// prepare array condition
			$filters = array();
			foreach ($fields as $field)
			{
				$filters[] = "{$field} LIKE '%{$this->db->escape_like_str($keyword)}%'";
			}

			// prepare SQL condition
			$condition = ' AND (' . implode(' OR ', $filters) . ')';
		}

		// prepare query
		$result = $this->db->query("SELECT {$select_fields} FROM {$this->table_name} LEFT JOIN users ON (id = audittrail_created_by) WHERE audittrail_deleted = 0 {$condition}");

		// process result
		$export = $this->dbutil->csv_from_result($result);

		// filename
		$file = 'audittrail-' . uniqid() . '.csv';

		// force download file
		force_download($file, $export);
	}

	// --------------------------------------------------------------------

	/**
	 * truncate
	 *
	 * @access	public
	 * @param	string
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function truncate()
	{
		return $this->db->truncate($this->table_name);
	}
}