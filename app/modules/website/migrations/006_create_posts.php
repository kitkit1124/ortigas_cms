<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015-2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_posts extends CI_Migration 
{
	private $_table = 'posts';

	private $_permissions = array(
		array('Posts Link', 'website.posts.link'),
		array('Posts List', 'website.posts.list'),
		array('View Post', 'website.posts.view'),
		array('Add Post', 'website.posts.add'),
		array('Edit Post', 'website.posts.edit'),
		array('Delete Post', 'website.posts.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website', // none if parent or single menu
			'menu_text' 		=> 'Posts', 
			'menu_link' 		=> 'website/posts', 
			'menu_perm' 		=> 'website.posts.link', 
			'menu_icon' 		=> 'fa fa-newspaper-o', 
			'menu_order' 		=> 2, 
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
			'post_id' 			=> array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'null' => FALSE),
			'post_title'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'post_slug'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'post_content'		=> array('type' => 'TEXT', 'null' => FALSE),
			'post_posted_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'post_layout'		=> array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'right_sidebar'),
			'post_image'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'post_alt_image'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'post_status'		=> array('type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE),

			'post_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'post_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'post_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'post_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'post_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'post_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('post_id', TRUE);
		$this->dbforge->add_key('post_title');
		$this->dbforge->add_key('post_slug');
		$this->dbforge->add_key('post_posted_on');
		$this->dbforge->add_key('post_layout');
		$this->dbforge->add_key('post_status');
		$this->dbforge->add_key('post_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);

		// add the initial values 
		$data = array(
			array('post_title'  => 'Sample Post #1', 'post_slug' => 'sample-post-1', 'post_image' => 'data/images/placeholder_banner.jpg',  'post_content' => '<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>', 'post_posted_on' => date('Y-m-d H:i:s'), 'post_status' => 'Posted', 'post_created_by' => 1),
			array('post_title'  => 'Sample Post #2', 'post_slug' => 'sample-post-2', 'post_image' => 'data/images/placeholder_banner.jpg', 'post_content' => '<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>', 'post_posted_on' => date('Y-m-d H:i:s'), 'post_status' => 'Posted', 'post_created_by' => 1),
			array('post_title'  => 'Sample Post #3', 'post_slug' => 'sample-post-3', 'post_image' => 'data/images/placeholder_banner.jpg', 'post_content' => '<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>', 'post_posted_on' => date('Y-m-d H:i:s'), 'post_status' => 'Posted', 'post_created_by' => 1),
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