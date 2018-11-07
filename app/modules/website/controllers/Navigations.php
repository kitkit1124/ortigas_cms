<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Navigations Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Navigations extends MX_Controller 
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
		
		// check for dependencies
		if (! $this->db->table_exists('navigroups'))
		{
			$this->session->set_flashdata('flash_error', 'Navigations module requires the Websites module version 9');
			redirect($this->session->userdata('redirect'), 'refresh');
		}

		$this->load->model('navigroups_model');
		$this->load->model('navigations_model');
		$this->load->language('navigations');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function index($id = FALSE)
	{
		$this->acl->restrict('website.navigations.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('website/navigations'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('website/navigations'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());

		// echo $id; exit;
		if (!$id)
		{
			redirect('website/navigations/1');
		}

		// active navigation group
		$data['navigroup_id'] = $id;

		// get the navigation groups
		$data['navigroups'] = $this->navigroups_model
			->where('navigroup_deleted', 0)
			->find_all();

		// get the active categories
		$this->load->model('categories_model');
		$data['categories'] = $this->categories_model
			->where('category_deleted', 0)
			->where('category_status', 'Active')
			->find_all();

		// get the active pages
		$this->load->model('pages_model');
		$data['pages'] = $this->pages_model
			->where('page_deleted', 0)
			->where('page_status', 'Posted')
			->find_all();

		// get the navigations
		$data['navigations'] = $this->navigations_model->get_nestable_navigations($id);

		// add plugins
		$this->template->add_js('npm/jquery.nestable/jquery.nestable.js');

		// render the page
		$this->template->add_css(module_css('website', 'navigations_index'), 'embed');
		$this->template->add_js(module_js('website', 'navigations_index'), 'embed');
		$this->template->write_view('content', 'navigations_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('website.navigations.list');

		echo $this->navigations_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * save
	 *
	 * @access	public
	 * @param	$_POST
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	public function save()
	{
		$this->acl->restrict('website.navigations.edit');

		$navigroup_id = $this->input->post('navigroup_id');
		$navigations = $this->input->post('navigations');

		if (is_numeric($navigroup_id) && is_array($navigations))
		{
			// delete existing navigation items
			$this->navigations_model->delete_where(array('navigation_group_id' => $navigroup_id));

			// save the new navigation items
			foreach ($navigations as $nav)
			{
				// save the parent
				$parent_id = $this->_save_nav($navigroup_id, $nav);

				if (isset($nav['children']))
				{
					foreach ($nav['children'] as $child)
					{
						// save the children
						$child_id = $this->_save_nav($navigroup_id, $child, $parent_id);

						if (isset($child['children']))
						{
							foreach ($child['children'] as $grand)
							{
								// save the grand-children
								$this->_save_nav($navigroup_id, $grand, $child_id);
							}
						}
					}
				}
			}

			// update the navigroup structure
			$data = array('navigroup_structure' => json_encode($navigations));
			$this->navigroups_model->update($navigroup_id, $data);

			// delete the frontend cache
			$this->output->delete_cache('/');

			echo json_encode(array('success' => true, 'message' => lang('save_success'))); exit;
		}
		else
		{
			echo json_encode(array('success' => false, 'message' => lang('save_failed'))); exit;
		}

	}

	// --------------------------------------------------------------------

	/**
	 * _save_nav
	 *
	 * @access	private
	 * @param	$navigroup_id integer
	 * @param	$nav array
	 * @param	$parent_id integer
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	private function _save_nav($navigroup_id, $nav, $parent_id = 0)
	{
		$data = array(
			'navigation_group_id'  	=> $navigroup_id,
			'navigation_is_parent'  => (isset($nav['children'])) ? TRUE : FALSE,
			'navigation_parent_id'  => $parent_id,
			'navigation_name'  		=> $nav['name'],
			'navigation_link'  		=> $nav['link'],
			'navigation_source'  	=> (isset($nav['res'])) ? $nav['res'] : NULL,
			'navigation_source_id'  => (isset($nav['resid'])) ? $nav['resid'] : NULL,
			'navigation_target'  	=> $nav['target'],
			'navigation_type'  		=> ($this->_is_url($nav['link'])) ? 'External' : 'Internal',
			'navigation_status'  	=> 'Active',
		);

		$insert_id = $this->navigations_model->insert($data);

		return (is_numeric($insert_id)) ? $insert_id : FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * _is_url
	 *
	 * @access	private
	 * @param	$url string
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	private function _is_url($url)
	{
		return ((substr($url, 0, 7) == 'http://') OR (substr($url, 0, 8) == 'https://')) ? TRUE : FALSE;
	} 


	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('website.navigations.' . $action, 'modal');

		$data['page_heading'] = lang($action . '_heading');
		$data['action'] = $action;

		if ($this->input->post())
		{
			if ($this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'message' => lang($action . '_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(					
					'navigation_group_id'		=> form_error('navigation_group_id'),
					'navigation_parent_id'		=> form_error('navigation_parent_id'),
					'navigation_name'		=> form_error('navigation_name'),
					'navigation_link'		=> form_error('navigation_link'),
					'navigation_target'		=> form_error('navigation_target'),
					'navigation_type'		=> form_error('navigation_type'),
					'navigation_status'		=> form_error('navigation_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->navigations_model->find($id);

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('website', 'navigations_form'), 'embed');
		$this->template->add_js(module_js('website', 'navigations_form'), 'embed');
		$this->template->write_view('content', 'navigations_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('website.navigations.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->navigations_model->delete($id);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}


	// --------------------------------------------------------------------

	/**
	 * _save
	 *
	 * @access	private
	 * @param	string $action
	 * @param 	integer $id
	 * @author 	Randy Nivales <randy.nivales@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('navigation_group_id', lang('navigation_group_id'), 'required');
		$this->form_validation->set_rules('navigation_parent_id', lang('navigation_parent_id'), 'required');
		$this->form_validation->set_rules('navigation_name', lang('navigation_name'), 'required');
		$this->form_validation->set_rules('navigation_link', lang('navigation_link'), 'required');
		$this->form_validation->set_rules('navigation_target', lang('navigation_target'), 'required');
		$this->form_validation->set_rules('navigation_type', lang('navigation_type'), 'required');
		$this->form_validation->set_rules('navigation_status', lang('navigation_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'navigation_group_id'		=> $this->input->post('navigation_group_id'),
			'navigation_parent_id'		=> $this->input->post('navigation_parent_id'),
			'navigation_name'		=> $this->input->post('navigation_name'),
			'navigation_link'		=> $this->input->post('navigation_link'),
			'navigation_target'		=> $this->input->post('navigation_target'),
			'navigation_type'		=> $this->input->post('navigation_type'),
			'navigation_status'		=> $this->input->post('navigation_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->navigations_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->navigations_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Navigations.php */
/* Location: ./application/modules/website/controllers/Navigations.php */