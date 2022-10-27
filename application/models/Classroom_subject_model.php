<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Classroom_subject_model extends CI_Model
	{
		private $_table = 'tb_subject_teacher_classrooms';
        private $_column_order = array(null, 'tb_school_years.school_year',  'tb_subject_teacher_classrooms.semester', 'tb_classrooms.classroom', 'tb_subjects.name','tb_teachers.name',  'tb_teachers.nip',  'tb_subject_teacher_classrooms.is_active'); 
        private $_column_search = array('tb_school_years.school_year',  'tb_subject_teacher_classrooms.semester', 'tb_classrooms.classroom', 'tb_subjects.name','tb_teachers.name',  'tb_teachers.nip'); 
        private $_order = array('tb_school_years.school_year' => 'DESC',  'tb_subject_teacher_classrooms.semester' => 'DESC', 'tb_classrooms.classroom' => 'ASC', 'tb_subjects.name' => 'ASC','tb_teachers.name' => 'ASC',  'tb_teachers.nip' => 'ASC');

        public function insert($subject_teacher)
        {
            if(!$subject_teacher){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $subject_teacher);

            $subject_teacher_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($subject_teacher_id);
            }
        }

        public function update($subject_teacher)
        {
            if(!$subject_teacher || empty($subject_teacher['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $subject_teacher['id']);
            $this->db->update($this->_table, $subject_teacher);

            $subject_teacher_id = $subject_teacher['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($subject_teacher_id);
            }
        }

        public function delete($subject_teacher)
        {
            if(!$subject_teacher || empty($subject_teacher['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $subject_teacher['id'])); 

            $subject_teacher_id = $subject_teacher['id'];

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
            

            $this->db->select($this->_table.'.*, tb_school_years.school_year,  tb_subject_teacher_classrooms.semester, tb_classrooms.classroom, tb_subjects.name AS subject_name, tb_teachers.name AS teacher_name,  tb_teachers.nip AS teacher_nip'); 
            $this->db->from($this->_table);
            $this->db->join('tb_classrooms', 'tb_classrooms.id = '.$this->_table.'.classroom_id');
            $this->db->join('tb_school_years', 'tb_school_years.id = '.$this->_table.'.school_year_id');
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
            $query = $this->db->select($this->_table.'.*,  tb_school_years.school_year,  tb_subject_teacher_classrooms.semester, tb_classrooms.classroom AS classroom_name, tb_subjects.name AS subject_name, tb_teachers.name AS teacher_name,  tb_teachers.nip AS teacher_nip, CONCAT(tb_teachers.name, " (", tb_teachers.nip, ")" ) AS teacher_name_nip,
            CONCAT(tb_subjects.name, " (", tb_teachers.name, "-", tb_teachers.nip, ")") AS subject_teacher_name') 
                        ->from($this->_table)
                        ->join('tb_classrooms', 'tb_classrooms.id = '.$this->_table.'.classroom_id')
                        ->join('tb_school_years', 'tb_school_years.id = '.$this->_table.'.school_year_id')
                        ->join('tb_subject_teachers', 'tb_subject_teachers.id = '.$this->_table.'.subject_teacher_id')
                        ->join('tb_teachers', 'tb_teachers.id = tb_subject_teachers.teacher_id')
                        ->join('tb_subjects', 'tb_subjects.id = tb_subject_teachers.subject_id')         
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        public function is_unique_classroom_subject($data)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $data['id'])
                        ->where('classroom_id', $data['classroom_id'])
                        ->where('school_year_id', $data['school_year_id'])
                        ->where('semester', $data['semester'])
                        ->where('subject_teacher_id', $data['subject_teacher_id'])
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