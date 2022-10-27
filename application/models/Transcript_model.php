<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Transcript_model extends CI_Model
	{
		private $_table = 'tb_transcripts';
        private $_column_order = array(null, 'tb_transcripts.classroom', 'tb_transcripts.school_year'); 
        private $_column_search = array('tb_transcripts.classroom', 'tb_transcripts.school_year'); 
        private $_order = array('update_at' => 'desc');

        public function insert($transcript)
        {
            if(!$transcript){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $transcript);

            $transcript_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($transcript_id);
            }
        }

        public function update($transcript)
        {
            if(!$transcript || empty($transcript['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $transcript['id']);
            $this->db->update($this->_table, $transcript);

            $transcript_id = $transcript['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($transcript_id);
            }
        }

        public function delete($transcript)
        {
            if(!$transcript || empty($transcript['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $transcript['id'])); 

            $transcript_id = $transcript['id'];

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
            $this->db->select($this->_table.'.*, tb_classrooms.classroom AS classroom_name, tb_school_years.school_year AS school_year, tb_students.name AS student_name'); 
            $this->db->from($this->_table);
            $this->db->join('tb_classrooms', 'tb_classrooms.id = '.$this->_table.'.classroom_id');
            $this->db->join('tb_school_years', 'tb_school_years.id = '.$this->_table.'.school_year_id');
            $this->db->join('tb_students', 'tb_students.id = '.$this->_table.'.student_id');
            
     
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

        private function _get_datatables_query_student_transcript($input)
        {
            $this->db->select($this->_table.'.*, tb_classrooms.classroom AS classroom_name, tb_school_years.school_year AS school_year, tb_students.name AS student_name, tb_subjects.name AS subject_name, tb_transcript_details.score, tb_teachers.name AS teacher_name'); 
            $this->db->from($this->_table);
            $this->db->join('tb_transcript_details', 'tb_transcript_details.transcript_id = '.$this->_table.'.id');
            $this->db->join('tb_subject_teachers', 'tb_subject_teachers.id = tb_transcript_details.subject_teacher_id');
            $this->db->join('tb_teachers', 'tb_teachers.id = tb_subject_teachers.teacher_id');
            $this->db->join('tb_subjects', 'tb_subjects.id = tb_subject_teachers.subject_id');    
            $this->db->join('tb_classrooms', 'tb_classrooms.id = '.$this->_table.'.classroom_id');
            $this->db->join('tb_school_years', 'tb_school_years.id = '.$this->_table.'.school_year_id');
            $this->db->join('tb_students', 'tb_students.id = '.$this->_table.'.student_id');
            
     
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
            
            if(isset($input['name'])) 
            {
                $this->db->like('tb_students.name', $input['name']);
            } 
            
            if(isset($input['nis'])) 
            {
                $this->db->like('tb_students.nis', $input['nis']);
            } 
            
            if(isset($input['classroom'])) 
            {
                $this->db->like('tb_classrooms.classroom', $input['classroom']);
            } 
            
            if(isset($input['school_year'])) 
            {
                $this->db->like('tb_school_years.school_year', $input['school_year']);
            } 
            
            if(isset($input['semester'])) 
            {
                $this->db->like('tb_transcripts.semester', $input['semester']);
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
            if($input['sql_type'] == 'ajax_student_transcript')
            {
                $this->_get_datatables_query_student_transcript($input);
            }
            else
            {
                $this->_get_datatables_query($input);
            }

            if($input['length'] != -1)
                $this->db->limit($input['length'], $input['start']);
            
            $query = $this->db->get();
            
            return $query->result();
        }

        public function count_filtered($input)
        {
            // $this->_get_datatables_query($input);
            if($input['sql_type'] == 'ajax_student_transcript')
            {
                $this->_get_datatables_query_student_transcript($input);
            }
            else
            {
                $this->_get_datatables_query($input);
            }

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
            $query = $this->db->select($this->_table.'.*, tb_classrooms.classroom AS classroom_name, tb_school_years.school_year AS school_year, tb_students.name AS student_name, CONCAT(tb_students.name, " (", tb_students.nis, ")" ) AS student_name_nis')
                        ->from($this->_table)
                        ->join('tb_classrooms', 'tb_classrooms.id = '.$this->_table.'.classroom_id')
                        ->join('tb_school_years', 'tb_school_years.id = '.$this->_table.'.school_year_id')
                        ->join('tb_students', 'tb_students.id = '.$this->_table.'.student_id')            
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        public function is_unique_transcript_student($data)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $data['id'])
                        ->where('classroom_id', $data['classroom_id'])
                        ->where('school_year_id', $data['school_year_id'])
                        ->where('student_id', $data['student_id'])
                        ->where('semester', $data['semester'])
                        ->get()
                        ->num_rows();

            if($total > 0)
            {
                return FALSE;
            }

            return TRUE;
        }

        
        // public function search($input)
        // {
        //     $this->db->select('id, classroom, classroom AS text' );

        //     if(isset($input['classroom']))
        //     {
        //         $this->db->like('classroom', $input['classroom']);
        //     }

        //     if(isset($input['is_active']))
        //     {
        //         $this->db->where('is_active', $input['is_active']);
        //     }

        //     $query =  $this->db->get($this->_table);

        //     return $query->result();
        // }
    }