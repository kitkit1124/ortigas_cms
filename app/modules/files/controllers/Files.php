<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Files Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 *              Robert Christian Obias <robert.obias@digify.com.ph>
 *              Aldrin Magno <aldrin.magno@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

class Files extends MX_Controller
{
	/**
	 * Constructor
	 *
	 * @access	public
	 *
	 */

    public $allowed_file_types;

	function __construct()
	{
		parent::__construct();

		$this->load->library('users/acl');
		$this->load->model('settings/configs_model');
		$this->load->model('sellers/sellers_model');
		$this->load->model('customers/customers_model');
		$this->load->model('reservations/reservations_model');
		$this->load->language('files');
	}

	// --------------------------------------------------------------------

	/**
	 * index
	 *
	 * @access	public
	 * @param	none
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	public function index()
	{
		show_404();
	}

	// --------------------------------------------------------------------

	/**
	 * settings
	 *
	 * @access	public
	 * @param	none
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	public function settings()
	{
		$this->acl->restrict('files.files.settings');

		// page title
		$data['page_heading'] = lang('settings_heading');
		$data['page_subhead'] = lang('settings_subhead');

		// breadcrumbs
		$this->breadcrumbs->push(lang('crumb_home'), site_url(''));
		$this->breadcrumbs->push(lang('crumb_module'), site_url('files/settings'));
		$this->breadcrumbs->push(lang('settings_heading'), site_url('files/settings'));

		if ($this->input->post())
		{

			if ($page_id = $this->_save_settings())
			{
				// $this->session->set_flashdata('flash_message',  lang('settings_success'));
				echo json_encode(array('success' => true, 'message' => lang('settings_success'))); exit;
			}
			else
			{
				$response['success'] = FALSE;
				$response['message'] = lang('validation_error');
				$response['errors'] = array(
					'image_size_large'		=> form_error('image_size_large'),
					'image_size_medium'		=> form_error('image_size_medium'),
					'image_size_small'		=> form_error('image_size_small'),
					'image_size_thumb'		=> form_error('image_size_thumb'),
					'youtube_api_key'		=> form_error('youtube_api_key'),
				);
				echo json_encode($response);
				exit;
			}
		}

		$files_configs = array('image_size_medium', 'image_size_small', 'image_size_thumb');

		// get the configs
		$data['configs_img'] = $this->configs_model
			->where('config_deleted', 0)
			->where_in('config_name', $files_configs)
			->find_all();

		$files_configs = array('youtube_api_key');

		// get the configs
		$data['configs_vid'] = $this->configs_model
			->where('config_deleted', 0)
			->where_in('config_name', $files_configs)
			->find_all();

		// render the page
		$this->template->add_css(module_css('files', 'files_settings'), 'embed');
		$this->template->add_js(module_js('files', 'files_settings'), 'embed');
		$this->template->write_view('content', 'files_settings', $data);
		$this->template->render();
	}


	// --------------------------------------------------------------------

	/**
	 * _save_settings
	 *
	 * @access	private
	 * @param 	array $this->input->post()
	 * @author 	Aldrin Magno <aldrin.magno@digify.com.ph>
	 */
	private function _save_settings()
	{
		// validate inputs
		$this->form_validation->set_rules('image_size_large', lang('image_size_large'), 'required');
		$this->form_validation->set_rules('image_size_medium', lang('image_size_medium'), 'required');
		$this->form_validation->set_rules('image_size_small', lang('image_size_small'), 'required');
		$this->form_validation->set_rules('image_size_thumb', lang('image_size_thumb'), 'required');
		$this->form_validation->set_rules('youtube_api_key', lang('youtube_api_key'), 'required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if ($this->form_validation->run($this) == FALSE)
		{
			return FALSE;
		}

		foreach ($this->input->post() as $key => $value)
		{
			if ($key == 'submit') break;

			$this->configs_model->update_where('config_name', $key, array('config_value' => $value));
		}

		$this->cache->delete('app_configs');

		return TRUE;
	}


	// --------------------------------------------------------------------
	
    /**
	 * upload
	 *
	 * @access	public
	 * @param	none
	 * @author 	Robert Christian Obias <robert.obias@digify.com.ph>
	 */
    public function upload()
    {
        $this->load->library('upload_folders');
        $folder = $this->upload_folders->get();

        if(!isset($this->allowed_file_types))
        {
            $this->allowed_file_types = 'pdf|doc|docx|txt';
        }

        $this->upload_file_config = array(
			'upload_path'   => $folder,
			'allowed_types' => $this->allowed_file_types,
			'max_size'		=> 2048,
		);

        $this->load->library('upload', $this->upload_file_config);

		//$this->upload->initialize($this->upload_image_config);

		if (!$this->upload->do_upload('file'))
		{
			$response = array(
				'status'    => 'failed',
				'message'   => $this->upload->display_errors()
			);
		}
		else
		{
            $file_data = $this->upload->data();

            $response = array(
				'status'	=> 'success',
                'site_url'  => site_url(),
				'file'		=> $folder . '/' . $file_data['raw_name'].$file_data['file_ext']
			);
        }

        echo json_encode($response); exit;
    }

	// public function import()
	// {
	// 	file_exists(base_url('/csv/import.xlsx'));


 //        $csv		= $this->input->post('csv');
	// 	$csv_data 	= $this->csv_reader->parse_file($csv);
	// 	$data 		= array_chunk($csv_data, 10, TRUE);

	// 	$key = getenv('KEY');
	// 	$key  =	$this->Key($key);

	// 	$data_arr = array();
	// 			if ( $data )
	// 			{
	// 				set_time_limit(0);
	// 				foreach ( $data as $data_key )
	// 				{
	// 					foreach ( $data_key as $val )
	// 					{
	// 						$clinic_name = remove_special_chars($val['CLINIC NAME']);

	// 						// check if name exists
	// 						if ( ! in_array($clinic_name, $hb_arr))
	// 						{
			

	// 							$data_arr = array(
	// 								'customer_fname'		=> Crypto::encrypt($val['clientfirtname'], $key),
	// 								'customer_lname'		=> Crypto::encrypt($val['clientlastname'], $key),
									
	// 							);

	// 							$insert_hmo = $this->hmo_branches_model->insert($hmo_branch_arr);
	// 						}
	// 					}

	// 					sleep(10);
	// 				}
	
	// 			}
 //    }

	public function import()
	{
		$csv_path = '../pub/csv/';   
		//$files = scandir($csv_path, SCANDIR_SORT_DESCENDING);
		//$newest_file = $files[0];
		//print_r($newest_file);

// get current directory path
  
$dirpath = '../pub/csv/'; 
// set file pattern
$dirpath .= "*.csv";
// copy filenames to array
$files = array();
$files = glob($dirpath);


		$csv = $files[0];
		$file = fopen($csv, "r");

		$key = getenv('KEY');
		$key  =	$this->Key($key);

		$data = array();
			set_time_limit(0);
		$count = 0 ;
		while(($filesop = fgetcsv($file, 1000, ",")) !== false)
			{
				if($count != 0)
				{
	
					$fields =array(
					'seller_first_name' => $filesop[0],
					'seller_middle_name' => $filesop[1],
					'seller_last_name' => $filesop[2],
				);

				$id = $this->sellers_model->select('seller_id')->find_by($fields);	
				if($id)
				{ 
					$seller_id = $id->seller_id;
					if(!empty($filesop[0]))
					{
						$seller_data[] = 
						array(
							'customer_fname' => Crypto::encrypt(($filesop[3] == 'NULL' ? 'NULL' : $filesop[3]),$key),		
							'customer_mname' => Crypto::encrypt(($filesop[4] == 'NULL' ? 'NULL' : $filesop[4]),$key),
							'customer_lname' => Crypto::encrypt(($filesop[5] == 'NULL' ? 'NULL' : $filesop[5]),$key),
							'customer_seller_id' => $seller_id,
							'reservation_unit_details' => $filesop[6],
							'reservation_notes' => $filesop[7],
							
						);

					}
										
				}
				else
				{
					$seller_id = $this->sellers_model->insert($fields);
					$seller_data[] = 
						array(
							'customer_fname' => Crypto::encrypt(($filesop[3] == 'NULL' ? 'NULL' : ($filesop[3] == '' ? 'NULL' : $filesop[3])),$key),	
							'customer_mname' => Crypto::encrypt(($filesop[4] == 'NULL' ? 'NULL' : ($filesop[4] == '' ? 'NULL' : $filesop[4])),$key),
							'customer_lname' => Crypto::encrypt(($filesop[5] == 'NULL' ? 'NULL' : ($filesop[5] == '' ? 'NULL' : $filesop[5])),$key),
							'customer_seller_id' => $seller_id,
							'reservation_unit_details' => $filesop[6],
							'reservation_notes' => $filesop[7],
						);		
			
				}
				}
				$count++;		
			}

		$chunk_data 	= array_chunk($seller_data, 10, TRUE);
		$customer_branch_arr = array();
		foreach ( $chunk_data as $data_key )
		{
			foreach ( $data_key as $val )
			{
				$customer_branch_arr = 
						array(
							'customer_fname' => $val['customer_fname'],	
							'customer_mname' => $val['customer_mname'],
							'customer_lname' => $val['customer_lname'],
							'customer_seller_id' =>$val['customer_seller_id'],
						);	
				
				$customer_id = $this->customers_model->insert($customer_branch_arr);
				$reservation_data = array(
									'reservation_customer_id'  	=> $customer_id,
									'reservation_reference_no' 	=> rand(10000,99999).$customer_id,
									'reservation_unit_details' 	=> $val['reservation_unit_details'],
									'reservation_notes'			=> $val['reservation_notes'],
								);
				$this->reservations_model->insert($reservation_data);
			}

		}
		echo "<pre>";
		print_r($customer_branch_arr);
		echo "</pre>";
		exit;

    }
    private function key($key)
	{
		return Key::loadFromAsciiSafeString($key);
	}
  

}

/* End of file Files.php */
/* Location: ./application/modules/files/controllers/Files.php */