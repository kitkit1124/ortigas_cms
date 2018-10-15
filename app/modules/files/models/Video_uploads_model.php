<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Videos_uploads_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutz Marzan <codifire@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Video_uploads_model extends BF_Model 
{

	protected $table_name			= 'video_uploads';
	protected $key					= 'video_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'video_created_on';
	protected $created_by_field		= 'video_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'video_modified_on';
	protected $modified_by_field	= 'video_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'video_deleted';
	protected $deleted_by_field		= 'video_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutz Marzan <codifire@digify.com.ph>
	 */

}