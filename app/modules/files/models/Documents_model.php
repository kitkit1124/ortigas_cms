<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Documents_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <codifire@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Documents_model extends BF_Model 
{

	protected $table_name			= 'documents';
	protected $key					= 'document_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'document_created_on';
	protected $created_by_field		= 'document_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'document_modified_on';
	protected $modified_by_field	= 'document_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'document_deleted';
	protected $deleted_by_field		= 'document_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Digify Admin <codifire@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'document_id', 
			'document_name',
			'document_file',
			'document_thumb',

			'document_created_on', 
			
			'document_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = document_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = document_modified_by', 'LEFT')
					->datatables($fields);
	}
}