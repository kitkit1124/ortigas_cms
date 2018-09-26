<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <codifire@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Add_field_videos_01 extends CI_Migration
{
	private $_table = 'videos';

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'video_thumb' 	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE)
		);

		$this->dbforge->add_column($this->_table, $fields);

	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'video_thumb');
	}
}