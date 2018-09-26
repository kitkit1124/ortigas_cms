<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Auditlog Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Audittrails extends MX_Controller 
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
		$this->load->model('audittrails_model');
		$this->load->language('audittrails');
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
		$this->acl->restrict('reports.audittrails.list');
	
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('reports/audittrails'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('reports/audittrails'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// datatables
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		// render the page
		$this->template->add_css(module_css('reports', 'audittrails_index'), 'embed');
		$this->template->add_js(module_js('reports', 'audittrails_index'), 'embed');
		$this->template->write_view('content', 'audittrails_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function datatables()
	{
		$this->acl->restrict('reports.audittrails.list');

		echo $this->audittrails_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * view
	 *
	 * @access	public
	 * @param   $id integer
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function view($id)
	{
		$this->acl->restrict('reports.audittrails.view', 'modal');

		$data['audittrail'] = $this->audittrails_model
			->join('users', 'id = audittrail_created_by', 'LEFT')
			->find($id);

		if ($this->_is_json($data['audittrail']->audittrail_data))
		{
			$data['data'] = '<pre>' . print_r(json_decode($data['audittrail']->audittrail_data), TRUE) . '</pre>';
		}
		else
		{
			$data['data'] = $this->_sql_format(trim($data['audittrail']->audittrail_data, '"'));
		}

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('reports', 'audittrails_view'), 'embed');
		$this->template->add_js(module_js('reports', 'audittrails_view'), 'embed');
		$this->template->write_view('content', 'audittrails_view', $data);
		$this->template->render();
	}

	private function _sql_format($query) 
	{
		$keywords = array("select", "from", "where", "order by", "group by", "insert into", "update", "values", "and");
		foreach ($keywords as $keyword) 
		{
			if (preg_match("/($keyword *)/i", $query, $matches)) 
			{
				$query = str_replace($matches[1], "<br><strong>" . strtoupper($matches[1]) . "</strong><br>", $query);
			}
		}
		return $query;
	}

	private function _is_json($string)
	{
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}

	// --------------------------------------------------------------------

	/**
	 * export
	 *
	 * @access	public
	 * @param	none
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function export()
	{
		$this->load->dbutil();
        $this->load->helper('download');

		$keyword = $this->input->get('q');

		return $this->audittrails_model->export($keyword);
	}

	// --------------------------------------------------------------------

	/**
	 * truncate
	 *
	 * @access	public
	 * @param	none
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function truncate()
	{
		$this->acl->restrict('reports.audittrails.truncate', 'modal');

		$data['page_heading'] = lang('truncate_heading');
		$data['page_confirm'] = lang('truncate_confirm');
		$data['page_button'] = lang('button_truncate');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->audittrails_model->truncate();

			echo json_encode(array('success' => true, 'message' => lang('truncate_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);		
	}
}

/* End of file Audittrail.php */
/* Location: ./application/modules/reports/controllers/Audittrail.php */