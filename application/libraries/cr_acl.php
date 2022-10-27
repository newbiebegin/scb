<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Cr_acl{

        public $session_user_id;

        public function __construct()
		{
			$CI =&get_instance();
			$this->session_user_id = $CI->session->userdata('session_user_id');		
				
			if (session_id() === '' AND isset($session_IU) AND !empty($session_IU))
				session_start();
			
			$CI->load->model('User_model');
		}

		function verify_acl(){
		
			$CI =&get_instance();
            // var_dump($CI->router->method);
            // var_dump($CI->router->class);
            // exit();
			// // $this->router->class;

            $data['modul'] = NULL;//$modul;
            $data['action'] = NULL;//$action;
            $data['allowed_users'] = NULL;//$allowed_users;
            $data['session_user_id'] = $this->session_user_id;

            $data_return = $CI->User_model->verify_acl($data);

            if($data_return['success'] == FALSE)
            {
                $CI->session->set_flashdata('error_messages', $data_return['message']);
                redirect('user/login/', 'refresh');
            }
        }
    }