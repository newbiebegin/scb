<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transcript_detail extends CR_Controller {
    
    private $_user_id;
    private $_dropdown_active_status;

    function __construct()
	{
		parent::__construct();
        $this->load->model('Transcript_detail_model');
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
            'js/pages/transcript_detail/datatable.js',
        );
        $data['template']['main_content'] = 'admin/app/app'; 
        $data['template']['content'] = 'admin/transcript_detail/list';  
        $data['template']['title'] = 'Form Search Transcript Detail';   
        $data['template']['sub_title'] = NULL;   
        $data['template']['form']['action'] = base_url('transcript_detail');   
     
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
        
       
        if( $this->input->post('transcript'))
        {
            $input['transcript_id'] = $this->input->post('transcript');
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
        
        $transcript_details = $this->Transcript_detail_model->get_datatables($input);
       
        $no = $input['start'];
        foreach ($transcript_details as $transcript_detail) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $transcript_detail->subject_name;
            $row[] = $transcript_detail->teacher_name;
            $row[] = $transcript_detail->teacher_nip;
            $row[] = $transcript_detail->score;
            $row[] = $this->_dropdown_active_status[$transcript_detail->is_active];
         
            $row[] = "<button type='button' class='btn btn-outline-primary' data-bs-toggle='modal'
                data-bs-target='#inlineForm' data-id='".$transcript_detail->id."' data-transcript='".$transcript_detail->transcript_id."' name='btn_edit' id='btn_edit' data-url='".site_url('transcript_detail/edit/'.$transcript_detail->id)."'>
                Edit
            </button>
            <button type='button' class='btn btn-outline-primary' data-bs-toggle='modal'
            data-bs-target='#warning' data-id='".$transcript_detail->id."' data-transcript='".$transcript_detail->transcript_id."' name='btn_delete' id='btn_delete' data-url='".site_url('transcript_detail/delete/'.$transcript_detail->id)."'>
                Delete        
            </button>";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $this->Transcript_detail_model->count_all(),
                        "recordsFiltered" => $this->Transcript_detail_model->count_filtered($input),
                        "data" => $data,
                );
                
        $this->output->set_output(json_encode($output));
    }

    public function add()
    {
        $this->config->load('form_validation/transcript_detail');
        $validation_rules = $this->config->item('transcript_detail/modal_form');

        $id = NULL;
        $data['data'] = array(); 

        $transcript_detail = array(
            'id' => $id,
            'transcript_id' => $this->input->post('transcript_id'),
            'subject_teacher_id' => $this->input->post('form_modal_subject_teacher'),
            'score' => $this->input->post('form_modal_score'),
            'is_active' => $this->input->post('form_modal_is_active'),
            'create_by' => $this->_user_id,
        );
      
        $this->form_validation->set_rules('form_modal_subject_teacher', 'Subject', 'trim|required|max_length[11]|callback_is_unique_transcript_detail_subject['.$id.'--Transcript--'.$transcript_detail['transcript_id'].'--Subject--'.$transcript_detail['subject_teacher_id'].']');
        $this->form_validation->set_rules('form_modal_score', 'Score', 'trim|required|max_length[7]
        ');
       
        $this->form_validation->set_rules($validation_rules);      

        if($this->form_validation->run())
        {
            $transcript_detail_saved = $this->Transcript_detail_model->insert($transcript_detail);

            if($transcript_detail_saved > 0)
            {
                $output['data']['success'] = true;
                $output['data']['messages']['content'] = 'Transcript detail data saved successfully';
                $output['data']['messages']['type'] = 'success_messages';
            }
            else
            {
                $output['data']['success'] = false;
                $output['data']['messages']['content'] = 'Transcript detail data failed to save';
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
        }
        
        $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
        
        $this->output->set_output(json_encode($output));
        
    }

    public function edit($id=NULL)
    {
        $this->config->load('form_validation/transcript_detail');
        $validation_rules = $this->config->item('transcript_detail/modal_form');

        $output['data'] = array(); 
        $output['data']['transcript_detail'] = $this->Transcript_detail_model->find_by_id($id);
        
        if(!isset($id) || !$output['data']['transcript_detail'])
        {
            $output['data']['success'] = false;
            $output['data']['messages']['content'] = 'Transcript detail not found';
            $output['data']['messages']['type'] = 'error_messages';
            
            $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
            return $this->output->set_output(json_encode($output));
        }

        $transcript_detail = array(
            'id' => $id,
            'transcript_id' => $this->input->post('transcript_id'),
            // 'subject_id' => $this->input->post('form_modal_subject'),
            'subject_teacher_id' => $this->input->post('form_modal_subject_teacher'),
            'score' => $this->input->post('form_modal_score'),
            'is_active' => $this->input->post('form_modal_is_active'),
            'update_by' => $this->_user_id,
        );

        $this->form_validation->set_rules('form_modal_subject_teacher', 'Subject', 'trim|required|max_length[11]|callback_is_unique_transcript_detail_subject['.$id.'--Transcript--'.$transcript_detail['transcript_id'].'--Subject--'.$transcript_detail['subject_teacher_id'].']');
        $this->form_validation->set_rules('form_modal_score', 'Score', 'trim|required|max_length[7]
        ');
       
        $this->form_validation->set_rules($validation_rules);      

        if($this->form_validation->run())
		{
            $transcript_detail_updated = $this->Transcript_detail_model->update($transcript_detail);
			
			if($transcript_detail_updated > 0)
			{
                $output['data']['success'] = true;
                $output['data']['messages']['content'] = 'Transcript detail data has been successfully updated';
                $output['data']['messages']['type'] = 'success_messages';
            }
            else
            {
                $output['data']['success'] = false;
                $output['data']['messages']['content'] = 'Transcript detail data failed to save';
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
                $output['data']['messages']['content'] = 'Transcript detail data found';
                $output['data']['messages']['type'] = 'success_messages';
            }    
        }
        
        $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
        
        $this->output->set_output(json_encode($output));
    }

    public function delete($id=NULL)
    {
        $output['data'] = array(); 
        $output['data']['transcript_detail'] = $this->Transcript_detail_model->find_by_id($id);

        if(!isset($id) || !$output['data']['transcript_detail'])
        {
            $output['data']['success'] = false;
            $output['data']['messages']['content'] = 'Transcript detail not found';
            $output['data']['messages']['type'] = 'error_messages';
            
            $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
            return $this->output->set_output(json_encode($output));
		}
        else
        {
            $transcript_detail = array ('id' => $id);
            $transcript_detail_deleted = $this->Transcript_detail_model->delete($transcript_detail);
			
			if($transcript_detail_deleted)
			{
                $output['data']['success'] = true;
                $output['data']['messages']['content'] = 'Transcript details deleted successfully';
                $output['data']['messages']['type'] = 'success_messages';
            }
            else
            {
                $output['data']['success'] = false;
                $output['data']['messages']['content'] = 'Transcript details failed to delete';
                $output['data']['messages']['type'] = 'error_messages';
            }
        }

        $output['data']['view_messages'] = $this->load->view('admin/main/message', $output, TRUE);
        
        $this->output->set_output(json_encode($output));
    }

    // public function is_unique_transcript_detail($transcript_detail, $id)
    // {
       
    //     $is_unique = $this->Classroom_detail_model->is_unique_transcript_detail($transcript_detail, $id);
        
    //     if($is_unique === FALSE)
    //     {
    //         $this->form_validation->set_message('is_unique_transcript_detail', 'The %s field must contain a unique value');

    //         return FALSE;
    //     }

    //     return TRUE;
    // }

    public function is_unique_transcript_detail_subject($subject, $id)
    {
        $ids = explode('--', $id);
        $data['id'] = $ids[0];

        $data['transcript_id'] = $ids[2];
        $data['subject_teacher_id'] = $ids[4];
        
        $is_unique = $this->Transcript_detail_model->is_unique_transcript_detail_subject($data);

        
        if($is_unique === FALSE)
        {
            $this->form_validation->set_message('is_unique_transcript_detail_subject', 'The %s field must contain a unique value');

            return FALSE;
        }

        return TRUE;
    }
}