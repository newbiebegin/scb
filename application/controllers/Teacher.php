<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CR_Controller {
    
    private $_user_id;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Teacher_model');
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
            'js/pages/teacher/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/teacher/list';  
        $data['template']['title'] = 'Form Search Teacher';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('teacher');   

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
        
        $teachers = $this->Teacher_model->get_datatables($input);
        $data = array();
        $no = $input['start'];
        foreach ($teachers as $teacher) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $teacher->name;
            $row[] = $teacher->nip;
            $row[] = $teacher->birthplace;
            $row[] = $teacher->birth_date;
            $row[] = $teacher->religion;
            $row[] = $teacher->gender;
            $row[] = "<a href='".site_url('teacher/edit/'.$teacher->id)."'>Edit </a> | <a href='".site_url('teacher/delete/'.$teacher->id)."'> Delete</a>";
            // $row[] = $teacher->address;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Teacher_model->count_all(),
                        "recordsFiltered" => $this->Teacher_model->count_filtered($input),
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
            'js/pages/teacher/form-edit-teacher.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/teacher/add';  
        $data['template']['title'] = 'Form Add Teacher';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('teacher/add');   
        $data['template']['form']['name'] = 'form_edit';   
	
        $this->form_validation->set_rules('nip', 'NIP', 'trim|required|max_length[50]|callback_is_unique_nip['.$id.']');
        
        if (empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|required|xss_clean|callback_is_file_uploaded_valid[photo]');
        }
        else
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean|callback_is_file_uploaded_valid[photo]');
        }

        if($this->form_validation->run() && $this->form_validation->run('teacher'))
        {
            $teacher = array(
                            'nip' => $this->input->post('nip'),
                            'name' => $this->input->post('name'),
                            'birthplace_id' => $this->input->post('birthplace'),
                            'birth_date' => $this->input->post('birth_date'),
                            'religion_id' => $this->input->post('religion'),
                            'gender' => $this->input->post('gender'),
                            'address' => $this->input->post('address'),
                            'phone_number' => $this->input->post('phone_number'),
                            'create_by' => $this->_user_id,
                        );

            $teacher_saved = $this->Teacher_model->insert($teacher);
			
			if($teacher_saved > 0)
			{
                $file_name = str_replace('.','',$teacher['nip']);
                $config['upload_path']          = './public/uploads/photos/teachers/';
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
                    $this->session->set_flashdata('success_messages', 'Teacher data successfully saved');
				    redirect("teacher");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save teacher data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['teacher'] = (object) array(
            'nip' => NULL,
            'name' => NULL,
            'birthplace_id' => NULL,
            'birthplace_name' => NULL,
            'birth_date' => NULL,
            'religion_id' => NULL,
            'religion_name' => NULL,
            'gender' => NULL,
            'address' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['teacher'] = $this->Teacher_model->find_by_id($id);

        if(!isset($id) || !$data['data']['teacher'])
        {
            $this->session->set_flashdata('error_messages', 'Teacher not found');				
            redirect("teacher");
        }

        $data['template']['css'] = array(
            'extensions/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        );
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/teacher/form-edit-teacher.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/teacher/edit';  
        $data['template']['title'] = 'Form Edit Teacher';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('teacher/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   

        // $this->form_validation->set_rules($this->Teacher_model->rules());
        $this->form_validation->set_rules('nip', 'NIP', 'trim|required|max_length[50]|callback_is_unique_nip['.$id.']');
        if (!empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean|callback_is_file_uploaded_valid[photo]');
        }

		if($this->form_validation->run() && $this->form_validation->run('teacher'))
		{
            $teacher = array(
                            'id' => $id,
                            'nip' => $this->input->post('nip'),
                            'name' => $this->input->post('name'),
                            'birthplace_id' => $this->input->post('birthplace'),
                            'birth_date' => $this->input->post('birth_date'),
                            'religion_id' => $this->input->post('religion'),
                            'gender' => $this->input->post('gender'),
                            'address' => $this->input->post('address'),
                            'phone_number' => $this->input->post('phone_number'),
                            'update_by' => $this->_user_id,
                        );

            $teacher_updated = $this->Teacher_model->update($teacher);
			
			if($teacher_updated > 0)
			{
                if (!empty($_FILES['photo']['name']))
                {
                    $file_name = str_replace('.','',$teacher['nip']);
                    $config['upload_path']          = './public/uploads/photos/teachers/';
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
                        $this->session->set_flashdata('success_messages', 'Teacher data has been successfully updated');
                        redirect("teacher");
                    }
                }
                else
                {
                    $this->session->set_flashdata('success_messages', 'Teacher data has been successfully updated');
                    redirect("teacher");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save teacher data';
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
        $data['data']['teacher'] = $this->Teacher_model->find_by_id($id);

        if(!isset($id) || !$data['data']['teacher'])
        {
            $this->session->set_flashdata('error_messages', 'Teacher not found');
		}
        else
        {
            $teacher = array ('id' => $id);
            $teacher_deleted = $this->Teacher_model->delete($teacher);
			
			if($teacher_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Teacher data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete teacher data');
            }
        }

        redirect("teacher");
    }

    public function is_unique_nip($nip, $id)
    {
        $is_unique = $this->Teacher_model->is_unique_nip($nip, $id);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_nip', 'The %s field must contain a unique value');

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
        
        $teachers = array("results" => $this->Teacher_model->search($input));
       
        $this->output->set_output(json_encode($teachers));
    }
}