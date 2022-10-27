<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom_detail extends CR_Controller {
    
    private $_user_id;
    private $_dropdown_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Classroom_detail_model');
        $this->load->model('School_year_model');
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
            'js/pages/classroom_detail/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/classroom_detail/list';  
        $data['template']['title'] = 'Form Search Classroom Detail';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('classroom_detail');   
     
        $this->load->view('admin/main/template', $data);
    }

    public function ajax_list()
    {
        $input = array();
        $data = array();
       
        if( $this->input->post('search'))
        {
            $input['search'] = $this->input->post('search');
        }
        
       
        if( $this->input->post('classroom'))
        {
            $input['classroom_id'] = $this->input->post('classroom');
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
        
        $classroom_details = $this->Classroom_detail_model->get_datatables($input);
       
        $no = $input['start'];
        foreach ($classroom_details as $classroom_detail) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $classroom_detail->school_year;
            $row[] = $classroom_detail->homeroom_teacher_name;
            $row[] = $classroom_detail->head_class_name;
            $row[] = $this->_dropdown_active_status[$classroom_detail->is_active];
         
            $row[] = "<button type='button' class='btn btn-outline-primary' data-bs-toggle='modal'
                data-bs-target='#inlineForm' data-id='".$classroom_detail->id."' data-classroom='".$classroom_detail->classroom_id."' name='btn_edit' id='btn_edit' data-url='".site_url('classroom_detail/edit/'.$classroom_detail->id)."'>
                Edit
            </button>
            <button type='button' class='btn btn-outline-primary' data-bs-toggle='modal'
            data-bs-target='#warning' data-id='".$classroom_detail->id."' data-classroom='".$classroom_detail->classroom_id."' name='btn_delete' id='btn_delete' data-url='".site_url('classroom_detail/delete/'.$classroom_detail->id)."'>
                Delete        
            </button>";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Classroom_detail_model->count_all(),
                        "recordsFiltered" => $this->Classroom_detail_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $this->config->load('form_validation/classroom_detail');
        $validation_rules = $this->config->item('classroom_detail/modal_form');

        $id = NULL;
        $data['data'] = array(); 

        $classroom_detail = array(
            'id' => $id,
            'classroom_id' => $this->input->post('form_modal_classroom'),
            'school_year_id' => $this->input->post('form_modal_school_year'),
            'homeroom_teacher_id' => $this->input->post('form_modal_homeroom_teacher'),
            'head_class_id' => $this->input->post('form_modal_head_class'),
            'is_active' => $this->input->post('form_modal_is_active'),
            'create_by' => $this->_user_id,
        );

        $this->form_validation->set_rules('form_modal_classroom', 'Classroom', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('form_modal_school_year', 'School Year', 'trim|required|max_length[11]|callback_is_unique_classroom_school_year['.$id.'--Classroom--'.$classroom_detail['classroom_id'].'--School Year--'.$classroom_detail['school_year_id'].']');
        $this->form_validation->set_rules('form_modal_homeroom_teacher', 'Homeroom Teacher', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('form_modal_head_class', 'Head Class', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules($validation_rules);      

        if($this->form_validation->run())
        {
            $classroom_detail_saved = $this->Classroom_detail_model->insert($classroom_detail);

            if($classroom_detail_saved > 0)
            {
                $output['data']['success'] = true;
                $output['data']['messages']['content'] = 'Classroom detail data saved successfully';
                $output['data']['messages']['type'] = 'success_messages';
            }
            else
            {
                $output['data']['success'] = false;
                $output['data']['messages']['content'] = 'Classroom detail data failed to save';
                $output['data']['messages']['type'] = 'error_messages';
            }
        }
        else
        {
            if($this->input->method() == 'post')
            {
                $output['data']['success'] = false;
                // $output['data']['errors'] = validation_errors();
                $output['data']['messages']['content'] = validation_errors();
                $output['data']['messages']['type'] = 'error_messages';
            }
        }
        
        $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
        
        $this->output->set_output(json_encode($output));
        
    }

    public function edit($id=NULL)
    {
        $this->config->load('form_validation/classroom_detail');
        $validation_rules = $this->config->item('classroom_detail/modal_form');

        $output['data'] = array(); 
        $output['data']['classroom_detail'] = $this->Classroom_detail_model->find_by_id($id);
        
        if(!isset($id) || !$output['data']['classroom_detail'])
        {
            $output['data']['success'] = false;
            $output['data']['messages']['content'] = 'Classroom detail not found';
            $output['data']['messages']['type'] = 'error_messages';
            
            $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
            return $this->output->set_output(json_encode($output));
        }

        $classroom_detail = array(
            'id' => $id,
            'classroom_id' => $this->input->post('form_modal_classroom'),
            'school_year_id' => $this->input->post('form_modal_school_year'),
            'homeroom_teacher_id' => $this->input->post('form_modal_homeroom_teacher'),
            'head_class_id' => $this->input->post('form_modal_head_class'),
            'is_active' => $this->input->post('form_modal_is_active'),
            'update_by' => $this->_user_id,
        );

        $this->form_validation->set_rules('form_modal_classroom', 'Classroom', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('form_modal_school_year', 'School Year', 'trim|required|max_length[11]|callback_is_unique_classroom_school_year['.$id.'--Classroom--'.$classroom_detail['classroom_id'].'--School Year--'.$classroom_detail['school_year_id'].']');
        $this->form_validation->set_rules('form_modal_homeroom_teacher', 'Homeroom Teacher', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('form_modal_head_class', 'Head Class', 'trim|required|max_length[11]');
        
        $this->form_validation->set_rules($validation_rules);      

        if($this->form_validation->run())
		{
            $classroom_detail_updated = $this->Classroom_detail_model->update($classroom_detail);
			
			if($classroom_detail_updated > 0)
			{
                $output['data']['success'] = true;
                $output['data']['messages']['content'] = 'Classroom detail data has been successfully updated';
                $output['data']['messages']['type'] = 'success_messages';
            }
            else
            {
                $output['data']['success'] = false;
                $output['data']['messages']['content'] = 'Classroom detail data failed to save';
                $output['data']['messages']['type'] = 'error_messages';
            }
        }
        else
        {
            if($this->input->method() == 'post')
            {
                $output['data']['success'] = false;
                $output['data']['messages']['content'] = validation_errors();
                $output['data']['messages']['type'] = 'error_messages';
            }
            else
            {
                $output['data']['success'] = true;
                $output['data']['messages']['content'] = 'Classroom detail data found';
                $output['data']['messages']['type'] = 'success_messages';
            }    
        }
        
        $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
        
        $this->output->set_output(json_encode($output));
    }

    public function delete($id=NULL)
    {
        $output['data'] = array(); 
        $output['data']['classroom_detail'] = $this->Classroom_detail_model->find_by_id($id);

        if(!isset($id) || !$output['data']['classroom_detail'])
        {
            $output['data']['success'] = false;
            $output['data']['messages']['content'] = 'Classroom detail not found';
            $output['data']['messages']['type'] = 'error_messages';
            
            $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
            return $this->output->set_output(json_encode($output));
		}
        else
        {
            $classroom_detail = array ('id' => $id);
            $classroom_detail_deleted = $this->Classroom_detail_model->delete($classroom_detail);
			
			if($classroom_detail_deleted)
			{
                $output['data']['success'] = true;
                $output['data']['messages']['content'] = 'Classroom details deleted successfully';
                $output['data']['messages']['type'] = 'success_messages';
            }
            else
            {
                $output['data']['success'] = false;
                $output['data']['messages']['content'] = 'Classroom details failed to delete';
                $output['data']['messages']['type'] = 'error_messages';
            }
        }

        $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
        
        $this->output->set_output(json_encode($output));
    }

    public function is_unique_classroom_detail($classroom_detail, $id)
    {
       
        $is_unique = $this->Classroom_detail_model->is_unique_classroom_detail($classroom_detail, $id);
        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_classroom_detail', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }

    public function is_unique_classroom_school_year($school_year, $id)
    {
        $ids = explode('--', $id);
        $data['id'] = $ids[0];

        $data['classroom_id'] = $ids[2];
        $data['school_year_id'] = $ids[4];
        
        $is_unique = $this->Classroom_detail_model->is_unique_classroom_school_year($data);

        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_classroom_school_year', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }
}