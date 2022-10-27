<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_year extends CR_Controller {
    
    private $_user_id;
    private $_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('School_year_model');
        $this->_user_id = $this->session->userdata('session_user_id');
        $this->_dropdown_active_status = cr_dropdown_active_status();
    }

    public function index()
	{
        $data['data'] = array(); 
        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/school_year/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/school_year/list';  
        $data['template']['title'] = 'Form Search School Year';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('school_year');   

        $this->load->view('admin/main/template', $data);
    }

    public function ajax_list()
    {
        $input = array();

        if( $this->input->post('search'))
        {
            $input['search'] = $this->input->post('search');
        }
        
        if( $this->input->post('order'))
        {
            $input['order'] = $this->input->post('order');
        }
        
        if( $this->input->post('length'))
        {
            $input['length'] = $this->input->post('length');
        }
        
        $input['start'] = $this->input->post('start');
        
        $school_years = $this->School_year_model->get_datatables($input);
        $data = array();
       

        $no = $input['start'];
        foreach ($school_years as $school_year) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $school_year->school_year;
            $row[] = $this->_dropdown_active_status[$school_year->is_active];
            $row[] = "<a href='".site_url('school_year/edit/'.$school_year->id)."'>Edit </a> | <a href='".site_url('school_year/delete/'.$school_year->id)."'> Delete</a>";
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->School_year_model->count_all(),
                        "recordsFiltered" => $this->School_year_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $id = NULL;
        $data['data'] = array(); 
        
        $data['template']['css'] = array();
        $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/school_year/form';  
        $data['template']['title'] = 'Form Add School Year';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('school_year/add');   
        $data['template']['form']['name'] = 'form_add';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   
	
        $this->form_validation->set_rules('school_year', 'School Year', 'trim|required|max_length[20]|callback_is_unique_school_year['.$id.']');
        
        if($this->form_validation->run() && $this->form_validation->run('school_year'))
        {
            $school_year = array(
                            'school_year' => $this->input->post('school_year'),
                            'is_active' => $this->input->post('is_active'),
                            'create_by' => $this->_user_id,
                        );

            $school_year_saved = $this->School_year_model->insert($school_year);
			
			if($school_year_saved > 0)
			{
                $this->session->set_flashdata('success_messages', 'School year data successfully saved');
                redirect("school_year");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save school year data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['school_year'] = (object) array(
            'school_year' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['school_year'] = $this->School_year_model->find_by_id($id);

        if(!isset($id) || !$data['data']['school_year'])
        {
            $this->session->set_flashdata('error_messages', 'School_year not found');				
            redirect("school_year");
        }

        $data['template']['css'] = array();
        $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/school_year/form';  
        $data['template']['title'] = 'Form Edit School Year';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('school_year/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status; 

        $this->form_validation->set_rules('school_year', 'School Year', 'trim|required|max_length[20]|callback_is_unique_school_year['.$id.']');
       
		if($this->form_validation->run() && $this->form_validation->run('school_year'))
		{
            $school_year = array(
                            'id' => $id,
                            'school_year' => $this->input->post('school_year'),
                            'is_active' => $this->input->post('is_active'),
                            'update_by' => $this->_user_id,
                        );

            $school_year_updated = $this->School_year_model->update($school_year);
			
			if($school_year_updated > 0)
			{
                $this->session->set_flashdata('success_messages', 'School year data has been successfully updated');
                redirect("school_year");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save school year data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }
        $data['method'] = $this->input->method();
		$this->load->view('admin/main/template', $data);
    }

    public function delete($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['school_year'] = $this->School_year_model->find_by_id($id);

        if(!isset($id) || !$data['data']['school_year'])
        {
            $this->session->set_flashdata('error_messages', 'School year not found');
		}
        else
        {
            $school_year = array ('id' => $id);
            $school_year_deleted = $this->School_year_model->delete($school_year);
			
			if($school_year_deleted)
			{
                $this->session->set_flashdata('success_messages', 'School year data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete school year data');
            }
        }

        redirect("school_year");
    }

    public function is_unique_school_year($school_year, $id)
    {
        $is_unique = $this->School_year_model->is_unique_school_year($school_year, $id);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_school_year', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }

    public function json_search()
    {
        $input= array();
        $input['school_year'] = $this->input->get('keyword');
        
        $school_years = array("results" => $this->School_year_model->search($input));
       
        $this->output->set_output(json_encode($school_years));
    }
}