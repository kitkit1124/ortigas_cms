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

		if ($action != 'add') 
		{
			$fields = array(
			'customer_id',
			'customer_fname',
			'customer_lname',
			'customer_telno',
			'customer_mobileno',
			'customer_email',
			'customer_id_type',
			'customer_id_details',
			'customer_mailing_country',
			'customer_mailing_house_no',
			'customer_mailing_street',
			'customer_mailing_city',
			'customer_mailing_brgy',
			'customer_mailing_zip_code',
			'customer_billing_country',
			'customer_billing_house_no',
			'customer_billing_street',
			'customer_billing_city',
			'customer_billing_brgy',
			'customer_billing_zip_code',
			);

			$customers = $this->customers_model->select($fields)->find_by('customer_id',$id);
			$key = getenv('KEY');
			$key  =	$this->Key($key);
			
			$array = array();
			foreach ($customers as $k => $value) {	
					if($k !== 'customer_id' )
					{	
						$array[$k] =  ($value == '' ? '' : Crypto::decrypt($value,$key));
					}
					else
					{

						$array[$k] =  $value;
					}
					
				}
			$data['record'] =  (object )$array;
		}	
		

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
	Public function email_validation($email)
	{
		$result = preg_match('/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',$email);
		if($result)
		{
		 	return true;
  		}
		else
		{
    		return false;
  		}
			
	}

	private function _save($action = 'add', $id = 0)
	{
		// validate inputs
		$this->form_validation->set_rules('customer_fname', 'First Name', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_lname','Last Name', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_telno', 'Phone Number', 'required|numeric|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_mobileno','Mobile Number', 'required|numeric|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_email', 'Email Address', 'required|valid_email|min_length[1]|max_length[50]|trim|callback_email_validation');
		$this->form_validation->set_rules('customer_id_type', 'ID Type', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_id_details', 'ID Details', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_mailing_country', 'Country', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_mailing_house_no','House Number', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_mailing_street', 'Street', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_mailing_city', 'City', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_mailing_brgy', 'Barangay', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_mailing_zip_code', 'Zip Code', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_billing_country', 'Country', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_billing_house_no', 'House Number', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_billing_street', 'Street', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_billing_city', 'City', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_billing_brgy','Barangay', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('customer_billing_zip_code', 'Zip Code', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_message('email_validation','The Email Address field must contain a valid email address.');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$key = getenv('KEY');
		$key  =	$this->Key($key);

		$data = array(
			'customer_fname'		=> Crypto::encrypt($this->input->post('customer_fname'), $key),
			'customer_lname'		=> Crypto::encrypt($this->input->post('customer_lname'), $key),
			'customer_telno'		=> Crypto::encrypt($this->input->post('customer_telno'), $key),
			'customer_mobileno'		=> Crypto::encrypt($this->input->post('customer_mobileno'), $key),
			'customer_email'		=> Crypto::encrypt($this->input->post('customer_email'), $key),
			'customer_id_type'		=> Crypto::encrypt($this->input->post('customer_id_type'), $key),
			'customer_id_details'		=> Crypto::encrypt($this->input->post('customer_id_details'), $key),
			'customer_mailing_country'		=> Crypto::encrypt($this->input->post('customer_mailing_country'), $key),
			'customer_mailing_house_no'		=> Crypto::encrypt($this->input->post('customer_mailing_house_no'), $key),
			'customer_mailing_street'		=> Crypto::encrypt($this->input->post('customer_mailing_street'), $key),
			'customer_mailing_city'		=> Crypto::encrypt($this->input->post('customer_mailing_city'), $key),
			'customer_mailing_brgy'		=> Crypto::encrypt($this->input->post('customer_mailing_brgy'), $key),
			'customer_mailing_zip_code'		=> Crypto::encrypt($this->input->post('customer_mailing_zip_code'), $key),
			'customer_billing_country'		=> Crypto::encrypt($this->input->post('customer_billing_country'), $key),
			'customer_billing_house_no'		=> Crypto::encrypt($this->input->post('customer_billing_house_no'), $key),
			'customer_billing_street'		=> Crypto::encrypt($this->input->post('customer_billing_street'), $key),
			'customer_billing_city'		=> Crypto::encrypt($this->input->post('customer_billing_city'), $key),
			'customer_billing_brgy'		=>  Crypto::encrypt($this->input->post('customer_billing_brgy'), $key),
			'customer_billing_zip_code'		=> Crypto::encrypt($this->input->post('customer_billing_zip_code'), $key),

			
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

		//$key = Key::CreateNewRandomKey();
		//$key = $key->saveToAsciiSafeString();

		$key = 'def000004e43f0793f89d18d2f5bcdcb044fa7ebb65319eb266e7fb7dd936830162d998896953f9f0db6f5dd6d5a567598950ff4efa77e21dc8c527cd7adcb022f34674e';
	     $key  =	$this->Key($key);

		
		$a = Crypto::encrypt((string) $faker->randomNumber(5), $key); 
		$b = Crypto::decrypt('def50200edc38196a2a67c3672d1c19af29988b84a9c1be3816e59651b9250b72546badac57c06a7178f0952172bec44100bca0076c7cb20db18bdce48a15f10b2bbcdff6b20e864273ab29965081d8e944e88b3688ac93a49', $key);
	
		$insert_data = array();
		for ( $i=1; $i<=1; $i++ )
		{
			$insert_data = array(
				'customer_fname' 			=> Crypto::encrypt($faker->firstName, $key),
				'customer_lname'			=> Crypto::encrypt($faker->lastName, $key),
				'customer_telno'			=> Crypto::encrypt('09262150624', $key),
				'customer_mobileno' 		=> Crypto::encrypt('09262150624', $key),
				'customer_email'			=> Crypto::encrypt('jaime.ramos@gmail.com.ph', $key),
				'customer_id_type'	  		=> Crypto::encrypt('Postal ID', $key),
				'customer_id_details' 		=> Crypto::encrypt((string) $faker->randomNumber(5), $key),
				'customer_mailing_country'	=> Crypto::encrypt('PHILIPPINES', $key),
				'customer_mailing_house_no'	=> Crypto::encrypt((string) $faker->randomNumber(5), $key),
				'customer_mailing_street'	=> Crypto::encrypt($faker->streetName, $key),
				'customer_mailing_city'		=> Crypto::encrypt($faker->city, $key),
				'customer_mailing_brgy'		=> Crypto::encrypt($faker->state, $key),
				'customer_mailing_zip_code' => Crypto::encrypt($faker->postcode, $key),
				'customer_billing_country'	=> Crypto::encrypt('PHILIPPINES', $key),
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
					'reservation_reference_no'			=> $faker->randomNumber(5).$customer_id,
					'reservation_project'				=> $faker->realText(20),
					'reservation_property_specialist'	=> $faker->realText(20),
					'reservation_sellers_group'			=> $faker->realText(20),
					'reservation_unit_details'			=> $faker->realText(20),
					'reservation_allocation'			=> $faker->realText(20),
					'reservation_fee'					=> 0.01,
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