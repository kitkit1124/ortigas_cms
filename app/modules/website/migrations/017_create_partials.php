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
class Migration_Create_partials extends CI_Migration 
{
	private $_table = 'partials';

	private $_permissions = array(
		array('Partials Link', 'website.partials.link'),
		array('Partials List', 'website.partials.list'),
		array('View Partial', 'website.partials.view'),
		array('Add Partial', 'website.partials.add'),
		array('Edit Partial', 'website.partials.edit'),
		array('Delete Partial', 'website.partials.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website', // 'none' if parent menu or single menu; or menu_link of parent
			'menu_text' 		=> 'Partials', 
			'menu_link' 		=> 'website/partials', 
			'menu_perm' 		=> 'website.partials.link', 
			'menu_icon' 		=> 'fa fa-th', 
			'menu_order' 		=> 7, 
			'menu_active' 		=> 1
		),
	);

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		$fields = array(
			'partial_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'partial_title'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'partial_content'		=> array('type' => 'TEXT', 'null' => FALSE),
			'partial_status'		=> array('type' => 'SET("Posted","Draft")', 'null' => FALSE),

			'partial_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'partial_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'partial_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'partial_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'partial_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'partial_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('partial_id', TRUE);
		$this->dbforge->add_key('partial_title');
		$this->dbforge->add_key('partial_status');

		$this->dbforge->add_key('partial_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		// add the initial values
		$data = array(
			array('partial_title'  => 'Footer - Address and Contact', 'partial_content' => '<p>9th Floor, Ortigas Building<br />Ortigas Avenue,<br />Pasig City 1600 Philippines<br />Phone: (+632) 631 - 1231<br />Telefax: (+632) 631 - 6517</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Footer - Subscription Text', 'partial_content' => '<table style="border-collapse: collapse;" border="0"><tbody><tr><td><h2>Stay Updated</h2></td></tr><tr><td><p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eu leo quam.</p></td></tr><tr><td><p>{{subscribe}}</p></td></tr><tr><td><table style="border-collapse: collapse;" border="0"><tbody><tr><td style="text-align: center;"><a href="http://www.facebook.com"><span class="fa fa-facebook"></span>&nbsp;</a></td><td style="text-align: center;"><a href="http://www.twitter.com"><span class="fa fa-twitter"></span>&nbsp;</a></td><td style="text-align: center;"><a href="http://www.instagram.com"><span class="fa fa-instagram"></span>&nbsp;</a></td></tr></tbody></table></td></tr></tbody></table>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Property Categories - Button Text', 'partial_content' => '<p>Inquire Now</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Career - Thank You', 'partial_content' => '<h2>Thank you for your interest.</h2><p>Our Human Resouces personnel will be in touch with you soon.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Inquire - Thank You', 'partial_content' => '<h2>Thank you for your interest.</h2><p>Our Human Resouces personnel will be in touch with you soon.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Subscribe - Thank You', 'partial_content' => '<h2>Thank you for your interest.</h2><p>Our Human Resouces personnel will be in touch with you soon.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Career - Unsuccessful', 'partial_content' => '<h2>Unsuccessful, Sorry.</h2><p>Our Human Resouces personnel will be in touch with you soon.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Inquire - Unsuccessful', 'partial_content' => '<h2>Unsuccessful, Sorry.</h2><p>Our Human Resouces personnel will be in touch with you soon.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Subscribe - Unsuccessful', 'partial_content' => '<h2>Unsuccessful, Sorry.</h2><p>Our Human Resouces personnel will be in touch with you soon.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Terms & Conditions', 'partial_content' => '<p>Lorem ipsum dolor sit amet, Aliquam sit amet turpis tincidunt, pretium turpis in, pharetra diam. Mauris nec felis sit amet felis facilisis scelerisque quis eget velit. Integer egestas laoreet elit id consequat. Proin nec luctus neque, eu elementum orci. Sed fermentum pretium nibh dictum tempus. Etiam eu egestas ipsum, pretium iaculis odio. Aliquam est orci, dignissim ut ullamcorper sed, feugiat lacinia sem. Aliquam viverra egestas mi in congue.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
			array('partial_title'  => 'Privacy Statement', 'partial_content' => '<p>Lorem ipsum dolor sit amet, Aliquam sit amet turpis tincidunt, pretium turpis in, pharetra diam. Mauris nec felis sit amet felis facilisis scelerisque quis eget velit. Integer egestas laoreet elit id consequat. Proin nec luctus neque, eu elementum orci. Sed fermentum pretium nibh dictum tempus. Etiam eu egestas ipsum, pretium iaculis odio. Aliquam est orci, dignissim ut ullamcorper sed, feugiat lacinia sem. Aliquam viverra egestas mi in congue.</p>', 'partial_status' => 'Posted', 'partial_created_by' => 1),
		);
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}