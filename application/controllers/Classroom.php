<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom extends CR_Controller {
    
    private $_user_id;
    private $_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Classroom_model');
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
            'js/pages/classroom/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/classroom/list';  
        $data['template']['title'] = 'Form Search Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('classroom');   
        
        // $data_template['data']['classroom'] = (object) array('is_active' => '');
        // $data_template['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   
        // $data_template['method'] = NULL;//$this->input->method();
        // $data['template']['datatable'] = $this->load->view('admin/classroom/dropdown_active_status', $data_template, TRUE);


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
        
        $classrooms = $this->Classroom_model->get_datatables($input);
        $data = array();
       
        // $data_template['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   
        // $data_template['method'] = NULL;//$this->input->method();

        $no = $input['start'];
        foreach ($classrooms as $classroom) {
            $no++;
            $row = array();
            // $data_template['data']['classroom'] = (object) array('is_active' => $classroom->is_active);
            $row[] = $no;
            // $row[] = '<div contenteditable="" class="update" data-id="'.$classroom->id.'" data-column="classroom">'.$classroom->classroom.'</div>';
            $row[] = $classroom->classroom;
            $row[] = $classroom->grade;
            // $row[] = $this->load->view('admin/classroom/dropdown_active_status', $data_template, TRUE);
            $row[] = $this->_dropdown_active_status[$classroom->is_active];
            $row[] = "<a href='".site_url('classroom/edit/'.$classroom->id)."'>Edit </a> | <a href='".site_url('classroom/delete/'.$classroom->id)."'> Delete</a>";
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Classroom_model->count_all(),
                        "recordsFiltered" => $this->Classroom_model->count_filtered($input),
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
        $data['template']['content'] = 'admin/classroom/form';  
        $data['template']['title'] = 'Form Add Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('classroom/add');   
        $data['template']['form']['name'] = 'form_add';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status;   

        // $data['template']['form']['classroom_detail']['add']['action'] = base_url('classroom_detail/add');   
        // $data['template']['form']['classroom_detail']['add']['name'] = 'form_add';   
        // $data['template']['form']['classroom_detail']['add']['dropdown_active_status'] = $this->_dropdown_active_status;   

        // $data['template']['form']['classroom_detail']['edit']['action'] = base_url('classroom_detail/edit');   
        // $data['template']['form']['classroom_detail']['edit']['name'] = 'form_edit';   
        // $data['template']['form']['classroom_detail']['edit']['dropdown_active_status'] = $this->_dropdown_active_status;   
	
        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/classroom/form-edit.js',
            // 'js/pages/classroom_detail/datatable.js',
            // 'js/pages/bootstrap-autocomplete.js',
            // 'js/pages/classroom_detail/form-edit.js',
        );

        $this->config->load('form_validation/classroom');
        $validation_rules = $this->config->item('classroom/form');
        $this->form_validation->set_rules($validation_rules);     

        $this->form_validation->set_rules('classroom', 'Classroom', 'trim|required|max_length[100]|callback_is_unique_classroom['.$id.']');
        
        if($this->form_validation->run() /*&& $this->form_validation->run('classroom')*/)
        {
            $classroom = array(
                            'classroom' => $this->input->post('classroom'),
                            'grade' => $this->input->post('grade'),
                            'is_active' => $this->input->post('is_active'),
                            'create_by' => $this->_user_id,
                        );

            $classroom_saved = $this->Classroom_model->insert($classroom);
			
			if($classroom_saved > 0)
			{
                $this->session->set_userdata('previous_url', uri_string());
                $this->session->set_flashdata('success_messages', 'Classroom data successfully saved');
                redirect("classroom/edit/".+$classroom_saved);
            }
            else
            {
                $data['data']['errors'] = 'Failed to save classroom data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['classroom'] = (object) array(
            'classroom_id' => NULL,
            'classroom' => NULL,
            'grade' => NULL,
            'is_active' => NULL,
        );
        
        $data['data']['classroom_detail'] = (object) array(
            'classroom_id' => NULL,
            'classroom_name' => NULL,
            'school_year' => NULL,
            'school_year_id' => NULL,
            'homeroom_teacher_id' => NULL,
            'homeroom_teacher_name' => NULL,
            'homeroom_teacher_name_nip' => NULL,
            'head_class_id' => NULL,
            'head_class_name' => NULL,
            'head_class_name_nis' => NULL,
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

        if($previous_url == 'classroom/add')
        {
            $data['template']['form']['redirect_tab_detail'] = TRUE;
        }

        $data['data'] = array(); 
        $data['data']['classroom'] = $this->Classroom_model->find_by_id($id);
        
        if(!isset($id) || !$data['data']['classroom'])
        {
            $this->session->set_flashdata('error_messages', 'Classroom not found');				
            redirect("classroom");
        }

        // $data['template']['css'] = array();
        // $data['template']['js'] = array();
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/classroom/form';  
        $data['template']['title'] = 'Form Edit Classroom';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('classroom/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   
        $data['template']['form']['dropdown_active_status'] = $this->_dropdown_active_status; 

        $data['template']['form']['classroom_detail']['add']['action'] = base_url('classroom_detail/add');   
        $data['template']['form']['classroom_detail']['add']['name'] = 'form_add';   
        $data['template']['form']['classroom_detail']['add']['dropdown_active_status'] = $this->_dropdown_active_status;   

        $data['template']['form']['classroom_detail']['edit']['action'] = base_url('classroom_detail/edit');   
        $data['template']['form']['classroom_detail']['edit']['name'] = 'form_edit';   
        $data['template']['form']['classroom_detail']['edit']['dropdown_active_status'] = $this->_dropdown_active_status;   
	
        $data['template']['css'] = array(
            'extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'css/pages/datatables.css',
            
        );
        $data['template']['js'] = array(
            'js/extensions/datatables.min.js',
            'js/pages/classroom/form-edit.js',
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/classroom_detail/form-edit.js',
            'js/pages/classroom_detail/datatable.js',
            'js/extensions/dataTables.buttons.min.js',
        );

        $this->config->load('form_validation/classroom');
        $validation_rules = $this->config->item('classroom/form');
        $this->form_validation->set_rules($validation_rules);     

        $this->form_validation->set_rules('classroom', 'Classroom', 'trim|required|max_length[100]|callback_is_unique_classroom['.$id.']');
       
		if($this->form_validation->run())
		{
            $classroom = array(
                            'id' => $id,
                            'classroom' => $this->input->post('classroom'),
                            'grade' => $this->input->post('grade'),
                            'is_active' => $this->input->post('is_active'),
                            'update_by' => $this->_user_id,
                        );

            $classroom_updated = $this->Classroom_model->update($classroom);
			
			if($classroom_updated > 0)
			{
                $this->session->set_flashdata('success_messages', 'Classroom data has been successfully updated');
                redirect("classroom");
            }
            else
            {
                $data['data']['errors'] = 'Failed to save classroom data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }
           
        $data['data']['classroom_detail'] = (object) array(
            'classroom_id' => NULL,
            'classroom_name' => NULL,
            'school_year' => NULL,
            'school_year_id' => NULL,
            'homeroom_teacher_id' => NULL,
            'homeroom_teacher_name' => NULL,
            'homeroom_teacher_name_nip' => NULL,
            'head_class_id' => NULL,
            'head_class_name' => NULL,
            'head_class_name_nis' => NULL,
            'is_active' => NULL,
        );
        
        $data['method'] = $this->input->method();
		$this->load->view('admin/main/template', $data);
    }

    public function delete($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['classroom'] = $this->Classroom_model->find_by_id($id);

        if(!isset($id) || !$data['data']['classroom'])
        {
            $this->session->set_flashdata('error_messages', 'Classroom not found');
		}
        else
        {
            $classroom = array ('id' => $id);
            $classroom_deleted = $this->Classroom_model->delete($classroom);
			
			if($classroom_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Classroom data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete classroom data');
            }
        }

        redirect("classroom");
    }

    public function is_unique_classroom($classroom, $id)
    {
        $is_unique = $this->Classroom_model->is_unique_classroom($classroom, $id);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_classroom', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }

    public function json_search()
    {
        $input= array();
        $input['classroom'] = $this->input->get('keyword');
        
        $classrooms = array("results" => $this->Classroom_model->search($input));
       
        $this->output->set_output(json_encode($classrooms));
    }
}