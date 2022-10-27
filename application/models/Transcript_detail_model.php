<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Transcript_detail_model extends CI_Model
	{
		private $_table = 'tb_transcript_details';
        private $_column_order = array(null, 'tb_subjects.name', 'tb_teachers.name', 'tb_teachers.nip', 'tb_transcript_details.score', 'tb_transcript_details.is_active'); 
        private $_column_search = array('tb_subjects.name', 'tb_teachers.name', 'tb_teachers.nip', 'tb_transcript_details.score', 'tb_transcript_details.is_active'); 
        private $_order = array('tb_subjects.name' => 'ASC', 'tb_teachers.name' => 'ASC', 'tb_teachers.nip' => 'ASC', 'tb_transcript_details.score' => 'ASC', 'tb_transcript_details.is_active' => 'ASC');

        public function insert($transcript_detail)
        {
            if(!$transcript_detail){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $transcript_detail);

            $transcript_detail_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($transcript_detail_id);
            }
        }

        public function update($transcript_detail)
        {
            if(!$transcript_detail || empty($transcript_detail['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $transcript_detail['id']);
            $this->db->update($this->_table, $transcript_detail);

            $transcript_detail_id = $transcript_detail['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($transcript_detail_id);
            }
        }

        public function delete($transcript_detail)
        {
            if(!$transcript_detail || empty($transcript_detail['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $transcript_detail['id'])); 

            $transcript_detail_id = $transcript_detail['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return FALSE;
            }
            else
            {
              $this->db->trans_commit();
              return TRUE;
            }
        }

        private function _get_datatables_query($input)
        {
            $this->db->select($this->_table.'.*, tb_subjects.name AS subject_name, tb_teachers.name AS teacher_name, tb_teachers.nip AS teacher_nip'); 
            $this->db->from($this->_table);
            $this->db->join('tb_subject_teachers', 'tb_subject_teachers.id = '.$this->_table.'.subject_teacher_id');
            $this->db->join('tb_teachers', 'tb_teachers.id = tb_subject_teachers.teacher_id');
            $this->db->join('tb_subjects', 'tb_subjects.id = tb_subject_teachers.subject_id');  
            
            $i = 0;
         
            foreach ($this->_column_search as $item) 
            {
                if(isset($input['search']) && $input['search']['value'])
                {
                    if($i===0)
                    {
                        $this->db->group_start(); 
                        $this->db->like($item, $input['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $input['search']['value']);
                    }
     
                    if(count($this->_column_search) - 1 == $i) 
                        $this->db->group_end(); 
                }
                $i++;
            }
            
            if(isset($input['transcript_id'])) 
            {
                $this->db->where('transcript_id', $input['transcript_id']);
            }

            if(isset($input['order'])) 
            {
                $this->db->order_by($this->_column_order[$input['order']['0']['column']], $input['order']['0']['dir']);
            } 
            else if(isset($this->_order))
            {
                $order = $this->_order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

        public function get_datatables($input)
        {
            $this->_get_datatables_query($input);

            if($input['length'] != -1)
                $this->db->limit($input['length'], $input['start']);
            
            $query = $this->db->get();
            
            return $query->result();
        }

        public function count_filtered($input)
        {
            $this->_get_datatables_query($input);
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function count_all()
        {
            $this->db->from($this->_table);
            return $this->db->count_all_results();
        }

        public function find_by_id($id)
        {   
            $query = $this->db->select($this->_table.'.*, tb_subjects.name AS subject_name, tb_teachers.name AS teacher_name, tb_teachers.nip AS teacher_nip, CONCAT(tb_subjects.name, " (", tb_teachers.name, "-", tb_teachers.nip, ")") AS subject_teacher_name') 
                        ->from($this->_table)
                        ->join('tb_subject_teachers', 'tb_subject_teachers.id = '.$this->_table.'.subject_teacher_id')
                        ->join('tb_teachers', 'tb_teachers.id = tb_subject_teachers.teacher_id')
                        ->join('tb_subjects', 'tb_subjects.id = tb_subject_teachers.subject_id')                        
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        // public function is_unique_school_year($school_year, $id)
        // {
        //     $total = $this->db->select()
        //                 ->from($this->_table)
        //                 ->where('id !=', $id)
        //                 ->where('school_year_id', $school_year)
        //                 ->get()
        //                 ->num_rows();

        //     if($total > 0)
        //     {
        //         return FALSE;
        //     }

        //     return TRUE;
        // }
        
        public function is_unique_transcript_detail_subject($data)
        {
            $total = $this->db->select()
                            ->from($this->_table)
                            ->where('id !=', $data['id'])
                            ->where('subject_teacher_id', $data['subject_teacher_id'])
                            ->where('transcript_id', $data['transcript_id'])
                            ->get()
                            ->num_rows();
    
            if($total > 0)
            {
                return FALSE;
            }

            return TRUE;
        }
    }