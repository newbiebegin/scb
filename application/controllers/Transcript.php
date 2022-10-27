<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transcript extends CR_Controller/*CI_Controller*/ {
    
    private $_user_id;
    private $_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Transcript_model');
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
            'js/pages/transcript/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/transcript/list';  
        $data['template']['title'] = 'Form Search Transcript';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('transcript');   
        
        $this->load->view('admin/main/template', $data);
    }

    public function ajax_list()
    {
        $input = array();
        
        if( $this->input->post('search_name'))
        {
            $input['name'] = $this->input->post('search_name');
        }
        
        if( $this->input->post('search_nis'))
        {
            $input['nis'] = $this->input->post('search_nis');
        }

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
        $input['sql_type'] = 'ajax_list';
        
        $transcripts = $this->Transcript_model->get_datatables($input);
        $data = array();
       
        $no = $input['start'];
        foreach ($transcripts as $transcript) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $transcript->classroom_name;
            $row[] = $transcript->school_year;
            $row[] = $transcript->semester;
            $row[] = $transcript->student_name;
            $row[] = $transcript->total_score;
            $row[] = $transcript->average_score;
            $row[] = $this->_dropdown_active_status[$transcript->is_active];
            $row[] = "<a href='".site_url('transcript/edit/'.$transcript->id)."'>Edit </a> | <a href='".site_url('transcript/delete/'.$transcript->id)."'> Delete</a>";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Transcript_model->count_all(),
                        "recordsFiltered" => $this->Transcript_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function ajax_student_transcript()
    {
        $input = array();
        
        if( $this->input->post('search_name'))
        {
            $input['name'] = $this->input->post('search_name');
        }
        
        if( $this->input->post('search_nis'))
        {
            $input['nis'] = $this->input->post('search_nis');
        }
        
        if( $this->input->post('search_classroom'))
        {
            $input['classroom'] = $this->input->post('search_classroom');
        }
        
        if( $this->input->post('search_school_year'))
        {
            $input['school_year'] = $this->input->post('search_school_year');
        }
        
        if( $this->input->post('search_semester'))
        {
            $input['semester'] = $this->input->post('search_semester');
        }

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
        $input['sql_type'] = 'ajax_student_transcript';

        $transcripts = $this->Transcript_model->get_datatables($input);
        $data = array();
       
        $no = $input['start'];
        foreach ($transcripts as $transcript) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $transcript->classroom_name;
            $row[] = $transcript->school_year;
            $row[] = $transcript->semester;
            $row[] = $transcript->student_name;
            $row[] = $transcript->subject_name;
            $row[] = $transcript->teacher_name;
            $row[] = $transcript->score;
            $row[] = $this->_dropdown_active_status[$transcript->is_active];
            $row[] = "<a href='".site_url('transcript/edit/'.$transcript->id)."'>Edit </a> | <a href='".site_url('transcript/delete/'.$transcript->id)."'> Delete</a>";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Transcript_model->count_all(),
                        "recordsFiltered" => $this->Transcript_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $id = NULL;
        $data['data'] = array(); 

        $transcript = array(
            'id' => $id,
            'classroom_id' => $this->input->post('classroom'),
            'school_year_id' => $this->input->post('school_year'),
            'semester' => $this->input->post('semester'),
            'student_id' => $this->input->post('student'),
            'is_active' => $this->input->post('is_active'),
            'create_by' => $this->_user_id,
        );
        
        $data['template']['css'] = array();
        $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/transcript/form';  
        $data['template']['title'] = 'Form Add Transcript';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('transcript/add');   
        $data['template']['form']['name'] = 'form_add';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   

        $data['template']['css'] = array();
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/transcript/form-edit.js',
        );

        $this->config->load('form_validation/transcript');
        $validation_rules = $this->config->item('transcript/form');
        
        $this->form_validation->set_rules('classroom', 'Classroom', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('school_year', 'School Year', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules('student', 'Student', 'trim|required|max_length[11]|callback_is_unique_transcript_student['.$id.'--Classroom--'.$transcript['classroom_id'].'--School Year--'.$transcript['school_year_id'].'--Semester--'.$transcript['semester'].']');

        $this->form_validation->set_rules($validation_rules);     

        if($this->form_validation->run())
        {
            $transcript_saved = $this->Transcript_model->insert($transcript);
			
			if($transcript_saved > 0)
			{
                $this->session->set_userdata('previous_url', uri_string());
                $this->session->set_flashdata('success_messages', 'Transcript data successfully saved');
                redirect("transcript/edit/".+$transcript_saved);
            }
            else
            {
                $data['data']['errors'] = 'Failed to save transcript data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['transcript'] = (object) array(
            'transcript_id' => NULL,
            'classroom_id' => NULL,
            'classroom_name' => NULL,
            'school_year' => NULL,
            'school_year_id' => NULL,
            'student_name' => NULL,
            'student_name_nis' => NULL,
            'student_id' => NULL,
            'semester' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
  
        $previous_url = $this->session->userdata('previous_url');
        $this->session->unset_userdata('previous_url');

        $data['template']['form']['redirect_tab_detail'] = FALSE;

        if($previous_url == 'transcript/add')
        {
            $data['template']['form']['redirect_tab_detail'] = TRUE;
        }

        $data['data'] = array(); 
        $data['data']['transcript'] = $this->Transcript_model->find_by_id($id);
        
        if(!isset($id) || !$data['data']['transcript'])
        {
            $this->session->set_flashdata('error_messages', 'Transcript not found');				
            redirect("transcript");
        }

        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/transcript/form';  
        $data['template']['title'] = 'Form Edit Transcript';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('transcript/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status; 

        $data['template']['form']['transcript_detail']['add']['action'] = base_url('transcript_detail/add');   
        $data['template']['form']['transcript_detail']['add']['name'] = 'form_add';   
        $data['template']['form']['transcript_detail']['add']['dropdown_active_status'] = $this->_dropdown_active_status;   

        // $data['template']['form']['transcript_detail']['edit']['action'] = base_url('transcript_detail/edit');   
        // $data['template']['form']['transcript_detail']['edit']['name'] = 'form_edit';   
        // $data['template']['form']['transcript_detail']['edit']['dropdown_active_status'] = $this->_dropdown_active_status;   
	
        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/transcript/form-edit.js',
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/transcript_detail/form-edit.js',
            'js/pages/transcript_detail/datatable.js',
            'js/extensions/dataTables.buttons.min.js',
        );
        
        $transcript = array(
            'id' => $id,
            'classroom_id' => $this->input->post('classroom'),
            'school_year_id' => $this->input->post('school_year'),
            'semester' => $this->input->post('semester'),
            'student_id' => $this->input->post('student'),
            'is_active' => $this->input->post('is_active'),
            'update_by' => $this->_user_id,
        );

        $this->config->load('form_validation/transcript');
        $validation_rules = $this->config->item('transcript/form');
        
        $this->form_validation->set_rules('classroom', 'Classroom', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('school_year', 'School Year', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules('student', 'Student', 'trim|required|max_length[11]|callback_is_unique_transcript_student['.$id.'--Classroom--'.$transcript['classroom_id'].'--School Year--'.$transcript['school_year_id'].'--Semester--'.$transcript['semester'].']');

        $this->form_validation->set_rules($validation_rules);  
       
		if($this->form_validation->run())
		{
            $transcript_updated = $this->Transcript_model->update($transcript);
			
			if($transcript_updated > 0)
			{
                $this->session->set_flashdata('success_messages', 'Transcript data has been successfully updated');
                redirect("transcript");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save transcript data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }
           
        $data['data']['transcript_detail'] = (object) array(
            'subject_teacher_id' => NULL,
            'subject_teacher_name' => NULL,
            'score' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();
		$this->load->view('admin/main/template', $data);
    }

    public function delete($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['transcript'] = $this->Transcript_model->find_by_id($id);

        if(!isset($id) || !$data['data']['transcript'])
        {
            $this->session->set_flashdata('error_messages', 'Transcript not found');
		}
        else
        {
            $transcript = array ('id' => $id);
            $transcript_deleted = $this->Transcript_model->delete($transcript);
			
			if($transcript_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Transcript data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete transcript data');
            }
        }

        redirect("transcript");
    }
    
    public function is_unique_transcript_student($student, $id)
    {
        $ids = explode('--', $id);
        $data['id'] = $ids[0];

        $data['classroom_id'] = $ids[2];
        $data['school_year_id'] = $ids[4];
        $data['semester'] = $ids[6];
        $data['student_id'] = $student;

        $is_unique = $this->Transcript_model->is_unique_transcript_student($data);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_transcript_student', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }

    public function json_search()
    {
        $input= array();
        $input['transcript'] = $this->input->get('keyword');
        
        $transcripts = array("results" => $this->Transcript_model->search($input));
       
        $this->output->set_output(json_encode($transcripts));
    }

    public function student_transcript_report()
    {
        
        $data['data'] = array(); 
        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/transcript/datatable_student_transcript.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/transcript/report/student_transcript';  
        $data['template']['title'] = 'Student Transcript Report';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('transcript').'/student_transcript_report';   
        
        $this->load->view('admin/main/template', $data);
    }
}