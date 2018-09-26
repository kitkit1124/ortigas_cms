<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Module Class
 *
 * @package		Codifire
 * @version		1.2
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @author 		Ghem Gatchalian <densetsu.ghem@gmail.com> (modified)
 * @copyright 	Copyright (c) 2016-2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Module extends MX_Controller 
{
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('users/acl');
		$this->load->library('migration');
		$this->load->config('config');
		$this->load->language('modules'); 
	}

	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function index()
	{
		// redirect to the list of modules
		redirect('admin/module/action/list', 'refresh');
	}

	// --------------------------------------------------------------------

	/**
	 * action
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	JP Llapitan <johnpaul.llapitan@gmail.com> (modified)
	 */
	public function action($action = 'list', $module = FALSE, $sub_module = FALSE) // adds @param $sub_module
	{
		switch ($action)
		{
			case 'list': $this->_modules_list(); break;
			case 'add': $this->_modules_add(); break;
			case 'delete': $this->_modules_delete($module, $sub_module); break;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _modules_list
	 *
	 * @access	private
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _modules_list()
	{
		$this->acl->restrict('admin.module.list');
	
		$data['page_heading'] = lang('modules_list_heading');
		$data['page_subhead'] = lang('modules_list_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('admin'));
		$this->breadcrumbs->push(lang('modules_list_heading'), site_url('admin/module/action/list'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// get all migration files
		$data['migrations'] = $this->migration->display_all_migrations();
		ksort($data['migrations']);

		// exclude these
		$data['core_migrations'] = array(
			'001_rollback_admin.php',
			'001_rollback_reports.php',
			'001_rollback_settings.php',
			'002_create_menus.php',
			'001_rollback_users.php',
			'002_create_users.php',
			'003_create_grants.php',
			'004_create_permissions.php',
		);

		$data['core_modules'] = array('core', 'dashboard', 'admin', 'reports', 'settings', 'users');

		// get the modules
		$data['modules'] = controller_list();
		ksort($data['modules']);
		
		// get the current versions
		$migrations = $this->db->get('migrations')->result();
		$versions = array();

		foreach ($migrations as $migration)
		{
			$versions[$migration->module] = $migration->version;
		}
		$data['versions'] = $versions;

		$this->template->add_css(module_css('admin', 'modules_list'), 'embed');
		$this->template->add_js(module_js('admin', 'modules_list'), 'embed');
		$this->template->write_view('content', 'modules_list', $data);
		$this->template->render();
	}


	// --------------------------------------------------------------------

	/**
	 * _modules_add
	 *
	 * @access	private
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	private function _modules_add()
	{
		$this->acl->restrict('admin.module.add');

		$data['page_heading'] = lang('modules_add_heading');
		$data['page_subhead'] = lang('modules_add_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('admin'));
		$this->breadcrumbs->push(lang('modules_list_heading'), site_url('admin/module/action/list'));
		$this->breadcrumbs->push(lang('modules_add_heading'), site_url('admin/module/action/add'));

		// table info
		$data['table'] = array(
			array(
				'column_name' => 'id',
				'column_type' => 'INT',
				'column_length' => '10',
				'form_type' => 'NOFORM',
				'column_unsigned' => 'Unsigned',
				'column_null' => '',
				'column_index' => 'Primary',
			),
			array(
				'column_name' => '',
				'column_type' => 'VARCHAR',
				'column_length' => '255',
				'form_type' => 'INPUT',
				'column_unsigned' => '',
				'column_null' => '',
				'column_index' => '',
			),
		);
		

		if ($this->input->post('submit'))
		{
			if ($this->_save_module())
			{
				$this->session->set_flashdata('flash_message', lang('modules_add_success'));
				redirect('admin/module/action/list', 'refresh');
			}
			else
			{

				$data['error_message'] = lang('validation_error');
				$column_names = $this->input->post('column_name');
				$column_type = $this->input->post('column_type');
				$column_length = $this->input->post('column_length');
				$form_type = $this->input->post('form_type');
				$column_unsigned = $this->input->post('column_unsigned');
				$column_null = $this->input->post('column_null');
				$column_index = $this->input->post('column_index');

				$key = 0;
				$table = array();
				foreach ($column_names as $column_name)
				{
					// table info
					$table[] = array(
						'column_name' => $column_name,
						'column_type' => $column_type[$key],
						'column_length' => $column_length[$key],
						'form_type' => $form_type[$key],
						'column_unsigned' => $column_unsigned[$key],
						'column_null' => $column_null[$key],
						'column_index' => $column_index[$key],
					);

					// increment the array key
					$key++;
				}	//end foreach
				$data['table'] = $table;
				
			}

		}

		// get the current user to be used for copyright info
		$data['user'] = $this->ion_auth->user()->row(); 

		// get the modules
		$controllers = controller_list();
		$modules = array('none' => 'New Module');
		foreach ($controllers as $module => $controller)
		{
			$modules[$module] = $module;
		}
		
		$data['modules'] = $modules;

		$this->template->add_css('npm/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css');	
		$this->template->add_js('npm/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js');		
		// $this->template->add_js('npm/input_mask/input_mask.min.js');

		$this->template->add_css(module_css('admin', 'modules_add'), 'embed');
		//$this->template->add_js('//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js');
		$this->template->add_js(module_js('admin', 'modules_add'), 'embed');
		$this->template->write_view('content', 'modules_add', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * _modules_delete
	 *
	 * @access	private
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	JP Llapitan <johnpaul.llapitan@gmail.com> (modify)
	 */
	private function _modules_delete($module, $sub_module = FALSE) // adds param sub-module
	{
		if (! $module) show_404();

		$this->acl->restrict('admin.module.delete', 'modal');

		$data['page_heading'] = lang('modules_delete_heading');
		$data['page_confirm'] = lang('modules_delete_confirm');
		$data['page_button'] = lang('modules_delete_button');

		if ($this->input->post())
		{
			// migrate the database
			$this->load->library('migration');
			$this->migration->init_module($module); 
			$this->migration->version(1);
			
			// delete the files
			$this->_rmdir_recursive(APPPATH . 'modules/' . $module, $sub_module); // adds param sub-module

			// reset the cache
			$this->cache->delete('app_menu');
			$this->cache->delete('app_config');
			$this->cache->delete('app_grants');

			echo json_encode(array('success' => true)); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * _rmdir_recursive
	 *
	 * @access	private
	 * @param	string $dir
	 * @param	string $prefix
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	JP Llapitan <johnpaul.llapitan@gmail.com> (modify)
	 */
	private function _rmdir_recursive($dir, $prefix = FALSE) // adds param $prefix 
	{
			foreach(scandir($dir) as $file) 
			{
					if ('.' === $file || '..' === $file) continue;
					if (is_dir("$dir/$file")) $this->_rmdir_recursive("$dir/$file", $prefix);
					else 
					{
						if(! $prefix) unlink("$dir/$file");
						else
						{
							if (substr(strtolower($file), 0, strlen($prefix)) === strtolower($prefix) && file_exists($dir.DIRECTORY_SEPARATOR.$file)) unlink($dir.DIRECTORY_SEPARATOR.$file); // adds single file deletion
						}
					}
			}
			if(! $prefix) rmdir($dir);
	}

	// --------------------------------------------------------------------

	/**
	 * _create_folders
	 *
	 * @access	private
	 * @param	string $module_path
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _create_folders($module_path)
	{
		// TODO: add error checking

		mkdir($module_path, 0775, TRUE);
		mkdir($module_path . '/config', 0775, TRUE);
		mkdir($module_path . '/controllers', 0775, TRUE);
		mkdir($module_path . '/language', 0775, TRUE);
		mkdir($module_path . '/language/english', 0775, TRUE);
		mkdir($module_path . '/migrations', 0775, TRUE);
		mkdir($module_path . '/models', 0775, TRUE);
		mkdir($module_path . '/views', 0775, TRUE);
		mkdir($module_path . '/views/css', 0775, TRUE);
		mkdir($module_path . '/views/js', 0775, TRUE);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * _copy_files
	 *
	 * @access	private
	 * @param	array $module
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	private function _copy_files($module)
	{
		// module name
		$module_name = ($module['parent_module'] == 'none') ? $module['lc_plural_module_name'] : $module['parent_module'];

		if ($module['parent_module'] == 'none')
		{
			// copy migration config
			$string = read_file($this->config->item('tpl_migration'));
			write_file(APPPATH . 'modules/' . $module_name . '/config/migration.php', $string);
		}

		// copy the controller
		if ($this->input->post('table_availability')) {
			$string = read_file($this->config->item('tpl_controller'));		
		}
		else
		{
			$string = read_file($this->config->item('tpl_controller01'));
			
		}

		$string = $this->_replace_vars($string, $module);
		$string = $this->_add_fields($string, $module);
		write_file(APPPATH . 'modules/' . $module_name . '/controllers/' . $module['ucf_plural_module_name'] . '.php', $string);



		// copy the language file
		$string = read_file($this->config->item('tpl_language'));
		$string = $this->_replace_vars($string, $module, true);
		$string = $this->_add_fields($string, $module);
		write_file(APPPATH . 'modules/' . $module_name . '/language/english/' . $module['lc_plural_module_name'] . '_lang.php', $string);


		if ($module['parent_module'] == 'none')
		{
			// copy the migration files
			$string = read_file($this->config->item('tpl_migration1'));
			$string = $this->_replace_vars($string, $module);
			// $string = $this->_add_fields($string, $module);
			write_file(APPPATH . 'modules/' . $module_name . '/migrations/001_rollback_' . $module['lc_plural_module_name'] . '.php', $string);

			$string = read_file($this->config->item('tpl_migration2'));
			$string = $this->_replace_vars($string, $module);
			$string = $this->_add_fields($string, $module);
			write_file(APPPATH . 'modules/' . $module_name . '/migrations/002_create_' . $module['lc_plural_module_name'] . '.php', $string);
		}
		else
		{
			// get the next migration version
			$migrations = $this->migration->display_all_migrations();
			$current_version = count($migrations[$module_name]);
			$new_version = $current_version + 1;
			$ver_with_zero = str_pad($new_version, 3, '0', STR_PAD_LEFT);

		
			// copy the migration file
			$string = read_file($this->config->item('tpl_migration2'));
			$string = $this->_replace_vars($string, $module);
			$string = $this->_add_fields($string, $module);
			write_file(APPPATH . 'modules/' . $module_name . '/migrations/' . $ver_with_zero . '_create_' . $module['lc_plural_module_name'] . '.php', $string);

			// update the migration version in the config file
			$string = read_file($this->config->item('tpl_migration'));
			$file = APPPATH . 'modules/' . $module_name . '/config/migration.php';
		

			// $string = read_file($file);
			unlink($file);
			$string = str_replace("= 2", "= $new_version", $string); 
			write_file($file, $string);
		}


		// copy the model
		//<!-- Start added
		if ($this->input->post('table_availability')) //added
		{
			$string = read_file($this->config->item('tpl_model'));
			$string = $this->_replace_vars($string, $module);
			$string = $this->_add_fields($string, $module);
			write_file(APPPATH . 'modules/' . $module_name . '/models/' . $module['ucf_plural_module_name'] . '_model.php', $string);

			// copy the view files
			$string = read_file($this->config->item('tpl_html_index'));
			$string = $this->_replace_vars($string, $module);
			$string = $this->_add_fields($string, $module);
			write_file(APPPATH . 'modules/' . $module_name . '/views/' . $module['lc_plural_module_name'] . '_index.php', $string);

			$string = read_file($this->config->item('tpl_html_form'));
			$string = $this->_replace_vars($string, $module);
			$string = $this->_add_fields($string, $module);
			write_file(APPPATH . 'modules/' . $module_name . '/views/' . $module['lc_plural_module_name'] . '_form.php', $string);

			$string = read_file($this->config->item('tpl_css_form'));
			$string = $this->_replace_vars($string, $module);
			write_file(APPPATH . 'modules/' . $module_name . '/views/css/' . $module['lc_plural_module_name'] . '_form.css', $string);
		}
		else
		{
			$string ='';
			write_file(APPPATH . 'modules/' . $module_name . '/views/' . $module['lc_plural_module_name'] . '_index.php', $string);
			

		}


		$string = read_file($this->config->item('tpl_css_index'));
		$string = $this->_replace_vars($string, $module);
		write_file(APPPATH . 'modules/' . $module_name . '/views/css/' . $module['lc_plural_module_name'] . '_index.css', $string);

		

		/*
		Add include model only when needed {{datatables_js}}
		*/
		$js_model = '';
		if ($this->input->post('table_availability'))
		{
			$js_model = read_file($this->config->item('tpl_js_model'));

		}

		$string = read_file($this->config->item('tpl_js_index'));
		$string = str_replace("{{datatables_js}}", $js_model, $string);

		$string = $this->_replace_vars($string, $module);
		$string = $this->_add_fields($string, $module);
		write_file(APPPATH . 'modules/' . $module_name . '/views/js/' . $module['lc_plural_module_name'] . '_index.js', $string);

		$string = read_file($this->config->item('tpl_js_form'));
		$string = $this->_replace_vars($string, $module);
		$string = $this->_add_fields($string, $module);
		write_file(APPPATH . 'modules/' . $module_name . '/views/js/' . $module['lc_plural_module_name'] . '_form.js', $string);

		return TRUE;
	}

	// --------------------------------------------------------------------
	/**
	 * _module_names
	 *
	 * @access	private
	 * @param	string $string
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	private function _module_names()
	{
		$lc_plural_module_name = url_title($this->input->post('module_name_plural'), '_', TRUE);
		$lc_singular_module_name = url_title($this->input->post('module_name_singular'), '_', TRUE);

		$data = array(
			'parent_module' => $this->input->post('parent_module'),
			'lc_plural_module_name' => $lc_plural_module_name,
			'lc_singular_module_name' => $lc_singular_module_name,
			'ucf_plural_module_name' => ucfirst($lc_plural_module_name),
		//	'ucf_plural_module_name_words' => ucwords(str_replace('_' ,' ', $lc_plural_module_name)),
			'ucf_singular_module_name' => ucfirst($lc_singular_module_name)
		);

		return $data;
	}

	// --------------------------------------------------------------------
	/**
	 * _replace_names
	 *
	 * @access	private
	 * @param	string $string
	 * @param	array $module
	 * @param boolean $words
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	private function _replace_vars($string, $module, $words=FALSE)
	{
		// replace parent module
		$parent_module = ($module['parent_module'] == 'none') ? $module['lc_plural_module_name'] : $module['parent_module'];	
		$string = str_replace("{{parent_module}}", $parent_module, $string);

		// replace module names
		$string = str_replace("{{lc_plural_module_name}}", (! $words) ? $module['lc_plural_module_name'] : ucwords(str_replace('_', ' ', $module['lc_plural_module_name'] )) , $string); // eg. contacts
		$string = str_replace("{{lc_singular_module_name}}", $module['lc_singular_module_name'], $string); // eg. contact



		//Remove Underscore if Words 
		$string = str_replace("{{ucf_plural_module_name}}", (! $words) ? $module['ucf_plural_module_name'] : ucwords(str_replace('_', ' ', $module['ucf_plural_module_name'] )) , $string); // eg. contacts
		$string = str_replace("{{ucf_singular_module_name}}", (! $words) ? $module['ucf_singular_module_name'] : ucwords(str_replace('_', ' ', $module['ucf_singular_module_name'] )) , $string); // eg. contacts
		
		//<!--wbe change later on
		$string = str_replace("{{ucf_plural_module_name_text}}", ucwords(str_replace('_', ' ', $module['ucf_plural_module_name'] )) , $string); // eg. contacts
		$string = str_replace("{{ucf_singular_module_name_text}}", ucwords(str_replace('_', ' ', $module['ucf_singular_module_name'] )) , $string); // eg. contacts
		//--> end

		// replace module info
		$string = str_replace("{{module_version}}", $this->input->post('module_version'), $string); // module version
		$string = str_replace("{{package_name}}", $this->input->post('package_name'), $string); // package name

		// replace author and copyright
		$string = str_replace("{{author_name}}", $this->input->post('author_name'), $string); // author name
		$string = str_replace("{{author_email}}", $this->input->post('author_email'), $string); // author email
		$string = str_replace("{{copyright_year}}", $this->input->post('copyright_year'), $string); // copyright year
		$string = str_replace("{{copyright_name}}", $this->input->post('copyright_name'), $string); // copyright name
		$string = str_replace("{{copyright_link}}", $this->input->post('copyright_link'), $string); // copyright link

		// replace icon and order
		$string = str_replace("{{module_icon}}", $this->input->post('module_icon'), $string);
		$string = str_replace("{{module_order}}", $this->input->post('module_order'), $string);




		return $string;
	}

	// --------------------------------------------------------------------

	/**
	 * _add_fields
	 *
	 * @access	private
	 * @param	string $string
	 * @param	array $module
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	private function _add_fields($string, $module)
	{
		// get the post data
		$column_names = $this->input->post('column_name');
		$column_types = $this->input->post('column_type');
		$column_length = $this->input->post('column_length');
		$form_types = $this->input->post('form_type');
		$column_unsigned = $this->input->post('column_unsigned');
		$column_null = $this->input->post('column_null');
		$column_index = $this->input->post('column_index');

		// set the initial values
		$controller_form_errors = '';
		$controller_form_validations = '';
		$controller_form_fields = '';
		$lang_form_labels = '';
		$lang_table_heads = '';
		$migration_table_fields = '';
		$migration_table_keys = '';
		$model_table_fields = '';
		$view_table_heads = '';
		$view_column_count = 6;
		$view_action_col = 1;
		$view_form_fields = '';
		$view_form_markups = '';
		$view_form_field_date = '';
		$view_form_field_datetime = '';
		$embed_datetime_plugin = '';
		$embed_jqueryui_plugin = '';
		$module_model = '';
		$migration_table = '';

		$key = 0;

		$no_constraints = array('DATE', 'DATETIME', 'TEXTAREA');
		$integers = array('INT', 'MEDIUMINT', 'SMALLINT', 'TINYINT', 'BOOLEAN');



		foreach ($column_names as $column_name)
		{
			// lowercase the column name
			$column_name = strtolower($column_name);

			// add column name prefix
			$col_name = "{$module['lc_singular_module_name']}_{$column_name}";

			// controller
			if ($column_index[$key] != 'Primary' AND $form_types[$key] != 'NOFORM')
			{
				$controller_form_errors .= "\t\t\t\t\t'{$col_name}'\t\t=> form_error('{$col_name}'),\n";
				$controller_form_validations .= "\t\t\$this->form_validation->set_rules('{$col_name}', lang('{$col_name}'), 'required');\n";
				$controller_form_fields .= "\t\t\t'{$col_name}'\t\t=> \$this->input->post('{$col_name}'),\n";
			}

			// language
			$col_value = ucwords(str_replace('_', ' ', $column_name));
			$col_value = ($col_value == 'Id') ? 'ID' : $col_value;
			$lang_form_labels .= "\$lang['{$col_name}']\t\t\t= '{$col_value}';\n";
			$lang_table_heads .= "\$lang['index_{$column_name}']\t\t\t= '{$col_value}';\n";

			// migration fields
			$type_set = ($column_types[$key] == 'SET' || $column_types[$key] == 'DECIMAL'  ) ? $column_length[$key] : '';

			if ($column_types[$key] == 'BOOLEAN')
				$migration_table_fields .= "\t\t\t'{$col_name}'\t\t=> array('type' => 'TINYINT',  'constraint' => 1,";
			else
				$migration_table_fields .= "\t\t\t'{$col_name}'\t\t=> array('type' => '{$column_types[$key]}{$type_set}',";


			if ($column_types[$key] != 'SET' && $column_types[$key] != 'DECIMAL'  &&$column_length[$key] != '--' && $column_length[$key] && !in_array($column_types[$key], $no_constraints)) 
				$migration_table_fields .= " 'constraint' => {$column_length[$key]},";	

			//for index
			if ($column_index[$key] == 'Primary' && $column_unsigned[$key] == 'Unsigned' && $column_null[$key] != 'Null' ) //&& $column_name == 'id'
				$migration_table_fields .= " 'auto_increment' => TRUE,";	

			if ($column_unsigned[$key] == 'Unsigned' && in_array($column_types[$key], $integers)) $migration_table_fields .= " 'unsigned' => TRUE,";
				$migration_table_fields .= ($column_null[$key] == 'Null') ? " 'null' => TRUE),\n" : " 'null' => FALSE),\n";

			// migration keys
			if ($column_index[$key] == 'Index') $migration_table_keys .= "\t\t\$this->dbforge->add_key('{$col_name}');\n";
			if ($column_index[$key] == 'Primary') $migration_table_keys .= "\t\t\$this->dbforge->add_key('{$col_name}', TRUE);\n";

			// model
			$model_table_fields .= "\t\t\t'{$col_name}',\n";

			// view
			$dt_class = ($column_index[$key] == 'Primary') ? 'all' : 'min-desktop';
			$dt_class = ($key == 1) ? 'all' : $dt_class; // show 2nd column on all devices
			$view_table_heads .= "\t\t\t<th class=\"{$dt_class}\"><?php echo lang('index_{$column_name}'); ?></th>\n";

			// js
			if ($form_types[$key] != 'NOFORM')
			{
				if ($form_types[$key] == 'CHECKBOX') $value = "\$('#{$col_name}').is(':checked') ? 1 : 0";
				else if ($form_types[$key] == 'RADIO') $value = "\$('.{$col_name}:checked').val()";
				else $value = "\$('#{$col_name}').val()";
				$view_form_fields .= "\t\t\t{$col_name}: $value,\n";
			}
					
			if ($column_types[$key] == 'DATETIME')
			{
				$view_form_field_datetime = "\$('.time_box').DateTimePicker({\n\tisPopup: true,\n\tdateTimeFormat:'yyyy-MM-dd HH:mm',\n\t}); ";
				$embed_datetime_plugin = "\$this->template->add_js('components/DateTimePicker/DateTimePicker.js'); \n\t\t";
				$embed_datetime_plugin .= "\$this->template->add_css('components/DateTimePicker/DateTimePicker.css');";
			}

			if ($column_types[$key] == 'DATE')
			{
				 $view_form_field_date = "\$('.datepicker').datepicker({\n\t\tchangeMonth: true,\n\t\tchangeYear: true,\n\t\tdateFormat: 'yy-mm-dd'\n\t});";
				 $embed_jqueryui_plugin = "\$this->template->add_css('components/jquery-ui/jquery-ui.min.css'); \n\t\t";
			}
			

			// form markups
			switch ($form_types[$key])
			{
				case 'NOFORM':
					// none
					break;

				case 'SELECT': 
					$replace = array('"', '(', ')');
					$col_len_value = str_replace($replace, "", $column_length[$key]);

					$view_form_markups .= $this->_add_form_markup($col_name, 'select', $col_len_value); 
					break;

				case 'TEXTAREA': $view_form_markups .= $this->_add_form_markup($col_name, 'textarea'); break;
				case 'CHECKBOX': $view_form_markups .= $this->_add_form_markup($col_name, 'checkbox'); break;
				case 'RADIO': $view_form_markups .= $this->_add_form_markup($col_name, 'radio'); break;
				case 'INPUT': 				
					if ($column_types[$key] == 'DATETIME') 
						$view_form_markups .= $this->_add_form_markup($col_name, 'datetime'); 	
					else if ($column_types[$key] == 'DATE')
						$view_form_markups .= $this->_add_form_markup($col_name, 'date'); 	
					else
						$view_form_markups .= $this->_add_form_markup($col_name, 'input'); 				
					break;
				default: //NONE

					break;
			}
			
			// increment the array key
			$key++;
		}	//end for loop

		$view_column_count += $key;
		$view_action_col = $view_column_count - 2;
		// replace the variables in the templates
		/*
		Add include model only when needed {{module_model}}
		*/
		$field_string = '';
		if ($this->input->post('table_availability'))
		{
			$module_model = "\$this->load->model('{{lc_plural_module_name}}_model');";
			$drop_table = "\$this->dbforge->drop_table(\$this->_table, TRUE);";
			$migration_table = read_file($this->config->item('tpl_php_migration_table'));
		}
		
		$string = str_replace("{{module_model}}",isset($module_model) ? $module_model: '', $string);
		$string = str_replace("{{drop_table}}", isset($drop_table) ? $drop_table : '', $string);
		

		$string = str_replace("{{migration_table}}", $migration_table, $string);

		
		$string = str_replace("{{controller_form_errors}}", $controller_form_errors, $string);
		$string = str_replace("{{controller_form_validations}}", $controller_form_validations, $string);
		$string = str_replace("{{controller_form_fields}}", $controller_form_fields, $string);
		
		//embed_datetime_plugin
		$string = str_replace("{{embed_datetime_plugin}}", $embed_datetime_plugin, $string);


		$string = str_replace("{{embed_jqueryui_plugin}}", $embed_jqueryui_plugin, $string);

		$string = str_replace("{{lang_form_labels}}", $lang_form_labels, $string);
		$string = str_replace("{{lang_table_heads}}", $lang_table_heads, $string);

		$string = str_replace("{{migration_table_fields}}", $migration_table_fields, $string);
		$string = str_replace("{{migration_table_keys}}", $migration_table_keys, $string);

		//added ghem
		$string = str_replace("{{lc_singular_module_name}}", $module['lc_singular_module_name'], $string); // eg. contact
		$string = str_replace("{{lc_plural_module_name}}", $module['lc_plural_module_name'], $string);


		$string = str_replace("{{model_table_fields}}", $model_table_fields, $string);
		$string = str_replace("{{view_table_heads}}", $view_table_heads, $string);
		$string = str_replace("{{view_column_count}}", $view_column_count, $string);
		$string = str_replace("{{view_action_col}}", $view_action_col, $string);
		$string = str_replace("{{view_form_fields}}", $view_form_fields, $string);
		$string = str_replace("{{view_form_markups}}", $view_form_markups, $string);
		$string = str_replace("{{view_form_field_datetime}}", $view_form_field_datetime, $string);
		$string = str_replace("{{view_form_field_date}}", $view_form_field_date, $string);
		

		//embed_datetime_plugin

		return $string;
	}

	// --------------------------------------------------------------------

	/**
	 * _add_form_markup
	 *
	 * @access	private
	 * @param	string $form_name
	 * @param	string $type
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>	 
	 */
	private function _add_form_markup($form_name, $type = 'input', $value="")
	{

		$string = read_file($this->config->item('tpl_html_' . $type));
		$string = str_replace("{{form_name}}", $form_name, $string);
			
		//added for value
		$string = str_replace("{{form_value}}", $value, $string);	
		//form_datetime

		return $string;
	}

	// --------------------------------------------------------------------

	/**
	 * _module_check
	 *
	 * @access	private
	 * @param	string $str
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	public function _module_check($str, $parent = '')
	{
		$modules_path = APPPATH . 'modules/';
		$module_name = url_title($str, '_', TRUE);
		
		if ($parent == 'none')
		{
			if (is_dir($modules_path . $module_name))
			{
				$this->form_validation->set_message('_module_check', lang('add_module_exists'));
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else //if parent available
		{
			//check if parent module exists then check if module class exists ($str) 
			//NOTE: parent exists 
			
			$modules_path .= $parent . '/controllers/';
			$module_name = ucfirst($module_name) . '.php';

			//echo ">>>".  file_exists($modules_path . $module_name);
			if (file_exists($modules_path . $module_name))
			{
				$this->form_validation->set_message('_module_check', lang('add_module_exists'));

				// $this->session->set_flashdata('flash_error', lang('validation_error'));
			} 
			else
			{
				return TRUE;
			}


			// echo $modules_path . '<br/>' . $module_name;
			return FALSE;
		}	
	}

	// --------------------------------------------------------------------

	/**
	 * _module_singular_check 
	 *		
	 * @access	private
	 * @param	string $str
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	/*public function _module_singular_check($str)
	{
		$str = url_title($str, '_', TRUE);

		//if table does not exists
		if (! $this->db->table_exists($str))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('_module_singular_check', lang('singular_module_exists'));
			return FALSE;
		}
	}*/

	// --------------------------------------------------------------------

	/**
	 * _save_module
	 *
	 * @access	private
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 * @author 	Ghem Gatchalian <densetsu.ghem@gmail.com>
	 */
	private function _save_module()
	{
		//to check if modules exists
		$parent_module = $this->input->post('parent_module');

		// validate inputs
		$this->form_validation->set_rules('module_name_plural', lang('module_name_plural'), 'required|callback__module_check['.$parent_module.']');
		//$this->form_validation->set_rules('module_name_singular', lang('module_name_singular'), 'required|callback__module_singular_check');
		$this->form_validation->set_rules('module_name_singular', lang('module_name_singular'), 'required');
		$this->form_validation->set_rules('module_version', lang('module_version'), 'required|numeric');
		$this->form_validation->set_rules('package_name', lang('package_name'), 'required|max_length[100]');
		$this->form_validation->set_rules('author_name', lang('author_name'), 'required|max_length[100]');
		$this->form_validation->set_rules('author_email', lang('author_email'), 'required|valid_email');
		$this->form_validation->set_rules('copyright_year', lang('copyright_year'), 'required|exact_length[4]|is_natural_no_zero');
		$this->form_validation->set_rules('copyright_name', lang('copyright_name'), 'required|max_length[100]');
		$this->form_validation->set_rules('copyright_link', lang('copyright_link'), 'required|max_length[255]');

		//<!-- Start added
		if ($this->input->post('table_availability')) //added
		{
			$this->form_validation->set_rules('column_name[]', lang('column_name'), 'required');
			$this->form_validation->set_rules('column_type[]', lang('column_type'), 'required|in_list[VARCHAR,CHAR,TEXT,SET,DATE,DATETIME,BIGINT,INT,MEDIUMINT,SMALLINT,TINYINT,DECIMAL,FLOAT,BOOLEAN]');
			$this->form_validation->set_rules('column_length[]', lang('column_length'), 'min_length[1]');
		}
		//--> end


		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			// $this->session->set_flashdata('flash_error', lang('validation_error'));
			return FALSE;
		}
	
		// set the path
		$modules_path = APPPATH . 'modules/';
		$module = $this->_module_names();

		// create the folders
		if ($module['parent_module'] == 'none')
		{
			if (! $this->_create_folders($modules_path . $module['lc_plural_module_name']))
			{
				$this->session->set_flashdata('flash_error', 'Unable to create the directories');
				return FALSE;
			}
		}

		// copy the files
		if (! $this->_copy_files($module))
		{
			$this->session->set_flashdata('flash_error', 'Unable to create the directories');
			return FALSE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

}

/* End of file Module.php */
/* Location: ./application/modules/admin/controllers/Module.php */