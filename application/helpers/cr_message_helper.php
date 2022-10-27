<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');	

if ( ! function_exists('cr_session_messages'))
{	
    function cr_show_messages($messages=array(), $type=NULL)
    {    
        $CI =& get_instance();
        $new_messages = "";

        if ( !is_null($messages) && $messages != NULL && $type != NULL && $type != "")
        {        
            if ( is_array($messages))
            {
                $messages = implode("<br>", $messages);
            }
        }

        if ($CI->session->flashdata('success_messages') || $type=='success_messages'){
        
            $new_messages.= "<div class='alert alert-success alert-dismissible show fade'>"
                            .$CI->session->flashdata('success_messages').
                            $messages.
                            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
        }
        
        if ($CI->session->flashdata('error_messages') || $type=='error_messages'){
        
            $new_messages .= "<div class='alert alert-danger alert-dismissible show fade'>"
                            .$CI->session->flashdata('error_messages').
                            $messages.
                            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
       
        }

        return $new_messages;
    }
}
