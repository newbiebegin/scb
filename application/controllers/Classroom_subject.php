<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom_subject extends CR_Controller {
    
    private $_user_id;
    private $_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Classroom_subject_model');
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
            'js/pages/classroom_subject/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/classroom_subject/list';  
        $data['template']['title'] = 'Form Search Classroom Subject';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('classroom_subject');   
        
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
        
        $classroom_subjects = $this->Classroom_subject_model->get_datatables($input);
        $data = array();
       
        $no = $input['start'];
        foreach ($classroom_subjects as $classroom_subject) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $classroom_subject->school_year;
            $row[] = $classroom_subject->semester;
            $row[] = $classroom_subject->classroom;
            $row[] = $classroom_subject->subject_name;
            $row[] = $classroom_subject->teacher_name;
            $row[] = $classroom_subject->teacher_nip;
            $row[] = $this->_dropdown_active_status[$classroom_subject->is_active];
            $row[] = "<a href='".site_url('classroom_subject/edit/'.$classroom_subject->id)."'>Edit </a> | <a href='".site_url('classroom_subject/delete/'.$classroom_subject->id)."'> Delete</a>";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Classroom_subject_model->count_all(),
                        "recordsFiltered" => $this->Classroom_subject_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $id = NULL;
        $data['data'] = array(); 

        $classroom_subject = array(
            'id' => $id,
            'classroom_id' => $this->input->post('classroom'),
            'school_year_id' => $this->input->post('school_year'),
            'subject_teacher_id' => $this->input->post('subject_teacher'),
            'semester' => $this->input->post('semester'),
            'is_active' => $this->input->post('is_active'),
            'create_by' => $this->_user_id,
        );
        
        $data['template']['css'] = array();
        $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/classroom_subject/form';  
        $data['template']['title'] = 'Form Add Subject Teacher';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('classroom_subject/add');   
        $data['template']['form']['name'] = 'form_add';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   

        $data['template']['css'] = array();
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/classroom_subject/form-edit.js',
        );

        $this->config->load('form_validation/classroom_subject');
        $validation_rules = $this->config->item('classroom_subject/form');
        
        $this->form_validation->set_rules('subject_teacher', 'Subject', 'trim|required|max_length[11]|callback_is_unique_classroom_subject['.$id.'--Classroom--'.$classroom_subject['classroom_id'].'--School Year--'.$classroom_subject['school_year_id'].'--Semester--'.$classroom_subject['semester'].']');

        $this->form_validation->set_rules($validation_rules);     

        if($this->form_validation->run())
        {
            $classroom_subject_saved = $this->Classroom_subject_model->insert($classroom_subject);
			
			if($classroom_subject_saved > 0)
			{
                $this->session->set_flashdata('success_messages', 'Classroom subject data successfully saved');
                redirect("classroom_subject");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save classroom subject data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['classroom_subject'] = (object) array(
            'classroom_subject_id' => NULL,
            'classroom_id' => NULL,
            'classroom_name' => NULL,
            'school_year' => NULL,
            'school_year_id' => NULL,
            'semester' => NULL,
            'subject_teacher_id' => NULL,
            'subject_teacher_name' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['classroom_subject'] = $this->Classroom_subject_model->find_by_id($id);
        
        if(!isset($id) || !$data['data']['classroom_subject'])
        {
            $this->session->set_flashdata('error_messages', 'Student Classroom not found');				
            redirect("classroom_subject");
        }

        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/classroom_subject/form';  
        $data['template']['title'] = 'Form Edit Student Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('classroom_subject/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status; 

        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/classroom_subject/form-edit.js',
            'js/pages/bootstrap-autocomplete.js',
        );
        
        $classroom_subject = array(
            'id' => $id,
            'classroom_id' => $this->input->post('classroom'),
            'school_year_id' => $this->input->post('school_year'),
            'subject_teacher_id' => $this->input->post('subject_teacher'),
            'semester' => $this->input->post('semester'),
            'is_active' => $this->input->post('is_active'),
            'update_by' => $this->_user_id,
        );

        $this->config->load('form_validation/classroom_subject');
        $validation_rules = $this->config->item('classroom_subject/form');
        
        $this->form_validation->set_rules('subject_teacher', 'Subject', 'trim|required|max_length[11]|callback_is_unique_classroom_subject['.$id.'--Classroom--'.$classroom_subject['classroom_id'].'--School Year--'.$classroom_subject['school_year_id'].'--Semester--'.$classroom_subject['semester'].']');

        $this->form_validation->set_rules($validation_rules);  
       
		if($this->form_validation->run())
		{
            $classroom_subject_updated = $this->Classroom_subject_model->update($classroom_subject);
			
			if($classroom_subject_updated > 0)
			{
                $this->session->set_flashdata('success_messages', 'Classroom subject data has been successfully updated');
                redirect("classroom_subject");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save classroom subject data';
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
        $data['data']['classroom_subject'] = $this->Classroom_subject_model->find_by_id($id);

        if(!isset($id) || !$data['data']['classroom_subject'])
        {
            $this->session->set_flashdata('error_messages', 'Classroom subject not found');
		}
        else
        {
            $classroom_subject = array ('id' => $id);
            $classroom_subject_deleted = $this->Classroom_subject_model->delete($classroom_subject);
			
			if($classroom_subject_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Classroom Subject data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete classroom subject data');
            }
        }

        redirect("classroom_subject");
    }
   
    public function is_unique_classroom_subject($subject_teacher, $id)
    {
        $ids = explode('--', $id);
        $data['id'] = $ids[0];

        $data['classroom_id'] = $ids[2];
        $data['school_year_id'] = $ids[4];
        $data['semester'] = $ids[6];
        $data['subject_teacher_id'] = $subject_teacher;

        $is_unique = $this->Classroom_subject_model->is_unique_classroom_subject($data);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_classroom_subject', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }
}