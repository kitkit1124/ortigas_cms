$fields = array(
{{migration_table_fields}}
			'{{lc_singular_module_name}}_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'{{lc_singular_module_name}}_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'{{lc_singular_module_name}}_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'{{lc_singular_module_name}}_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'{{lc_singular_module_name}}_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'{{lc_singular_module_name}}_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
{{migration_table_keys}}
		$this->dbforge->add_key('{{lc_singular_module_name}}_deleted');
		$this->dbforge->create_table($this->_table, TRUE);