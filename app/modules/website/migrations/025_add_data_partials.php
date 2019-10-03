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
		$data = array('partial_title'  => 'Footer - Subscription Modal', 'partial_content' => "<table style=\"border-collapse: collapse; height: 189px;\" border=\"0\"><tbody><tr style=\"height: 61px;\"><td style=\"height: 61px; width: 668px; text-align: center;\"><h1><span style=\"font-size: 24pt;\">Get Connected!</span></h1></td></tr><tr style=\"height: 46px;\"><td style=\"height: 46px; width: 668px; text-align: center;\"><p><span style=\"font-size: 18pt;\">Subscribe to our newsletter to get regular updates about our projects, estates, and malls.</span></p></td></tr><tr style=\"height: 46px;\"><td style=\"height: 46px; width: 668px; text-align: center;\"><p>{{subscribe}}</p></td></tr><tr style=\"height: 18px;\"><td style=\"height: 18px; width: 668px; text-align: center;\"><span style=\"font-size: 8pt;\">By clicking on the button above, I give my consent to all divisions and organizations in Ortigas&amp;Company, and their service provides and agents to collect, use and disclose the personal data as contained in this form, or as otherwise provided by me for the purpose of providing information on their products and services to me via email, including but not limited to offers, promotions, and new goods and services</span></td></tr><tr style=\"height: 18px;\"><td style=\"height: 18px; width: 668px; text-align: center;\"><br />{{subscribe_button}}</td></tr></tbody></table><p>&nbsp;</p>", 'partial_status' => 'Posted');
		$this->db->insert($this->_table, $data);
	}

	public function down()
	{

	}
}