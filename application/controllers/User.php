<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    function __construct()
	{
		parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
	{
       
        $data['template']['main_content'] = 'admin/auth/auth';   
        $data['template']['content'] = 'admin/auth/login';     
        $data['template']['title'] = 'Login.';    
        $data['template']['css'][] = 'pages/auth.css';   
        
        $data['template']['content'] = 'admin/auth/register';
        $data['template']['title'] = 'Sign Up.';   

        $data['template']['content'] = 'admin/auth/forgot_password';
        $data['template']['title'] = 'Forgot Password.';   

        $data['template']['css'] = NULL;
        $data['template']['main_content'] = 'admin/app/app';   
        $data['template']['content'] = 'admin/dashboard';   
        $data['template']['content'] = 'admin/student/add';   

		$this->load->view('admin/main/template', $data);
	}

    public function login()
    {
        $data['template']['main_content'] = 'admin/auth/auth';   
        $data['template']['content'] = 'admin/auth/login';     
        $data['template']['title'] = 'Login.';    
        $data['template']['css'] = array(
            'css/pages/auth.css'
        );   
        $data['template']['form']['action'] = base_url('user/login');    
        $data['data'] = array();

        $this->form_validation->set_rules($this->User_model->login_rules());
		
		if($this->form_validation->run())
		{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
			$auth = $this->User_model->verify_login($username, $password);
			
            if($auth['success'] == TRUE)
            {
                $session_data =  array('session_user_id' => $auth['data']['id'], 
										'session_username' => $auth['data']['username'], 
										);
                $this->session->set_userdata($session_data);
                
                $this->session->set_flashdata('success_messages', 'Welcome, '.$username);
        		
                redirect("administrator/dashboard");
                // redirect("user/login");
	        }
            else
            {
                $data['data']['errors'] = $auth['message'];
            }
			
		}
        else
        {
            $data['data']['errors'] = validation_errors();
        }
	
	
        $this->load->view('admin/main/template', $data);
    }

    public function logout()
    { 
        $username =  $this->session->userdata('session_username');
        $session_data =  array('session_user_id' => NULL, 
                                'session_username' => NULL, 
							);
        $this->session->set_userdata($session_data);


        $this->session->set_flashdata('success_messages', 'See you later, '.$username);
        redirect("user/login");
        
        $this->session->sess_destroy();
    }
}
