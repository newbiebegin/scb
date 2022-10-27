<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Subject_model extends CI_Model
	{
		private $_table = 'tb_subjects';
        private $_column_order = array(null, 'tb_subjects.name'); 
        private $_column_search = array('tb_subjects.name'); 
        private $_order = array('name' => 'asc');

        public function insert($subject)
        {
            if(!$subject){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $subject);

            $subject_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($subject_id);
            }
        }

        public function update($subject)
        {
            if(!$subject || empty($subject['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $subject['id']);
            $this->db->update($this->_table, $subject);

            $subject_id = $subject['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($subject_id);
            }
        }

        public function delete($subject)
        {
            if(!$subject || empty($subject['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $subject['id'])); 

            $subject_id = $subject['id'];

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
            $query = $this->db->select($this->_table.'.* ')
                        ->from($this->_table)
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        public function is_unique_name($name, $id)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $id)
                        ->where('name', $name)
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
            $this->db->select('id, name, name AS text' );

            if(isset($input['keyword']))
            {
                $this->db->like('name', $input['keyword']);
            }

            if(isset($input['is_active']))
            {
                $this->db->where('is_active', $input['is_active']);
            }

            $query =  $this->db->get($this->_table);

            return $query->result();
        }



    }