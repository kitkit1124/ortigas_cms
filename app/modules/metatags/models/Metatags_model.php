<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Metatags_model Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Metatags_model extends BF_Model 
{

	protected $table_name			= 'metatags';
	protected $key					= 'metatag_id';
	protected $date_format			= 'datetime';
	protected $log_user				= TRUE;

	protected $set_created			= TRUE;
	protected $created_field		= 'metatag_created_on';
	protected $created_by_field		= 'metatag_created_by';

	protected $set_modified			= TRUE;
	protected $modified_field		= 'metatag_modified_on';
	protected $modified_by_field	= 'metatag_modified_by';

	protected $soft_deletes			= TRUE;
	protected $deleted_field		= 'metatag_deleted';
	protected $deleted_by_field		= 'metatag_deleted_by';

	// --------------------------------------------------------------------

	/**
	 * get_metatags
	 *
	 * @access	public
	 * @param 	integer $id
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function get_metatags($id)
	{
		$metatags = $this->find($id);

		$output = '';
		if ($metatags)
		{
			$output .= '<meta name="robots" content="index,follow"/>' . "\r\n\t\t"
                 . '<meta name="title" content="' . (($metatags->metatag_title) ? $metatags->metatag_title : '') . '" />' . "\r\n\t\t"
                 . '<meta name="keywords" content="' . (($metatags->metatag_keywords) ? $metatags->metatag_keywords : '') . '" />' . "\r\n\t\t"
                 . '<meta name="description" content="' . (($metatags->metatag_description) ? $metatags->metatag_description : '') . '" />' . "\r\n\t\t"
                 . '<meta property="og:title" content="' . (($metatags->metatag_og_title) ? $metatags->metatag_og_title : '') . '"/>' . "\r\n\t\t"
                 . '<meta property="og:image" content="' . (($metatags->metatag_og_image) ? site_url($metatags->metatag_og_image) : '') . '"/>' . "\r\n\t\t"
                 . '<meta property="og:description" content="' . (($metatags->metatag_og_description) ? $metatags->metatag_og_description : '') . '" />' . "\r\n\t\t"  
                 . '<meta property="og:url" content="' . current_url().'"/>' . "\r\n\t\t"
                 . '<meta name="twitter:card" content="summary"/>' . "\r\n\t\t"
                 . '<meta name="twitter:title" content="' . (($metatags->metatag_twitter_title) ? $metatags->metatag_twitter_title : '') . '"/>' . "\r\n\t\t"
                 . '<meta name="twitter:url" content="' . current_url() . '"/>' . "\r\n\t\t"
                 . '<meta name="twitter:description" content="' . (($metatags->metatag_twitter_description) ? $metatags->metatag_twitter_description : '') . '"/>' . "\r\n\t\t"
                 . '<meta name="twitter:image" content="' . (($metatags->metatag_twitter_image) ? site_url($metatags->metatag_twitter_image) : '') . '"/>';
		}

		return $output;
	}
}