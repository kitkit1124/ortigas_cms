<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader 
{
	function ext_view($folder, $view, $vars = array(), $return = FALSE) {

		if (method_exists($this, '_ci_object_to_array'))
		{
			$vars =$this->_ci_object_to_array($vars);
		}
		else
		{
			$vars = $this->_ci_prepare_view_vars($vars);
		}
	
		$this->_ci_view_paths = array_merge($this->_ci_view_paths, array(FCPATH . $folder . '/' => TRUE));
		return $this->_ci_load(array(
			'_ci_view' => $view,
			'_ci_vars' => $vars,
			'_ci_return' => $return
		));
	}
}