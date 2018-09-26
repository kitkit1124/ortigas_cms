<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['tpl_migration'] 			= APPPATH . 'modules/admin/views/template/config/migration.php';
$config['tpl_controller'] 			= APPPATH . 'modules/admin/views/template/controllers/Template.php';
$config['tpl_language'] 			= APPPATH . 'modules/admin/views/template/language/english/template_lang.php';
$config['tpl_migration1'] 			= APPPATH . 'modules/admin/views/template/migrations/001_rollback_template.php';
$config['tpl_migration2'] 			= APPPATH . 'modules/admin/views/template/migrations/002_create_template.php';
$config['tpl_model'] 				= APPPATH . 'modules/admin/views/template/models/Template_model.php';
$config['tpl_html_index'] 			= APPPATH . 'modules/admin/views/template/views/template_index.php';
$config['tpl_html_form'] 			= APPPATH . 'modules/admin/views/template/views/template_form.php';
$config['tpl_html_input'] 			= APPPATH . 'modules/admin/views/template/views/template_input.php';
//add datetime
$config['tpl_html_datetime'] 		= APPPATH . 'modules/admin/views/template/views/template_datetime.php';
$config['tpl_html_date'] 			= APPPATH . 'modules/admin/views/template/views/template_date.php';

$config['tpl_html_select'] 			= APPPATH . 'modules/admin/views/template/views/template_select.php';
$config['tpl_html_textarea'] 		= APPPATH . 'modules/admin/views/template/views/template_textarea.php';
$config['tpl_html_checkbox'] 		= APPPATH . 'modules/admin/views/template/views/template_checkbox.php';
$config['tpl_html_radio'] 			= APPPATH . 'modules/admin/views/template/views/template_radio.php';
$config['tpl_css_index'] 			= APPPATH . 'modules/admin/views/template/views/css/template_index.css';
$config['tpl_css_form'] 			= APPPATH . 'modules/admin/views/template/views/css/template_form.css';
$config['tpl_js_index'] 			= APPPATH . 'modules/admin/views/template/views/js/template_index.js';
$config['tpl_js_form'] 				= APPPATH . 'modules/admin/views/template/views/js/template_form.js';

//if model needed {{datatables_js}}
$config['tpl_js_model'] 			= APPPATH . 'modules/admin/views/template/views/js/template_js_model.js';
$config['tpl_php_migration_table'] 	= APPPATH . 'modules/admin/views/template/views/template_migrations_table.php';
$config['tpl_controller01'] 		= APPPATH . 'modules/admin/views/template/controllers/Template01.php';
//$config['tpl_html_index01'] 		= APPPATH . 'modules/admin/views/template/views/template_index01.php';