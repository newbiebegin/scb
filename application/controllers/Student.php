<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CR_Controller {
    
    private $_user_id;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Student_model');
        $this->_user_id = $this->session->userdata('session_user_id');
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
            'js/pages/student/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student/list';  
        $data['template']['title'] = 'Form Search Student';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student');   

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
        
        $students = $this->Student_model->get_datatables($input);
        $data = array();
        $no = $input['start'];
        foreach ($students as $student) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $student->name;
            $row[] = $student->nis;
            $row[] = $student->birthplace;
            $row[] = $student->birth_date;
            $row[] = $student->religion;
            $row[] = $student->gender;
            $row[] = "<a href='".site_url('student/edit/'.$student->id)."'>Edit </a> | <a href='".site_url('student/delete/'.$student->id)."'> Delete</a>";
            // $row[] = $student->address;
            // $row[] = $student->student_guardian_id;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Student_model->count_all(),
                        "recordsFiltered" => $this->Student_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $id = NULL;
        $data['data'] = array(); 
        
        $data['template']['css'] = array(
            'extensions/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        );
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/student/form-edit-student.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student/add';  
        $data['template']['title'] = 'Form Add Student';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student/add');   
        $data['template']['form']['name'] = 'form_edit';   

        // $this->form_validation->set_rules($this->Student_model->rules($input));
		
		// if($this->form_validation->run())
		
        $this->form_validation->set_rules('nis', 'NIS', 'trim|required|max_length[50]|callback_is_unique_nis['.$id.']');
        
        $this->form_validation->set_rules('photo', 'Photo', 'trim|required|xss_clean|callback_is_file_uploaded_valid[photo]');
        
        if($this->form_validation->run() && $this->form_validation->run('student'))
        {
            $student = array(
                            'nis' => $this->input->post('nis'),
                            'name' => $this->input->post('name'),
                            'birthplace_id' => $this->input->post('birthplace'),
                            'birth_date' => $this->input->post('birth_date'),
                            'religion_id' => $this->input->post('religion'),
                            'gender' => $this->input->post('gender'),
                            'address' => $this->input->post('address'),
                            'student_guardian_id' => $this->input->post('student_guardian'),
                            'create_by' => $this->_user_id,
                        );

            $student_saved = $this->Student_model->insert($student);
			
			if($student_saved > 0)
			{
                $file_name = str_replace('.','',$student['nis']);
                $config['upload_path']          = './public/uploads/photos/students/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['file_name']            = $file_name;
                $config['overwrite']            = true;
                $config['max_size']             = 1024; // 1MB
                $config['max_width']            = 1080;
                $config['max_height']           = 1080;
                
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('photo'))
                {
                    $data['data']['errors'] = $this->upload->display_errors();
                }
                else
                {
                    // $uploaded_data = $this->upload->data();

                    $this->session->set_flashdata('success_messages', 'Student data successfully saved');
				
                    // redirect("student/add");
                    redirect("student");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save student data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['student'] = (object) array(
            'nis' => NULL,
            'name' => NULL,
            'birthplace_id' => NULL,
            'birthplace_name' => NULL,
            'birth_date' => NULL,
            'religion_id' => NULL,
            'religion_name' => NULL,
            'gender' => NULL,
            'address' => NULL,
            'student_guardian_id' => NULL,
            'student_guardian_name' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['student'] = $this->Student_model->find_by_id($id);

        if(!isset($id) || !$data['data']['student'])
        {
            $this->session->set_flashdata('error_messages', 'Student not found');
				
            redirect("student");
        }


        $data['template']['css'] = array(
            'extensions/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        );
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/student/form-edit-student.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student/edit';  
        $data['template']['title'] = 'Form Edit Student';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   

        // $this->form_validation->set_rules($this->Student_model->rules());
        $this->form_validation->set_rules('nis', 'NIS', 'trim|required|max_length[50]|callback_is_unique_nis['.$id.']');
        if (!empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean|callback_is_file_uploaded_valid[photo]');
        }

		if($this->form_validation->run() && $this->form_validation->run('student'))
		{
            $student = array(
                            'id' => $id,
                            'nis' => $this->input->post('nis'),
                            'name' => $this->input->post('name'),
                            'birthplace_id' => $this->input->post('birthplace'),
                            'birth_date' => $this->input->post('birth_date'),
                            'religion_id' => $this->input->post('religion'),
                            'gender' => $this->input->post('gender'),
                            'address' => $this->input->post('address'),
                            'student_guardian_id' => $this->input->post('student_guardian'),
                            'update_by' => $this->_user_id,
                        );

            $student_updated = $this->Student_model->update($student);
			
			if($student_updated > 0)
			{
                if (!empty($_FILES['photo']['name']))
                {
                    $file_name = str_replace('.','',$student['nis']);
                    $config['upload_path']          = './public/uploads/photos/students/';
                    $config['allowed_types']        = 'jpg|jpeg|png';
                    $config['file_name']            = $file_name;
                    $config['overwrite']            = true;
                    $config['max_size']             = 1024; // 1MB
                    $config['max_width']            = 1080;
                    $config['max_height']           = 1080;
                    
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('photo'))
                    {
                        $data['data']['errors'] = $this->upload->display_errors();
                    }
                    else
                    {
                        $this->session->set_flashdata('success_messages', 'Student data successfully saved');
                        redirect("student");
                    }
                }
                else
                {
                    $this->session->set_flashdata('success_messages', 'Student data successfully saved');
                    redirect("student");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save student data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

		$this->load->view('admin/main/template', $data);
    }

    public function delete($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['student'] = $this->Student_model->find_by_id($id);

        if(!isset($id) || !$data['data']['student'])
        {
            $this->session->set_flashdata('error_messages', 'Student not found');
		}
        else
        {
            $student = array ('id' => $id);
            $student_deleted = $this->Student_model->delete($student);
			
			if($student_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Student data successfully saved');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete student data');
            }
        }

        redirect("student");
    }

    public function is_unique_nis($nis, $id)
    {
        $is_unique = $this->Student_model->is_unique_nis($nis, $id);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_nis', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }

    public function is_file_uploaded_valid($file, $name)
    {
        if (!empty($_FILES[$name]['name']))
        {
            if(!file_exists($_FILES[$name]['tmp_name']) || !is_uploaded_file($_FILES[$name]['tmp_name']))
            {
                $this->form_validation->set_message('is_file_uploaded_valid', 'The %s field must uploaded file');
                return FALSE;
            }
        }

        return TRUE;
    }
    
    public function json_search()
    {
        $input= array();
        $input['keyword'] = $this->input->get('keyword');
        
        $students = array("results" => $this->Student_model->search($input));
       
        $this->output->set_output(json_encode($students));
    }
}