<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Image_sliders_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Image_sliders_model extends BF_Model {

	protected $table_name			= 'image_sliders';
	protected $key					= 'image_slider_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'image_slider_created_on';
	protected $created_by_field		= 'image_slider_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'image_slider_modified_on';
	protected $modified_by_field	= 'image_slider_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'image_slider_deleted';
	protected $deleted_by_field		= 'image_slider_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_datatables
	 *
	 * @access	public
	 * @param	none
	 * @author 	Gutzby Marzan <gutzby.marzan@digify.com.ph>
	 */
	public function get_datatables()
	{
		$fields = array(
			'image_slider_id',
			'image_slider_section_type',
			'image_slider_section_id',
			'image_slider_image',
			'image_slider_title',
			'image_slider_title_size',
			'image_slider_title_pos',
			'image_slider_caption',
			'image_slider_caption_size',
			'image_slider_caption_pos',
			'image_slider_order',
			'image_slider_status',

			'image_slider_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'image_slider_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = image_slider_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = image_slider_modified_by', 'LEFT')
					->datatables($fields);
	}
}