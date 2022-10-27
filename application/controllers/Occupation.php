<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Occupation extends CR_Controller {
    
    private $_user_id;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Occupation_model');
        $this->_user_id = $this->session->userdata('session_user_id');
    }

    public function json_search()
    {
        $input= array();
        $input['name'] = $this->input->get('keyword');
        
        $occupations = array("results" => $this->Occupation_model->search($input));
       
        $this->output->set_output(json_encode($occupations));
    }
}