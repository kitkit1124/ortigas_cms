<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Property_sliders_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Property_sliders_model extends BF_Model {

	protected $table_name			= 'property_sliders';
	protected $key					= 'property_slider_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'property_slider_created_on';
	protected $created_by_field		= 'property_slider_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'property_slider_modified_on';
	protected $modified_by_field	= 'property_slider_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'property_slider_deleted';
	protected $deleted_by_field		= 'property_slider_deleted_by';

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
			'property_slider_id',
			'property_slider_property_id',
			'property_slider_image',
			'property_slider_title',
			'property_slider_title_size',
			'property_slider_title_pos',
			'property_slider_caption',
			'property_slider_caption_size',
			'property_slider_caption_pos',
			'property_slider_order',
			'property_slider_status',

			'property_slider_created_on', 
			'concat(creator.first_name, " ", creator.last_name)', 
			'property_slider_modified_on', 
			'concat(modifier.first_name, " ", modifier.last_name)'
		);

		return $this->join('users as creator', 'creator.id = property_slider_created_by', 'LEFT')
					->join('users as modifier', 'modifier.id = property_slider_modified_by', 'LEFT')
					->datatables($fields);
	}
}