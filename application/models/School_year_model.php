<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class School_year_model extends CI_Model
	{
		private $_table = 'tb_school_years';
        private $_column_order = array(null, 'tb_school_years.school_year'); 
        private $_column_search = array('tb_school_years.school_year'); 
        private $_order = array('school_year' => 'asc');

        public function insert($school_year)
        {
            if(!$school_year){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $school_year);

            $school_year_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($school_year_id);
            }
        }

        public function update($school_year)
        {
            if(!$school_year || empty($school_year['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $school_year['id']);
            $this->db->update($this->_table, $school_year);

            $school_year_id = $school_year['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($school_year_id);
            }
        }

        public function delete($school_year)
        {
            if(!$school_year || empty($school_year['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $school_year['id'])); 

            $school_year_id = $school_year['id'];

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

        public function is_unique_school_year($school_year, $id)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $id)
                        ->where('school_year', $school_year)
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
            $this->db->select('id, school_year, school_year AS text' );

            if(isset($input['school_year']))
            {
                $this->db->like('school_year', $input['school_year']);
            }

            if(isset($input['is_active']))
            {
                $this->db->where('is_active', $input['is_active']);
            }

            $query =  $this->db->get($this->_table);

            return $query->result();
        }

        // public function dropdown($data)
        // {
        //     $query =   $this->db->select('id, school_year')
        //                         ->from($this->_table)
        //                         ->get()
        //                         ->result();
        //     return $query;
        // }
    }