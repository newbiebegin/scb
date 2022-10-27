<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Student_classroom_model extends CI_Model
	{
		private $_table = 'tb_student_classrooms';
        private $_column_order = array(null, 'tb_classrooms.classroom', 'tb_school_years.school_year', 'tb_students.name', 'tb_student_classrooms.is_active'); 
        private $_column_search = array('tb_classrooms.classroom', 'tb_school_years.school_year', 'tb_students.name'); 
        private $_order = array('tb_school_years.school_year' => 'DESC', 'tb_classrooms.classroom' => 'ASC', 'tb_students.name' => 'asc');

        public function insert($student_classroom)
        {
            if(!$student_classroom){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $student_classroom);

            $student_classroom_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($student_classroom_id);
            }
        }

        public function update($student_classroom)
        {
            if(!$student_classroom || empty($student_classroom['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $student_classroom['id']);
            $this->db->update($this->_table, $student_classroom);

            $student_classroom_id = $student_classroom['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($student_classroom_id);
            }
        }

        public function delete($student_classroom)
        {
            if(!$student_classroom || empty($student_classroom['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $student_classroom['id'])); 

            $student_classroom_id = $student_classroom['id'];

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

        public function is_unique_student_classroom($data)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $data['id'])
                        ->where('classroom_id', $data['classroom_id'])
                        ->where('school_year_id', $data['school_year_id'])
                        ->where('student_id', $data['student_id'])
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