<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Cr_controller extends CI_Controller
	{
        public function __construct(){
		
			parent::__construct();
            
            $this->cr_acl->verify_acl();
        }
    }