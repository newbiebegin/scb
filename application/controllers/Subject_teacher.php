<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_teacher extends CR_Controller {
    
    private $_user_id;
    private $_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Subject_teacher_model');
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
            'js/pages/subject_teacher/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/subject_teacher/list';  
        $data['template']['title'] = 'Form Search Student Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('subject_teacher');   
        
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
        
        $subject_teachers = $this->Subject_teacher_model->get_datatables($input);
        $data = array();
       
        $no = $input['start'];
        foreach ($subject_teachers as $subject_teacher) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $subject_teacher->teacher_name;
            $row[] = $subject_teacher->teacher_nip;
            $row[] = $subject_teacher->subject_name;
            $row[] = $this->_dropdown_active_status[$subject_teacher->is_active];
            $row[] = "<a href='".site_url('subject_teacher/edit/'.$subject_teacher->id)."'>Edit </a> | <a href='".site_url('subject_teacher/delete/'.$subject_teacher->id)."'> Delete</a>";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Subject_teacher_model->count_all(),
                        "recordsFiltered" => $this->Subject_teacher_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $id = NULL;
        $data['data'] = array(); 

        $subject_teacher = array(
            'id' => $id,
            'teacher_id' => $this->input->post('teacher'),
            'subject_id' => $this->input->post('subject'),
            'is_active' => $this->input->post('is_active'),
            'create_by' => $this->_user_id,
        );
        
        $data['template']['css'] = array();
        $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/subject_teacher/form';  
        $data['template']['title'] = 'Form Add Subject Teacher';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('subject_teacher/add');   
        $data['template']['form']['name'] = 'form_add';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   

        $data['template']['css'] = array();
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/subject_teacher/form-edit.js',
        );

        $this->config->load('form_validation/subject_teacher');
        $validation_rules = $this->config->item('subject_teacher/form');
        
        $this->form_validation->set_rules('teacher', 'Teacher', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_length[11]|callback_is_unique_subject_teacher['.$id.'--Teacher--'.$subject_teacher['teacher_id'].']');

        $this->form_validation->set_rules($validation_rules);     

        if($this->form_validation->run())
        {
            $subject_teacher_saved = $this->Subject_teacher_model->insert($subject_teacher);
			
			if($subject_teacher_saved > 0)
			{
                $this->session->set_flashdata('success_messages', 'Subject teacher data successfully saved');
                redirect("subject_teacher");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save subject teacher data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['subject_teacher'] = (object) array(
            'subject_teacher_id' => NULL,
            'teacher_id' => NULL,
            'teacher_name' => NULL,
            'teacher_nip' => NULL,
            'teacher_name_nip' => NULL,
            'subject_id' => NULL,
            'subject_name' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['subject_teacher'] = $this->Subject_teacher_model->find_by_id($id);
        
        if(!isset($id) || !$data['data']['subject_teacher'])
        {
            $this->session->set_flashdata('error_messages', 'Student Classroom not found');				
            redirect("subject_teacher");
        }

        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/subject_teacher/form';  
        $data['template']['title'] = 'Form Edit Student Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('subject_teacher/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status; 

        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/subject_teacher/form-edit.js',
            'js/pages/bootstrap-autocomplete.js',
        );
        
        $subject_teacher = array(
            'id' => $id,
            'teacher_id' => $this->input->post('teacher'),
            'subject_id' => $this->input->post('subject'),
            'is_active' => $this->input->post('is_active'),
            'update_by' => $this->_user_id,
        );

        $this->config->load('form_validation/subject_teacher');
        $validation_rules = $this->config->item('subject_teacher/form');
        
        $this->form_validation->set_rules('teacher', 'Teacher', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_length[11]|callback_is_unique_subject_teacher['.$id.'--Teacher--'.$subject_teacher['teacher_id'].']');

        $this->form_validation->set_rules($validation_rules);  
       
		if($this->form_validation->run())
		{
            $subject_teacher_updated = $this->Subject_teacher_model->update($subject_teacher);
			
			if($subject_teacher_updated > 0)
			{
                $this->session->set_flashdata('success_messages', 'Subject teacher data has been successfully updated');
                redirect("subject_teacher");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save subject teacher data';
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
        $data['data']['subject_teacher'] = $this->Subject_teacher_model->find_by_id($id);

        if(!isset($id) || !$data['data']['subject_teacher'])
        {
            $this->session->set_flashdata('error_messages', 'Subject teacher not found');
		}
        else
        {
            $subject_teacher = array ('id' => $id);
            $subject_teacher_deleted = $this->Subject_teacher_model->delete($subject_teacher);
			
			if($subject_teacher_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Subject teacher data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete subject teacher data');
            }
        }

        redirect("subject_teacher");
    }
    
    public function is_unique_subject_teacher($subject, $id)
    {
        $ids = explode('--', $id);
        $data['id'] = $ids[0];

        $data['teacher_id'] = $ids[2];
        $data['subject_id'] = $subject;

        $is_unique = $this->Subject_teacher_model->is_unique_subject_teacher($data);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_subject_teacher', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }

    public function json_search()
    {
        $input= array();
        $input['keyword'] = $this->input->get('keyword');
        
        $subject_teachers = array("results" => $this->Subject_teacher_model->search($input));
       
        $this->output->set_output(json_encode($subject_teachers));
    }
}