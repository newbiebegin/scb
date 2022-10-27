<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Classroom_model extends CI_Model
	{
		private $_table = 'tb_classrooms';
        private $_column_order = array(null, 'tb_classrooms.classroom', 'tb_classrooms.grade'); 
        private $_column_search = array('tb_classrooms.classroom', 'tb_classrooms.grade'); 
        private $_order = array('classroom' => 'asc');

        public function insert($classroom)
        {
            if(!$classroom){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $classroom);

            $classroom_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($classroom_id);
            }
        }

        public function update($classroom)
        {
            if(!$classroom || empty($classroom['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $classroom['id']);
            $this->db->update($this->_table, $classroom);

            $classroom_id = $classroom['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($classroom_id);
            }
        }

        public function delete($classroom)
        {
            if(!$classroom || empty($classroom['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $classroom['id'])); 

            $classroom_id = $classroom['id'];

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
            $this->db->select($this->_table.'.*'); 
            $this->db->from($this->_table);
     
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
            $query = $this->db->select($this->_table.'.* ')
                        ->from($this->_table)
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        public function is_unique_classroom($classroom, $id)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $id)
                        ->where('classroom', $classroom)
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
            $this->db->select('id, classroom, classroom AS text' );

            if(isset($input['classroom']))
            {
                $this->db->like('classroom', $input['classroom']);
            }

            if(isset($input['is_active']))
            {
                $this->db->where('is_active', $input['is_active']);
            }

            $query =  $this->db->get($this->_table);

            return $query->result();
        }
    }