<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Navigroups_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Navigroups_model extends BF_Model 
{

	protected $table_name			= 'navigroups';
	protected $key					= 'navigroup_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'navigroup_created_on';
	protected $created_by_field		= 'navigroup_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'navigroup_modified_on';
	protected $modified_by_field	= 'navigroup_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'navigroup_deleted';
	protected $deleted_by_field		= 'navigroup_deleted_by';
}