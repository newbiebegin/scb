<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Religion_model extends CI_Model
	{
		private $_table = 'tb_religions';
        private $_column_order = array(null, 'name'); 
        private $_column_search = array('name'); 
        private $_order = array('name' => 'asc');

        public function rules()
        {
            return [
                [
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'trim|required|max_length[100]',
                ],
            ];
        }

        public function search($input)
        {
            $this->db->select('id, name, name AS text' );

            if(isset($input['name']))
            {
                $this->db->like('name', $input['name']);
            }

            if(isset($input['is_active']))
            {
                $this->db->where('is_active', $input['is_active']);
            }

            $query =  $this->db->get($this->_table);

            return $query->result();
        }
    }