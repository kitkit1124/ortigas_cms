<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 20185, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_post_properties extends CI_Migration 
{
	private $_table = 'post_properties';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'post_properties_id' 				=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'post_properties_post_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE),
			'post_properties_property_id' 		=> array('type' => 'TINYINT', 'unsigned' => TRUE, 'null' => FALSE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('post_properties_id', TRUE);
		$this->dbforge->add_key('post_properties_post_id');
		$this->dbforge->add_key('post_properties_properties_id');
		$this->dbforge->create_table($this->_table, TRUE);

	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);
	}
}