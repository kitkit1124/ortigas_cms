<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Payments Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Digify Admin <webdevs@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;
class Payments extends MX_Controller {
	
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
		$this->load->model('payments_model');
		$this->load->language('payments');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('payments.payments.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('payments'));
		
		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		// add plugins
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		
		
		
		// render the page
		$this->template->add_css(module_css('payments', 'payments_index'), 'embed');
		$this->template->add_js(module_js('payments', 'payments_index'), 'embed');
		$this->template->write_view('content', 'payments_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('payments.payments.list');

		echo $this->payments_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('payments.payments.' . $action, 'modal');

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
					'payment_reservation_id'		=> form_error('payment_reservation_id'),
					'payment_encoded_details'		=> form_error('payment_encoded_details'),
					'payment_status'		=> form_error('payment_status'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') 

		$fields = array(
			'payment_reservation_id',
			'payment_paynamics_no',
			'customer_fname', 
			'customer_lname',
			'reservation_project',
			'payment_type',
			'reservation_fee',
			'payment_status',
		);
		$key = getenv('KEY');
		$key  =	$this->Key($key);

		$payment_data = $this->payments_model->select($fields)
		->join('reservations','reservation_reference_no =  payment_reservation_id')
		->join('customers', 'customer_id = reservation_customer_id', 0)
		->find_by('payment_id',$id);

		$payment =array();
		foreach ($payment_data as $k => $value) {	
			if($k == 'customer_fname' || $k == 'customer_lname')
			{
				$payment[$k] =  Crypto::decrypt($value,$key);
			}
			else
			{
				$payment[$k] =  $value;
			}
			
		}
		$data['record'] = (object) $payment;

		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('payments', 'payments_form'), 'embed');
		$this->template->add_js(module_js('payments', 'payments_form'), 'embed');
		$this->template->write_view('content', 'payments_form', $data);
		$this->template->render();
	}
	private function key($key)
	{
		return Key::loadFromAsciiSafeString($key);
	}
	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('payments.payments.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->payments_model->delete($id);

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
	 * @author 	Digify Admin <webdevs@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('payment_reservation_id', lang('payment_reservation_id'), 'required');
		$this->form_validation->set_rules('payment_encoded_details', lang('payment_encoded_details'), 'required');
		$this->form_validation->set_rules('payment_status', lang('payment_status'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'payment_reservation_id'		=> $this->input->post('payment_reservation_id'),
			'payment_encoded_details'		=> $this->input->post('payment_encoded_details'),
			'payment_status'		=> $this->input->post('payment_status'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->payments_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->payments_model->update($id, $data);
		}

		return $return;

	}
}

/* End of file Payments.php */
/* Location: ./application/modules/payments/controllers/Payments.php */