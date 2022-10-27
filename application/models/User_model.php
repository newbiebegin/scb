<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class User_model extends CI_Model
	{
		private $_table = 'tb_sys_users';

        public function login_rules()
        {
            return [
                [
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'trim|required|min_length[2]|max_length[50]',
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required|min_length[3]|max_length[30]',
                ],
            ];
        }

        public function rules()
        {
            return [
                [
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'trim|required|min_length[2]|max_length[50]|is_unique[tb_sys.users.username]',
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required|min_length[3]|max_length[30]',
                ],
                [
                    'field' => 'passconf',
                    'label' => 'Password Confirmation',
                    'rules' => 'trim|required|matches[password]',
                ],
                [
                    'field' => 'student_id',
                    'label' => 'Student',
                    'rules' => 'trim',
                ],
                [
                    'field' => 'teacher_id',
                    'label' => 'Teacher',
                    'rules' => 'trim',
                ],
                [
                    'field' => 'administrator_id',
                    'label' => 'Administrator',
                    'rules' => 'trim',
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Active Status',
                    'rules' => 'trim|required',
                ],
                [
                    'field' => 'latitude',
                    'label' => 'Latitude',
                    'rules' => 'trim|required',
                ],
            ];
        }

        public function verify_login($username, $password)
        {
            // $username = $this->db->escape($username);
			// // $password = $this->db->escape(md5($password));
			// $password = $this->db->escape($password);

            $query = $this->db->select('id, username')
                        ->where('username', $username)
                        ->where('password', $password)
                        ->get($this->_table);
            $row = $query->row();

            if (isset($row))
            {
                $data = array(
                            'success' => TRUE,
                            'data' => array(
                                'username' => $row->username,
                                'id' => $row->id
                            ),
                            'message' => NULL,
                        );
            }
            else{
                $data = array(
                    'success' => FALSE,
                    'data' => array(),
                    'message' => 'Wrong Username / Password'
                );
            }
            
            return $data;
        }

        public function verify_acl($data)
        {
            $query = $this->db->select('id, IFNULL(student_id, 0) AS student_id, IFNULL(teacher_id, 0) AS teacher_id, IFNULL(administrator_id, 0) AS administrator_id')
                        ->where('id', $data['session_user_id'])
                        ->get($this->_table);
            $row = $query->row();

            if (isset($row))
            {
                // if($data['allowed_users'] == 'student' && $row->student_id > 0)
                // {

                // }
                // elseif($data['allowed_users'] == 'teacher' && $row->teacher_id > 0)
                // {
                    
                // }
                // elseif($data['allowed_users'] == 'administrator' && $row->administrator_id > 0)
                // {
                    
                // }
                
                $data = array(
                            'success' => TRUE,
                            'data' => array(
                                'student_id' => $row->student_id,
                                'teacher_id' => $row->teacher_id,
                                'administrator_id' => $row->administrator_id,
                                'id' => $row->id
                            ),
                            'message' => NULL,
                        );
            }
            else
            {
                $data = array(
                    'success' => FALSE,
                    'data' => array(),
                    'message' => 'Access denied'
                );
            }
            
            return $data;
        }
    }