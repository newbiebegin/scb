<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');	

if ( ! function_exists('cr_dropdown_active_status'))
{	
    function cr_dropdown_active_status()
    {    
        return $contents = array(
            "" => "",
            "Y" => "Active",
            "N" => "Inactive"
        );
    }

    function cr_dropdown_gender()
    {    
        return $contents = array(
            "" => "",
            "M" => "Male",
            "F" => "Female"
                );
    }
}
