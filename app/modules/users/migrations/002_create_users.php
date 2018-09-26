<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Migration_Create_users extends CI_Migration {

	public function up()
	{
		// Drop table 'groups' if it exists
		$this->dbforge->drop_table('groups', TRUE);

		// Table structure for table 'groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'deleted'=> array(
				'type' => 'TINYINT', 
				'constraint' => 1, 
				'unsigned' => TRUE, 
				'null' => FALSE,
				'default' => 0
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('groups');

		// Dumping data for table 'groups'
		$data = array(
			array(
				// 'id' => '1',
				'name' => 'Admin',
				'description' => 'Administrator'
			),
			array(
				// 'id' => '2',
				'name' => 'User',
				'description' => 'General User'
			)
		);
		$this->db->insert_batch('groups', $data);


		// Drop table 'users' if it exists
		$this->dbforge->drop_table('users', TRUE);

		// Table structure for table 'users'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'salt' => array(
				'type' => 'VARCHAR',
				'constraint' => '40'
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			),
			'activation_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'remember_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'last_login' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'active' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'company' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE
			),
			'photo' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE
			),
			'deleted'=> array(
				'type' => 'TINYINT', 
				'constraint' => 1, 
				'unsigned' => TRUE, 
				'null' => FALSE,
				'default' => 0
			),

		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('username');
		$this->dbforge->add_key('email');
		$this->dbforge->add_key('active');
		$this->dbforge->add_key('first_name');
		$this->dbforge->add_key('last_name');
		$this->dbforge->add_key('company');
		$this->dbforge->add_key('phone');
		$this->dbforge->add_key('deleted');
		$this->dbforge->create_table('users');

		// Dumping data for table 'users'
		$data = array(
			// 'id' => '1',
			'ip_address' => '127.0.0.1',
			'username' => '',
			'password' => '$2y$08$HbMGIS4eJFcoz9D5lenr0uiBaxm61y6U3eBwIoyY52svOQJkHmLoG', // C0d!fire
			'salt' => '4MSWrTlj4G4Y/piWRr22Pu',
			'email' => 'webdevs@digify.com.ph',
			'activation_code' => '',
			'forgotten_password_code' => NULL,
			'created_on' => '1268889823',
			'last_login' => '1268889823',
			'active' => '1',
			'first_name' => 'Digify',
			'last_name' => 'Admin',
			'company' => 'Digify, Inc.',
			'phone' => '1234567',
			'photo' => 'ui/images/unknown.jpg'
		);
		
		$this->db->insert('users', $data);


		// Drop table 'users_groups' if it exists
		$this->dbforge->drop_table('users_groups', TRUE);

		// Table structure for table 'users_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users_groups');

		// Dumping data for table 'users_groups'
		$data = array(
			array(
				// 'id' => '1',
				'user_id' => '1',
				'group_id' => '1',
			),
			array(
				// 'id' => '2',
				'user_id' => '1',
				'group_id' => '2',
			)
		);
		$this->db->insert_batch('users_groups', $data);


		// Drop table 'login_attempts' if it exists
		$this->dbforge->drop_table('login_attempts', TRUE);

		// Table structure for table 'login_attempts'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'login' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
			'time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('login_attempts');
	}

	public function down()
	{
		$this->dbforge->drop_table('users', TRUE);
		$this->dbforge->drop_table('groups', TRUE);
		$this->dbforge->drop_table('users_groups', TRUE);
		$this->dbforge->drop_table('login_attempts', TRUE);
	}
}
