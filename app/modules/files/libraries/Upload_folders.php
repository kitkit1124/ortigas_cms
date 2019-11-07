<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Upload_folders Class
 *
 * @package		Codifire
 * @version		1.1
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2016, Randy Nivales
 * @link		randynivales@gmail.com
 */
class Upload_folders {

	/**
	* Constructor
	*
	* @access	public
	*
	*/
	public function __construct()
	{
		log_message('debug', "Upload_folders Class Initialized");
	}
	
	// --------------------------------------------------------------------

	/**
	 * get
	 *
	 * Returns the current upload folder
	 *
	 * @access	public
	 * @param	none
	 * @author 	Randy Nivales <randynivales@gmail.com>
	 */	
	function get()
	{
		$upload_path = getenv('UPLOAD_FOLDER').'data/uploads/';

		$year = date("Y");   
		$month = date("m");   
		
		$year_folder = $upload_path . $year;   
		$month_folder = $upload_path . $year . "/" . $month;

		if (file_exists($year_folder))
		{
			if (file_exists($month_folder) == FALSE)
			{
				mkdir($month_folder, 0777);
				chmod($month_folder,0777);
			}
		}
		else
		{
			mkdir($year_folder, 0777);
			mkdir($month_folder, 0777);

			chmod($year_folder,0777);
			chmod($month_folder,0777);
		}

		return $upload_path . $year . "/" . $month;
	}
}

/* End of file Upload_folders.php */
/* Location: ./application/modules/files/libraries/Upload_folders.php */