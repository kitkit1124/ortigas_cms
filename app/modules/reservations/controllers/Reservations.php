<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Reservations Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2019, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;
class Reservations extends MX_Controller {
	
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
		$this->load->model('reservations_model');
		$this->load->model('customers/customers_model');
		$this->load->language('reservations');
		$this->load->model('properties/properties_model');
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
		$this->acl->restrict('reservations.reservations.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('reservations'));
		
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
		$this->template->add_css(module_css('reservations', 'reservations_index'), 'embed');
		$this->template->add_js(module_js('reservations', 'reservations_index'), 'embed');
		$this->template->write_view('content', 'reservations_index', $data);
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
		$this->acl->restrict('reservations.reservations.list');

		echo $this->reservations_model->get_datatables();
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
	private function key($key)
	{
		return Key::loadFromAsciiSafeString($key);
	}

	function email_form($action = 'email', $id = FALSE)
	{
		

		$data['page_heading'] = 'Send Form Link';
		$data['action'] = $action;

		
		$reservation_data = $this->reservations_model->select('reservation_customer_id,reservation_reference_no')->find_by(array('reservation_customer_id' => $id));
		$c = $this->customers_model->select('customer_email')->find_by(array('customer_id' =>$reservation_data->reservation_customer_id));
		
		$key = getenv('KEY');
		$key  =	$this->Key($key);

		if($c->customer_email == '')
		{
			$data['email'] = '';
		}
		else
		{
			$data['email'] =  Crypto::decrypt($c->customer_email,$key);
		}
		
		 if ($this->input->post())
		 {
			
	
			$user = $this->ion_auth->user()->row();
		 	$this->send_email($this->input->post('reservation_email'),$user->email,$reservation_data->reservation_reference_no);
			echo json_encode(array('success' => true, 'message' => $this->input->post('reservation_email'))); exit;
		 }	
		// $user = $this->ion_auth->user()->row();
		// $this->send_email($email,$user->email,$reservation_data->reservation_reference_no);
	

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('reservations', 'reservations_form'), 'embed');
		$this->template->add_js(module_js('reservations', 'reservations_email_form'), 'embed');
		$this->template->write_view('content', 'reservations_email_form', $data);
		$this->template->render();
	}

	function form($action = 'add', $id = FALSE)
	{
		$this->acl->restrict('reservations.reservations.' . $action, 'modal');

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
					'reservation_customer_id'		=> form_error('reservation_customer_id'),
					//'reservation_reference_no'		=> form_error('reservation_reference_no'),
					'reservation_project'		=> form_error('reservation_project'),
					'reservation_property_specialist'		=> form_error('reservation_property_specialist'),
					'reservation_sellers_group'		=> form_error('reservation_sellers_group'),
					'reservation_unit_details'		=> form_error('reservation_unit_details'),
					'reservation_allocation'		=> form_error('reservation_allocation'),
					'reservation_fee'		=> form_error('reservation_fee'),
					'reservation_notes'		=> form_error('reservation_notes'),
				);
				echo json_encode($response);
				exit;
			}
		}

		if ($action != 'add') $data['record'] = $this->reservations_model->find($id);


		$c = $this->customers_model->select('customer_id,customer_fname,customer_lname')->where('customer_deleted',0)->order_by('customer_fname','asc')->find_all();
		$customers =array();

		if($c)
		{
			$key = getenv('KEY');
			$key  =	$this->Key($key);
			$customers =array();
			foreach ($c	 as $k => $value) {
				$fname = (Crypto::decrypt($value->customer_fname,$key) == 'NULL' ? '': Crypto::decrypt($value->customer_fname,$key));
				$lname = (Crypto::decrypt($value->customer_lname,$key) == 'NULL' ? '': Crypto::decrypt($value->customer_lname,$key));
				$customers[$value->customer_id] =  $fname." ".$lname;
			}
		}

		$data['customers'] = $customers;
		
		$data['properties'] = $this->properties_model->get_active_properties();

		// render the page
		$this->template->set_template('modal');
		$this->template->add_css(module_css('reservations', 'reservations_form'), 'embed');
		$this->template->add_js(module_js('reservations', 'reservations_form'), 'embed');
		$this->template->write_view('content', 'reservations_form', $data);
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
		$this->acl->restrict('reservations.reservations.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->reservations_model->delete($id);

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
		//$this->form_validation->set_rules('reservation_reference_no', lang('reservation_reference_no'), 'required');
		$this->form_validation->set_rules('reservation_project', lang('reservation_project'), 'required');
		$this->form_validation->set_rules('reservation_property_specialist', lang('reservation_property_specialist'), 'required');
		$this->form_validation->set_rules('reservation_sellers_group', lang('reservation_sellers_group'), 'required');
		$this->form_validation->set_rules('reservation_unit_details', lang('reservation_unit_details'), 'required');
		$this->form_validation->set_rules('reservation_allocation', lang('reservation_allocation'), 'required');
		$this->form_validation->set_rules('reservation_fee', lang('reservation_fee'), 'required|numeric');
		$this->form_validation->set_rules('reservation_notes', lang('reservation_notes'), 'required');


		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}
	

		$data = array(
			'reservation_customer_id'		=> $this->input->post('reservation_customer_id'),
			'reservation_reference_no'		=> rand(10000,99999).$this->input->post('reservation_customer_id'),
			'reservation_project'		=> $this->input->post('reservation_project'),
			'reservation_property_specialist'		=> $this->input->post('reservation_property_specialist'),
			'reservation_sellers_group'		=> $this->input->post('reservation_sellers_group'),
			'reservation_unit_details'		=> $this->input->post('reservation_unit_details'),
			'reservation_allocation'		=> $this->input->post('reservation_allocation'),
			'reservation_fee'		=> number_format($this->input->post('reservation_fee'), 2, '.', ''),
			'reservation_notes'		=> $this->input->post('reservation_notes'),
		);
		

		if ($action == 'add')
		{
			$insert_id = $this->reservations_model->insert($data);
			
			$c = $this->customers_model->select('customer_email')->find_by(array('customer_id' => $this->input->post('reservation_customer_id')));

		$key = getenv('KEY');
		$key  =	$this->Key($key);
		
			$email =  Crypto::decrypt($c->customer_email,$key);
			
			$user = $this->ion_auth->user()->row();
			$this->send_email($email,$user->email,$data['reservation_reference_no']);
			$return = (is_numeric($insert_id)) ? $insert_id : FALSE;
		}
		else if ($action == 'edit')
		{
			$return = $this->reservations_model->update($id, $data);
		}

		return $return;

	}
	public function send_email($to,$from,$ref_no)
	{
			$config['smtp_host'] = 'ortigas.com.ph';
			$config['protocol'] = 'smtp';
			$config['smtp_timeout'] = 10;
            $config['smtp_port'] = 25;
            $config['smtp_user'] = 'information@tiendesitas.com.ph';
            $config['smtp_pass'] = 'K5a1$li1';
            $config['mailtype'] = 'html';
            $config['charset'] ='utf-8';
            $config['newline'] ='\r\n';
            $config['validation'] = true;
            $config['email_debug'] ='y';
        
		
            $this->load->library('email');

            $this->email->initialize($config);
			
			$message_content = getenv('WEB_URL').'/reservations/form/'.$ref_no;
           	
            $this->email->clear();
            $this->email->set_newline("\r\n");
            $this->email->to($to);
			$this->email->cc('rafael.aquino@digify.com.ph,jaime.ramos@digify.com.ph');
            $this->email->from($from,config_item('website_name'));
            $this->email->subject('Reservation Form');
            $this->email->set_mailtype("html");
            $this->email->message($message_content);
            if($this->email->send())
			{
				return true;
			}
			else
			{
				return false;
			}
			
	}
}

/* End of file Reservations.php */
/* Location: ./application/modules/reservations/controllers/Reservations.php */