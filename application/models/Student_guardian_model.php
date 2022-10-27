<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Student_guardian_model extends CI_Model
	{
		private $_table = 'tb_student_guardians';
        private $_column_order = array(null, 'student_guardian_name'); 
        private $_column_search = array('student_guardian_name'); 
        private $_order = array('student_guardian_name' => 'asc');

        public function search($input)
        {
            $this->db->select('id, student_guardian_name, student_guardian_name AS text' );

            if(isset($input['student_guardian_name']))
            {
                $this->db->like('student_guardian_name', $input['student_guardian_name']);
            }

            if(isset($input['is_active']))
            {
                $this->db->where('is_active', $input['is_active']);
            }

            $query =  $this->db->get($this->_table);

            return $query->result();
        }

        public function insert($student_guardian)
        {
            if(!$student_guardian){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $student_guardian);

            $student_guardian_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($student_guardian_id);
            }
        }

        public function update($student_guardian)
        {
            if(!$student_guardian || empty($student_guardian['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $student_guardian['id']);
            $this->db->update($this->_table, $student_guardian);

            $student_guardian_id = $student_guardian['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($student_guardian);
            }
        }

        public function delete($student_guardian)
        {
            if(!$student_guardian || empty($student_guardian['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $student_guardian['id'])); 

            $student_guardian_id = $student_guardian['id'];

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
            $this->db->select($this->_table.'.*, tb_religions.name AS student_guardian_religion'); 
            $this->db->from($this->_table);
            $this->db->join('tb_religions', 'tb_religions.id = '.$this->_table.'.student_guardian_religion_id');
     
            $i = 0;
         
            foreach ($this->_column_search as $item) // loop column 
            {
                 // if datatable send POST for search
                if(isset($input['search']) && $input['search']['value'])
                {
                    if($i===0) // first loop
                    {
                        /*
                        * open bracket. query Where with OR clause better with bracket.
                        * because maybe can combine with other WHERE with AND.
                        */
                        $this->db->group_start(); 
                        $this->db->like($item, $input['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $input['search']['value']);
                    }
     
                    if(count($this->_column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }
             
            if(isset($input['order'])) // here order processing
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
            $query = $this->db->select(
                            $this->_table.'.* 
                            , father_religion.name AS father_religion_name 
                            , father_occupation.name AS father_occupation_name 
                            , mother_religion.name AS mother_religion_name 
                            , mother_occupation.name AS mother_occupation_name 
                            , tb_religions.name AS student_guardian_religion_name 
                            , tb_occupations.name AS student_guardian_occupation_name 
                        ')
                        ->from($this->_table)
                        ->join('tb_religions AS father_religion', 'father_religion.id = '.$this->_table.'.father_religion_id')
                        ->join('tb_occupations AS father_occupation', 'father_occupation.id = '.$this->_table.'.father_occupation_id')
                        ->join('tb_religions AS mother_religion', 'mother_religion.id = '.$this->_table.'.mother_religion_id')
                        ->join('tb_occupations AS mother_occupation', 'mother_occupation.id = '.$this->_table.'.mother_occupation_id')
                        ->join('tb_religions', 'tb_religions.id = '.$this->_table.'.student_guardian_religion_id')
                        ->join('tb_occupations', 'tb_occupations.id = '.$this->_table.'.student_guardian_occupation_id')
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        public function is_unique_code($code, $id)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $id)
                        ->where('code', $code)
                        ->get()
                        ->num_rows();

            if($total > 0)
            {
                return FALSE;
            }

            return TRUE;
        }

    }