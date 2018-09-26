<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * App_configs Class
 *
 * This class loads the settings from configs table
 *
 * @package		App_configs
 * @version		1.0
 * @author 		Robert Christian Obias <robert.obias@digify.com.ph>
 * @copyright 	Copyright (c) 2014, Robert Christian Obias
 * @link		
 */
class App_configs {
	
	 /**
	  * Constructor
	  *
	  * @access	public
	  *
	  */
	public function __construct()
	{	
		$this->CI =& get_instance();

		$this->CI->load->driver('cache', $this->CI->config->item('cache_drivers'));

		// check if configs table exists
		if ($this->CI->db->table_exists('configs'))
		{
			if (! $app_configs = $this->CI->cache->get('app_configs'))
			{
				$app_configs = $this->CI->db->select('config_id, config_name, config_value')->get('configs');

				if ($app_configs = $app_configs->result())
				{
					// then save to cache
					$this->CI->cache->save('app_configs', $app_configs);
				}
			}
			
		 
			// assemble the config data
			foreach ($app_configs as $app_config)
			{
				$app_config = (object)$app_config;
				
				$this->CI->config->set_item($app_config->config_name, $app_config->config_value);
			}

			log_message('debug', "App_configs Class Initialized");
		}
		else
		{
			// die('Configs table does not exists');
		}
	}
}

/* End of file App_configs.php */
/* Location: ./application/libraries/App_configs.php */