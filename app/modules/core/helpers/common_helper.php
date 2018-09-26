<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Common Helper Functions
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */

if (!function_exists('delete_cache')) 
{
	function delete_cache($uri_string=null)
	{
	    $CI =& get_instance();
	    $path = $CI->config->item('cache_path');
	    $path = rtrim($path, DIRECTORY_SEPARATOR);

	    $cache_path = ($path == '') ? APPPATH.'cache/' : $path;

	    $uri =  $CI->config->item('base_url').
	            $CI->config->item('index_page').
	            $uri_string;

	    $cache_path .= md5($uri);

	    return unlink($cache_path);
	}
}

if (!function_exists('frontend_navigation')) 
{
	function frontend_navigation($id) 
	{
		$CI = & get_instance();
		return $CI->navigations_model->get_frontend_navigations($id);
	}
}

if (!function_exists('frontend_banners')) 
{
	function frontend_banners($id) 
	{
		$CI = & get_instance();
		$CI->load->model('website/banners_model');
		return $CI->banners_model->get_frontend_banners($id);
	}
}

if (!function_exists('parse_content')) 
{
	function parse_content($content) 
	{
		// return $content;
		return preg_replace_callback("/##(.*)\(([0-9])\)##/", "parse_content_callback", $content);
	}

	function parse_content_callback($matches)
	{
		if (function_exists($matches[1])) 
		{
			return $matches[1]($matches[2]);
		}
		else
		{
			return FALSE;
		}
	}
}

if (!function_exists('is_url')) 
{
	function is_url($url)
	{
		return ((substr($url, 0, 7) == 'http://') OR (substr($url, 0, 8) == 'https://')) ? TRUE : FALSE;
	}
}

if (!function_exists('assets_url')) 
{
	function assets_url($uri = '', $group = FALSE) 
	{
		$CI = & get_instance();
		
		if (!$dir = $CI->config->item('assets_path')) 
			$dir = 'assets/';
		
		if ($group) 
			return $CI->config->base_url($dir . $group . '/' . $uri);
		else 
			return $CI->config->base_url($dir . $uri);
	}
}

if (!function_exists('module_js')) 
{
	function module_js($module, $js) 
	{
		return read_file(APPPATH . 'modules/' . $module . '/views/js/' . $js . '.js');

		// return "assets/scripts/extra/extra.js?f=$module/views/js/$js.js";
	}
}

if (!function_exists('module_css')) 
{
	function module_css($module, $css) 
	{
		return read_file(APPPATH . 'modules/' . $module . '/views/css/' . $css . '.css');

		// return "assets/styles/extra/extra.css?f=$module/views/css/$css.css";
	}
}

if (!function_exists('pr')) 
{
	function pr($data) 
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}


if (!function_exists('module_list')) 
{
    function module_list() 
	{
		$modules = get_dir_file_info(APPPATH.'modules/');
		return $modules;
    }
}

if (!function_exists('controller_list')) 
{
    function controller_list() 
	{
		$modules = module_list();
		$controllers = array();
		foreach ($modules as $module)
		{
			$controllers[$module['name']] = get_dir_file_info(APPPATH.'modules/'.$module['name'].'/controllers/', FALSE);
		}

		return $controllers;
    }
}

if (!function_exists('mainnav')) 
{
	function mainnav() 
	{
		$modules = module_list();
		foreach ($modules as $module)
		{
			$file = APPPATH.'modules/'.$module['name'].'/views/'.$module['name'].'_nav.php';
			if (file_exists($file)) include_once $file;
		}
    }
}

if (!function_exists('in_array_search')) {
	function in_array_search($string, $array = array ())
	{       
	    foreach ($array as $key => $value) 
		{
	        unset ($array[$key]);
	        if (strpos($value, $string) !== false) {
	            $array[$key] = $value;
	        }
	    }       
	    return $array;
	}
}

if (!function_exists('array_values_by_key')) 
{
	function array_values_by_key($array, $key = FALSE, $value)
	{
		if (is_array($array))
		{
			foreach ($array as $row) 
			{
				if ($key)
				{
					$vals[$row->$key] = $row->$value; 
				}
				else
				{
					$vals[] = $row->$value; 
				}
			}

			return $vals;
		}
		else
		{
			return array();
		}
				
	}
}

if (!function_exists('multi_array_object_search_sibling')) 
{
	function multi_array_object_search_sibling($array_items, $needle_key, $needle_value, $return_value)
	{
		foreach($array_items as $item)
		{
			if ($item->$needle_key === $needle_value )
			return $item->$return_value;
		}
		return false;
	}
}

if( ! function_exists('relative_time'))
{
    function relative_time($datetime)
    {
        $CI =& get_instance();
        $CI->lang->load('date');

        if(!is_numeric($datetime))
        {
            $val = explode(" ",$datetime);
           $date = explode("-",$val[0]);
           $time = explode(":",$val[1]);
           $datetime = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
        }

        $difference = time() - $datetime;
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        if ($difference > 0) 
        { 
            $ending = 'ago';
        } 
        else 
        { 
            $difference = -$difference;
            $ending = 'to go';
        }
        for($j = 0; $difference >= $lengths[$j]; $j++)
        {
            $difference /= $lengths[$j];
        } 
        $difference = round($difference);

        if($difference != 1) 
        { 
            $period = strtolower($CI->lang->line('date_'.$periods[$j].'s'));
        } else {
            $period = strtolower($CI->lang->line('date_'.$periods[$j]));
        }

        return "$difference $period $ending";
    }
}

if( ! function_exists('get_age'))
{
	function get_age($birth_date)
	{
		if ($birth_date == '0000-00-00') return 0;
		
		// Put the year, month and day in separate variables
		list($Year, $Month, $Day) = explode("-", $birth_date);

		$YearDiff = date("Y") - $Year;

		// If the birthday hasn't arrived yet this year, the person is one year younger
		if(date("m") < $Month || (date("m") == $Month && date("d") < $DayDiff))
		{
			$YearDiff--;
		}
		return $YearDiff;
	}
}

if( ! function_exists('url_get_contents'))
{
	function url_get_contents($Url) {
	    if (!function_exists('curl_init')){ 
	        die('CURL is not installed!');
	    }
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $Url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $output = curl_exec($ch);
	    curl_close($ch);
	    return $output;
	}

}


if (!function_exists('create_dropdown')) 
{
	function create_dropdown($type, $data) 
	{
		if ($type == 'number')
		{
			$numbers = range(1, $data);

			$return = array('');
			foreach ($numbers as $number)
			{
				$return[$number] = $number;
			}
		}
		else if ($type == 'array')
		{
			$return = array();
			$elements = explode(',', $data);
			foreach($elements as $element)
			{
				$return[$element] = $element;
			}
		}

		return $return;
	}
}

if (!function_exists('is_weak_password')) 
{
	function is_weak_password($password)
	{
		/*
		Explaining $\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
		$ = beginning of string
		\S* = any set of characters
		(?=\S{8,}) = of at least length 8
		(?=\S*[a-z]) = containing at least one lowercase letter
		(?=\S*[A-Z]) = and at least one uppercase letter
		(?=\S*[\d]) = and at least one number
		(?=\S*[\W]) = and at least a special character (non-word characters)
		$ = end of the string
		*/

		$dummy = array(); // patch for php 5.3
		if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password, $dummy))
		{
			return 'Password must have at least one lowercase letter, one uppercase letter, one number and one special character';
		}

		else if (preg_match_all('/\s/', $password, $dummy))
		{
			return 'Spaces are not allowed in the password field';
		}

		else if (preg_match('/(password|letmein|1234|superman|batman|qwerty|abc123|baseball|dragon|football|monkey|mustang|access|shadow|master|michael|1111|1212|iloveyou|sunshine|welcome|jesus|ninja)/i', $password))
		{
			return 'Dictionary words and common passwords are not allowed in the password field';
		}

		return FALSE; // strong password
	}
}

/* End of file assets_helper.php */
/* Location: ./application/helpers/assets_helper.php */