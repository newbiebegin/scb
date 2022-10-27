<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Administrator_model extends CI_Model
	{
		private $_table = 'tb_administrators';
        private $_column_order = array(null, 'tb_administrators.name', 'tb_cities.name','birth_date','tb_religions.name','tb_administrators.gender'); 
        private $_column_search = array('tb_administrators.name','tb_administrators.nip','tb_cities.name','tb_religions.name','tb_administrators.gender'); 
        private $_order = array('name' => 'asc');

        public function insert($administrator)
        {
            if(!$administrator){
				return;
			}
            
            $this->db->trans_begin();
            
            $this->db->insert($this->_table, $administrator);

            $administrator_id = $this->db->insert_id();

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($administrator_id);
            }
        }

        public function update($administrator)
        {
            if(!$administrator || empty($administrator['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->where('id', $administrator['id']);
            $this->db->update($this->_table, $administrator);

            $administrator_id = $administrator['id'];

            if( $this->db->trans_status() === FALSE )
            {
              $this->db->trans_rollback();
              return(0);
            }
            else
            {
              $this->db->trans_commit();
              return($administrator_id);
            }
        }

        public function delete($administrator)
        {
            if(!$administrator || empty($administrator['id'])){
				return;
			}
            
            $this->db->trans_begin();
            $this->db->delete($this->_table, array('id' => $administrator['id'])); 

            $administrator_id = $administrator['id'];

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
    }