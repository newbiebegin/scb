<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Teacher_model extends CI_Model
	{
		private $_table = 'tb_teachers';
        private $_column_order = array(null, 'tb_teachers.name','tb_teachers.nip','tb_cities.name','birth_date','tb_religions.name','tb_teachers.gender'); 
        private $_column_search = array('tb_teachers.name','tb_teachers.nip','tb_cities.name','tb_religions.name','tb_teachers.gender'); 
        private $_order = array('name' => 'asc');

        public function insert($teacher)
        {
            if(!$teacher){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $teacher);

            $teacher_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($teacher_id);
            }
        }

        public function update($teacher)
        {
            if(!$teacher || empty($teacher['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $teacher['id']);
            $this->db->update($this->_table, $teacher);

            $teacher_id = $teacher['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($teacher_id);
            }
        }

        public function delete($teacher)
        {
            if(!$teacher || empty($teacher['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $teacher['id'])); 

            $teacher_id = $teacher['id'];

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
            $this->db->select($this->_table.'.*, tb_religions.name AS religion, tb_cities.name AS birthplace'); 
            $this->db->from($this->_table);
            $this->db->join('tb_religions', 'tb_religions.id = '.$this->_table.'.religion_id');
            $this->db->join('tb_cities', 'tb_cities.id = '.$this->_table.'.birthplace_id');
     
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
            $query = $this->db->select($this->_table.'.*, tb_religions.name AS religion_name,
            tb_cities.name AS birthplace_name
            ')
                        ->from($this->_table)
                        ->join('tb_religions', 'tb_religions.id = '.$this->_table.'.religion_id')
                        ->join('tb_cities', 'tb_cities.id = '.$this->_table.'.birthplace_id')
                        ->where($this->_table.'.id', $id)
                        ->get()
                        ->row();

            return $query;
        }

        public function is_unique_nip($nip, $id)
        {
            $total = $this->db->select()
                        ->from($this->_table)
                        ->where('id !=', $id)
                        ->where('nip', $nip)
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
            $this->db->select('id, name, nip, CONCAT(name, " (", nip, ")") AS text' );

            if(isset($input['keyword']))
            {
                $this->db->group_start();
                $this->db->like('name', $input['keyword']);
                $this->db->or_like('nip', $input['keyword']);
                $this->db->group_end();
            }

            if(isset($input['is_active']))
            {
                $this->db->where('is_active', $input['is_active']);
            }

            $query =  $this->db->get($this->_table);

            return $query->result();
        }
    }