<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Social_plugins Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Social_plugins extends MX_Controller {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */

	var $start_date;
	var $end_date;

	function __construct()
	{
		parent::__construct();

		$this->load->library('users/acl');
		$this->load->model('social_plugins_model');
		$this->load->language('social_plugins');
		
		$this->start_date 	= date('Y-m-d', strtotime("today -30 days"));
		$this->end_date 	= date('Y-m-d', strtotime("today"));

	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('social_plugins.social_plugins.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('social_plugins'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('components/DataTables/datatables.min.css');
		$this->template->add_js('components/DataTables/datatables.min.js');
		$this->template->add_js('components/daterangepicker/moment.min.js');
		$this->template->add_css('components/daterangepicker/daterangepicker.css');
		$this->template->add_js('components/daterangepicker/daterangepicker.js');
		$this->template->add_js('https://www.gstatic.com/charts/loader.js', 'external');
		
		// render the page
		$this->template->add_css(module_css('social_plugins', 'social_plugins_index'), 'embed');
		$this->template->add_js(module_js('social_plugins', 'social_plugins_index'), 'embed');
		$this->template->write_view('content', 'social_plugins_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('social_plugins.social_plugins.list');

		echo $this->social_plugins_model->get_datatables(($this->input->get('start') ?: $this->start_date), ($this->input->get('end') ?: $this->end_date));
	}

	// --------------------------------------------------------------------

	/**
	 * content
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function contents()
	{
		$this->acl->restrict('social_plugins.social_plugins.list');

		// override language file
		$this->load->language('social_plugin_contents');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('social_plugins/reports'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('social_plugins/contents'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('components/DataTables/datatables.min.css');
		$this->template->add_js('components/DataTables/datatables.min.js');
		$this->template->add_js('components/daterangepicker/moment.min.js');
		$this->template->add_css('components/daterangepicker/daterangepicker.css');
		$this->template->add_js('components/daterangepicker/daterangepicker.js');
		$this->template->add_js('https://www.gstatic.com/charts/loader.js', 'external');
		
		// render the page
		$this->template->add_js(module_js('social_plugins', 'social_plugins_content_index'), 'embed');
		$this->template->add_css(module_css('social_plugins', 'social_plugins_content_index'), 'embed');
		$this->template->write_view('content', 'social_plugins_content_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * top_pages
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function top_pages()
	{
		$result = $this->social_plugins_model
					->select('social_plugin_url, SUM(social_plugin_count) AS social_plugin_count')
					->where('social_plugin_date BETWEEN "' . ($this->input->get('start') ?: $this->start_date) . '" AND "' . ($this->input->get('end') ?: $this->end_date) . '"')
					->order_by('social_plugin_count', 'DESC')
					->group_by('social_plugin_url')
					->limit(5)->find_all();

		echo json_encode($result);
	}

	// --------------------------------------------------------------------

	/**
	 * top_channels
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function top_channels()
	{
		$result = $this->social_plugins_model
					->select('social_plugin_channel, SUM(social_plugin_count) AS social_plugin_count')
					->where('social_plugin_date BETWEEN "' . ($this->input->get('start') ?: $this->start_date) . '" AND "' . ($this->input->get('end') ?: $this->end_date) . '"')
					->order_by('social_plugin_count', 'DESC')
					->group_by('social_plugin_channel')
					->limit(5)->find_all();

		echo json_encode($result);
	}

	// --------------------------------------------------------------------

	/**
	 * report_line_chart
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	public function report_line_chart()
	{
		$result = $this->social_plugins_model
					->select('DATE_FORMAT(social_plugin_date, "%Y-%m-%d") AS social_plugin_date, SUM(social_plugin_count) AS social_plugin_count')
					->where('social_plugin_date BETWEEN "' . ($this->input->get('start') ?: $this->start_date) . '" AND "' . ($this->input->get('end') ?: $this->end_date) . '"')
					->order_by('social_plugin_date', 'ASC')
					->group_by('social_plugin_date')
					->find_all();
		
		$channel = array(array("Month", "Shares"));
		if ($result)
		{
			foreach ($result as $key => $value)
			{
				$channel[($key+1)][0] = $value->social_plugin_date;
				$channel[($key+1)][1] = (int)$value->social_plugin_count;
			}
		}
		else
		{
			$channel[1][0] = date("Y-m-d");
			$channel[1][1] = 0;
		}

		echo json_encode($channel);
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	none
	 * @author 	JP Llapitan <john.llapitan@digify.com.ph>
	 */
	function collect()
	{
		if ($this->input->get())
		{
			$date = date('Y-m-d');

			// check if record is already exists
			$this->db->where('social_plugin_channel', $this->input->get('channel'));
			$this->db->where('social_plugin_url', $this->input->get('url'));
			$this->db->where('social_plugin_event', $this->input->get('event'));
			$this->db->where('social_plugin_date', $date);
			$count = $this->social_plugins_model->find_all();

			// update existing record
			if ($count)
			{
				$this->db->where('social_plugin_channel', $this->input->get('channel'));
				$this->db->where('social_plugin_url', $this->input->get('url'));
				$this->db->where('social_plugin_event', $this->input->get('event'));
				$this->db->where('social_plugin_date', $date);
				$this->db->set('social_plugin_count', '`social_plugin_count`+1', FALSE);
				
				if($this->db->update('social_plugins'))
				{
					echo json_encode(array('status' => 'success', 'message' => lang('share_success') . ucfirst($this->input->get('channel'))));
					exit();
				}
				else
				{
					echo json_encode(array('status' => 'error', 'message' => lang('share_error') . ucfirst($this->input->get('channel'))));
					exit();
				}			
			}

			// insert new record
			$data = array(
						"social_plugin_channel" => $this->input->get('channel'),
						"social_plugin_url" 	=> urldecode($this->input->get('url')),
						"social_plugin_event" 	=> $this->input->get('event'),
						"social_plugin_count" 	=> 1,
						"social_plugin_date" 	=> $date,
					);
			
			$insert_id = $this->social_plugins_model->insert($data);

			if ($insert_id)
			{
				echo json_encode(array('status' => 'success', 'message' => lang('share_success') . ucfirst($this->input->get('channel'))));
			}
			else {
				echo json_encode(array('status' => 'error', 'message' => lang('share_error') . ucfirst($this->input->get('channel'))));
			}
		}
	}

}

/* End of file Social_plugins.php */
/* Location: ./application/modules/social_plugins/controllers/Social_plugins.php */