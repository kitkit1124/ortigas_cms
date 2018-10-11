<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_jobs extends CI_Migration {

	private $_table = 'career_applicants';

	private $_permissions = array(
		array('Jobs Link', 'careers.jobs.link'),
		array('Jobs List', 'careers.jobs.list'),
		array('View Job', 'careers.jobs.view'),
		array('Add Job', 'careers.jobs.add'),
		array('Edit Job', 'careers.jobs.edit'),
		array('Delete Job', 'careers.jobs.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'careers',
			'menu_text' 		=> 'Applicants',    
			'menu_link' 		=> 'careers/jobs', 
			'menu_perm' 		=> 'careers.jobs.link', 
			'menu_icon' 		=> 'fa fa-users', 
			'menu_order' 		=> 4, 
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
		// create the table
		$fields = array(
			'job_id'				=> array('type' => 'INT', 'constraint' => 10, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'job_career_id'			=> array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => TRUE, 'null' => FALSE),
			'job_applicant_name'	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'job_email'				=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'job_mobile'			=> array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
			'job_document'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'job_referred'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
			'job_pitch'				=> array('type' => 'TEXT', 'null' => TRUE),

			'job_created_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'job_created_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'job_modified_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'job_modified_on' 		=> array('type' => 'DATETIME', 'null' => TRUE),
			'job_deleted' 			=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'job_deleted_by' 		=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('job_id', TRUE);
		$this->dbforge->add_key('job_career_id');
		$this->dbforge->add_key('job_applicant_name');
		$this->dbforge->add_key('job_email');

		$this->dbforge->add_key('job_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}