<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CR_Controller {
    
    private $_user_id;

    function __construct()
	{
		parent::__construct();
        $this->load->model('City_model');
        $this->_user_id = $this->session->userdata('session_user_id');
    }

    public function json_search()
    {
        $input= array();
        $input['name'] = $this->input->get('keyword');
        
        $cities = array("results" => $this->City_model->search($input));
        
        $this->output->set_output(json_encode($cities));
    }
}