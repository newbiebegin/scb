<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_classroom extends CR_Controller {
    
    private $_user_id;
    private $_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Student_classroom_model');
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
            'js/pages/student_classroom/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student_classroom/list';  
        $data['template']['title'] = 'Form Search Student Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student_classroom');   
        
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
        
        $student_classrooms = $this->Student_classroom_model->get_datatables($input);
        $data = array();
       
        $no = $input['start'];
        foreach ($student_classrooms as $student_classroom) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $student_classroom->classroom_name;
            $row[] = $student_classroom->school_year;
            $row[] = $student_classroom->student_name;;
            $row[] = $this->_dropdown_active_status[$student_classroom->is_active];
            $row[] = "<a href='".site_url('student_classroom/edit/'.$student_classroom->id)."'>Edit </a> | <a href='".site_url('student_classroom/delete/'.$student_classroom->id)."'> Delete</a>";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Student_classroom_model->count_all(),
                        "recordsFiltered" => $this->Student_classroom_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $id = NULL;
        $data['data'] = array(); 

        $student_classroom = array(
            'id' => $id,
            'classroom_id' => $this->input->post('classroom'),
            'school_year_id' => $this->input->post('school_year'),
            'student_id' => $this->input->post('student'),
            'is_active' => $this->input->post('is_active'),
            'create_by' => $this->_user_id,
        );
        
        $data['template']['css'] = array();
        $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student_classroom/form';  
        $data['template']['title'] = 'Form Add Student_classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student_classroom/add');   
        $data['template']['form']['name'] = 'form_add';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   

        $data['template']['css'] = array();
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/student_classroom/form-edit.js',
        );

        $this->config->load('form_validation/student_classroom');
        $validation_rules = $this->config->item('student_classroom/form');
        
        $this->form_validation->set_rules('classroom', 'Classroom', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('school_year', 'School Year', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules('student', 'Student', 'trim|required|max_length[11]|callback_is_unique_student_classroom['.$id.'--Classroom--'.$student_classroom['classroom_id'].'--School Year--'.$student_classroom['school_year_id'].']');

        $this->form_validation->set_rules($validation_rules);     

        if($this->form_validation->run())
        {
            $student_classroom_saved = $this->Student_classroom_model->insert($student_classroom);
			
			if($student_classroom_saved > 0)
			{
                $this->session->set_flashdata('success_messages', 'Student classroom data successfully saved');
                redirect("student_classroom");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save student_classroom data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['student_classroom'] = (object) array(
            'student_classroom_id' => NULL,
            'classroom_id' => NULL,
            'classroom_name' => NULL,
            'school_year' => NULL,
            'school_year_id' => NULL,
            'student_name' => NULL,
            'student_name_nis' => NULL,
            'student_id' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['student_classroom'] = $this->Student_classroom_model->find_by_id($id);
        
        if(!isset($id) || !$data['data']['student_classroom'])
        {
            $this->session->set_flashdata('error_messages', 'Student Classroom not found');				
            redirect("student_classroom");
        }

        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student_classroom/form';  
        $data['template']['title'] = 'Form Edit Student Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student_classroom/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status; 

        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/student_classroom/form-edit.js',
            'js/pages/bootstrap-autocomplete.js',
        );
        
        $student_classroom = array(
            'id' => $id,
            'classroom_id' => $this->input->post('classroom'),
            'school_year_id' => $this->input->post('school_year'),
            'student_id' => $this->input->post('student'),
            'is_active' => $this->input->post('is_active'),
            'update_by' => $this->_user_id,
        );

        $this->config->load('form_validation/student_classroom');
        $validation_rules = $this->config->item('student_classroom/form');
        
        $this->form_validation->set_rules('classroom', 'Classroom', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('school_year', 'School Year', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules('student', 'Student', 'trim|required|max_length[11]|callback_is_unique_student_classroom['.$id.'--Classroom--'.$student_classroom['classroom_id'].'--School Year--'.$student_classroom['school_year_id'].']');

        $this->form_validation->set_rules($validation_rules);  
       
		if($this->form_validation->run())
		{
            $student_classroom_updated = $this->Student_classroom_model->update($student_classroom);
			
			if($student_classroom_updated > 0)
			{
                $this->session->set_flashdata('success_messages', 'Student Classroom data has been successfully updated');
                redirect("student_classroom");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save student classroom data';
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
        $data['data']['student_classroom'] = $this->Student_classroom_model->find_by_id($id);

        if(!isset($id) || !$data['data']['student_classroom'])
        {
            $this->session->set_flashdata('error_messages', 'Student classroom not found');
		}
        else
        {
            $student_classroom = array ('id' => $id);
            $student_classroom_deleted = $this->Student_classroom_model->delete($student_classroom);
			
			if($student_classroom_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Student classroom data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete student classroom data');
            }
        }

        redirect("student_classroom");
    }
    
    public function is_unique_student_classroom($student, $id)
    {
        $ids = explode('--', $id);
        $data['id'] = $ids[0];

        $data['classroom_id'] = $ids[2];
        $data['school_year_id'] = $ids[4];
        $data['student_id'] = $student;

        $is_unique = $this->Student_classroom_model->is_unique_student_classroom($data);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_student_classroom', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }
}