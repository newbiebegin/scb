<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_guardian extends CR_Controller {
    
    private $_user_id;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Student_guardian_model');
        $this->_user_id = $this->session->userdata('session_user_id');
    }

    public function json_search()
    {
        $input= array();
        $input['student_guardian_name'] = $this->input->get('keyword');
        
        $student_guardians = array("results" => $this->Student_guardian_model->search($input));
       
        $this->output->set_output(json_encode($student_guardians));
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
            'js/pages/student_guardian/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student_guardian/list';  
        $data['template']['title'] = 'Form Search Student Guardian';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student_guardian');   

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
        
        $student_guardians = $this->Student_guardian_model->get_datatables($input);
        $data = array();
        $no = $input['start'];
        foreach ($student_guardians as $student_guardian) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $student_guardian->student_guardian_name;
            $row[] = $student_guardian->code;
            // $row[] = $student_guardian->student_guardian_occupation;
            $row[] = $student_guardian->student_guardian_religion;
            $row[] = $student_guardian->student_guardian_phone_number;
            $row[] = "<a href='".site_url('student_guardian/edit/'.$student_guardian->id)."'>Edit </a> | <a href='".site_url('student_guardian/delete/'.$student_guardian->id)."'> Delete</a>";
            // $row[] = $student_guardian->address;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Student_guardian_model->count_all(),
                        "recordsFiltered" => $this->Student_guardian_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $id = NULL;
        $data['data'] = array(); 
        
        $data['template']['css'] = array(
            // 'extensions/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        );
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/student_guardian/form-edit-student-guardian.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student_guardian/add';  
        $data['template']['title'] = 'Form Add Student Guardian';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student_guardian/add');   
        $data['template']['form']['name'] = 'form_edit';   
	
        $this->form_validation->set_rules('code', 'Code', 'trim|required|max_length[50]|callback_is_unique_code['.$id.']');
        
        if (empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|required|xss_clean|callback_is_file_uploaded_valid[photo]');
        }
        else
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean|callback_is_file_uploaded_valid[photo]');
        }

        if($this->form_validation->run() && $this->form_validation->run('student_guardian'))
        {
            $student_guardian = array(
                'code' => $this->input->post('code'),
                'father_name' => $this->input->post('father_name'),
                'father_occupation_id' => $this->input->post('father_occupation'),
                'father_religion_id' => $this->input->post('father_religion'),
                'father_address' => $this->input->post('father_address'),
                'father_phone_number' => $this->input->post('father_phone_number'),
                'mother_name' => $this->input->post('mother_name'),
                'mother_occupation_id' => $this->input->post('mother_occupation'),
                'mother_religion_id' => $this->input->post('mother_religion'),
                'mother_address' => $this->input->post('mother_address'),
                'mother_phone_number' => $this->input->post('mother_phone_number'),
                'student_guardian_name' => $this->input->post('student_guardian_name'),
                'student_guardian_occupation_id' => $this->input->post('student_guardian_occupation'),
                'student_guardian_religion_id' => $this->input->post('student_guardian_religion'),
                'student_guardian_address' => $this->input->post('student_guardian_address'),
                'student_guardian_phone_number' => $this->input->post('student_guardian_phone_number'),
                
                'create_by' => $this->_user_id,
            );

            $student_guardian_saved = $this->Student_guardian_model->insert($student_guardian);
			
			if($student_guardian_saved > 0)
			{
                $file_name = str_replace('.','',$student_guardian['code']);
                $config['upload_path']          = './public/uploads/photos/student_guardians/';
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
                    $this->session->set_flashdata('success_messages', 'Student Guardian data successfully saved');
				    redirect("student_guardian");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save student guardian data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['student_guardian'] = (object) array(
            'code' => NULL,
            'father_name' => NULL,
            'father_occupation_id' => NULL,
            'father_occupation_name' => NULL,
            'father_religion_id' => NULL,
            'father_religion_name' => NULL,
            'father_address' => NULL,
            'father_phone_number' => NULL,
            'mother_name' => NULL,
            'mother_occupation_id' => NULL,
            'mother_occupation_name' => NULL,
            'mother_religion_id' => NULL,
            'mother_religion_name' => NULL,
            'mother_address' => NULL,
            'mother_phone_number' => NULL,
            'student_guardian_name' => NULL,
            'student_guardian_occupation_id' => NULL,
            'student_guardian_occupation_name' => NULL,
            'student_guardian_religion_id' => NULL,
            'student_guardian_religion_name' => NULL,
            'student_guardian_address' => NULL,
            'student_guardian_phone_number' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['student_guardian'] = $this->Student_guardian_model->find_by_id($id);

        if(!isset($id) || !$data['data']['student_guardian'])
        {
            $this->session->set_flashdata('error_messages', 'Student Guardian not found');				
            redirect("student_guardian");
        }

        $data['template']['css'] = array(
            'extensions/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        );
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/student_guardian/form-edit-student-guardian.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/student_guardian/edit';  
        $data['template']['title'] = 'Form Edit Student Guardian';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('student_guardian/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   

        $this->form_validation->set_rules('code', 'Code', 'trim|required|max_length[50]|callback_is_unique_code['.$id.']');

        if (!empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean|callback_is_file_uploaded_valid[photo]');
        }

		if($this->form_validation->run() && $this->form_validation->run('student_guardian'))
		{
            $student_guardian = array(
                'id' => $id,
                'code' => $this->input->post('code'),
                'father_name' => $this->input->post('father_name'),
                'father_occupation_id' => $this->input->post('father_occupation'),
                'father_religion_id' => $this->input->post('father_religion'),
                'father_address' => $this->input->post('father_address'),
                'father_phone_number' => $this->input->post('father_phone_number'),
                'mother_name' => $this->input->post('mother_name'),
                'mother_occupation_id' => $this->input->post('mother_occupation'),
                'mother_religion_id' => $this->input->post('mother_religion'),
                'mother_address' => $this->input->post('mother_address'),
                'mother_phone_number' => $this->input->post('mother_phone_number'),
                'student_guardian_name' => $this->input->post('student_guardian_name'),
                'student_guardian_occupation_id' => $this->input->post('student_guardian_occupation'),
                'student_guardian_religion_id' => $this->input->post('student_guardian_religion'),
                'student_guardian_address' => $this->input->post('student_guardian_address'),
                'student_guardian_phone_number' => $this->input->post('student_guardian_phone_number'),
                
                'update_by' => $this->_user_id,
            );

            $student_guardian_updated = $this->Student_guardian_model->update($student_guardian);
			
			if($student_guardian_updated > 0)
			{
                if (!empty($_FILES['photo']['name']))
                {
                    $file_name = str_replace('.','',$student_guardian['code']);
                    $config['upload_path']          = './public/uploads/photos/student_guardians/';
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
                        $this->session->set_flashdata('success_messages', 'Student Guardian data has been successfully updated');
                        redirect("student_guardian");
                    }
                }
                else
                {
                    $this->session->set_flashdata('success_messages', 'Student Guardian data has been successfully updated');
                    redirect("student_guardian");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save student guardian data';
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
        $data['data']['student_guardian'] = $this->Student_guardian_model->find_by_id($id);

        if(!isset($id) || !$data['data']['student_guardian'])
        {
            $this->session->set_flashdata('error_messages', 'Student Guardian not found');
		}
        else
        {
            $student_guardian = array ('id' => $id);
            $student_guardian_deleted = $this->Student_guardian_model->delete($student_guardian);
			
			if($student_guardian_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Student Guardian data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete student guardian data');
            }
        }

        redirect("student_guardian");
    }

    public function is_unique_code($code, $id)
    {
        $is_unique = $this->Student_guardian_model->is_unique_code($code, $id);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_code', 'The %s field must contain a unique value');

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
}