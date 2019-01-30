<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutz Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Edit_partials extends CI_Migration 
{
	private $_table = 'partials';

	public function __construct() 
	{
		parent::__construct();

		// check for dependencies
		if (! $this->db->table_exists('partials'))
		{
			echo json_encode(array('success' => FALSE, 'message' => 'This upgrade requires the Websites module')); exit;
		}

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$data = array(
			array('partial_id' => 12,'partial_title'  => 'Search Career', 'partial_content' => '<h2 style="text-align: left;">No Found Results...</h2><p style="text-align: left;">Lorem ipsum dolor sit amet, Aliquam sit amet turpis tincidunt, pretium turpis in, pharetra diam. Mauris nec felis sit amet felis facilisis scelerisque quis eget velit. Integer egestas laoreet elit id consequat. Proin nec luctus neque, eu elementum orci. Sed fermentum pretium nibh dictum tempus. Etiam eu egestas ipsum, pretium iaculis odio. Aliquam est orci, dignissim ut ullamcorper sed, feugiat lacinia sem. Aliquam viverra egestas mi in congue.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_id' => 13,'partial_title'  => 'Error 404', 'partial_content' => '<h2 style="text-align: left;">PAGE NOT FOUND</h2><p>The page you are looking for could have been deleted or have never existed.</p>
				<p>Please return back to our homepage and see if you can find what you are looking for.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
		);
		$this->db->insert_batch($this->_table, $data);
	
	}

	public function down()
	{
		$this->db->delete($this->_table, array('partial_id' => 12));
	}
}