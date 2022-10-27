<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CR_Controller {
    
    private $_user_id;
    private $_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Subject_model');
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
            'js/pages/subject/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/subject/list';  
        $data['template']['title'] = 'Form Search Subject';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('subject');   

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
        
        $subjects = $this->Subject_model->get_datatables($input);
        $data = array();
       

        $no = $input['start'];
        foreach ($subjects as $subject) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $subject->name;
            $row[] = $this->_dropdown_active_status[$subject->is_active];
            $row[] = "<a href='".site_url('subject/edit/'.$subject->id)."'>Edit </a> | <a href='".site_url('subject/delete/'.$subject->id)."'> Delete</a>";
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Subject_model->count_all(),
                        "recordsFiltered" => $this->Subject_model->count_filtered($input),
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
        $data['template']['content'] = 'admin/subject/form';  
        $data['template']['title'] = 'Form Add Subject';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('subject/add');   
        $data['template']['form']['name'] = 'form_add';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   
	
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]|callback_is_unique_name['.$id.']');
        
        if($this->form_validation->run() && $this->form_validation->run('subject'))
        {
            $subject = array(
                            'name' => $this->input->post('name'),
                            'is_active' => $this->input->post('is_active'),
                            'create_by' => $this->_user_id,
                        );

            $subject_saved = $this->Subject_model->insert($subject);
			
			if($subject_saved > 0)
			{
                $this->session->set_flashdata('success_messages', 'Subject data successfully saved');
                redirect("subject");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save subject data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['subject'] = (object) array(
            'name' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['subject'] = $this->Subject_model->find_by_id($id);

        if(!isset($id) || !$data['data']['subject'])
        {
            $this->session->set_flashdata('error_messages', 'Subject not found');				
            redirect("subject");
        }

        $data['template']['css'] = array();
        $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/subject/form';  
        $data['template']['title'] = 'Form Edit Subject';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('subject/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status; 

        // $this->form_validation->set_rules($this->Subject_model->rules());
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]|callback_is_unique_name['.$id.']');
       
		if($this->form_validation->run() && $this->form_validation->run('subject'))
		{
            $subject = array(
                            'id' => $id,
                            'name' => $this->input->post('name'),
                            'is_active' => $this->input->post('is_active'),
                            'update_by' => $this->_user_id,
                        );

            $subject_updated = $this->Subject_model->update($subject);
			
			if($subject_updated > 0)
			{
                $this->session->set_flashdata('success_messages', 'Subject data has been successfully updated');
                redirect("subject");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save subject data';
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
        $data['data']['subject'] = $this->Subject_model->find_by_id($id);

        if(!isset($id) || !$data['data']['subject'])
        {
            $this->session->set_flashdata('error_messages', 'Subject not found');
		}
        else
        {
            $subject = array ('id' => $id);
            $subject_deleted = $this->Subject_model->delete($subject);
			
			if($subject_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Subject data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete subject data');
            }
        }

        redirect("subject");
    }

    public function is_unique_name($name, $id)
    {
        $is_unique = $this->Subject_model->is_unique_name($name, $id);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_name', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }

    public function json_search()
    {
        $input= array();
        $input['keyword'] = $this->input->get('keyword');
        
        $subjects = array("results" => $this->Subject_model->search($input));
       
        $this->output->set_output(json_encode($subjects));
    }
}