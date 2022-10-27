<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CR_Controller {
    
    private $_user_id;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Administrator_model');
        $this->_user_id = $this->session->userdata('session_user_id');
    }

    public function dashboard()
	{
        $data['template']['css'] = NULL;
        $data['template']['main_content'] = 'admin/app/app';   
        $data['template']['content'] = 'admin/dashboard';   
        $data['template']['title'] = 'Profile Statistics';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['js'][] = 'extensions/apexcharts/apexcharts.min.js';
        $data['template']['js'][] = 'js/pages/dashboard.js';
        
        $data['data'] = array(); 

		$this->load->view('admin/main/template', $data);
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
            'js/pages/administrator/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/administrator/list';  
        $data['template']['title'] = 'Form Search Administrator';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('administrator');   

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
        
        $administrators = $this->Administrator_model->get_datatables($input);
        $data = array();
        $no = $input['start'];
        foreach ($administrators as $administrator) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $administrator->name;
            $row[] = $administrator->birthplace;
            $row[] = $administrator->birth_date;
            $row[] = $administrator->religion;
            $row[] = $administrator->gender;
            $row[] = $administrator->phone_number;
            $row[] = "<a href='".site_url('administrator/edit/'.$administrator->id)."'>Edit </a> | <a href='".site_url('administrator/delete/'.$administrator->id)."'> Delete</a>";
            // $row[] = $administrator->address;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Administrator_model->count_all(),
                        "recordsFiltered" => $this->Administrator_model->count_filtered($input),
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
            'js/pages/administrator/form-edit-administrator.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/administrator/add';  
        $data['template']['title'] = 'Form Add Administrator';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('administrator/add');   
        $data['template']['form']['name'] = 'form_add';   
	
        if (empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|required|xss_clean|callback_is_file_uploaded_valid[photo]');
        }
        else
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean|callback_is_file_uploaded_valid[photo]');
        }

        if($this->form_validation->run() && $this->form_validation->run('administrator'))
        {
            $administrator = array(
                            'name' => $this->input->post('name'),
                            'birthplace_id' => $this->input->post('birthplace'),
                            'birth_date' => $this->input->post('birth_date'),
                            'religion_id' => $this->input->post('religion'),
                            'gender' => $this->input->post('gender'),
                            'address' => $this->input->post('address'),
                            'phone_number' => $this->input->post('phone_number'),
                            'create_by' => $this->_user_id,
                        );

            $administrator_saved = $this->Administrator_model->insert($administrator);
			
			if($administrator_saved > 0)
			{
                $file_name = str_replace('.','',$administrator_saved);
                $config['upload_path']          = './public/uploads/photos/administrators/';
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
                    $this->session->set_flashdata('success_messages', 'Administrator data successfully saved');
				    redirect("administrator");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save administrator data';
            }
        }
        else
        {
            $data['data']['errors'] = validation_errors();
        }

        $data['data']['administrator'] = (object) array(
            'name' => NULL,
            'birthplace_id' => NULL,
            'birthplace_name' => NULL,
            'birth_date' => NULL,
            'religion_id' => NULL,
            'religion_name' => NULL,
            'gender' => NULL,
            'address' => NULL,
            'phone_number' => NULL,
        );
        
        $data['method'] = $this->input->method();

		$this->load->view('admin/main/template', $data);
    }

    public function edit($id=NULL)
    {
        $data['data'] = array(); 
        $data['data']['administrator'] = $this->Administrator_model->find_by_id($id);

        if(!isset($id) || !$data['data']['administrator'])
        {
            $this->session->set_flashdata('error_messages', 'Teacher not found');				
            redirect("administrator");
        }

        $data['template']['css'] = array(
            'extensions/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        );
        $data['template']['js'] = array(
            'js/pages/bootstrap-autocomplete.js',
            'js/pages/administrator/form-edit-administrator.js',
            'extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'js/pages/form-datepicker.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/administrator/edit';  
        $data['template']['title'] = 'Form Edit Teacher';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('administrator/edit/'.$id);   
        $data['template']['form']['name'] = 'form_edit';   

        // $this->form_validation->set_rules($this->Administrator_model->rules());
        if (!empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean|callback_is_file_uploaded_valid[photo]');
        }

		if($this->form_validation->run() && $this->form_validation->run('administrator'))
		{
            $administrator = array(
                            'id' => $id,
                            'name' => $this->input->post('name'),
                            'birthplace_id' => $this->input->post('birthplace'),
                            'birth_date' => $this->input->post('birth_date'),
                            'religion_id' => $this->input->post('religion'),
                            'gender' => $this->input->post('gender'),
                            'address' => $this->input->post('address'),
                            'phone_number' => $this->input->post('phone_number'),
                            'update_by' => $this->_user_id,
                        );

            $administrator_updated = $this->Administrator_model->update($administrator);
			
			if($administrator_updated > 0)
			{
                if (!empty($_FILES['photo']['name']))
                {
                    $file_name = str_replace('.','',$administrator_updated);
                    $config['upload_path']          = './public/uploads/photos/administrators/';
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
                        $this->session->set_flashdata('success_messages', 'Administrator data has been successfully updated');
                        redirect("administrator");
                    }
                }
                else
                {
                    $this->session->set_flashdata('success_messages', 'Administrator data has been successfully updated');
                    redirect("administrator");
                }
			}
            else
            {
                $data['data']['errors'] = 'Failed to save administrator data';
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
        $data['data']['administrator'] = $this->Administrator_model->find_by_id($id);

        if(!isset($id) || !$data['data']['administrator'])
        {
            $this->session->set_flashdata('error_messages', 'Administrator not found');
		}
        else
        {
            $administrator = array ('id' => $id);
            $administrator_deleted = $this->Administrator_model->delete($administrator);
			
			if($administrator_deleted)
			{
                $this->session->set_flashdata('success_messages', 'Administrator data deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error_messages', 'Failed to delete administrator data');
            }
        }

        redirect("administrator");
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