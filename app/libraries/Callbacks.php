<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

class Callbacks {

    // --------------------------------------------------------------------
    
	
    public static function payments($params)
    {
		$key = getenv('KEY');
		$key  =	Key::loadFromAsciiSafeString($key);
        $data = array();

        if($params)
        {
            $counter = 0;
            $arr = array();
            foreach($params as $k=>$val)
            {
				$name = explode(" ",$val['fullname'] );
                $arr = array(
                    'fullname' => Crypto::decrypt($name[0],$key)." ".Crypto::decrypt($name[1],$key)
                );
                
                $data[$counter] = array_merge($params[$counter], $arr);
                $counter++;
            }
        }
        
        return $data;
    }
	public static function customers($params)
    {
		$key = getenv('KEY');
		$key  =	Key::loadFromAsciiSafeString($key);
        $data = array();

        if($params)
        {
            $counter = 0;
            $arr = array();
            foreach($params as $k=>$val)
            {
                $arr = array(
				'customer_fname' 				=> ($val['customer_lname'] 				== '' ? '' :	Crypto::decrypt($val['customer_fname'],$key)),
				'customer_lname'				=> ($val['customer_lname'] 				== '' ? '' :	Crypto::decrypt($val['customer_lname'],$key)),
				'customer_telno'				=> ($val['customer_telno'] 				== '' ? '' :	Crypto::decrypt($val['customer_telno'],$key)),
				'customer_mobileno'				=> ($val['customer_mobileno'] 			== '' ? '' :	Crypto::decrypt($val['customer_mobileno'],$key)),
				'customer_email'				=> ($val['customer_email'] 				== '' ? '' :	Crypto::decrypt($val['customer_email'],$key)),
				'customer_id_type'				=> ($val['customer_id_type'] 			== '' ? '' :	Crypto::decrypt($val['customer_id_type'],$key)),
				'customer_id_details'			=> ($val['customer_id_details'] 		== '' ? '' : 	Crypto::decrypt($val['customer_id_details'],$key)),
				'customer_mailing_country'		=> ($val['customer_mailing_country'] 	== '' ? '' :	Crypto::decrypt($val['customer_mailing_country'],$key)),
				'customer_mailing_house_no'		=> ($val['customer_mailing_house_no'] 	== '' ? '' :	Crypto::decrypt($val['customer_mailing_house_no'],$key)),
				'customer_mailing_street'		=> ($val['customer_mailing_street'] 	== '' ? '' : 	Crypto::decrypt($val['customer_mailing_street'],$key)),
				'customer_mailing_city'			=> ($val['customer_mailing_city'] 		== '' ? '' : 	Crypto::decrypt($val['customer_mailing_city'],$key)),
				'customer_mailing_brgy'			=> ($val['customer_mailing_brgy'] 		== '' ? '' : 	Crypto::decrypt($val['customer_mailing_brgy'],$key)),
				'customer_mailing_zip_code'		=> ($val['customer_mailing_zip_code'] 	== '' ? '' : 	Crypto::decrypt($val['customer_mailing_zip_code'],$key)),
				'customer_billing_country'		=> ($val['customer_billing_country'] 	== '' ? '' : 	Crypto::decrypt($val['customer_billing_country'],$key)),
				'customer_billing_house_no'		=> ($val['customer_billing_house_no'] 	== '' ? '' : 	Crypto::decrypt($val['customer_billing_house_no'],$key)),
				'customer_billing_street'		=> ($val['customer_billing_street'] 	== '' ? '' : 	Crypto::decrypt($val['customer_billing_street'],$key)),
				'customer_billing_city'			=> ($val['customer_billing_city'] 		== '' ? '' : 	Crypto::decrypt($val['customer_billing_city'],$key)),
				'customer_billing_brgy'			=> ($val['customer_billing_brgy'] 		== '' ? '' : 	Crypto::decrypt($val['customer_billing_brgy'],$key)),
				'customer_billing_zip_code'		=> ($val['customer_billing_zip_code'] 	== '' ? '' : 	Crypto::decrypt($val['customer_billing_zip_code'],$key)),
				
                );
                
                $data[$counter] = array_merge($params[$counter], $arr);
                $counter++;
            }
        }
        
        return $data;
    }
	public static function reservation_customers($params)
    {
		$key = getenv('KEY');
		$key  =	Key::loadFromAsciiSafeString($key);
        $data = array();

        if($params)
        {
            $counter = 0;
            $arr = array();
            foreach($params as $k=>$val)
            {
                $arr = array(
				'customer_fname' 			=> Crypto::decrypt($val['customer_fname'], $key),
				'customer_lname'			=> Crypto::decrypt($val['customer_lname'], $key),
                );
                
                $data[$counter] = array_merge($params[$counter], $arr);
                $counter++;
            }
        }
        
        return $data;
    }
    
   
}