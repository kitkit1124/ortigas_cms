<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Customers Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

class Customers extends MX_Controller {
	
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
		$this->load->model('customers_model');
		$this->load->model('reservations/reservations_model');

		$this->load->language('customers');
	}
	
	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function index()
	{
		$this->acl->restrict('customers.customers.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('customers'));
		
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
		$this->template->add_css(module_css('customers', 'customers_index'), 'embed');
		$this->template->add_js(module_js('customers', 'customers_index'), 'embed');
		$this->template->write_view('content', 'customers_index', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * datatables
	 *
	 * @access	public
	 * @param	mixed datatables parameters (datatables.net)
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	public function datatables()
	{
		$this->acl->restrict('customers.customers.list');

		echo $this->customers_model->get_datatables();
	}

	// --------------------------------------------------------------------

	/**
	 * form
	 *
	 * @access	public
	 * @param	$action string
	 * @param   $id integer
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('customers.customers.' . $action, 'modal');

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
					'customer_fname'		=> form_error('customer_fname'),
					'customer_lname'		=> form_error('customer_lname'),
					'customer_telno'		=> form_error('customer_telno'),
					'customer_mobileno'		=> form_error('customer_mobileno'),
					'customer_email'		=> form_error('customer_email'),
					'customer_id_type'		=> form_error('customer_id_type'),
					'customer_id_details'		=> form_error('customer_id_details'),
					'customer_mailing_country'		=> form_error('customer_mailing_country'),
					'customer_mailing_house_no'		=> form_error('customer_mailing_house_no'),
					'customer_mailing_street'		=> form_error('customer_mailing_street'),
					'customer_mailing_city'		=> form_error('customer_mailing_city'),
					'customer_mailing_brgy'		=> form_error('customer_mailing_brgy'),
					'customer_mailing_zip_code'		=> form_error('customer_mailing_zip_code'),
					'customer_billing_country'		=> form_error('customer_billing_country'),
					'customer_billing_house_no'		=> form_error('customer_billing_house_no'),
					'customer_billing_street'		=> form_error('customer_billing_street'),
					'customer_billing_city'		=> form_error('customer_billing_city'),
					'customer_billing_brgy'		=> form_error('customer_billing_brgy'),
					'customer_billing_zip_code'		=> form_error('customer_billing_zip_code'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->customers_model->find($id);


		

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('customers', 'customers_form'), 'embed');
		$this->template->add_js(module_js('customers', 'customers_form'), 'embed');
		$this->template->write_view('content', 'customers_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	function delete($id)
	{
		$this->acl->restrict('customers.customers.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->customers_model->delete($id);

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
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('customer_fname', lang('customer_fname'), 'required');
		$this->form_validation->set_rules('customer_lname', lang('customer_lname'), 'required');
		$this->form_validation->set_rules('customer_telno', lang('customer_telno'), 'required');
		$this->form_validation->set_rules('customer_mobileno', lang('customer_mobileno'), 'required');
		$this->form_validation->set_rules('customer_email', lang('customer_email'), 'required');
		$this->form_validation->set_rules('customer_id_type', lang('customer_id_type'), 'required');
		$this->form_validation->set_rules('customer_id_details', lang('customer_id_details'), 'required');
		$this->form_validation->set_rules('customer_mailing_country', lang('customer_mailing_country'), 'required');
		$this->form_validation->set_rules('customer_mailing_house_no', lang('customer_mailing_house_no'), 'required');
		$this->form_validation->set_rules('customer_mailing_street', lang('customer_mailing_street'), 'required');
		$this->form_validation->set_rules('customer_mailing_city', lang('customer_mailing_city'), 'required');
		$this->form_validation->set_rules('customer_mailing_brgy', lang('customer_mailing_brgy'), 'required');
		$this->form_validation->set_rules('customer_mailing_zip_code', lang('customer_mailing_zip_code'), 'required');
		$this->form_validation->set_rules('customer_billing_country', lang('customer_billing_country'), 'required');
		$this->form_validation->set_rules('customer_billing_house_no', lang('customer_billing_house_no'), 'required');
		$this->form_validation->set_rules('customer_billing_street', lang('customer_billing_street'), 'required');
		$this->form_validation->set_rules('customer_billing_city', lang('customer_billing_city'), 'required');
		$this->form_validation->set_rules('customer_billing_brgy', lang('customer_billing_brgy'), 'required');
		$this->form_validation->set_rules('customer_billing_zip_code', lang('customer_billing_zip_code'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'customer_fname'		=> $this->input->post('customer_fname'),
			'customer_lname'		=> $this->input->post('customer_lname'),
			'customer_telno'		=> $this->input->post('customer_telno'),
			'customer_mobileno'		=> $this->input->post('customer_mobileno'),
			'customer_email'		=> $this->input->post('customer_email'),
			'customer_id_type'		=> $this->input->post('customer_id_type'),
			'customer_id_details'		=> $this->input->post('customer_id_details'),
			'customer_mailing_country'		=> $this->input->post('customer_mailing_country'),
			'customer_mailing_house_no'		=> $this->input->post('customer_mailing_house_no'),
			'customer_mailing_street'		=> $this->input->post('customer_mailing_street'),
			'customer_mailing_city'		=> $this->input->post('customer_mailing_city'),
			'customer_mailing_brgy'		=> $this->input->post('customer_mailing_brgy'),
			'customer_mailing_zip_code'		=> $this->input->post('customer_mailing_zip_code'),
			'customer_billing_country'		=> $this->input->post('customer_billing_country'),
			'customer_billing_house_no'		=> $this->input->post('customer_billing_house_no'),
			'customer_billing_street'		=> $this->input->post('customer_billing_street'),
			'customer_billing_city'		=> $this->input->post('customer_billing_city'),
			'customer_billing_brgy'		=> $this->input->post('customer_billing_brgy'),
			'customer_billing_zip_code'		=> $this->input->post('customer_billing_zip_code'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->customers_model->insert($data);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->customers_model->update($id, $data);
		}

		return $return;
	}

	private function key($key)
	{
		return Key::loadFromAsciiSafeString($key);
	}

	public function generate_data()
	{
		$faker = Faker\Factory::create();

		$key = $this->key(getenv('KEY'));

		// $ciphertext  = Crypto::encrypt('testingsecretdata', $key);
		// $secret_data = Crypto::decrypt($ciphertext, $key);

		$a = Crypto::encrypt((string) $faker->randomNumber(5), $key); 
		$b = Crypto::decrypt($a, $key);

		$insert_data = array();
		for ( $i=1; $i<=50; $i++ )
		{
			$insert_data = array(
				'customer_fname' 			=> Crypto::encrypt($faker->firstName, $key),
				'customer_lname'			=> Crypto::encrypt($faker->lastName, $key),
				'customer_telno'			=> Crypto::encrypt($faker->phoneNumber, $key),
				'customer_mobileno' 		=> Crypto::encrypt($faker->phoneNumber, $key),
				'customer_email'			=> Crypto::encrypt($faker->email, $key),
				'customer_id_type'	  		=> Crypto::encrypt('Postal ID', $key),
				'customer_id_details' 		=> Crypto::encrypt((string) $faker->randomNumber(5), $key),
				'customer_mailing_country'	=> Crypto::encrypt($faker->country, $key),
				'customer_mailing_house_no'	=> Crypto::encrypt((string) $faker->randomNumber(5), $key),
				'customer_mailing_street'	=> Crypto::encrypt($faker->streetName, $key),
				'customer_mailing_city'		=> Crypto::encrypt($faker->city, $key),
				'customer_mailing_brgy'		=> Crypto::encrypt($faker->state, $key),
				'customer_mailing_zip_code' => Crypto::encrypt($faker->postcode, $key),
				'customer_billing_country'	=> Crypto::encrypt($faker->country, $key),
				'customer_billing_house_no'	=> Crypto::encrypt((string) $faker->randomNumber(5), $key),
				'customer_billing_street'	=> Crypto::encrypt($faker->streetName, $key),
				'customer_billing_city'		=> Crypto::encrypt($faker->city, $key),
				'customer_billing_brgy'		=> Crypto::encrypt($faker->state, $key),
				'customer_billing_zip_code' => Crypto::encrypt($faker->postcode, $key),
			);

			$customer_id = $this->customers_model->insert($insert_data);

			if ( $customer_id )
			{
				$reservation_data = array(
					'reservation_customer_id'			=> $customer_id,
					'reservation_reference_no'			=> $faker->randomNumber(5),
					'reservation_project'				=> $faker->realText(20),
					'reservation_property_specialist'	=> $faker->realText(20),
					'reservation_sellers_group'			=> $faker->realText(20),
					'reservation_unit_details'			=> $faker->realText(20),
					'reservation_allocation'			=> $faker->realText(20),
					'reservation_fee'					=> $faker->randomFloat(2),
					'reservation_notes'					=> $faker->text(150)
				);
				
				$this->reservations_model->insert($reservation_data);

				echo 'Added ' . "\r\n";
			}
		}
	}
}

/* End of file Customers.php */
/* Location: ./application/modules/customers/controllers/Customers.php */