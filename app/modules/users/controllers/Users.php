<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Users Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Users extends CI_Controller 
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
		$this->load->database();
		$this->load->library(array('acl', 'ion_auth', 'form_validation', 'reports/audittrail'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		$this->load->model('users_model');
		$this->load->model('groups_model');
		$this->load->model('users_model');
		$this->load->language('users');
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
		$this->acl->restrict('users.users.list');
		
		// page title
		$data['page_heading'] = lang('index_heading');
		$data['page_subhead'] = lang('index_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_settings'), site_url('users'));
		$this->breadcrumbs->push(lang('index_heading'), site_url('users'));

		// session breadcrumb
		$this->session->set_userdata('redirect', current_url());
		
		$this->template->add_css('npm/datatables.net-bs4/css/dataTables.bootstrap4.css');
		$this->template->add_css('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
		$this->template->add_js('npm/datatables.net/js/jquery.dataTables.js');
		$this->template->add_js('npm/datatables.net-bs4/js/dataTables.bootstrap4.js');
		$this->template->add_js('npm/datatables.net-responsive/js/dataTables.responsive.min.js');
		$this->template->add_js('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
		
		$this->template->add_js(module_js('users', 'users_index'), 'embed');
		$this->template->write_view('content', 'users_index', $data);
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
		$this->acl->restrict('users.users.list');

		$fields = array('id', 'first_name', 'last_name', 'email', 'created_on', 'last_login', 'active');

		echo $this->users_model->datatables($fields);
	}

	// --------------------------------------------------------------------

	/**
	 * add
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function add()
	{
		$this->acl->restrict('users.users.add', 'modal');

		$data['page_heading'] = lang('add_heading');
		$data['page_type'] = 'add';

		if ($this->input->post())
		{
			if ($this->_create_user())
			{
				echo json_encode(array('success' => true, 'message' => lang('add_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'first_name'		=> form_error('first_name'),
					'last_name'			=> form_error('last_name'),
					'company'			=> form_error('company'),
					'phone'				=> form_error('phone'),
					'email'				=> form_error('email'),
					// 'username'			=> form_error('username'),
					'password'			=> form_error('password'),
					'confirm_password'	=> form_error('confirm_password'),
				);
				echo json_encode($response);
				exit;
			}
		}

		$data['groups'] = $this->groups_model->order_by('name')->find_all();

		$data['current_groups'] = array();

		$this->template->set_template('modal');
		$this->template->add_css('npm/select2/css/select2.min.css');
		$this->template->add_js('npm/select2/js/select2.min.js');	
		$this->template->add_js(module_js('users', 'users_form'), 'embed');
		$this->template->write_view('content', 'users_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * permission
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function edit($id)
	{
		$this->acl->restrict('users.users.edit', 'modal');

		$data['page_heading'] = lang('edit_heading');
		$data['page_type'] = 'edit';

		if ($this->input->post())
		{
			if ($this->_edit_user($id))
			{
				echo json_encode(array('success' => true, 'message' => lang('edit_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'first_name'		=> form_error('first_name'),
					'last_name'			=> form_error('last_name'),
					'company'			=> form_error('company'),
					'phone'				=> form_error('phone'),
					'email'				=> form_error('email'),
					'username'			=> form_error('username'),
					'password'			=> form_error('password'),
					'password_confirm'	=> form_error('password_confirm'),
				);
				echo json_encode($response);
				exit;
			}
		}

		$data['record'] = $this->users_model->find($id);

		// get the current groups
		$current_groups = $this->ion_auth->get_users_groups($id)->result();

		$data['groups'] = $this->groups_model->order_by('name')->find_all();

		// current groups
		$curr_grp = array();
		if ($current_groups)
		{
			foreach($current_groups as $grp)
			{
				// $curr_grp .= "{id:{$grp->id}, text:'{$grp->name}'},";
				$curr_grp[] = $grp->id;
			}
		}
		// $data['current_groups'] = '[' . $curr_grp . ']';
		$data['current_groups'] = $curr_grp;

		$this->template->set_template('modal');
		$this->template->add_css('npm/select2/css/select2.min.css');
		$this->template->add_js('npm/select2/js/select2.min.js');	
		$this->template->add_js(module_js('users', 'users_form'), 'embed');
		$this->template->write_view('content', 'users_form', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * login
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function login()
	{
		$data['page_heading'] = "Login";
		$data['page_subhead'] = "Sign in to start your session";

		//validate form input
		$this->form_validation->set_rules('identity', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if ($this->form_validation->run($this) == TRUE)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page or the page before the login page
				$this->session->set_flashdata('message', $this->ion_auth->messages());

				// log this
				$this->audittrail->insert('login', 'users');

				if ($this->input->post('return'))
				{
					header('Location: ' . $this->input->post('return'));
					//echo "<script>console.log(".header('Location: ' . $this->input->post('return')).")</script>";
					//pr('test');
				}
				else
				{
					// if ($this->acl->restrict('dashboard.dashboard.list', 'return'))
					// {
						redirect('', 'refresh');
					// }
					// else
					// {
					// 	redirect('', 'refresh');
					// }
				}
			}
			else
			{
				//if the login was un-successful
				$data['error_message'] = $this->ion_auth->errors();
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['error_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array(
				'name' 			=> 'identity',
				'id' 			=> 'identity',
				'type' 			=> 'text',
				'value' 		=> $this->form_validation->set_value('identity'),
				'autocomplete' 	=> 'off'
			);
			$data['password'] = array(
				'name' 			=> 'password',
				'id' 			=> 'password',
				'type' 			=> 'password',
				'autocomplete' 	=> 'off'
			);

			// $this->_render_page('users/login', $data);

			
		}

		$this->template->set_template('blank');
		$this->template->add_js(module_js('users', 'users_login'), 'embed');
		$this->template->write_view('content', 'users_login', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * logout
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function logout()
	{
		$data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		// log this
		$this->audittrail->insert('logout', 'users');

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('users/login', 'refresh');
	}

	// --------------------------------------------------------------------

	/**
	 * profile
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function profile()
	{
		$this->acl->restrict('users.users.profile', 'modal');

		$data['page_heading'] = lang('profile_heading');

		$user = $this->ion_auth->user()->row();

		if ($this->input->post())
		{
			if ($this->_change_profile($user))
			{
				echo json_encode(array('success' => true, 'message' => lang('profile_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'first_name'		=> form_error('first_name'),
					'last_name'			=> form_error('last_name'),
					'email'				=> form_error('email'),
					'company'			=> form_error('company'),
					'phone'				=> form_error('phone'),
				);
				echo json_encode($response);
				exit;
			}
		}

		$data['record'] = $user;
		$this->template->set_template('modal');
		$this->template->add_js(module_js('users', 'users_profile'), 'embed');
		$this->template->write_view('content', 'users_profile', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * password
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function password()
	{
		$this->acl->restrict('users.users.password', 'modal');

		$data['page_heading'] = lang('password_heading');

		if ($this->input->post())
		{
			if ($this->_change_password())
			{
				echo json_encode(array('success' => true, 'message' => lang('password_success'))); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'old'				=> form_error('old'),
					'new'				=> form_error('new'),
					'new_confirm'		=> form_error('new_confirm')
				);
				echo json_encode($response);
				exit;
			}
		}


		$this->template->set_template('modal');
		$this->template->add_js(module_js('users', 'users_password'), 'embed');
		$this->template->write_view('content', 'users_password', $data);
		$this->template->render();
	}

	// --------------------------------------------------------------------

	/**
	 * photo
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function photo()
	{	
		$this->acl->restrict('users.users.photo');

		// page title
		$data['page_heading'] = lang('photo_heading');
		$data['page_subhead'] = lang('photo_subhead');
		
		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('index_heading'), site_url('users'));
		$this->breadcrumbs->push(lang('photo_heading'), site_url('users/photo'));

		if (!empty($_FILES))
		{
			$this->_save_photo();
			exit;
		}

		$this->template->add_css('npm/dropzone/dropzone.min.css');
		$this->template->add_js('npm/dropzone/dropzone.min.js');

		$this->template->add_css(module_css('users', 'users_photo'), 'embed');
		$this->template->add_js(module_js('users', 'users_photo'), 'embed');
		$this->template->write_view('content', 'users_photo', $data);
		$this->template->render();
	}


	// --------------------------------------------------------------------

	/**
	 * forgot_password
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function forgot_password()
	{
		$data['page_heading'] = "Forgot Password";
		$data['page_subhead'] = "Please enter your Email so we can send you an email to reset your password.";

		//setting validation rules by checking wheather identity is username or email
		if($this->config->item('identity', 'ion_auth') == 'username' )
		{
		   $this->form_validation->set_rules('email', lang('forgot_password_username_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('email', lang('forgot_password_validation_email_label'), 'required|valid_email');
		}
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');


		if ($this->form_validation->run() == false)
		{
			//setup the input
			$data['email'] = array(
				'name' 			=> 'email',
				'id' 			=> 'email', 
				'class' 		=> 'form-control',
				'autocomplete' 	=> 'off',
				'placeholder'	=> 'Email Address'
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$data['identity_label'] = lang('forgot_password_username_identity_label');
			}
			else
			{
				$data['identity_label'] = lang('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			// $this->_render_page('users/forgot_password', $data);

			$this->template->set_template('blank');
			$this->template->write_view('content', 'users_forgot_password', $data);
			$this->template->render();
		}
		else
		{
			// get identity from username or email
			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
			}
			else
			{
				$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
			}

			if (empty($identity)) {

				if($this->config->item('identity', 'ion_auth') == 'username')
				{
					$this->ion_auth->set_message('forgot_password_username_not_found');
				}
				else
				{
				   $this->ion_auth->set_message('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('flash_error', $this->ion_auth->messages());
				redirect("users/forgot_password", 'refresh');
			}

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// log this
				$data = array('username' => $identity);
				$this->audittrail->insert('forgot password', 'users', $data);

				//if there were no errors
				$this->session->set_flashdata('flash_message', $this->ion_auth->messages());
				redirect("users/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("users/forgot_password", 'refresh');
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * reset_password
	 *
	 * @access	public
	 * @param	string $code
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	public function reset_password($code = NULL)
	{
		$data['page_heading'] = "Reset Password";
		$data['page_subhead'] = "Please enter your new password.";

		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', lang('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', lang('reset_password_validation_new_password_confirm_label'), 'required');
			$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
					'class' => 'form-control',
					'autocomplete' 	=> 'off'
				);
				$data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
					'class' => 'form-control',
					'autocomplete' 	=> 'off'
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				//render
				$this->template->set_template('blank');
				$this->template->write_view('content', 'users_reset_password', $data);
				$this->template->render();
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error(lang('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// log this
						$data = array('username' => $identity);
						$this->audittrail->insert('reset password', 'users', $data);

						//if the password was successfully changed
						$this->session->set_flashdata('flash_message', $this->ion_auth->messages());
						redirect("users/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('flash_error', $this->ion_auth->errors());
						redirect('users/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('flash_error', $this->ion_auth->errors());
			redirect("users/forgot_password", 'refresh');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * activate
	 *
	 * @access	public
	 * @param	integer $id
	 * @param	string $code
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function activate($id, $code=false)
	{
		$this->acl->restrict('users.users.activate');

		$data['page_heading'] = lang('activate_heading');
		$data['page_confirm'] = lang('activate_confirm');
		$data['page_button'] = lang('button_activate');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->ion_auth->activate($id);

			// log this
			$data = array('id' => $id);
			$this->audittrail->insert('activate', 'users', $data);

			echo json_encode(array('success' => true, 'message' => lang('activate_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * suspend
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function suspend($id = NULL)
	{
		$this->acl->restrict('users.users.suspend');

		$data['page_heading'] = lang('suspend_heading');
		$data['page_confirm'] = lang('suspend_confirm');
		$data['page_button'] = lang('button_suspend');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->ion_auth->deactivate($id);

			// log this
			$data = array('id' => $id);
			$this->audittrail->insert('suspend', 'users', $data);

			echo json_encode(array('success' => true, 'message' => lang('suspend_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
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
		$this->acl->restrict('users.users.delete', 'modal');

		$data['page_heading'] = lang('delete_heading');
		$data['page_confirm'] = lang('delete_confirm');
		$data['page_button'] = lang('button_delete');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$this->ion_auth->remove_from_group('', $id);
			$this->users_model->delete($id);

			// log this
			$data = array('id' => $id);
			$this->audittrail->insert('delete', 'users', $data);

			echo json_encode(array('success' => true, 'message' => lang('delete_success'))); exit;
		}

		$this->load->view('../../modules/core/views/confirm', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * change_user
	 *
	 * @access	public
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	function change_user($id)
	{
		$data['page_heading'] = lang('change_user_heading');
		$data['page_confirm'] = lang('change_user_confirm');
		$data['page_button'] = lang('button_change_user');
		$data['datatables_id'] = '#datatables';

		if ($this->input->post())
		{
			$user = $this->users_model->find($id);

			$temp_pass = uniqid();
			$pass = $user->password;

			$data = array(
				'password' => $temp_pass
			);

			if($this->ion_auth->update($user->id, $data))
			{
				$remember = (bool) 0;

				if ($this->ion_auth->login($user->email, $temp_pass, $remember))
				{
					$revert = array(
						'password' => $pass
					);

					$this->users_model->update($user->id, $revert);

					// log this
					$data = array('id' => $id);
					$this->audittrail->insert('change user', 'users', $data);

					echo json_encode(array('success' => true, 'message' => lang('change_user_success'))); exit;
				}
				else
				{
					echo json_encode(array('success' => false, 'message' => "fail")); exit;
				}
			}
			else
			{
				echo json_encode(array('success' => false, 'message' => "fail")); exit;
			}
		}

		$this->template->set_template('modal');
		$this->template->add_js(module_js('users', 'roles_change_user'), 'embed');
		$this->template->write_view('content', 'roles_change_user', $data);
		$this->template->render();

	}

	// --------------------------------------------------------------------

	/**
	 * _create_user
	 *
	 * @access	private
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _create_user()
	{
		$tables = $this->config->item('tables','ion_auth');

		//validate form input
		$this->form_validation->set_rules('first_name', lang('first_name'), 'required');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'required');
		$this->form_validation->set_rules('email', lang('email'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
		$this->form_validation->set_rules('company', lang('company'), 'max_length[100]');
		$this->form_validation->set_rules('phone', lang('phone'), 'max_length[20]');
		// $this->form_validation->set_rules('username', lang('username'), 'required|is_unique['.$tables['users'].'.username]');
		$this->form_validation->set_rules('password', lang('password'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|callback__password_check');
		$this->form_validation->set_rules('password_confirm', lang('password_confirm'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$username 	= $this->input->post('email');
		$email    	= strtolower($this->input->post('email'));
		$password 	= $this->input->post('password');
		$groups 	= $this->input->post('groups');
		$company 	= $this->input->post('company');
		$phone 		= $this->input->post('phone');

		$additional_data = array(
			'first_name'	=> $this->input->post('first_name'),
			'last_name'		=> $this->input->post('last_name'),
			'company'		=> $this->input->post('company'),
			'phone'			=> $this->input->post('phone'),
			'photo'			=> 'ui/images/unknown.jpg',
		);

		// log this
		$data = array(
			'username' => $username,
			'email' => $email,
			'groups' => $groups,
			'firsname' => $this->input->post('first_name'),
			'lastname' => $this->input->post('last_name')
		);
		$this->audittrail->insert('insert', 'users', $data);

		if ($this->ion_auth->register($username, $password, $email, $additional_data, $groups))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _edit_user
	 *
	 * @access	private
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _edit_user($id)
	{
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', lang('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', lang('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('email', lang('email'), 'required|valid_email');
		$this->form_validation->set_rules('company', lang('company'), 'max_length[100]');
		$this->form_validation->set_rules('phone', lang('phone'), 'max_length[20]');
		// $this->form_validation->set_rules('username', lang('username'), 'required');

		if ($this->input->post('password'))
		{
			$this->form_validation->set_rules('password', lang('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|callback__password_check');
			$this->form_validation->set_rules('password_confirm', lang('edit_user_validation_password_confirm_label'), 'required');
		}

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'first_name'	=> $this->input->post('first_name'),
			'last_name'		=> $this->input->post('last_name'),
			'company'		=> $this->input->post('company'),
			'phone'			=> $this->input->post('phone'),
			'email'			=> $this->input->post('email'),
			// 'username'  => $this->input->post('username'),
		);

		// update the password if it was posted
		if ($this->input->post('password'))
		{
			$data['password'] = $this->input->post('password');
		}

		// Only allow updating groups if user is admin
		// if ($this->ion_auth->is_admin())
		// {
			// Update the groups user belongs to
			$groupData = $this->input->post('groups');

			if (isset($groupData) && !empty($groupData)) {

				$this->ion_auth->remove_from_group('', $id);

				foreach ($groupData as $grp) {
					$this->ion_auth->add_to_group($grp, $id);
				}
			}
		// }

		// log this
		$this->audittrail->insert('update', 'users', $data);

		if ($this->ion_auth->update($user->id, $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _change_password
	 *
	 * @access	private
	 * @param	integer $id
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _change_password()
	{

		$this->form_validation->set_rules('old', lang('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', lang('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]|callback__password_check');
		$this->form_validation->set_rules('new_confirm', lang('change_password_validation_new_password_confirm_label'), 'required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		// $user = $this->ion_auth->user()->row();

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			// log this
			$data = array();
			$this->audittrail->insert('change password', 'users', $data);

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				// $this->logout();
				return TRUE;
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				// redirect('users/change_password', 'refresh');
				return FALSE;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _change_profile
	 *
	 * @access	private
	 * @param	object $user
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _change_profile($user)
	{
		$this->form_validation->set_rules('first_name', lang('first_name'), 'required');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'required');
		$this->form_validation->set_rules('email', lang('email'), 'required|valid_email');
		$this->form_validation->set_rules('company', lang('company'), 'max_length[100]');
		$this->form_validation->set_rules('phone', lang('phone'), 'max_length[20]');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}
		else
		{
			$data = array(
				'first_name'	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'email'			=> strtolower($this->input->post('email')),
				'company'		=> $this->input->post('company'),
				'phone'			=> $this->input->post('phone'),
			);

			// log this
			$this->audittrail->insert('change profile', 'users', $data);

			if ($this->ion_auth->update($user->id, $data))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _save_photo
	 *
	 * @access	private
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */
	private function _save_photo()
	{
		// get the current upload folder
		$this->load->library('files/upload_folders');
		$folder = $this->upload_folders->get();

		// get the users profile
		$user = $this->ion_auth->user()->row();

		$config = array();
		$config['upload_path'] = FCPATH . $folder;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= 0;
		$config['max_width']  = 0;
		$config['max_height']  = 0;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{	echo $this->upload->display_errors(); exit;
			return FALSE;
		}
		$img = $this->upload->data();
		// pr($img); exit;
		log_message('debug', print_r($img, true));
		
		$this->load->library('image_lib'); 
		
		// // resize the image
		// $config['image_library'] = 'gd2';
		// $config['source_image'] = $img['full_path'];
		// $config['create_thumb'] = FALSE;
		// $config['maintain_ratio'] = FALSE;
		// $config['width'] = 150;
		// $config['height'] = 150;
		// $this->image_lib->initialize($config);
		// if ( ! $this->image_lib->resize())
		// {
		//     return FALSE;
		// }

		// crop the image
		$cropped_image = $folder . '/' . $img['raw_name'] . '_cropped' . $img['file_ext'];
		$img_size = ($img['image_width'] > $img['image_height']) ? $img['image_height'] : $img['image_width'];
		$config2['image_library'] = 'gd2';
		$config2['source_image'] = $img['full_path'];
		$config2['new_image'] = FCPATH . $cropped_image;
		$config2['create_thumb'] = FALSE;
		$config2['maintain_ratio'] = FALSE;
		$config2['width'] = $img_size;
		$config2['height'] = $img_size;
		$config2['x_axis'] = ($img['image_width'] > $img['image_height']) ? ($img['image_width'] - $img['image_height'])/2 : 0;
		$config2['y_axis'] = ($img['image_height'] > $img['image_width']) ? ($img['image_height'] - $img['image_width'])/2 : 0;

		$this->image_lib->initialize($config2);
		$this->image_lib->crop(); 	


		// reset
		$this->image_lib->clear();

		
		// resize the image
		$config['image_library'] = 'gd2';
		$config['source_image'] = $cropped_image;
		$config['new_image'] = FCPATH . $folder . '/' . $img['raw_name'] . $img['file_ext'];
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;

		$config['width'] = 250;
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	
		// filename for the db
		$photo = $img['file_name'];
		// $this->session->set_userdata('photo', $photo);

		

		if ($this->ion_auth->update($user->id, array('photo' => $folder . '/' . $photo)))
		{
			// delete the user's previous profile photo
			// unlink(FCPATH . $folder . $user->photo);

			return TRUE;
		}
		else
		{
			log_message('debug', print_r($this->ion_auth->errors(), TRUE));
			return FALSE;
		}
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

	public function _password_check($str)
	{
		if ($result = is_weak_password($str))
		{
			$this->form_validation->set_message('_password_check', $result);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}
