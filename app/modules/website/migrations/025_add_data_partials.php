<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Add_data_partials extends CI_Migration 
{
	private $_table = 'partials';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// add partial for subscription modal: should be ID = 14
		$data = array(
			array('partial_title'  => 'Footer - Subscription Modal', 'partial_content' => '<table style=\"border-collapse: collapse; height: 303px;\" border=\"0\">\n<tbody>\n<tr style=\"height: 61px;\">\n<td style=\"height: 61px; width: 635px;\">\n<h1 style=\"text-align: center;\"><strong>Get Connected!</strong></h1>\n</td>\n</tr>\n<tr style=\"height: 60px;\">\n<td style=\"height: 60px; width: 635px;\">\n<p style=\"text-align: center;\">Subscribe to our newsletter to get regular updates about our projects, estates, and malls.</p>\n</td>\n</tr>\n<tr style=\"height: 46px;\">\n<td style=\"height: 46px; width: 635px;\">\n<p style=\"text-align: center;\">{{subscribe}}</p>\n</td>\n</tr>\n<tr style=\"height: 22px;\">\n<td style=\"height: 22px; width: 635px; text-align: center;\">\n<h6><span style=\"font-size: 8pt;\">By clicking on the button above, I give my consent to all divisions and organizations in Ortigas&amp;Company, and their service providers and agents, to collect, use and disclose the personal data as contained in this form, or as otherwise provided by me for the purpose of providing information on their products and services to me via email, including but not limited to offers, promotions, and new goods and services</span></h6>\n</td>\n</tr>\n<tr>\n<td style=\"width: 635px; text-align: center;\"><br />{{subscribe_button}}<br /><br /></td>\n</tr>\n</tbody>\n</table>', 'partial_status' => 'Posted', 'partial_created_by' => 1)
		);
		$this->db->insert($this->_table, $data);
	}

	public function down()
	{

	}
}