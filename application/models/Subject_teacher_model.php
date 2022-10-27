<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Subject_teacher_model extends CI_Model
	{
		private $_table = 'tb_subject_teachers';
        private $_column_order = array(null, 'tb_teachers.name',  'tb_teachers.nip', 'tb_subjects.name', 'tb_subject_teachers.is_active'); 
        private $_column_search = array('tb_teachers.name', 'tb_teachers.nip', 'tb_subjects.name'); 
        private $_order = array('tb_teachers.name' => 'ASC', 'tb_teachers.nip' => 'ASC', 'tb_subjects.name' => 'ASC');

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
            $this->db->select($this->_table.'.*, tb_teachers.name AS teacher_name, tb_teachers.nip AS teacher_nip, tb_subjects.name AS subject_name'); 
            $this->db->from($this->_table);
            $this->db->join('tb_teachers', 'tb_teachers.id = '.$this->_table.'.teacher_id');
            $this->db->join('tb_subjects', 'tb_subjects.id = '.$this->_table.'.subject_id');            
     
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
            $query = $this->db->select($this->_table.'.*, tb_teachers.name AS teacher_name, tb_teachers.nip AS teacher_nip, tb_subjects.name AS subject_name, CONCAT(tb_teachers.name, " (", tb_teachers.nip, ")" ) AS teacher_name_nip')
                        ->from($this->_table)
                        ->join('tb_teachers', 'tb_teachers.id = '.$this->_table.'.teacher_id')
                        ->join('tb_subjects', 'tb_subjects.id = '.$this->_table.'.subject_id')           
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        public function is_unique_subject_teacher($data)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $data['id'])
                        ->where('teacher_id', $data['teacher_id'])
                        ->where('subject_id', $data['subject_id'])
                        ->get()
                        ->num_rows();

            if($total > 0)
            {
                return FALSE;
            }

            return TRUE;
        }

        public function search($input)
        {
            $this->db->select($this->_table.'.id, tb_teachers.name AS teacher_name, tb_teachers.nip,
                CONCAT(tb_subjects.name, " (", tb_teachers.name, "-", tb_teachers.nip, ")") AS text' );
            $this->db->from($this->_table);
            $this->db->join('tb_teachers', 'tb_teachers.id = '.$this->_table.'.teacher_id');
            $this->db->join('tb_subjects', 'tb_subjects.id = '.$this->_table.'.subject_id');    

            if(isset($input['keyword']))
            {
                $this->db->group_start();
                $this->db->like('tb_subjects.name', $input['keyword']);
                $this->db->or_like('tb_teachers.name', $input['keyword']);
                $this->db->or_like('tb_teachers.nip', $input['keyword']);
                $this->db->group_end();
            }

            if(isset($input['is_active']))
            {
                $this->db->where($this->_table.'.is_active', $input['is_active']);
            }

            $query =  $this->db->get();

            return $query->result();
        }
    }