<?php

$config = array(
		array(
            'field' => 'father_name',
            'label' => 'Father Name',
            'rules' => 'trim|required|max_length[100]',
        ),
		array(
            'field' => 'father_occupation_id',
            'label' => 'Father Occupation',
			'rules' => 'trim|required|max_length[11]',
        ),		
		array(
            'field' => 'father_religion_id',
            'label' => 'Father Religion',
			'rules' => 'trim|required|max_length[11]',
        ),	
		array(
            'field' => 'father_address',
            'label' => 'Father Address',
			'rules' => 'trim|required',
        ),
		array(
            'field' => 'father_phone_number',
            'label' => 'Father Phone Number',
			'rules' => 'trim|max_length[20]',
        ),
		array(
            'field' => 'mother_name',
            'label' => 'Mother Name',
            'rules' => 'trim|required|max_length[100]',
        ),
		array(
            'field' => 'mother_occupation_id',
            'label' => 'Mother Occupation',
			'rules' => 'trim|required|max_length[11]',
        ),		
		array(
            'field' => 'mother_religion_id',
            'label' => 'Mother Religion',
			'rules' => 'trim|required|max_length[11]',
        ),	
		array(
            'field' => 'mother_address',
            'label' => 'Mother Address',
			'rules' => 'trim|required',
        ),
		array(
            'field' => 'mother_phone_number',
            'label' => 'Mother Phone Number',
			'rules' => 'trim|max_length[20]',
        ),
		array(
            'field' => 'student_guardian_name',
            'label' => 'Student Guardian Name',
            'rules' => 'trim|required|max_length[100]',
        ),
		array(
            'field' => 'student_guardian_occupation_id',
            'label' => 'Student Guardian Occupation',
			'rules' => 'trim|required|max_length[11]',
        ),		
		array(
            'field' => 'student_guardian_religion_id',
            'label' => 'Student Guardian Religion',
			'rules' => 'trim|required|max_length[11]',
        ),	
		array(
            'field' => 'student_guardian_address',
            'label' => 'Student Guardian Address',
			'rules' => 'trim|required',
        ),
		array(
            'field' => 'student_guardian_phone_number',
            'label' => 'Student Guardian Phone Number',
			'rules' => 'trim|max_length[20]',
        ),
		
    );