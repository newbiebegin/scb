<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Classroom_detail_model extends CI_Model
	{
		private $_table = 'tb_classroom_details';
        private $_column_order = array(null, 'tb_school_years.school_year', 'tb_teachers.homeroom_teacher_name', 'tb_students.head_class_name'); 
        private $_column_search = array('tb_classroom_details.school_year', 'tb_teachers.homeroom_teacher_name', 'tb_students.head_class_name'); 
        private $_order = array('school_year' => 'desc');

        public function insert($classroom_detail)
        {
            if(!$classroom_detail){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $classroom_detail);

            $classroom_detail_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($classroom_detail_id);
            }
        }

        public function update($classroom_detail)
        {
            if(!$classroom_detail || empty($classroom_detail['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $classroom_detail['id']);
            $this->db->update($this->_table, $classroom_detail);

            $classroom_detail_id = $classroom_detail['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($classroom_detail_id);
            }
        }

        public function delete($classroom_detail)
        {
            if(!$classroom_detail || empty($classroom_detail['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $classroom_detail['id'])); 

            $classroom_detail_id = $classroom_detail['id'];

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
            $this->db->select($this->_table.'.*, tb_school_years.school_year, tb_students.name AS head_class_name, tb_teachers.name AS homeroom_teacher_name'); 
            $this->db->from($this->_table);
            $this->db->join('tb_classrooms', 'tb_classrooms.id = '.$this->_table.'.classroom_id');
            $this->db->join('tb_school_years', 'tb_school_years.id = '.$this->_table.'.school_year_id');
            $this->db->join('tb_students', 'tb_students.id = '.$this->_table.'.head_class_id', 'left');
            $this->db->join('tb_teachers', 'tb_teachers.id = '.$this->_table.'.homeroom_teacher_id', 'left');

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
            
            if(isset($input['classroom_id'])) 
            {
                $this->db->where('classroom_id', $input['classroom_id']);
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
            $query = $this->db->select($this->_table.'.*, tb_classrooms.classroom AS classroom_name,
            tb_school_years.school_year AS school_year, tb_teachers.name AS homeroom_teacher_name,
            CONCAT(tb_teachers.name, " (", tb_teachers.nip, ")" ) AS homeroom_teacher_name_nip,
            tb_students.name AS head_class_name, CONCAT(tb_students.name, " (", tb_students.nis, ")" ) AS head_class_name_nis')
                        ->from($this->_table)
                        ->join('tb_classrooms', 'tb_classrooms.id = '.$this->_table.'.classroom_id')
                        ->join('tb_school_years', 'tb_school_years.id = '.$this->_table.'.school_year_id')
                        ->join('tb_teachers', 'tb_teachers.id = '.$this->_table.'.homeroom_teacher_id', 'left')
                        ->join('tb_students', 'tb_students.id = '.$this->_table.'.head_class_id', 'left')
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

        public function is_unique_classroom_school_year($data)
        {
            $total = $this->db->select()
                            ->from($this->_table)
                            ->where('id !=', $data['id'])
                            ->where('school_year_id', $data['school_year_id'])
                            ->where('classroom_id', $data['classroom_id'])
                            ->get()
                            ->num_rows();
    
            if($total > 0)
            {
                return FALSE;
            }

            return TRUE;
        }
    }