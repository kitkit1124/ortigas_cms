<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Menus Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Menus extends MX_Controller 
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
		$this->load->model('menus_model');
		$this->load->language('menus');
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
		$this->acl->restrict('admin.menus.list');
	
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('admin/menus'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('admin/menus'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

		$this->template->add_css(module_css('admin', 'menus_index'), 'embed');
		$this->template->add_js(module_js('admin', 'menus_index'), 'embed');
		$this->template->write_view('content', 'menus_index', $data);
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
		$this->acl->restrict('admin.menus.list');

		echo $this->menus_model->get_datatables();
	}

	/**
     * form Displays the form for add/edit
     * 
     * @access public
     * @param string $action int $id
     * @author Robert Christian Obias <robert.obias@digify.com.ph>
     */
    public function form($action, $id = 0) 
    {
        // check the current user's permission
        $this->acl->restrict('admin.menus.'.$action, 'modal');

        // set the page variables

        $data = array(
            'page_heading'	=> lang($action.'_heading'),
            'page_type'		=> $action,
            'record'		=> ($id ? $this->menus_model->find($id) : ''),
            'action'		=> $action
        );

        // process the form
        if($this->input->post()) 
        {
            if($this->_save($action, $id)) 
            {
                echo json_encode(array('success' => true, 'message' => lang($action.'_success'))); exit();
            }
            else 
            {
                $response = array(
                    'success' => FALSE,
                    'message' => lang('validation_error'),
                    'errors'  => array(
                        'menu_text' 	=> form_error('menu_text'),
						'menu_link' 	=> form_error('menu_link'),
						'menu_perm' 	=> form_error('menu_perm'),
						'menu_icon' 	=> form_error('menu_icon'),
						'menu_parent' 	=> form_error('menu_parent'),
						'menu_order' 	=> form_error('menu_order'),
						'menu_active' 	=> form_error('menu_active'),
                    )
                );

                echo json_encode($response); exit();
            }
        }

        $data['menu_items'] = $this->menus_model->format_dropdown('menu_id', 'concat(menu_text, " (", menu_link, ")")');
		$data['menu_items'][0]  = 'No Parent';
        
        $this->template->set_template('modal');
        $this->template->add_js(module_js('admin', 'menus_form'), 'embed');
        $this->template->write_view('content', 'menus_form', $data);
        
        $this->template->render();
    }

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function delete($id)
	{
		$this->acl->restrict('admin.menus.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		// $data['page_success'] = lang('delete_success');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->menus_model->delete($id);

			$this->cache->delete('app_menu');
			$this->cache->delete('app_grants');

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * _save
	 *
	 * @access	private
	 * @param	string $type
	 * @param 	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _save($type = 'add', $id = 0)
	{		
		// validate inputs
		$this->form_validation->set_rules('menu_text', lang('menu_text'), 'required');
		$this->form_validation->set_rules('menu_link', lang('menu_link'), 'required');
		$this->form_validation->set_rules('menu_perm', lang('menu_perm'), 'required');
		$this->form_validation->set_rules('menu_icon', lang('menu_icon'), 'required');
		$this->form_validation->set_rules('menu_parent', lang('menu_parent'), 'is_natural');
		$this->form_validation->set_rules('menu_parent', lang('menu_parent'), 'required|is_natural');
		$this->form_validation->set_rules('menu_active', lang('menu_active'), 'is_natural');
		
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		$data = array(
			'menu_text'					=> $this->input->post('menu_text'),
			'menu_link'					=> $this->input->post('menu_link'),
			'menu_perm'					=> $this->input->post('menu_perm'),
			'menu_icon'					=> $this->input->post('menu_icon'),
			'menu_parent'				=> $this->input->post('menu_parent'),
			'menu_order'				=> $this->input->post('menu_order'),
			'menu_active'				=> $this->input->post('menu_active'),
		);
		
		if ($type == 'add')
		{
			$return_id = $this->menus_model->insert($data);

			$return = (is_numeric($return_id)) ? $return_id : FALSE;
		}
		else if ($type == 'edit')
		{
			$return = $this->menus_model->update($id, $data);
		}

		$this->cache->delete('app_menu');
		$this->cache->delete('app_grants');

		return $return;
	}	

}

/* End of file Menus.php */
/* Location: ./application/modules/admin/controllers/Menus.php */